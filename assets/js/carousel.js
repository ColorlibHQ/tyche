/**
 * The theme's two carousels, without a carousel library.
 *
 * Replaces Owl Carousel 2.1.4, which was released in 2016, is unmaintained, and brought
 * 156 KB and a jQuery dependency for two behaviours:
 *
 *   - the hero, which shows one slide at a time and advances on a timer;
 *   - the product rows, which show one, two or N products and step with arrows.
 *
 * The product rows are a scroll-snap track, so dragging, flicking and the scrollbar all
 * work without any of it being implemented here. Both respect prefers-reduced-motion,
 * pause while hovered or focused, and expose their controls to a screen reader.
 *
 * @package Tyche
 */
( function () {
	'use strict';

	var reduceMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	/* ---------------- hero ---------------- */

	function initHero( root ) {
		var slides = Array.prototype.filter.call( root.children, function ( el ) {
			return el.classList.contains( 'item' );
		} );

		if ( slides.length === 0 ) {
			return;
		}

		root.classList.add( 'tyche-slider' );
		slides.forEach( function ( s, i ) {
			s.classList.add( 'tyche-slider__slide' );
			s.setAttribute( 'aria-hidden', i === 0 ? 'false' : 'true' );
			if ( i === 0 ) {
				s.classList.add( 'is-active' );
			}
		} );

		if ( slides.length === 1 ) {
			return;
		}

		var index = 0;
		var timer = null;
		var DELAY = 17000;

		function show( next ) {
			next = ( next + slides.length ) % slides.length;
			slides[ index ].classList.remove( 'is-active' );
			slides[ index ].setAttribute( 'aria-hidden', 'true' );
			slides[ next ].classList.add( 'is-active' );
			slides[ next ].setAttribute( 'aria-hidden', 'false' );
			index = next;
		}

		function nav( dir, label, cls ) {
			var b = document.createElement( 'button' );
			b.type = 'button';
			b.className = cls;
			b.setAttribute( 'aria-label', label );
			b.innerHTML = '<i class="fa-solid fa-angle-' + ( dir < 0 ? 'left' : 'right' ) + '" aria-hidden="true"></i>';
			b.addEventListener( 'click', function () {
				show( index + dir );
				restart();
			} );
			root.appendChild( b );
			return b;
		}

		var strings = window.tycheCarousel || {};
		nav( -1, strings.previous || 'Previous slide', 'main-slider-previous' );
		nav( 1, strings.next || 'Next slide', 'main-slider-next' );

		function start() {
			if ( reduceMotion ) {
				return;
			}
			timer = window.setInterval( function () { show( index + 1 ); }, DELAY );
		}

		function stop() {
			window.clearInterval( timer );
			timer = null;
		}

		function restart() {
			stop();
			start();
		}

		root.addEventListener( 'mouseenter', stop );
		root.addEventListener( 'mouseleave', start );
		root.addEventListener( 'focusin', stop );
		root.addEventListener( 'focusout', start );
		document.addEventListener( 'visibilitychange', function () {
			if ( document.hidden ) { stop(); } else { start(); }
		} );

		start();
	}

	/* ---------------- product rows ---------------- */

	function initProductRow( container ) {
		var track = container.querySelector( '.tyche-product-slider' );

		if ( ! track ) {
			return;
		}

		track.classList.add( 'tyche-track' );

		var prev = container.querySelector( '.tyche-product-slider-navigation .prev' );
		var next = container.querySelector( '.tyche-product-slider-navigation .next' );

		function step() {
			var first = track.firstElementChild;
			if ( ! first ) {
				return track.clientWidth;
			}
			var style = window.getComputedStyle( track );
			var gap = parseFloat( style.columnGap || style.gap || 0 ) || 0;
			return first.getBoundingClientRect().width + gap;
		}

		function scrollBy( dir ) {
			track.scrollBy( {
				left: dir * step(),
				behavior: reduceMotion ? 'auto' : 'smooth'
			} );
		}

		function sync() {
			var max = track.scrollWidth - track.clientWidth - 1;
			if ( prev ) { prev.classList.toggle( 'is-disabled', track.scrollLeft <= 0 ); }
			if ( next ) { next.classList.toggle( 'is-disabled', track.scrollLeft >= max ); }
		}

		if ( prev ) {
			prev.addEventListener( 'click', function ( e ) { e.preventDefault(); scrollBy( -1 ); } );
		}
		if ( next ) {
			next.addEventListener( 'click', function ( e ) { e.preventDefault(); scrollBy( 1 ); } );
		}

		track.addEventListener( 'scroll', sync, { passive: true } );
		window.addEventListener( 'resize', sync );
		sync();
	}

	function init() {
		var hero = document.getElementById( 'main-slider' );
		if ( hero ) {
			initHero( hero );
		}
		Array.prototype.forEach.call(
			document.querySelectorAll( '.tyche-product-slider-container' ),
			initProductRow
		);
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
}() );
