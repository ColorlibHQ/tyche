/**
 * Check the header: that the menu can be reached, and that the store's icons
 * appear once each.
 *
 * Both faults this catches shipped, and neither was visible to any other check.
 * The stacked header put its menu on a second line and hid that line once the
 * menu folded into its button — and the button was inside the line, so a phone
 * had a logo, a search, an account and a cart, and no way into the categories.
 * Contrast, overflow and the store test all judge what is drawn, and a control
 * that is not there is not a measurement.
 *
 * Then WooCommerce hooks its own mini-cart and account link into any header
 * pattern that does not appear to contain them, and Tyche keeps both in a
 * nested pattern it cannot see: two carts and two account icons. It only
 * happens on stores created since WooCommerce 8.5, so the dev bed has to carry
 * `woocommerce_hooked_blocks_version` or this check is theatre.
 *
 *   WP_URL=https://example.com node .dev/header-check.mjs
 *   WP_URL=… TYCHE_WIDTHS=390,900,1280 TYCHE_PATHS=/,/shop/ node .dev/header-check.mjs
 *
 * @package Tyche
 */

import { chromium } from 'playwright';

const site = process.env.WP_URL || 'http://localhost';
const paths = ( process.env.TYCHE_PATHS || '/' ).split( ',' ).filter( Boolean );
const widths = ( process.env.TYCHE_WIDTHS || '390,768,1024,1280' ).split( ',' ).map( Number );

const browser = await chromium.launch();
let failures = 0;

for ( const path of paths ) {
	for ( const width of widths ) {
		const context = await browser.newContext( {
			viewport: { width, height: 900 },
			isMobile: width <= 480,
			hasTouch: width <= 480,
		} );
		const page = await context.newPage();
		await page.goto( site + path, { waitUntil: 'domcontentloaded', timeout: 90000 } );
		await page.waitForTimeout( 1500 );

		// An open menu counts however it is shown: inline in the bar on a wide
		// screen, or behind a button on a narrow one.
		const shown = await page.evaluate( () => {
			const visible = ( el ) => {
				if ( ! el ) {
					return false;
				}
				const box = el.getBoundingClientRect();
				return box.width > 0 && box.height > 0 && 'hidden' !== getComputedStyle( el ).visibility;
			};
			const links = Array.from(
				document.querySelectorAll( 'header .wp-block-navigation__container > .wp-block-navigation-item > a' )
			).filter( visible );

			return { inline: links.length, toggle: visible( document.querySelector( 'header .wp-block-navigation__responsive-container-open' ) ) };
		} );

		let opened = 0;
		if ( ! shown.inline && shown.toggle ) {
			await page.click( 'header .wp-block-navigation__responsive-container-open' );
			await page.waitForTimeout( 700 );
			opened = await page.evaluate(
				() => document.querySelectorAll( '.wp-block-navigation__responsive-container.is-menu-open a' ).length
			);
		}

		const icons = await page.evaluate( () => ( {
			cart: document.querySelectorAll( 'header .wc-block-mini-cart' ).length,
			account: document.querySelectorAll( 'header .wp-block-woocommerce-customer-account' ).length,
			search: document.querySelectorAll( 'header .wp-block-search' ).length,
		} ) );
		const doubled = Object.entries( icons ).filter( ( [ , n ] ) => n > 1 );

		if ( shown.inline ) {
			console.log( `${ path } @ ${ width }px — ${ shown.inline } links in the bar` );
		} else if ( opened ) {
			console.log( `${ path } @ ${ width }px — button opens ${ opened } links` );
		} else {
			failures++;
			console.log(
				`${ path } @ ${ width }px — NO MENU: ${ shown.toggle ? 'the button opens nothing' : 'no menu and no button' }`
			);
		}

		if ( doubled.length ) {
			failures++;
			console.log(
				`${ path } @ ${ width }px — DOUBLED: ${ doubled.map( ( [ name, n ] ) => `${ n } ${ name }s` ).join( ', ' ) }`
			);
		}

		await context.close();
	}
}

await browser.close();

if ( failures ) {
	process.exit( 1 );
}
