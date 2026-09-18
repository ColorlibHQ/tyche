<?php
/**
 * The Tyche icon collection for the Icon block.
 *
 * WordPress's own collection has a cart, a shield and a store, but nothing for
 * delivery, returns or support -- the promises every shop repeats under its
 * hero. These are Tabler outline icons (MIT), redrawn at a 1.5 stroke so they
 * sit beside the type rather than shouting over it.
 *
 * Icon collections arrived in WordPress 7.1. On 7.0 the Icon block renders
 * nothing for a name it does not know, so patterns that use these still lay out
 * correctly; they simply show no glyph.
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the collection and its icons.
 */
function tyche_register_icons() {
	if ( ! function_exists( 'wp_register_icon_collection' ) || ! function_exists( 'wp_register_icon' ) ) {
		return;
	}

	wp_register_icon_collection(
		'tyche',
		array(
			'label'       => __( 'Tyche', 'tyche' ),
			'description' => __( 'Store promises: delivery, returns, payment and support.', 'tyche' ),
		)
	);

	$icons = array(
		'truck-delivery' => __( 'Delivery', 'tyche' ),
		'arrow-back-up'  => __( 'Returns', 'tyche' ),
		'lock'           => __( 'Secure payment', 'tyche' ),
		'credit-card'    => __( 'Card', 'tyche' ),
		'headset'        => __( 'Support', 'tyche' ),
		'leaf'           => __( 'Sustainable', 'tyche' ),
		'recycle'        => __( 'Recycled', 'tyche' ),
		'gift'           => __( 'Gift', 'tyche' ),
		'package'        => __( 'Package', 'tyche' ),
		'ruler-measure'  => __( 'Size guide', 'tyche' ),
		'sparkles'       => __( 'New', 'tyche' ),
		'shield-check'   => __( 'Guarantee', 'tyche' ),
		'map-pin'        => __( 'Location', 'tyche' ),
		'clock'          => __( 'Opening hours', 'tyche' ),
		'heart'          => __( 'Favourite', 'tyche' ),
		'star'           => __( 'Rating', 'tyche' ),
		'sun'            => __( 'Light', 'tyche' ),
		'droplet'        => __( 'Water', 'tyche' ),
		'paw'            => __( 'Pet safe', 'tyche' ),
	);

	foreach ( $icons as $name => $label ) {
		wp_register_icon(
			'tyche/' . $name,
			array(
				'label'     => $label,
				'file_path' => get_template_directory() . '/assets/icons/' . $name . '.svg',
			)
		);
	}
}
add_action( 'init', 'tyche_register_icons' );
