<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Tyche_Customizer {
	public function __construct() {
		add_action( 'customize_register', array( $this, 'customize_register' ) );
	}

	public function customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

		$wp_customize->get_section( 'title_tagline' )->panel    = 'appearance';
		$wp_customize->get_section( 'title_tagline' )->title    = esc_html__( 'General Options', 'tyche' );
		$wp_customize->get_section( 'colors' )->panel           = 'appearance';
		$wp_customize->get_section( 'background_image' )->panel = 'appearance';

		if ( ! class_exists( 'Kirki' ) ) {
			require_once get_template_directory() . '/inc/libraries/class-kirki-installer-section.php';
		}

		/**
		 * Add the theme configuration
		 */
		tyche_Kirki::add_config( 'tyche_theme', array(
			'option_type' => 'theme_mod',
			'capability'  => 'edit_theme_options',
		) );

		/**
		 * Load panels, sections and options
		 */
		require_once get_template_directory() . '/inc/customizer/theme-options/panels.php';
		require_once get_template_directory() . '/inc/customizer/theme-options/sections.php';
		require_once get_template_directory() . '/inc/customizer/theme-options/options.php';
	}

	public function customize_preview_js() {
		wp_enqueue_script( 'tyche_customizer', get_template_directory_uri() . '/inc/customizer/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
	}

}