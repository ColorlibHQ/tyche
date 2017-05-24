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

tyche_Kirki::add_section( 'theme_options_general', array(
	'title'      => esc_html__( 'General', 'tyche' ),
	'panel'      => 'theme_options',
	'priority'   => 11,
	'capability' => 'edit_theme_options',
) );

tyche_Kirki::add_section( 'theme_options_footer', array(
	'title'      => esc_html__( 'Footer', 'tyche' ),
	'panel'      => 'theme_options',
	'priority'   => 12,
	'capability' => 'edit_theme_options',
) );

tyche_Kirki::add_section( 'theme_options_contact_page', array(
	'title'      => esc_html__( 'Contact Page', 'tyche' ),
	'panel'      => 'theme_options',
	'priority'   => 13,
	'capability' => 'edit_theme_options',
) );

tyche_Kirki::add_section( 'frontpage_sections_general', array(
	'title'      => esc_html__( 'General', 'tyche' ),
	'panel'      => 'frontpage_sections',
	'priority'   => 12,
	'capability' => 'edit_theme_options',
) );

tyche_Kirki::add_section( 'frontpage_sections_bigtitle', array(
	'title'      => esc_html__( 'Big title section', 'tyche' ),
	'panel'      => 'frontpage_sections',
	'priority'   => 13,
	'capability' => 'edit_theme_options',
) );

tyche_Kirki::add_section( 'frontpage_sections_bigtitle_images', array(
	'title'      => esc_html__( 'Big title section images', 'tyche' ),
	'panel'      => 'frontpage_sections',
	'priority'   => 14,
	'capability' => 'edit_theme_options',
) );

tyche_Kirki::add_section( 'frontpage_sections_bigtitle_info', array(
	'title'      => esc_html__( 'Big title section info', 'tyche' ),
	'panel'      => 'frontpage_sections',
	'priority'   => 15,
	'capability' => 'edit_theme_options',
) );
