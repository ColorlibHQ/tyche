<?php
/**
 * Block style variations.
 *
 * Registered in PHP because a variation needs a translatable label for the
 * editor's Styles panel. Each name is a class that style.css already styles, so
 * a pattern can ask for it and a store owner can apply it to their own blocks.
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the variations.
 */
function tyche_register_block_styles() {
	$styles = array(
		'core/heading'   => array(
			'tyche-eyebrow' => __( 'Eyebrow', 'tyche' ),
		),
		'core/paragraph' => array(
			'tyche-eyebrow' => __( 'Eyebrow', 'tyche' ),
		),
		'core/button'    => array(
			'tyche-outline' => __( 'Outline', 'tyche' ),
			'tyche-link'    => __( 'Text link', 'tyche' ),
		),
		'core/group'     => array(
			'tyche-card' => __( 'Card', 'tyche' ),
		),
		'core/list'      => array(
			'tyche-checks' => __( 'Check list', 'tyche' ),
		),
		'core/image'     => array(
			'tyche-zoom' => __( 'Zoom on hover', 'tyche' ),
		),
		'core/cover'     => array(
			'tyche-zoom' => __( 'Zoom on hover', 'tyche' ),
		),
	);

	foreach ( $styles as $block => $variations ) {
		foreach ( $variations as $name => $label ) {
			register_block_style(
				$block,
				array(
					'name'  => $name,
					'label' => $label,
				)
			);
		}
	}
}
add_action( 'init', 'tyche_register_block_styles' );
