<?php
/**
 * Theme supports and assets.
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme supports.
 */
function tyche_setup() {
	load_theme_textdomain( 'tyche', get_template_directory() . '/languages' );

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// The stylesheet styles blocks, so the editor canvas has to load it too or
	// the product cards and header look nothing like the front end while editing.
	add_editor_style( array( 'style.css', 'assets/css/woocommerce.css' ) );
}
add_action( 'after_setup_theme', 'tyche_setup' );

/**
 * Front-end assets.
 *
 * style.css always loads. Block style variations keep their rules there rather
 * than in a per-style handle: those handles are only printed while WordPress
 * loads separate core block assets, and a plugin can switch that off site-wide,
 * which leaves every variation's class on the page and none of its CSS.
 */
function tyche_enqueue_assets() {
	wp_enqueue_style( 'tyche-style', get_stylesheet_uri(), array(), TYCHE_VERSION );

	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style(
			'tyche-woocommerce',
			get_template_directory_uri() . '/assets/css/woocommerce.css',
			array( 'tyche-style' ),
			TYCHE_VERSION
		);
	}

	wp_enqueue_script(
		'tyche-header',
		get_template_directory_uri() . '/assets/js/header.js',
		array(),
		TYCHE_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'tyche_enqueue_assets' );

/**
 * Preload the two faces every page's first screen uses.
 *
 * Without this the header and hero render in the fallback face and then swap,
 * which shifts the product grid on a slow connection.
 */
function tyche_preload_fonts() {
	$faces = array( 'figtree-latin-400-normal.woff2', 'instrument-serif-latin-400-normal.woff2' );

	foreach ( $faces as $face ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( get_theme_file_uri( 'assets/fonts/' . $face ) )
		);
	}
}
add_action( 'wp_head', 'tyche_preload_fonts', 1 );
