<?php
/**
 * Tyche Theme Customizer.
 *
 * @package Tyche
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function tyche_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->get_section( 'title_tagline' )->panel = 'appearance';
	$wp_customize->get_section( 'title_tagline' )->title = esc_html__('General Options', 'tyche');
	$wp_customize->get_section( 'colors' )->panel = 'appearance';
	$wp_customize->get_section( 'background_image' )->panel = 'appearance';
}

add_action( 'customize_register', 'tyche_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function tyche_customize_preview_js() {
	wp_enqueue_script( 'tyche_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}

add_action( 'customize_preview_init', 'tyche_customize_preview_js' );

/**
 * Add the theme configuration
 */
tyche_Kirki::add_config( 'tyche_theme', array(
	'option_type' => 'theme_mod',
	'capability'  => 'edit_theme_options',
) );


require_once get_template_directory() . '/inc/theme-options/panels.php';
require_once get_template_directory() . '/inc/theme-options/sections.php';
require_once get_template_directory() . '/inc/theme-options/options.php';