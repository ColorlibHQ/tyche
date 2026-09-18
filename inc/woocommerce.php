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
 * navigation of any header template part. This theme's header already places
 * both, but they sit inside a pattern, and the Block Hooks API looks for them in
 * the part's own blocks -- where it cannot see them. On a site whose header is
 * saved in the database, that is a second cart and a second account icon
 * dropped into the middle of the bar, which pushes the header onto two rows.
 *
 * @param string[] $hooked_blocks      Block types to insert.
 * @param string   $relative_position   Where they would go.
 * @param string   $anchor_block_type   The block they attach to.
 * @param mixed    $context             The template, part or post being built.
 * @return string[]
 */
function tyche_skip_duplicate_header_icons( $hooked_blocks, $relative_position, $anchor_block_type, $context ) {
	if ( 'core/navigation' !== $anchor_block_type ) {
		return $hooked_blocks;
	}

	$area = '';
	if ( $context instanceof WP_Block_Template ) {
		$area = isset( $context->area ) ? $context->area : '';
	} elseif ( $context instanceof WP_Post && 'wp_template_part' === $context->post_type ) {
		$terms = get_the_terms( $context, 'wp_template_part_area' );
		$area  = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
	}

	if ( 'header' !== $area ) {
		return $hooked_blocks;
	}

	return array_values(
		array_diff( $hooked_blocks, array( 'woocommerce/mini-cart', 'woocommerce/customer-account' ) )
	);
}
add_filter( 'hooked_block_types', 'tyche_skip_duplicate_header_icons', 20, 4 );
