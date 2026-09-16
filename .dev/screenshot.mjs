/**
 * Capture theme screenshot.png at exactly 1200x900.
 *
 * Theme Check rejects any other size, and the Appearance screen crops
 * anything taller. The page is rendered at 1600x1200 -- the same 4:3 -- and
 * scaled down, so the type is sharp rather than rendered at 1200 and squeezed.
 *
 *   node .dev/screenshot.mjs <url> [out]
 *
 * @package Tyche
 */

import { chromium } from 'playwright';

const url = process.argv[ 2 ];
const out = process.argv[ 3 ] || 'screenshot.png';

if ( ! url ) {
	console.error( 'Usage: node .dev/screenshot.mjs <url> [out]' );
	process.exit( 1 );
}

const browser = await chromium.launch();
const context = await browser.newContext( {
	viewport: { width: 1600, height: 1200 },
	deviceScaleFactor: 1,
} );
const page = await context.newPage();

await page.goto( url, { waitUntil: 'networkidle', timeout: 90000 } );

// Lazy images inside the first screen have to be decoded before the shot, or
// the capture catches empty boxes.
await page.evaluate( async () => {
	document.querySelectorAll( 'img[loading="lazy"]' ).forEach( ( img ) => {
		img.loading = 'eager';
	} );
	await Promise.allSettled( [ ...document.images ].map( ( img ) => img.decode().catch( () => {} ) ) );
} );
await page.waitForTimeout( 1500 );

const buffer = await page.screenshot( { clip: { x: 0, y: 0, width: 1600, height: 1200 } } );
await browser.close();

// Scale 1600x1200 -> 1200x900 with sharp if it is available, else write the
// full-size capture and say so.
const { default: sharp } = await import( 'sharp' ).catch( () => ( { default: null } ) );

if ( sharp ) {
	await sharp( buffer ).resize( 1200, 900 ).png( { quality: 90 } ).toFile( out );
	console.log( out + ' written at 1200x900' );
} else {
	const { writeFileSync } = await import( 'node:fs' );
	writeFileSync( out, buffer );
	console.log( out + ' written at 1600x1200 -- install sharp to scale it' );
}
