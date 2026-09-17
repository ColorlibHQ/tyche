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

// TYCHE_PALETTE=colors-7-midnight measures the page under a style variation by
// overriding the preset variables, exactly what the variation changes. The
// palette audit in build_theme.py checks pairs it knows about; this catches the
// ones a pattern creates -- a light button labelled `contrast` read white on
// white in both dark palettes and passed every audit.
if ( process.env.TYCHE_PALETTE ) {
	const { readFileSync } = await import( 'node:fs' );
	const { dirname, join } = await import( 'node:path' );
	const { fileURLToPath } = await import( 'node:url' );
	const root = join( dirname( fileURLToPath( import.meta.url ) ), '..' );
	const file = join( root, 'styles/colors', process.env.TYCHE_PALETTE + '.json' );
	const palette = JSON.parse( readFileSync( file, 'utf8' ) ).settings.color.palette;
	const css = ':root, body { ' + palette.map( ( c ) => `--wp--preset--color--${ c.slug }: ${ c.color } !important;` ).join( ' ' ) + ' }';
	await page.addStyleTag( { content: css } );
	await page.waitForTimeout( 400 );
}

// Controls that only appear on hover are measured in their shown state, the only
// state anyone reads them in. Measuring them hidden sampled the photograph under
// invisible text and reported the product card buttons at 1.8:1.
await page.addStyleTag( { content: '.tyche-card-button { opacity: 1 !important; transform: none !important; transition: none !important; }' } );
await page.waitForTimeout( 200 );

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
		if ( 'hidden' === style.visibility || 'none' === style.display ) {
			return;
		}

		// Opacity is not inherited as a computed value: a transparent wrapper
		// leaves its text reporting 1. Anything invisible through an ancestor is
		// skipped, and counted, so a skip is never silent.
		for ( let node = el; node; node = node.parentElement ) {
			if ( '0' === getComputedStyle( node ).opacity ) {
				window.__tycheHidden = ( window.__tycheHidden || 0 ) + 1;
				return;
			}
		}

		// Text clipped out of sight by an ancestor. WooCommerce's star ratings
		// are written this way: "Rated 4 out of 5" is pushed below a 26px box
		// with overflow hidden and stars are drawn over the top, so the words
		// are for screen readers and nobody reads them off the photograph they
		// happen to sit on.
		const textBox = ( () => {
			const range = document.createRange();
			let box = null;
			for ( const node of el.childNodes ) {
				if ( 3 !== node.nodeType || ! node.textContent.trim() ) {
					continue;
				}
				range.selectNodeContents( node );
				const r = range.getBoundingClientRect();
				if ( ! r.width && ! r.height ) {
					continue;
				}
				box = box
					? { top: Math.min( box.top, r.top ), bottom: Math.max( box.bottom, r.bottom ),
						left: Math.min( box.left, r.left ), right: Math.max( box.right, r.right ) }
					: { top: r.top, bottom: r.bottom, left: r.left, right: r.right };
			}
			return box;
		} )();

		if ( textBox ) {
			for ( let node = el.parentElement; node; node = node.parentElement ) {
				const s = getComputedStyle( node );
				if ( 'visible' === s.overflow && 'visible' === s.overflowY && 'visible' === s.overflowX ) {
					continue;
				}
				const clip = node.getBoundingClientRect();
				const hiddenVertically = textBox.top >= clip.bottom - 1 || textBox.bottom <= clip.top + 1;
				const hiddenHorizontally = textBox.left >= clip.right - 1 || textBox.right <= clip.left + 1;
				if ( hiddenVertically || hiddenHorizontally ) {
					window.__tycheClipped = ( window.__tycheClipped || 0 ) + 1;
					return;
				}
			}
		}

		// Climb to whichever comes first: an opaque background colour, which is
		// the ground; or a photograph, or an element out of flow, where the
		// ground is pixels. A translucent background — a tinted panel laid on a
		// photograph — is not a ground on its own, so the climb carries on past it.
		let ground = null;
		let pixels = false;
		const layers = [];
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
			// A translucent panel is not a ground, but it is not nothing either.
			// Ignoring it reported a label on an 88%-opaque pill at 1.3:1 against
			// the photograph under the pill, a contrast no one can see. The climb
			// carries on, and the layers are painted back over whatever it finds.
			if ( alpha > 0 ) {
				layers.push( s.backgroundColor );
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
			layers,
		} );
	} );

	return out;
} );

const clipped = await page.evaluate( () => window.__tycheClipped || 0 );
if ( clipped ) {
	console.log( `${ clipped } text node(s) clipped out of view by an ancestor, not measured` );
}

const hidden = await page.evaluate( () => window.__tycheHidden || 0 );
if ( hidden ) {
	console.log( `${ hidden } text node(s) invisible through an ancestor with opacity 0, not measured` );
}

/**
 * Paint an element's translucent backgrounds back over the pixels behind it,
 * outermost layer first, so what is measured is what the eye is given.
 */
function paintOver( pixels, layers ) {
	if ( ! layers || ! layers.length ) {
		return pixels;
	}
	const parsed = layers
		.map( ( layer ) => ( { colour: parseColor( layer ), alpha: alphaFromCss( layer ) } ) )
		.filter( ( layer ) => layer.colour )
		.reverse();

	return pixels.map( ( pixel ) => parsed.reduce( ( base, layer ) => ( {
		r: layer.colour.r * layer.alpha + base.r * ( 1 - layer.alpha ),
		g: layer.colour.g * layer.alpha + base.g * ( 1 - layer.alpha ),
		b: layer.colour.b * layer.alpha + base.b * ( 1 - layer.alpha ),
	} ), pixel ) );
}

/** The alpha of a CSS colour, in either rgba() or color(srgb ... / a) form. */
function alphaFromCss( value ) {
	const m = String( value ).match( /\/\s*([\d.]+)\s*\)$/ ) ||
		String( value ).match( /^rgba\([^,]+,[^,]+,[^,]+,\s*([\d.]+)\s*\)$/ );
	return m ? Number( m[ 1 ] ) : 1;
}

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
	const behind = sampled ? paintOver( sampled.interior, c.layers ) : null;
	const r = behind ? worstTenth( colour, behind ) : null;
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
