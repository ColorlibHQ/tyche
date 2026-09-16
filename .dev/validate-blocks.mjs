/**
 * Parses every template, part, pattern and stored page through the block parser
 * and fails on any invalid or missing block.
 *
 * Block comment attributes have to match what a block's save function produces.
 * When they do not, the editor shows "this block contains unexpected or invalid
 * content" and offers to recover it — but nothing warns you at build time, and
 * the front end looks fine. This does warn you.
 *
 * Needs Playwright (npm i -D playwright) and an admin login on a site running
 * the theme.
 *
 *   WP_URL=http://example.test WP_USER=admin WP_PASS=secret \
 *     node tools/validate-blocks.mjs
 *
 * @package Tyche
 */

import { chromium } from 'playwright';

const url = process.env.WP_URL || 'http://localhost';
const user = process.env.WP_USER;
const pass = process.env.WP_PASS;

if ( ! user || ! pass ) {
	console.error( 'Set WP_URL, WP_USER and WP_PASS.' );
	process.exit( 1 );
}

const browser = await chromium.launch();
const page = await ( await browser.newContext() ).newPage();

await page.goto( url + '/wp-login.php', { waitUntil: 'commit' } );
await page.fill( '#user_login', user );
await page.fill( '#user_pass', pass );
await page.click( '#wp-submit' );
await page.waitForFunction( () => 'complete' === document.readyState );

await page.goto( url + '/wp-admin/site-editor.php', { waitUntil: 'commit', timeout: 60000 } );
await page.waitForSelector( '.edit-site, #site-editor', { timeout: 60000 } );
await page.waitForTimeout( 6000 );

const problems = await page.evaluate( async () => {
	const walk = ( blocks, path, out ) => {
		for ( const block of blocks ) {
			if ( block.name && false === block.isValid ) {
				out.push( path + ': invalid ' + block.name );
			}

			if ( 'core/missing' === block.name ) {
				out.push( path + ': missing ' + ( block.attributes?.originalName || '?' ) );
			}

			if ( block.innerBlocks?.length ) {
				walk( block.innerBlocks, path, out );
			}
		}
	};

	const out = [];
	const theme = window.wp.data.select( 'core' ).getCurrentTheme?.()?.stylesheet;

	for ( const route of [ '/wp/v2/templates?per_page=100', '/wp/v2/template-parts?per_page=100' ] ) {
		const items = await window.wp.apiFetch( { path: route } );

		for ( const item of items ) {
			if ( theme && item.theme !== theme ) {
				continue;
			}

			walk( window.wp.blocks.parse( item.content.raw ), item.slug, out );
		}
	}

	// Patterns as well. Most of a block theme's hand-built markup lives in
	// patterns rather than templates, and an invalid block there is just as
	// broken -- it simply takes until someone inserts it to find out.
	const patterns = await window.wp.apiFetch( { path: '/wp/v2/block-patterns/patterns' } );

	for ( const pattern of patterns ) {
		if ( ! pattern.name || 0 !== pattern.name.indexOf( 'tyche/' ) ) {
			continue;
		}

		walk( window.wp.blocks.parse( pattern.content ), pattern.name, out );
	}

	// Stored pages and menus too. A pattern can be valid while the page built
	// from it is not: wp_insert_post() unslashes, so content inserted without
	// wp_slash() loses the backslash from every \\u002d in a block attribute.
	// Only the stored copy shows that, so check what activation and the starter
	// importer actually wrote.
	for ( const type of [ 'pages', 'navigation' ] ) {
		const items = await window.wp.apiFetch( { path: '/wp/v2/' + type + '?per_page=100&context=edit&status=publish,draft' } );

		for ( const item of items ) {
			walk( window.wp.blocks.parse( item.content.raw ), type + '/' + item.id + ' (' + ( item.title?.raw || item.slug ) + ')', out );
		}
	}

	return out;
} );

await browser.close();

if ( problems.length ) {
	console.error( 'Invalid block markup:\n  ' + problems.join( '\n  ' ) );
	process.exit( 1 );
}

console.log( 'Every block in every template, part, pattern, page and menu is valid.' );
