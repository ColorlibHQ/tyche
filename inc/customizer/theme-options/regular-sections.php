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
