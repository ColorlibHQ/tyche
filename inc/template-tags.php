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
