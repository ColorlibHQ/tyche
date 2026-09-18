<?php
/**
 * WooCommerce integration.
 *
 * On a block theme WooCommerce renders its own blocks, so there are no template
 * overrides here -- templates/*.html and assets/css/woocommerce.css do the work.
 * This file only states image sizes the design needs.
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;

/**
 * Image sizes.
 *
 * Product cards are 4:5 and up to about 440px wide, so 2x screens need a
 * source near 900px. The cards ask for the uncropped `woocommerce_single` size
 * and crop with CSS: WooCommerce's default thumbnail is a 1:1 crop, and cropping
 * a square to 4:5 a second time throws away the sides of the photograph.
 */
function tyche_woocommerce_support() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 600,
			'single_image_width'    => 1100,
		)
	);
}
add_action( 'after_setup_theme', 'tyche_woocommerce_support' );

/**
 * Keep WooCommerce from adding a second account icon and cart to the header.
 *
 * WooCommerce hooks its own mini-cart and customer-account blocks in after the
 * navigation of any header pattern, unless that pattern already contains them.
 * It looks for them in the pattern's own markup, and this theme's header keeps
 * them in a small pattern of their own -- so they are there, and WooCommerce
 * cannot see them, and a new store gets two carts and two account icons loose
 * in the middle of the bar, which pushes the header onto two rows.
 *
 * Only stores created since WooCommerce 8.5 are affected, because the whole
 * mechanism is gated on an option older stores never had: the existing preview
 * looked fine while every new one was wrong.
 *
 * @param string[] $patterns Pattern slugs WooCommerce will not hook into.
 * @return string[]
 */
function tyche_header_patterns_place_their_own_icons( $patterns ) {
	// Every header the theme ships, read off disk rather than listed by hand:
	// the list was written when there were five, and the two stacked headers
	// added after it went out with two carts and two account icons in the bar.
	// The registry cannot be asked, because this runs while it is being filled.
	static $headers = null;
	if ( null === $headers ) {
		$headers = array();
		foreach ( (array) glob( get_template_directory() . '/patterns/header*.php' ) as $file ) {
			$data      = get_file_data( $file, array( 'slug' => 'Slug' ) );
			$headers[] = $data['slug'] ? $data['slug'] : 'tyche/' . basename( $file, '.php' );
		}
	}

	return array_merge( (array) $patterns, $headers );
}
add_filter( 'woocommerce_hooked_blocks_pattern_exclude_list', 'tyche_header_patterns_place_their_own_icons' );
