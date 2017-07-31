<?php
/**
 * Tyche Theme Customizer.
 *
 * @package Tyche
 */

if ( ! class_exists( 'Kirki' ) ) {
	global $wp_customize;
	$wp_customize->add_section( new Kirki_Installer_Section( $wp_customize, 'kirki_installer', array(
		'title'      => '',
		'capability' => 'install_plugins',
		'priority'   => 0,
	) ) );
}

Tyche_Kirki::add_section( 'theme_options_general', array(
	'title'      => esc_html__( 'General', 'tyche' ),
	'panel'      => 'theme_options',
	'priority'   => 0,
	'capability' => 'edit_theme_options',
) );

Tyche_Kirki::add_section( 'theme_options_footer', array(
	'title'      => esc_html__( 'Footer', 'tyche' ),
	'panel'      => 'theme_options',
	'priority'   => 12,
	'capability' => 'edit_theme_options',
) );

Tyche_Kirki::add_section( 'theme_options_contact_page', array(
	'title'      => esc_html__( 'Contact Page', 'tyche' ),
	'panel'      => 'theme_options',
	'priority'   => 13,
	'capability' => 'edit_theme_options',
) );

Tyche_Kirki::add_section( 'frontpage_sections_general', array(
	'title'      => esc_html__( 'Frontpage Section Ordering and Visibility', 'tyche' ),
	'panel'      => 'frontpage_sections',
	'capability' => 'edit_theme_options',
) );

Tyche_Kirki::add_section( 'frontpage_sections_bigtitle_images', array(
	'title'      => esc_html__( 'Slider Section Images', 'tyche' ),
	'panel'      => 'frontpage_sections',
	'capability' => 'edit_theme_options',
) );

Tyche_Kirki::add_section( 'frontpage_sections_bigtitle_info', array(
	'title'      => esc_html__( 'Slider Section Info', 'tyche' ),
	'panel'      => 'frontpage_sections',
	'capability' => 'edit_theme_options',
) );

global $tyche_required_actions, $tyche_recommended_plugins;
$wp_customize->add_section(
	new Epsilon_Section_Recommended_Actions(
		$wp_customize,
		'epsilon_recommended_section',
		array(
			'title'                        => esc_html__( 'Recomended Actions', 'tyche' ),
			'social_text'                  => esc_html__( 'We are social :', 'tyche' ),
			'plugin_text'                  => esc_html__( 'Recomended Plugins :', 'tyche' ),
			'actions'                      => $tyche_required_actions,
			'plugins'                      => $tyche_recommended_plugins,
			'theme_specific_option'        => 'tyche_show_required_actions',
			'theme_specific_plugin_option' => 'tyche_show_required_plugins',
			'facebook'                     => 'https://www.facebook.com/colorlib',
			'twitter'                      => 'https://twitter.com/colorlib',
			'wp_review'                    => true,
			'theme_slug'                   => 'tyche',
			'priority'                     => 0,
		)
	)
);
