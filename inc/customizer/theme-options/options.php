<?php
/**
 * Tyche Theme Customizer.
 *
 * @package Tyche
 */

if ( ! class_exists( 'Kirki' ) ) {
	global $wp_customize;

	$wp_customize->add_setting( 'kirki_installer_setting', array() );
	$wp_customize->add_control( 'kirki_installer_control', array(
		'section'  => 'kirki_installer',
		'settings' => 'kirki_installer_setting',
	) );
}

/**
 *  Section information
 */
tyche_Kirki::add_field( 'tyche_theme', array(
	'settings' => 'tyche_frontpage_settings',
	'label'    => esc_html__( 'Front Page Settings', 'tyche' ),
	'section'  => 'frontpage_settings',
	'type'     => 'custom',
	'default'  => '<div style="padding: 30px;">' . esc_html__( 'You can enter custom markup in this control and use it however you want', 'tyche' ) . '</div>',
	'priority' => 11,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'settings' => 'tyche_color_scheme',
	'label'    => esc_html__( 'Color Scheme', 'tyche' ),
	'section'  => 'colors',
	'type'     => 'palette',
	'default'  => 'red',
	'choices'  => array(
		'red'       => array(
			'#f66249',
		),
		'beige'     => array(
			'#eaab76',
		),
		'black'     => array(
			'#252525',
		),
		'green'     => array(
			'#99ca45',
		),
		'blue'      => array(
			'#263585',
		),
		'lightblue' => array(
			'#2279d3',
		),
		'orange'    => array(
			'#ffab1a',
		),
	),
) );

/**
 * Theme Options Panel
 */
tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'toggle',
	'settings' => 'tyche_enable_top_bar',
	'label'    => esc_html__( 'Enable Header Top Bar', 'tyche' ),
	'section'  => 'theme_options_general',
	'default'  => '1',
	'priority' => 10,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'toggle',
	'settings' => 'tyche_enable_post_breadcrumbs',
	'label'    => esc_html__( 'Enable Breadcrumbs', 'tyche' ),
	'section'  => 'theme_options_general',
	'default'  => '1',
	'priority' => 12,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'tyche_contact_phone',
	'label'    => esc_html__( 'Contact Phone', 'tyche' ),
	'section'  => 'theme_options_contact_page',
	'default'  => '',
	'priority' => 10,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'tyche_contact_address',
	'label'    => esc_html__( 'Contact Address', 'tyche' ),
	'section'  => 'theme_options_contact_page',
	'default'  => '',
	'priority' => 11,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'              => 'text',
	'settings'          => 'tyche_contact_page_shortcode_form',
	'label'             => esc_html__( 'Contact Form Shortcode', 'tyche' ),
	'section'           => 'theme_options_contact_page',
	'default'           => '',
	'priority'          => 12,
	'sanitize_callback' => array( 'tyche_Kirki', 'unfiltered' ),
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'              => 'text',
	'settings'          => 'tyche_contact_page_shortcode_map',
	'label'             => esc_html__( 'Google Map Shortcode', 'tyche' ),
	'section'           => 'theme_options_contact_page',
	'default'           => '',
	'priority'          => 13,
	'sanitize_callback' => array( 'tyche_Kirki', 'unfiltered' ),
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'toggle',
	'settings' => 'tyche_show_banner',
	'label'    => esc_html__( 'Enable Banner in Header', 'tyche' ),
	'section'  => 'theme_options_general',
	'default'  => '1',
	'priority' => 13,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'radio',
	'settings' => 'tyche_banner_type',
	'label'    => esc_html__( 'Banner Type', 'tyche' ),
	'section'  => 'theme_options_general',
	'default'  => 'image',
	'priority' => 14,
	'choices'  => array(
		'image'   => esc_attr__( 'Image', 'tyche' ),
		'adsense' => esc_attr__( 'AdSense', 'tyche' ),
	),
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'image',
	'settings' => 'tyche_banner_image',
	'label'    => esc_html__( 'Banner Image', 'tyche' ),
	'section'  => 'theme_options_general',
	'default'  => get_template_directory_uri() . '/assets/images/banner.jpg',
	'priority' => 15,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'              => 'text',
	'settings'          => 'tyche_banner_link',
	'label'             => esc_html__( 'Banner URL', 'tyche' ),
	'section'           => 'theme_options_general',
	'default'           => 'http://colorlib.com',
	'priority'          => 16,
	'sanitize_callback' => 'esc_url_raw',
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'code',
	'settings' => 'tyche_banner_adsense_code',
	'label'    => esc_html__( 'AdSense Code', 'tyche' ),
	'section'  => 'theme_options_general',
	'default'  => '',
	'priority' => 17,
	'choices'  => array(
		'language' => 'javascript',
		'theme'    => 'monokai',
		'height'   => 250,
	),
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'settings' => 'tyche_footer_layout',
	'type'     => 'radio-image',
	'label'    => esc_html__( 'Layout', 'tyche' ),
	'section'  => 'theme_options_footer',
	'default'  => '4',
	'priority' => 10,
	'choices'  => array(
		'1' => get_template_directory_uri() . '/assets/images/1-column.png',
		'2' => get_template_directory_uri() . '/assets/images/2-column.png',
		'3' => get_template_directory_uri() . '/assets/images/3-column.png',
		'4' => get_template_directory_uri() . '/assets/images/4-column.png',
	),
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'toggle',
	'settings' => 'tyche_enable_copyright',
	'label'    => esc_html__( 'Enable Copyright', 'tyche' ),
	'section'  => 'theme_options_footer',
	'default'  => '1',
	'priority' => 11,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'tyche_copyright_contents',
	'label'    => esc_html__( 'Copyright Contents', 'tyche' ),
	'section'  => 'theme_options_footer',
	'default'  => 'Copyright &copy; ' . date( 'Y' ) . ' | Powered by WordPress.',
	'priority' => 12,
) );

/**
 * Frontpage settings
 */
tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'toggle',
	'settings' => 'tyche_enable_main_slider',
	'label'    => esc_html__( 'Enable Front Page Slider', 'tyche' ),
	'section'  => 'frontpage_sections_general',
	'default'  => '1',
	'priority' => 10,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'settings' => 'tyche_frontpage_sections',
	'label'    => esc_html__( 'Enable / Disable sections', 'tyche' ),
	'section'  => 'frontpage_sections_general',
	'type'     => 'sortable',
	'default'  => array(
		'content-area-1',
		'content-area-2',
		'content-area-3',
		'content-area-4',
		'content-area-5',
	),
	'priority' => 11,
	'choices'  => array(
		'content-area-1' => esc_attr__( 'Content Widget Area #1', 'tyche' ),
		'content-area-2' => esc_attr__( 'Content Widget Area #2', 'tyche' ),
		'content-area-3' => esc_attr__( 'Content Widget Area #3', 'tyche' ),
		'content-area-4' => esc_attr__( 'Content Widget Area #4', 'tyche' ),
		'content-area-5' => esc_attr__( 'Content Widget Area #5', 'tyche' ),
	),
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'settings' => 'tyche_slider_layout',
	'type'     => 'radio-image',
	'label'    => esc_html__( 'Layout', 'tyche' ),
	'section'  => 'frontpage_sections_bigtitle_images',
	'default'  => 'left',
	'priority' => 10,
	'choices'  => array(
		'left'   => get_template_directory_uri() . '/assets/images/align-left.png',
		'center' => get_template_directory_uri() . '/assets/images/align-center.png',
		'right'  => get_template_directory_uri() . '/assets/images/align-right.png',
	),
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'      => 'repeater',
	'label'     => esc_attr__( 'Slider Backgrounds', 'tyche' ),
	'section'   => 'frontpage_sections_bigtitle_images',
	'priority'  => 10,
	'row_label' => array(
		'type'  => 'text',
		'value' => esc_attr__( 'Background Image', 'tyche' ),
	),
	'default'   => array(
		'image_bg'        => get_template_directory_uri() . '/assets/images/hero.jpg',
		'cta_text'        => '2016',
		'cta_subtext'     => 'Autumn Collection',
		'button_one_text' => 'Shop Now',
		'button_two_text' => 'Learn More',
		'button_one_url'  => 'https://colorlib.com',
		'button_two_url'  => 'https://colorlib.com',
	),
	'settings'  => 'tyche_slider_bg',
	'fields'    => array(
		'image_bg'        => array(
			'type'    => 'image',
			'label'   => esc_attr__( 'Image', 'tyche' ),
			'default' => get_template_directory_uri() . '/assets/images/hero.jpg',
		),
		'cta_text'        => array(
			'type'    => 'text',
			'label'   => esc_html__( 'CTA Text', 'tyche' ),
			'default' => '2016',
		),
		'cta_subtext'     => array(
			'type'    => 'text',
			'label'   => esc_html__( 'CTA Subtext', 'tyche' ),
			'default' => 'Autumn Collection',
		),
		'button_one_text' => array(
			'type'    => 'text',
			'label'   => esc_html__( 'Button #1 Text', 'tyche' ),
			'default' => 'Shop Now',
		),
		'button_one_url'  => array(
			'type'    => 'text',
			'label'   => esc_html__( 'Button #1 URL', 'tyche' ),
			'default' => 'http://colorlib.com',
		),
		'button_two_text' => array(
			'type'    => 'text',
			'label'   => esc_html__( 'Button #2 Text', 'tyche' ),
			'default' => 'Learn More',
		),
		'button_two_url'  => array(
			'type'    => 'text',
			'label'   => esc_html__( 'Button #2 URL', 'tyche' ),
			'default' => 'http://colorlib.com',
		),
	),
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'info_section_one_text',
	'section'  => 'frontpage_sections_bigtitle_info',
	'default'  => 'FREE SHIPPING',
	'label'    => esc_html__( 'Info Section #1 Text', 'tyche' ),
	'priority' => 10,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'info_section_one_subtext',
	'default'  => 'On all orders over 90$',
	'section'  => 'frontpage_sections_bigtitle_info',
	'label'    => esc_html__( 'Info Section #1 Subtext', 'tyche' ),
	'priority' => 11,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'dashicons',
	'settings' => 'info_section_one_icon',
	'section'  => 'frontpage_sections_bigtitle_info',
	'label'    => esc_html__( 'Info Section #1 Icon', 'tyche' ),
	'priority' => 12,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'info_section_two_text',
	'default'  => 'CALL US ANYTIME',
	'section'  => 'frontpage_sections_bigtitle_info',
	'label'    => esc_html__( 'Info Section #2 Text', 'tyche' ),
	'priority' => 13,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'info_section_two_subtext',
	'default'  => '+04786445953',
	'section'  => 'frontpage_sections_bigtitle_info',
	'label'    => esc_html__( 'Info Section #2 Subtext', 'tyche' ),
	'priority' => 14,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'dashicons',
	'settings' => 'info_section_two_icon',
	'section'  => 'frontpage_sections_bigtitle_info',
	'label'    => esc_html__( 'Info Section #2 Icon', 'tyche' ),
	'priority' => 15,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'info_section_three_text',
	'default'  => 'OUR LOCATION',
	'section'  => 'frontpage_sections_bigtitle_info',
	'label'    => esc_html__( 'Info Section #1 Text', 'tyche' ),
	'priority' => 16,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'info_section_three_subtext',
	'section'  => 'frontpage_sections_bigtitle_info',
	'default'  => '557-6308 Lacinia Road. NYC',
	'label'    => esc_html__( 'Info Section #3 Subtext', 'tyche' ),
	'priority' => 17,
) );

tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'dashicons',
	'settings' => 'info_section_three_icon',
	'section'  => 'frontpage_sections_bigtitle_info',
	'label'    => esc_html__( 'Info Section #3 Icon', 'tyche' ),
	'priority' => 18,
) );
