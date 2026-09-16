/**
 * Find elements that spill out of the box they live in.
 *
 * Every responsive check in this repo measured the DOCUMENT:
 * `scrollWidth > innerWidth`. That catches a page you can scroll sideways and
 * nothing else — and the reservation form's inputs were 34px wider than their
 * grid cell at every width while the document stayed exactly as wide as the
 * viewport, because the overflow happened inside a panel in the middle of the
 * page. It shipped, and a person spotted it.
 *
 * This compares each element against its offsetParent's content box instead,
 * which is the question that was actually worth asking.
 *
 *   WP_URL=https://example.com TYCHE_PATHS=/,/contact/ node .dev/overflow-check.mjs
 *
 * @package Tyche
 */

import { chromium } from 'playwright';

const site = process.env.WP_URL || 'http://localhost';
const paths = ( process.env.TYCHE_PATHS || '/' ).split( ',' ).filter( Boolean );
const widths = ( process.env.TYCHE_WIDTHS || '1400,1024,768,390' ).split( ',' ).map( Number );

const browser = await chromium.launch();
let total = 0;

for ( const path of paths ) {
	for ( const width of widths ) {
		const context = await browser.newContext( {
			viewport: { width, height: 1000 },
			isMobile: width <= 480,
			hasTouch: width <= 480,
		} );
		const page = await context.newPage();

		await page.goto( site + path, { waitUntil: 'domcontentloaded', timeout: 90000 } );
		await page.waitForTimeout( 2500 );

		const spills = await page.evaluate( () => {
			const out = [];

			for ( const el of document.querySelectorAll( 'body *' ) ) {
				const style = getComputedStyle( el );

				if ( 'none' === style.display || 'hidden' === style.visibility ) {
					continue;
				}
				// Deliberately out of flow, or deliberately clipped.
				if ( 'absolute' === style.position || 'fixed' === style.position ) {
					continue;
				}
				// `alignfull` and `alignwide` exist in order to break out of
				// the container's padding. That is the feature, not a spill.
				if ( el.classList.contains( 'alignfull' ) || el.classList.contains( 'alignwide' ) ) {
					continue;
				}

				const parent = el.parentElement;
				if ( ! parent || parent === document.body ) {
					continue;
				}

				const ps = getComputedStyle( parent );
				if ( 'visible' !== ps.overflowX ) {
					continue;
				}
				// A parent that is itself out of flow is measured on its own turn.
				if ( 'absolute' === ps.position || 'fixed' === ps.position ) {
					continue;
				}

				const box = el.getBoundingClientRect();
				const pbox = parent.getBoundingClientRect();

				if ( box.width < 4 || pbox.width < 4 ) {
					continue;
				}

				const padLeft = parseFloat( ps.paddingLeft ) || 0;
				const padRight = parseFloat( ps.paddingRight ) || 0;
				const innerLeft = pbox.left + padLeft;
				const innerRight = pbox.right - padRight;

				// 1px of slack for subpixel rounding.
				const over = Math.round( Math.max( box.right - innerRight, innerLeft - box.left ) );

				if ( over > 1 ) {
					out.push( {
						tag: el.tagName.toLowerCase() + ( el.className && 'string' === typeof el.className
							? '.' + el.className.split( /\s+/ ).slice( 0, 2 ).join( '.' ) : '' ),
						parent: parent.tagName.toLowerCase() + ( parent.className && 'string' === typeof parent.className
							? '.' + parent.className.split( /\s+/ ).slice( 0, 2 ).join( '.' ) : '' ),
						over,
					} );
				}
			}

			// One line per distinct element/parent pair.
			const seen = new Set();
			return out.filter( ( o ) => {
				const key = o.tag + '|' + o.parent;
				if ( seen.has( key ) ) {
					return false;
				}
				seen.add( key );
				return true;
			} );
		} );

		if ( spills.length ) {
			total += spills.length;
			console.log( `\n${ path } @ ${ width }px — ${ spills.length } element(s) spilling` );
			for ( const s of spills.slice( 0, 8 ) ) {
				console.log( `   +${ s.over }px  ${ s.tag }  inside  ${ s.parent }` );
			}
		} else {
			console.log( `${ path } @ ${ width }px — clean` );
		}

		await context.close();
	}
}

await browser.close();

if ( total ) {
	process.exit( 1 );
}
