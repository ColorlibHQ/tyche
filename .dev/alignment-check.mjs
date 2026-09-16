/**
 * Everything inside a constrained layout must sit centred in it.
 *
 * WordPress centres a constrained layout's children with `margin: auto` and
 * caps them at the content width. Auto margins do nothing to an inline element,
 * so an <iframe> in a Custom HTML block takes the width cap but not the
 * centring, and lands flush left. The contact map shipped like that in 1.0 and
 * 1.1.0: 46px left of the form above it at 1280px, and a visible band of white
 * beside it on any wide screen. overflow-check sees nothing, because nothing
 * overflows.
 *
 * So the signature is an element that took the cap and not the centring: its
 * width is its max-width, it is narrower than the container's content box, and
 * its left and right gaps differ by more than 2px. Something narrow that is left
 * aligned on purpose (a card's icon tile, sitting over left-aligned text) is
 * narrower than its cap, and is not reported.
 *
 *   WP_URL=https://colorlibhub.com/tyche node .dev/alignment-check.mjs
 *   TYCHE_PATHS=/,/contact/ WP_URL=… node .dev/alignment-check.mjs
 */

import { chromium } from 'playwright';

const base = ( process.env.WP_URL || 'http://127.0.0.1:9481' ).replace( /\/$/, '' );
const paths = ( process.env.TYCHE_PATHS || '/,/about/,/services/,/work/,/pricing/,/contact/,/blog/' ).split( ',' );
const widths = [ 1440, 1024, 390 ];

const browser = await chromium.launch();
const failures = [];
let measured = 0;

for ( const width of widths ) {
	const context = await browser.newContext( { viewport: { width, height: 900 }, reducedMotion: 'reduce' } );
	const page = await context.newPage();
	for ( const path of paths ) {
		await page.goto( base + path, { waitUntil: 'domcontentloaded', timeout: 60000 } );
		await page.waitForTimeout( 800 );
		const result = await page.evaluate( () => {
			const off = [];
			let n = 0;
			document.querySelectorAll( '.is-layout-constrained' ).forEach( ( box ) => {
				const cs = getComputedStyle( box );
				const r = box.getBoundingClientRect();
				if ( ! r.width ) {
					return;
				}
				const left = r.left + parseFloat( cs.paddingLeft ) + parseFloat( cs.borderLeftWidth );
				const right = r.right - parseFloat( cs.paddingRight ) - parseFloat( cs.borderRightWidth );
				for ( const child of box.children ) {
					if ( child.matches( '.alignleft, .alignright, .alignfull, .alignwide, .has-text-align-left, style, script, .screen-reader-text' ) ) {
						continue;
					}
					const c = child.getBoundingClientRect();
					const s = getComputedStyle( child );
					const cap = parseFloat( s.maxWidth );
					if ( ! c.width || 'absolute' === s.position || 'fixed' === s.position || c.width >= right - left - 1 || ! ( Math.abs( c.width - cap ) <= 1 ) ) {
						continue;
					}
					n++;
					const gapLeft = c.left - left;
					const gapRight = right - c.right;
					if ( Math.abs( gapLeft - gapRight ) > 2 ) {
						off.push( `<${ child.tagName.toLowerCase() } class="${ String( child.className ).slice( 0, 50 ) }"> gaps ${ Math.round( gapLeft ) }px left, ${ Math.round( gapRight ) }px right` );
					}
				}
			} );
			return { n, off };
		} );
		measured += result.n;
		result.off.forEach( ( o ) => failures.push( `${ path } @ ${ width }px: ${ o }` ) );
	}
	await context.close();
}

await browser.close();

if ( failures.length ) {
	console.error( `${ failures.length } off-centre element(s):` );
	[ ...new Set( failures ) ].forEach( ( f ) => console.error( '  ' + f ) );
	process.exit( 1 );
}
console.log( `every narrower child of a constrained layout is centred (${ measured } measured, ${ paths.length } pages x ${ widths.length } widths)` );
