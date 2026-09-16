/**
 * What is actually behind an element that sits on a photograph.
 *
 * Climbing the DOM for a background colour cannot answer that. A cover's
 * photograph and its dimming layer are siblings of the content, not ancestors,
 * so the climb walks straight past them to the page: a white label on a dimmed
 * photograph reports as white-on-white, a failure that is not there, and a dark
 * label on a bright photograph would report a pass that is not there either.
 * contrast-rendered.mjs dealt with this by skipping every cover — which meant
 * the hero headline, the page banners and the statistics were never measured.
 *
 * So this measures pixels. It hides the element, photographs the region it
 * occupies plus a margin, decodes the PNG with Node's own zlib (no dependency,
 * and no page Content Security Policy in the way), and returns the colours
 * actually rendered there: `interior` behind the element, `ring` around it.
 *
 * Callers judge contrast against the worst tenth of those pixels. That tolerates
 * a stray highlight in a photograph, and still fails a label that sits over a
 * genuinely bright patch of one.
 */

import zlib from 'node:zlib';

/** rgb()/rgba() in 0–255, or color(srgb r g b / a) in 0–1, which color-mix() returns. */
export function parseColor( value ) {
	if ( ! value ) {
		return null;
	}
	let m = value.match( /rgba?\(([^)]+)\)/ );
	if ( m ) {
		const v = m[ 1 ].split( /[\s,/]+/ ).filter( Boolean ).map( Number );
		return { r: v[ 0 ], g: v[ 1 ], b: v[ 2 ], a: v.length > 3 ? v[ 3 ] : 1 };
	}
	m = value.match( /color\(srgb ([^)]+)\)/ );
	if ( m ) {
		const v = m[ 1 ].split( /[\s/]+/ ).filter( Boolean ).map( Number );
		return { r: v[ 0 ] * 255, g: v[ 1 ] * 255, b: v[ 2 ] * 255, a: v.length > 3 ? v[ 3 ] : 1 };
	}
	return null;
}

function channel( x ) {
	x /= 255;
	return x <= 0.03928 ? x / 12.92 : Math.pow( ( x + 0.055 ) / 1.055, 2.4 );
}

function luminance( c ) {
	return 0.2126 * channel( c.r ) + 0.7152 * channel( c.g ) + 0.0722 * channel( c.b );
}

export function contrast( a, b ) {
	const [ hi, lo ] = [ luminance( a ), luminance( b ) ].sort( ( x, y ) => y - x );
	return ( hi + 0.05 ) / ( lo + 0.05 );
}

/** Minimal decoder for what Playwright writes: 8-bit RGB or RGBA, not interlaced. */
export function decodePng( buf ) {
	let pos = 8;
	let width = 0;
	let height = 0;
	let depth = 0;
	let type = 0;
	const idat = [];
	while ( pos < buf.length ) {
		const len = buf.readUInt32BE( pos );
		const name = buf.toString( 'ascii', pos + 4, pos + 8 );
		const data = buf.subarray( pos + 8, pos + 8 + len );
		if ( 'IHDR' === name ) {
			width = data.readUInt32BE( 0 );
			height = data.readUInt32BE( 4 );
			depth = data[ 8 ];
			type = data[ 9 ];
			if ( 0 !== data[ 12 ] ) {
				throw new Error( 'interlaced PNG is not supported' );
			}
		} else if ( 'IDAT' === name ) {
			idat.push( data );
		} else if ( 'IEND' === name ) {
			break;
		}
		pos += 12 + len;
	}
	if ( 8 !== depth || ( 2 !== type && 6 !== type ) ) {
		throw new Error( `unsupported PNG: depth ${ depth }, colour type ${ type }` );
	}
	const bpp = 6 === type ? 4 : 3;
	const raw = zlib.inflateSync( Buffer.concat( idat ) );
	const stride = width * bpp;
	const out = Buffer.alloc( height * stride );
	for ( let y = 0; y < height; y++ ) {
		const filter = raw[ y * ( stride + 1 ) ];
		const line = raw.subarray( y * ( stride + 1 ) + 1, ( y + 1 ) * ( stride + 1 ) );
		const cur = out.subarray( y * stride, ( y + 1 ) * stride );
		const prev = y ? out.subarray( ( y - 1 ) * stride, y * stride ) : null;
		for ( let x = 0; x < stride; x++ ) {
			const a = x >= bpp ? cur[ x - bpp ] : 0;
			const b = prev ? prev[ x ] : 0;
			const c = prev && x >= bpp ? prev[ x - bpp ] : 0;
			let v = line[ x ];
			if ( 1 === filter ) {
				v += a;
			} else if ( 2 === filter ) {
				v += b;
			} else if ( 3 === filter ) {
				v += ( a + b ) >> 1;
			} else if ( 4 === filter ) {
				const p = a + b - c;
				const pa = Math.abs( p - a );
				const pb = Math.abs( p - b );
				const pc = Math.abs( p - c );
				v += pa <= pb && pa <= pc ? a : pb <= pc ? b : c;
			}
			cur[ x ] = v & 0xff;
		}
	}
	return { width, height, bpp, data: out };
}

/**
 * The pixels behind `handle` (interior) and around it (ring), with the element
 * itself hidden while they are photographed.
 *
 * `text: true` measures the box around the element's own lines of text instead
 * of the element. A heading is a block as wide as its column; centred over a
 * photograph, most of that box is picture the words never touch.
 */
export async function sampleBehind( page, handle, pad = 6, { text = false } = {} ) {
	await handle.scrollIntoViewIfNeeded();
	await page.waitForTimeout( 150 );
	const box = text
		? await handle.evaluate( ( el ) => {
			const rects = [];
			for ( const node of el.childNodes ) {
				if ( 3 === node.nodeType && node.textContent.trim() ) {
					const range = document.createRange();
					range.selectNodeContents( node );
					rects.push( ...range.getClientRects() );
				}
			}
			if ( ! rects.length ) {
				return null;
			}
			const x = Math.min( ...rects.map( ( r ) => r.left ) );
			const y = Math.min( ...rects.map( ( r ) => r.top ) );
			return {
				x,
				y,
				width: Math.max( ...rects.map( ( r ) => r.right ) ) - x,
				height: Math.max( ...rects.map( ( r ) => r.bottom ) ) - y,
			};
		} )
		: await handle.boundingBox();
	if ( ! box ) {
		return null;
	}
	const view = page.viewportSize();

	await handle.evaluate( ( el ) => {
		el.dataset.ucVisibility = el.style.visibility;
		el.style.visibility = 'hidden';
	} );

	const x0 = Math.max( 0, Math.floor( box.x - pad ) );
	const y0 = Math.max( 0, Math.floor( box.y - pad ) );
	const x1 = Math.min( view.width, Math.ceil( box.x + box.width + pad ) );
	const y1 = Math.min( view.height, Math.ceil( box.y + box.height + pad ) );
	const restore = () => handle.evaluate( ( el ) => {
		el.style.visibility = el.dataset.ucVisibility || '';
		delete el.dataset.ucVisibility;
	} );
	// Nothing of it inside the viewport: unmeasurable, which callers report.
	if ( x1 <= x0 || y1 <= y0 ) {
		await restore();
		return null;
	}
	const png = await page.screenshot( { clip: { x: x0, y: y0, width: x1 - x0, height: y1 - y0 } } );

	await restore();

	const img = decodePng( png );
	const left = box.x - x0;
	const top = box.y - y0;
	const interior = [];
	const ring = [];
	for ( let y = 0; y < img.height; y++ ) {
		for ( let x = 0; x < img.width; x++ ) {
			const i = ( y * img.width + x ) * img.bpp;
			const px = { r: img.data[ i ], g: img.data[ i + 1 ], b: img.data[ i + 2 ] };
			const inside = x >= left && x < left + box.width && y >= top && y < top + box.height;
			( inside ? interior : ring ).push( px );
		}
	}
	return { interior, ring };
}

/** Contrast of `color` against the worst tenth of `pixels`. */
export function worstTenth( color, pixels ) {
	if ( ! color || ! pixels || ! pixels.length ) {
		return null;
	}
	const ratios = pixels.map( ( p ) => contrast( color, p ) ).sort( ( a, b ) => a - b );
	return ratios[ Math.floor( ratios.length * 0.1 ) ];
}
