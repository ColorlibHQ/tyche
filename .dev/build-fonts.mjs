/**
 * Downloads the theme's webfonts into assets/fonts/.
 *
 * The list comes from .dev/fonts.json, which build_theme.py writes from the
 * same table it builds theme.json's fontFace entries from. So the files here
 * are exactly the ones theme.json names: an undeclared file is dead weight in
 * the zip, and a declared file that is missing is a 404 on every page.
 *
 * Usage:  python3 .dev/build_theme.py && node .dev/build-fonts.mjs
 */

import { readFileSync, writeFileSync, mkdirSync, readdirSync, unlinkSync } from 'node:fs';
import { dirname, join, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = resolve( dirname( fileURLToPath( import.meta.url ) ), '..' );
const out = join( root, 'assets/fonts' );
const VERSION = '5.3.0';
const faces = JSON.parse( readFileSync( join( root, '.dev/fonts.json' ), 'utf8' ) );

mkdirSync( out, { recursive: true } );
const wanted = new Set();
let bytes = 0;

for ( const { family, subset, weight, style } of faces ) {
	const name = `${ family }-${ subset }-${ weight }-${ style }.woff2`;
	wanted.add( name );
	const url = `https://cdn.jsdelivr.net/npm/@fontsource/${ family }@${ VERSION }/files/${ name }`;
	const res = await fetch( url );
	if ( ! res.ok ) {
		throw new Error( `${ res.status } ${ url }` );
	}
	const buf = Buffer.from( await res.arrayBuffer() );
	writeFileSync( join( out, name ), buf );
	bytes += buf.length;
	console.log( `  ${ name.padEnd( 46 ) } ${ ( buf.length / 1024 ).toFixed( 1 ) }KB` );
}

for ( const file of readdirSync( out ) ) {
	if ( file.endsWith( '.woff2' ) && ! wanted.has( file ) ) {
		unlinkSync( join( out, file ) );
		console.log( `  removed ${ file } (no longer declared)` );
	}
}

console.log( `\n${ ( bytes / 1024 ).toFixed( 0 ) }KB in assets/fonts/` );
