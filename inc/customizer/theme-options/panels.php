<?php
/**
 * Tyche Theme Customizer.
 *
 * @package Tyche
 */

Tyche_Customizer_Fields::add_panel( 'appearance', array(
	'priority' => 10,
	'title'    => esc_html__( 'Appearance', 'tyche' ),
) );

Tyche_Customizer_Fields::add_panel( 'theme_options', array(
	'priority' => 10,
	'title'    => esc_html__( 'Theme Options', 'tyche' ),
) );

Tyche_Customizer_Fields::add_panel( 'frontpage_sections', array(
	'priority' => 14,
	'title'    => esc_html__( 'Front Page Sections', 'tyche' ),
) );
