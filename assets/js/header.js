/**
 * Sticky header.
 *
 * The announcement bar scrolls away and the header below it sticks. CSS alone
 * cannot know the bar's height -- it wraps to two lines on a phone -- so this
 * measures it into --tyche-bar-height, which the sticky `top` subtracts. It also
 * marks the header once the page has scrolled, which is what draws its rule.
 *
 * Everything degrades to a header that simply scrolls with the page.
 */
( function () {
	const header = document.querySelector( '.tyche-site-header' );
	if ( ! header ) {
		return;
	}

	const bar = header.querySelector( '.tyche-announcement' );
	const root = document.documentElement;
	let ticking = false;

	const measure = () => {
		root.style.setProperty( '--tyche-bar-height', ( bar ? bar.offsetHeight : 0 ) + 'px' );
	};

	const update = () => {
		const threshold = bar ? bar.offsetHeight : 0;
		header.classList.toggle( 'is-scrolled', window.scrollY > threshold + 4 );
		ticking = false;
	};

	measure();
	update();

	window.addEventListener( 'scroll', () => {
		if ( ! ticking ) {
			ticking = true;
			window.requestAnimationFrame( update );
		}
	}, { passive: true } );

	if ( 'ResizeObserver' in window && bar ) {
		new ResizeObserver( measure ).observe( bar );
	} else {
		window.addEventListener( 'resize', measure );
	}
}() );
