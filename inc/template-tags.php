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

/**
 * URL of a published page by slug, or a fallback when the store has no such page.
 *
 * Patterns link "Our story" to /about/, "Size guide" to /size-guide/ and so on.
 * Those pages exist when a store has built them -- Tyche offers each as a page
 * pattern -- and a link to a page that does not exist would be a 404, so the
 * fallback is the shop. Looked up with get_posts() on the page post type:
 * get_page_by_path() also matches attachments with the same slug.
 *
 * @param string $slug     Page slug.
 * @param string $fallback URL when no page has that slug; the shop by default.
 * @return string
 */
function tyche_page_url( $slug, $fallback = '' ) {
	static $found = array();

	if ( ! array_key_exists( $slug, $found ) ) {
		$ids            = get_posts(
			array(
				'name'           => $slug,
				'post_type'      => 'page',
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'no_found_rows'  => true,
			)
		);
		$found[ $slug ] = $ids ? get_permalink( $ids[0] ) : '';
	}

	return $found[ $slug ] ? $found[ $slug ] : ( $fallback ? $fallback : tyche_store_url( 'shop' ) );
}

/**
 * URL of a product category by slug, or the shop.
 *
 * @param string $slug Category slug.
 * @return string
 */
function tyche_category_url( $slug ) {
	$term = taxonomy_exists( 'product_cat' ) ? get_term_by( 'slug', $slug, 'product_cat' ) : false;
	$link = $term ? get_term_link( $term ) : '';

	return ( $link && ! is_wp_error( $link ) ) ? $link : tyche_store_url( 'shop' );
}

/**
 * URL of the posts page, or the home page when the site has none.
 *
 * @return string
 */
function tyche_blog_url() {
	$id = (int) get_option( 'page_for_posts' );

	return $id ? get_permalink( $id ) : home_url( '/' );
}

/**
 * The shop sorted a given way: newest, most popular.
 *
 * @param string $orderby date, popularity, rating or price.
 * @return string
 */
function tyche_shop_sorted_url( $orderby ) {
	return add_query_arg( 'orderby', $orderby, tyche_store_url( 'shop' ) );
}

/**
 * The amount a shopper has to spend for free delivery, formatted, or ''.
 *
 * The theme's copy promises free delivery over an amount, and that amount is
 * set in WooCommerce, not here. Reading it back means the promise on a product
 * page, in the announcement bar and on the store-promises card always matches
 * what the checkout actually does -- including on a store built from a starter,
 * where the threshold is the starter's, not the one this theme was written for.
 *
 * @return string
 */
function tyche_free_shipping_amount() {
	static $amount = null;

	if ( null !== $amount ) {
		return $amount;
	}

	$amount = '';

	if ( ! class_exists( 'WC_Shipping_Zones' ) ) {
		return $amount;
	}

	$zones   = WC_Shipping_Zones::get_zones();
	$zones[] = array( 'id' => 0 );
	$lowest  = 0;

	foreach ( $zones as $zone ) {
		$zone_object = new WC_Shipping_Zone( $zone['id'] );
		foreach ( $zone_object->get_shipping_methods( true ) as $method ) {
			if ( 'free_shipping' !== $method->id ) {
				continue;
			}
			$requires = $method->get_option( 'requires' );
			$minimum  = (float) $method->get_option( 'min_amount' );
			if ( $minimum > 0 && in_array( $requires, array( 'min_amount', 'either', 'both' ), true ) && ( ! $lowest || $minimum < $lowest ) ) {
				$lowest = $minimum;
			}
		}
	}

	if ( $lowest ) {
		// fmod() returns a float, so a strict comparison with 0 is never true and
		// every whole amount printed as "$40.00".
		$whole  = abs( fmod( $lowest, 1 ) ) < 0.005;
		$amount = wp_strip_all_tags( wc_price( $lowest, array( 'decimals' => $whole ? 0 : 2 ) ) );
	}

	return $amount;
}

/**
 * "Free delivery on orders over $40", or a sentence that promises no amount.
 *
 * @param string $context short for a badge, long for a sentence.
 * @return string
 */
function tyche_free_delivery_line( $context = 'long' ) {
	$amount = tyche_free_shipping_amount();

	if ( ! $amount ) {
		return 'short' === $context
			? __( 'Free delivery', 'tyche' )
			: __( 'Free delivery on qualifying orders', 'tyche' );
	}

	return 'short' === $context
		/* translators: %s: the amount an order has to reach, such as $75. */
		? sprintf( __( 'Free delivery over %s', 'tyche' ), $amount )
		/* translators: %s: the amount an order has to reach, such as $75. */
		: sprintf( __( 'Free delivery on orders over %s', 'tyche' ), $amount );
}

/**
 * What the journal calls itself.
 *
 * The blog's own page carries the words: its title, and its excerpt as the line
 * underneath. Theme copy cannot know what a store writes about — "Styling
 * notes, new collections" is right for knitwear and wrong for a coffee roaster
 * — so the store's own page is asked first and the theme only fills a gap.
 *
 * @param string $part title or intro.
 * @return string
 */
function tyche_blog_words( $part = 'title' ) {
	$page = (int) get_option( 'page_for_posts' );
	$post = $page ? get_post( $page ) : null;

	if ( 'intro' === $part ) {
		if ( $post && '' !== trim( (string) $post->post_excerpt ) ) {
			return $post->post_excerpt;
		}
		return __( 'Notes, guides and the people behind what we sell.', 'tyche' );
	}

	if ( $post && '' !== trim( (string) $post->post_title ) ) {
		return $post->post_title;
	}

	return __( 'Journal', 'tyche' );
}
