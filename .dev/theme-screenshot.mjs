/**
 * screenshot.png for WordPress.org: 1200x900, rendered at 2x and downscaled.
 *
 * The capture is the real homepage. Only the hero is shortened for it, so the
 * frame shows the categories and new arrivals as well as the hero -- at its
 * normal 86vh height the hero would fill the whole screenshot.
 *
 *   WP_URL=http://localhost:8812 node .dev/theme-screenshot.mjs
 *
 * @package Tyche
 */

import { chromium } from 'playwright';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = join( dirname( fileURLToPath( import.meta.url ) ), '..' );
const base = process.env.WP_URL || 'http://localhost:8812';

const browser = await chromium.launch();
const page = await ( await browser.newContext( { viewport: { width: 1600, height: 1200 }, deviceScaleFactor: 1.5, reducedMotion: 'reduce' } ) ).newPage();
await page.goto( base + '/', { waitUntil: 'load' } );
await page.addStyleTag( { content: '.tyche-hero { min-height: 560px !important; } .tyche-card-button { opacity: 0 !important; }' } );
await page.evaluate( async () => {
	for ( let y = 0; y < 3000; y += 500 ) {
		window.scrollTo( 0, y );
		await new Promise( ( r ) => setTimeout( r, 80 ) );
	}
	window.scrollTo( 0, 0 );
	await document.fonts.ready;
} );
await page.waitForLoadState( 'networkidle' ).catch( () => {} );
await page.waitForTimeout( 800 );
await page.screenshot( { path: join( root, '.dev/shots/screenshot-raw.png' ), clip: { x: 0, y: 0, width: 1600, height: 1200 } } );
await browser.close();
console.log( 'captured' );
