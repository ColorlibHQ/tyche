<?php
/**
 * Small helpers the patterns call while they render.
 *
 * Patterns are PHP, so a link to the shop or the account page can be resolved
 * when the page renders instead of being hard-coded to a slug that a store may
 * have renamed. Each helper still returns something sensible without
 * WooCommerce, so a pattern never prints an empty href.
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL of a WooCommerce page, or the home page when WooCommerce is not active.
 *
 * @param string $page One of shop, cart, checkout, myaccount.
 * @return string
 */
function tyche_store_url( $page = 'shop' ) {
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		$url = wc_get_page_permalink( $page );
		if ( $url ) {
			return $url;
		}
	}

	return home_url( '/' );
}

/**
 * Whether WooCommerce is active.
 *
 * Store blocks in a pattern are only printed when it is, so a site without
 * WooCommerce does not get "this block is not available" in its header.
 *
 * @return bool
 */
function tyche_has_woocommerce() {
	return class_exists( 'WooCommerce' );
}
