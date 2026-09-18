/**
 * Check that the menu can be reached at every width.
 *
 * The stacked header put its menu on a second line and hid that line once the
 * menu folded into its button — and the button was inside the line. The header
 * still measured well: contrast, overflow and the store test all judge what is
 * drawn, and a control that is not there is not a measurement. A phone had a
 * logo, a search, an account and a cart, and no way into the categories.
 *
 * So this asks the only question that catches it: at this width, can a person
 * open the menu and see links in it?
 *
 *   WP_URL=https://example.com node .dev/menu-check.mjs
 *   WP_URL=… TYCHE_WIDTHS=390,900,1280 TYCHE_PATHS=/,/shop/ node .dev/menu-check.mjs
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

		await context.close();
	}
}

await browser.close();

if ( failures ) {
	process.exit( 1 );
}
