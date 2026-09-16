/**
 * Render a page in every colour palette by overriding the preset variables in
 * the browser. Exact for what the palettes change, and it changes nothing on
 * the site. Writes .dev/shots/palettes/<slug>.png and a contact sheet.
 *
 *   WP_URL=http://localhost:8812 node .dev/palettes.mjs [path]
 *
 * @package Tyche
 */

import { chromium } from 'playwright';
import { readFileSync, readdirSync, mkdirSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = join( dirname( fileURLToPath( import.meta.url ) ), '..' );
const out = join( root, '.dev/shots/palettes' );
mkdirSync( out, { recursive: true } );
const base = process.env.WP_URL || 'http://localhost:8812';
const path = process.argv[ 2 ] || '/';

const sets = [ [ 'colors-1-linen', JSON.parse( readFileSync( join( root, 'theme.json' ), 'utf8' ) ).settings.color.palette ] ];
for ( const file of readdirSync( join( root, 'styles/colors' ) ).sort() ) {
	sets.push( [ file.replace( '.json', '' ), JSON.parse( readFileSync( join( root, 'styles/colors', file ), 'utf8' ) ).settings.color.palette ] );
}

const browser = await chromium.launch();
const page = await ( await browser.newContext( { viewport: { width: 1440, height: 900 }, reducedMotion: 'reduce' } ) ).newPage();
await page.goto( base + path, { waitUntil: 'load' } );

for ( const [ slug, palette ] of sets ) {
	const css = ':root, body { ' + palette.map( ( c ) => `--wp--preset--color--${ c.slug }: ${ c.color } !important;` ).join( ' ' ) + ' }';
	await page.evaluate( ( style ) => {
		let el = document.getElementById( 'tyche-palette-preview' );
		if ( ! el ) {
			el = document.createElement( 'style' );
			el.id = 'tyche-palette-preview';
			document.head.appendChild( el );
		}
		el.textContent = style;
	}, css );
	await page.waitForTimeout( 300 );
	await page.screenshot( { path: join( out, slug + '.png' ), clip: { x: 0, y: 0, width: 1440, height: 2400 }, fullPage: true } );
	console.log( '  ' + slug );
}

await browser.close();
