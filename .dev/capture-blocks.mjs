/**
 * Captures the markup a block produces when a person inserts it in the editor.
 *
 * Several WooCommerce blocks build their inner blocks in the edit component, not
 * in their registration: Product Filters adds a heading and six filters, each
 * filter adds its own controls, Product Gallery adds its image and thumbnails.
 * `createBlock()` produces none of that, and a template written from the block
 * names alone renders empty filters. So this inserts each block into a real
 * editor, lets the edit components mount, and saves what the serialiser returns.
 *
 *   WP_URL=http://localhost:8812 WP_USER=admin WP_PASS=admin123 \
 *     node .dev/capture-blocks.mjs
 *
 * Writes .dev/captured/<name>.html. Generators read those files.
 *
 * @package Tyche
 */

import { chromium } from 'playwright';
import { mkdirSync, writeFileSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const out = join( dirname( fileURLToPath( import.meta.url ) ), 'captured' );
mkdirSync( out, { recursive: true } );

const url = process.env.WP_URL || 'http://localhost:8812';
const user = process.env.WP_USER || 'admin';
const pass = process.env.WP_PASS || 'admin123';

// name -> [ blockName, attributes, afterInsert(attrs) ]
const JOBS = {
	'product-filters': [ 'woocommerce/product-filters', {} ],
	'product-collection-carousel': [
		'woocommerce/product-collection',
		{ collection: 'woocommerce/product-collection/new-arrivals' },
		{ displayLayout: { type: 'carousel', columns: 4, shrinkColumns: true } },
	],
	'accordion': [ 'core/accordion', {} ],
};

// Blocks that only exist inside a product's context, captured in that template.
const SINGLE_PRODUCT_JOBS = {
	'product-gallery': [ 'woocommerce/product-gallery', {} ],
	'add-to-cart-with-options': [ 'woocommerce/add-to-cart-with-options', {} ],
	'product-details': [ 'woocommerce/product-details', {} ],
	'product-reviews': [ 'woocommerce/product-reviews', {} ],
};

const browser = await chromium.launch();
const page = await ( await browser.newContext( { viewport: { width: 1440, height: 1000 } } ) ).newPage();
page.on( 'pageerror', ( e ) => console.log( '  page error:', e.message.slice( 0, 140 ) ) );

await page.goto( url + '/wp-login.php' );
await page.fill( '#user_login', user );
await page.fill( '#user_pass', pass );
await Promise.all( [ page.waitForNavigation(), page.click( '#wp-submit' ) ] );

async function capture( editorPath, jobs ) {
	await page.goto( url + editorPath, { timeout: 90000 } );
	await page.waitForFunction( () => window.wp?.data?.select( 'core/block-editor' )?.getBlocks, null, { timeout: 90000 } );
	await page.waitForTimeout( 8000 );
	for ( const [ name, [ blockName, attrs, later ] ] of Object.entries( jobs ) ) {
		const clientId = await page.evaluate( ( [ b, a ] ) => {
			const { createBlock, getBlockType } = window.wp.blocks;
			if ( ! getBlockType( b ) ) {
				return null;
			}
			const block = createBlock( b, a );
			window.wp.data.dispatch( 'core/block-editor' ).insertBlocks( block );
			return block.clientId;
		}, [ blockName, attrs ] );

		if ( ! clientId ) {
			console.log( `  ${ name }: ${ blockName } is not registered in this editor` );
			continue;
		}

		await page.waitForTimeout( 5000 );

		if ( later ) {
			await page.evaluate( ( [ b, a ] ) => {
				const found = window.wp.data.select( 'core/block-editor' ).getBlocks().filter( ( x ) => x.name === b ).pop();
				if ( found ) {
					window.wp.data.dispatch( 'core/block-editor' ).updateBlockAttributes( found.clientId, a );
				}
			}, [ blockName, later ] );
			await page.waitForTimeout( 5000 );
		}

		// Some blocks replace themselves on mount, which gives them a new client id,
		// so look the block up by name rather than by the id it was inserted with.
		const markup = await page.evaluate( ( b ) => {
			const found = window.wp.data.select( 'core/block-editor' ).getBlocks().filter( ( x ) => x.name === b ).pop();
			return found ? window.wp.blocks.serialize( [ found ] ) : '';
		}, blockName );

		if ( ! markup ) {
			console.log( `  ${ name }: ${ blockName } did not survive insertion` );
			continue;
		}

		writeFileSync( join( out, name + '.html' ), markup + '\n' );
		console.log( `  ${ name }: ${ markup.length } bytes, ${ ( markup.match( /<!-- wp:/g ) || [] ).length } blocks` );

		await page.evaluate( ( b ) => {
			const ids = window.wp.data.select( 'core/block-editor' ).getBlocks().filter( ( x ) => x.name === b ).map( ( x ) => x.clientId );
			window.wp.data.dispatch( 'core/block-editor' ).removeBlocks( ids, false );
		}, blockName );
	}
}

// The site editor registers template-only blocks the post editor leaves out.
await capture( '/wp-admin/site-editor.php?postType=wp_template&postId=tyche//index&canvas=edit', JOBS );
await capture( '/wp-admin/site-editor.php?postType=wp_template&postId=woocommerce/woocommerce//single-product&canvas=edit', SINGLE_PRODUCT_JOBS );

await browser.close();
