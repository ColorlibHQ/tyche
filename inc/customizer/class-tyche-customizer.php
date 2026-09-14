<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Tyche_Customizer
 */
class Tyche_Customizer {
	/**
	 * Tyche_Customizer constructor.
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'customize_register' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customizer_enqueues' ) );
		add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ) );
	}

	/**
	 * @param $wp_customize
	 */
	public function customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		$wp_customize->get_setting( 'custom_logo' )->transport     = 'refresh';
		$wp_customize->get_setting( 'header_textcolor' )->default  = 'ffffff';

		/*
		 * Panels, sections and fields are all registered here now. Kirki wanted them on
		 * init; core wants them on customize_register, where $wp_customize exists.
		 */
		require_once get_template_directory() . '/inc/customizer/class-tyche-customize-controls.php';
		require_once get_template_directory() . '/inc/customizer/class-tyche-customizer-fields.php';

		Tyche_Customizer_Fields::set_manager( $wp_customize );

		require_once get_template_directory() . '/inc/customizer/theme-options/panels.php';
		require_once get_template_directory() . '/inc/customizer/theme-options/sections.php';
		require_once get_template_directory() . '/inc/customizer/theme-options/options.php';

		$wp_customize->get_section( 'title_tagline' )->panel    = 'theme_options';
		$wp_customize->get_section( 'title_tagline' )->priority = 1;

		$wp_customize->get_section( 'colors' )->priority = 2;
		$wp_customize->get_section( 'colors' )->panel    = 'theme_options';


		if ( ! isset( $wp_customize->selective_refresh ) ) {
			return;
		}

		$wp_customize->selective_refresh->add_partial(
			'blogname', array(
				'selector'        => '.site-title',
				'render_callback' => array( 'Tyche_Helper', 'customize_partial_blogname' ),
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription', array(
				'selector'        => '.site-description',
				'render_callback' => array( 'Tyche_Helper', 'customize_partial_blogdescription' ),
			)
		);
	}

	/**
	 *
	 */
	public function customize_preview_js() {
		wp_enqueue_script( 'tyche_customizer', get_template_directory_uri() . '/inc/customizer/assets/js/previewer.js', array( 'customize-preview' ), '20132', true );
		wp_localize_script(
			'tyche_customizer', 'EpsilonWPUrls', array(
				'siteurl' => get_option( 'siteurl' ),
				'theme'   => get_template_directory_uri(),
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}

	/**
	 *
	 */
	public function customizer_enqueues() {
		wp_enqueue_media();

		$version = wp_get_theme()->get( 'Version' );

		wp_enqueue_style(
			'tyche-customizer-controls',
			get_template_directory_uri() . '/assets/css/customizer-controls.css',
			array(),
			$version
		);

		wp_enqueue_script(
			'tyche-customizer-controls',
			get_template_directory_uri() . '/assets/js/customizer-controls.js',
			array( 'jquery', 'jquery-ui-sortable', 'customize-controls' ),
			$version,
			true
		);

		wp_enqueue_style( 'tyche_media_upload_css', get_template_directory_uri() . '/inc/customizer/assets/css/upload-media.css' );
		wp_enqueue_script(
			'tyche_media_upload_js',
			get_template_directory_uri() . '/inc/customizer/assets/js/upload-media.js',
			array(
				'jquery',
				'customize-controls',
			)
		);
		wp_localize_script(
			'tyche_media_upload_js', 'EpsilonWPUrls', array(
				'siteurl' => get_option( 'siteurl' ),
				'theme'   => get_template_directory_uri(),
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}

}
