<?php
/**
 * Pattern categories.
 *
 * WordPress reads patterns/*.php on its own. Categories are registered on
 * `init` so their labels are translated before the patterns that use them load.
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the categories.
 */
function tyche_register_pattern_categories() {
	$categories = array(
		'tyche-store'    => array(
			'label'       => __( 'Tyche: store sections', 'tyche' ),
			'description' => __( 'Heroes, collections, product rows and promotions.', 'tyche' ),
		),
		'tyche-content'  => array(
			'label'       => __( 'Tyche: content sections', 'tyche' ),
			'description' => __( 'Stories, reviews, questions and journal posts.', 'tyche' ),
		),
		'tyche-pages'    => array(
			'label'       => __( 'Tyche: pages', 'tyche' ),
			'description' => __( 'Complete page layouts.', 'tyche' ),
		),
	);

	foreach ( $categories as $slug => $args ) {
		register_block_pattern_category( $slug, $args );
	}
}
add_action( 'init', 'tyche_register_pattern_categories' );
