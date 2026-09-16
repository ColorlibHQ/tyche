/**
 * Full-page captures of the store pages at desktop and phone widths.
 *
 *   WP_URL=http://localhost:8812 node .dev/shots.mjs [label] [pages]
 *
 * pages is a comma list of names from PAGES below; default is all of them.
 * Shots land in .dev/shots/<label>/<width>-<page>.png (gitignored). A cart item
 * is added first so the cart and checkout pages have something to show.
 *
 * @package Tyche
 */

import { chromium } from 'playwright';
import { mkdirSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const base = process.env.WP_URL || 'http://localhost:8812';
const label = process.argv[ 2 ] || 'current';
const only = process.argv[ 3 ] ? process.argv[ 3 ].split( ',' ) : null;
const out = join( dirname( fileURLToPath( import.meta.url ) ), 'shots', label );
mkdirSync( out, { recursive: true } );

const PAGES = {
	home: '/',
	shop: '/?post_type=product',
	category: '/?product_cat=coats',
	product: '/?product=wool-overcoat',
	cart: '/?page_id=31',
	checkout: '/?page_id=32',
	blog: '/?page_id=0&post_type=post',
	post: '/?p=1',
	search: '/?s=wool&post_type=product',
	notfound: '/?p=999999',
};

const browser = await chromium.launch();
const errors = [];

for ( const [ width, height, tag ] of [ [ 1440, 900, 'desk' ], [ 390, 844, 'phone' ] ] ) {
	const context = await browser.newContext( { viewport: { width, height }, reducedMotion: 'reduce' } );
	const page = await context.newPage();
	page.on( 'pageerror', ( e ) => errors.push( `${ tag } ${ page.url() }: ${ e.message.slice( 0, 120 ) }` ) );

	// Something in the cart, so cart and checkout render their filled state.
	await page.goto( base + '/?add-to-cart=' + ( process.env.TYCHE_CART_PRODUCT || '' ), { waitUntil: 'load' } ).catch( () => {} );

	for ( const [ name, path ] of Object.entries( PAGES ) ) {
		if ( only && ! only.includes( name ) ) {
			continue;
		}
		await page.goto( base + path, { waitUntil: 'load' } );
		await page.evaluate( () => document.fonts.ready );
		await page.waitForTimeout( 700 );
		await page.screenshot( { path: join( out, `${ tag }-${ name }.png` ), fullPage: true } );
	}
	await context.close();
}

await browser.close();
console.log( `shots in ${ out }` );
console.log( errors.length ? 'JS errors:\n  ' + [ ...new Set( errors ) ].join( '\n  ' ) : 'no JS errors' );
