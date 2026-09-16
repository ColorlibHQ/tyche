/**
 * Measure text contrast on a real rendered page, under every colour palette.
 *
 * theme.json's own audit checks the palette's numbers. It cannot catch a
 * pattern that puts the wrong slug on the wrong ground — which is how every
 * cover headline and the whole footer came out black-on-black in the two dark
 * palettes: they asked for `base`, and `base` is the page background, so in a
 * dark palette it is nearly black.
 *
 * This walks the rendered DOM, resolves each text node's effective background
 * by climbing its ancestors, and reports anything under 4.5:1. It is the check
 * that would have caught that bug, so it runs over all eight palettes.
 *
 * Text on a photograph is measured too, by its pixels (photo-ground.mjs). This
 * check used to skip it: climbing ancestors from a cover headline walks past
 * the photograph and its dimming layer, which are siblings, and finds the page.
 * Skipping meant the hero, the page banners, the statistics and the "Why us"
 * section were never measured at all — and the primary-coloured eyebrow on the
 * darkened "Why us" photograph shipped at under 3:1 without a single warning.
 * An element taken out of flow (absolute or fixed) is measured the same way,
 * since what is behind it is not in its ancestry either.
 *
 *   WP_URL=... TYCHE_URL=/some-page/ node .dev/contrast-rendered.mjs
 *   TYCHE_DARK=1 WP_URL=... TYCHE_URL=/ node .dev/contrast-rendered.mjs
 *
 * @package Tyche
 */

import { chromium } from 'playwright';
import { contrast, parseColor, sampleBehind, worstTenth } from './photo-ground.mjs';

const site = ( process.env.WP_URL || 'http://local-wp.local' ).replace( /\/$/, '' );
const path = process.env.TYCHE_URL || '/';

const browser = await chromium.launch();
// Reduced motion, so no scroll reveal is half-way through its fade while the
// pixels behind it are photographed. Scale 1, so a screenshot pixel is a CSS pixel.
const page = await ( await browser.newContext( {
	viewport: { width: 1400, height: 1000 },
	deviceScaleFactor: 1,
	reducedMotion: 'reduce',
} ) ).newPage();

// `domcontentloaded` plus a settle, not `networkidle`: a production site with
// analytics or a chat widget may never reach network idle at all, and the
// check then fails as a timeout rather than a contrast result.
await page.goto( site + path, { waitUntil: 'domcontentloaded', timeout: 90000 } );
await page.waitForTimeout( 2500 );

// TYCHE_DARK=1 measures the same page with dark mode on, which is where the
// palette is lifted rather than replaced and is the likeliest place for a
// pairing to fall under AA.
if ( process.env.TYCHE_DARK ) {
	await page.evaluate( () => {
		document.documentElement.classList.add( 'tyche-dark' );
	} );
	await page.waitForTimeout( 400 );
}

const candidates = await page.evaluate( () => {
	// rgb()/rgba(), or color(srgb r g b / a), which color-mix() produces.
	const alphaOf = ( value ) => {
		if ( ! value || 'transparent' === value ) {
			return 0;
		}
		const m = value.match( /\/\s*([\d.]+)\s*\)$/ ) || value.match( /^rgba\([^,]+,[^,]+,[^,]+,\s*([\d.]+)\s*\)$/ );
		return m ? Number( m[ 1 ] ) : 1;
	};

	const out = [];

	document.querySelectorAll( 'h1,h2,h3,h4,h5,h6,p,li,a,dt,dd,summary,label,button,span' ).forEach( ( el, i ) => {
		const own = [ ...el.childNodes ].some( ( n ) => 3 === n.nodeType && n.textContent.trim() );
		if ( ! own ) {
			return;
		}

		// Too small to be read, or parked off the side of the page on purpose, as
		// the enquiry form's honeypot is: nobody sees either.
		const box = el.getBoundingClientRect();
		if ( box.width < 6 || box.height < 6 || box.right <= 0 || box.left >= document.documentElement.clientWidth ) {
			return;
		}

		const style = getComputedStyle( el );
		if ( 'hidden' === style.visibility || '0' === style.opacity || 'none' === style.display ) {
			return;
		}

		// Climb to whichever comes first: an opaque background colour, which is
		// the ground; or a photograph, or an element out of flow, where the
		// ground is pixels. A translucent background — a tinted panel laid on a
		// photograph — is not a ground on its own, so the climb carries on past it.
		let ground = null;
		let pixels = false;
		for ( let node = el; node; node = node.parentElement ) {
			const s = getComputedStyle( node );
			if ( node.classList.contains( 'wp-block-cover' ) || ( s.backgroundImage && 'none' !== s.backgroundImage ) ) {
				pixels = true;
				break;
			}
			const alpha = alphaOf( s.backgroundColor );
			if ( alpha >= 0.99 ) {
				ground = s.backgroundColor;
				break;
			}
			if ( alpha > 0 || 'absolute' === s.position || 'fixed' === s.position ) {
				pixels = true;
				break;
			}
		}

		el.setAttribute( 'data-uc-cr', String( i ) );
		out.push( {
			i,
			text: el.textContent.trim().replace( /\s+/g, ' ' ).slice( 0, 40 ),
			colour: style.color,
			// Nothing painted anywhere up the tree is the browser's white canvas.
			ground: pixels ? null : ( ground || 'rgb(255, 255, 255)' ),
		} );
	} );

	return out;
} );

const findings = [];
let onPhotos = 0;

for ( const c of candidates ) {
	const colour = parseColor( c.colour );
	if ( ! colour ) {
		continue;
	}

	if ( null !== c.ground ) {
		const ground = parseColor( c.ground );
		const r = ground ? contrast( colour, ground ) : null;
		if ( null !== r && r < 4.5 ) {
			findings.push( { ratio: r, text: c.text, colour: c.colour, background: c.ground } );
		}
		continue;
	}

	onPhotos++;
	const handle = await page.$( `[data-uc-cr="${ c.i }"]` );
	const sampled = handle ? await sampleBehind( page, handle, 0, { text: true } ) : null;
	const r = sampled ? worstTenth( colour, sampled.interior ) : null;
	if ( null === r ) {
		findings.push( { ratio: 0, text: c.text, colour: c.colour, background: 'a photograph it could not measure' } );
	} else if ( r < 4.5 ) {
		findings.push( { ratio: r, text: c.text, colour: c.colour, background: 'the photograph behind it (worst tenth of its pixels)' } );
	}
}

await browser.close();

if ( findings.length ) {
	console.error( `${ findings.length } text nodes under 4.5:1 on ${ path } (${ onPhotos } measured on photographs)` );
	for ( const f of findings.slice( 0, 12 ) ) {
		console.error( `  ${ f.ratio.toFixed( 2 ) }  "${ f.text }"  ${ f.colour } on ${ f.background }` );
	}
	process.exit( 1 );
}

console.log( `every text node on ${ path } is at least 4.5:1 (${ candidates.length } measured, ${ onPhotos } on photographs)` );
