/**
 * Screenshots of store states a static page capture never shows: the variable
 * product form, the reviews panel open, the cart drawer open, and My Account.
 *
 *   WP_URL=http://localhost:8812 node .dev/states.mjs [label]
 *
 * @package Tyche
 */

import { chromium } from 'playwright';
import { mkdirSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const base = process.env.WP_URL || 'http://localhost:8812';
const out = join( dirname( fileURLToPath( import.meta.url ) ), 'shots', process.argv[ 2 ] || 'states' );
mkdirSync( out, { recursive: true } );

const browser = await browser_launch();
const errors = [];

async function browser_launch() {
	return chromium.launch();
}

for ( const [ width, height, tag ] of [ [ 1440, 900, 'desk' ], [ 390, 844, 'phone' ] ] ) {
	const context = await browser.newContext( { viewport: { width, height }, reducedMotion: 'reduce' } );
	const page = await context.newPage();
	page.on( 'pageerror', ( e ) => errors.push( `${ tag } ${ page.url() }: ${ e.message.slice( 0, 140 ) }` ) );

	// Variable product: pick options so the price and stock message render.
	await page.goto( base + '/?product=merino-rollneck', { waitUntil: 'load' } );
	await page.screenshot( { path: join( out, `${ tag }-variable.png` ), fullPage: true } );
	const selects = page.locator( 'table.variations select' );
	if ( await selects.count() ) {
		await selects.nth( 0 ).selectOption( { index: 2 } );
		await selects.nth( 1 ).selectOption( { index: 1 } );
		await page.waitForTimeout( 800 );
		await page.screenshot( { path: join( out, `${ tag }-variable-chosen.png` ), fullPage: false } );
	}

	// Reviews open.
	await page.goto( base + '/?product=wool-overcoat', { waitUntil: 'load' } );
	const reviews = page.locator( '.wp-block-accordion-heading__toggle', { hasText: 'Reviews' } );
	if ( await reviews.count() ) {
		await reviews.first().click();
		await page.waitForTimeout( 600 );
		await reviews.first().scrollIntoViewIfNeeded();
		await page.screenshot( { path: join( out, `${ tag }-reviews.png` ), fullPage: false } );
	}

	// Add to cart, then open the drawer.
	await page.goto( base + '/?product=wool-overcoat', { waitUntil: 'load' } );
	await page.locator( '.single_add_to_cart_button' ).first().click();
	await page.waitForLoadState( 'load' );
	await page.locator( '.wc-block-mini-cart__button' ).first().click();
	await page.waitForTimeout( 1500 );
	await page.screenshot( { path: join( out, `${ tag }-drawer.png` ), fullPage: false } );

	await page.goto( base + '/?page_id=33', { waitUntil: 'load' } );
	await page.screenshot( { path: join( out, `${ tag }-account.png` ), fullPage: true } );
	await context.close();
}

await browser.close();
console.log( `shots in ${ out }` );
console.log( errors.length ? 'JS errors:\n  ' + [ ...new Set( errors ) ].join( '\n  ' ) : 'no JS errors' );
