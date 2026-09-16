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
