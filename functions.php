<?php
/**
 * Shopper functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Shopper
 */

if ( ! function_exists( 'shopper_setup' ) ) :
	function shopper_setup() {
		load_theme_textdomain( 'shopper', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'title-tag' );

		add_theme_support( 'post-thumbnails' );

		add_image_size( 'shopper-blog-post-image', '730', '435', true );
		add_image_size( 'shopper-slider-image', '1600', '545', true );
		add_image_size( 'shopper-recent-post-list-image', '65', '65', true );
		add_image_size( 'shopper-recent-post-alternate-image', 160, 90, true );

		register_nav_menus( array(
			                    'primary' => esc_html__( 'Primary', 'shopper' ),
			                    'social'  => esc_html__( 'Copyright Social', 'shopper' ),
		                    ) );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		add_theme_support( 'custom-logo', array(
			'height'     => 70,
			'width'      => 165,
			'flex-width' => true,
		) );

		add_theme_support( 'custom-background', apply_filters( 'shopper_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		add_theme_support( 'custom-header', apply_filters( 'shopper_custom_header_args', array(
			'default-image'      => '',
			'default-text-color' => '000000',
			'width'              => 1000,
			'height'             => 250,
			'flex-height'        => true
		) ) );

		add_theme_support( 'woocommerce' );
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Welcome screen
		if ( is_admin() ) {
			global $shopper_required_actions;
			/*
			 * id - unique id; required
			 * title
			 * description
			 * check - check for plugins (if installed)
			 * plugin_slug - the plugin's slug (used for installing the plugin)
			 *
			 */
			$imported = get_option( 'mt_imported_demo' );

			if ( empty( $imported ) ) {
				$imported = false;
			} else {
				$imported = true;
			}

			$shopper_required_actions = array(

				array(
					"id"    => 'shopper-req-ac-install-additional-plugins',
					"title" => esc_html__( 'Please install plugins recommended through the notices.', 'shopper' ),
				),

				array(
					"id"          => 'shopper-req-ac-check-demo-content',
					"title"       => esc_html__( 'Check the demo content after installing Shopper Companion', 'shopper' ),
					"description" => esc_html__( "After installing Ensign Theme plugin, please make sure to import the demo content.", 'shopper' ),
					"check"       => $imported,
				)

			);
			require get_template_directory() . '/inc/welcome-screen/welcome-screen.php';
		}
	}
endif;
add_action( 'after_setup_theme', 'shopper_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function shopper_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'shopper_content_width', 640 );
}

add_action( 'after_setup_theme', 'shopper_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function shopper_scripts() {

	wp_enqueue_style( 'karla-font', '//fonts.googleapis.com/css?family=Karla:400,700' );
	wp_enqueue_style( 'font-awesome-style', get_template_directory_uri() . '/assets/css/font-awesome.min.css' );
	wp_enqueue_script( 'shopper-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '', true );
	wp_enqueue_script( 'shopper-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '', true );
	wp_enqueue_script( 'owlCarousel', get_template_directory_uri() . '/assets/js/owl-carousel/owl.carousel.min.js', array( 'jquery' ), '1.3.3', true );
	wp_enqueue_style( 'owlCarousel', get_template_directory_uri() . '/assets/css/owl-carousel/owl.carousel.min.css' );
	wp_enqueue_style( 'owlCarousel-theme', get_template_directory_uri() . '/assets/css/owl-carousel/owl.theme.default.css' );
	wp_register_script( 'shopper-scripts', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery' ), '', false );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Localize the script with new data
	$pass_it_by = array(
		'base'  => get_site_url( 'url' ),
		'flags' => get_site_url( 'url' ) . '/wp-content/plugins/qtranslate-x/flags/'
	);
	wp_localize_script( 'shopper-scripts', 'shopper_variables', $pass_it_by );

	$scheme = get_theme_mod( 'shopper_color_scheme', 'red' );

	if ( $scheme !== 'red' ) {
		wp_enqueue_style( 'shopper-style-alternate', get_stylesheet_directory_uri() . '/css/style-' . $scheme . '.css' );
	} else {
		wp_enqueue_style( 'shopper-style', get_stylesheet_uri() );
	}

	// Enqueued script with localized data.
	wp_enqueue_script( 'shopper-scripts' );
	wp_enqueue_style( 'dashicons' );

}

add_action( 'wp_enqueue_scripts', 'shopper_scripts', 15 );

/**
 * Register sidebars
 */
require get_template_directory() . '/inc/sidebars.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Recommend the Kirki plugin
 */
require get_template_directory() . '/inc/include-kirki.php';

/**
 * Load the Kirki Fallback class
 */
require get_template_directory() . '/inc/kirki-fallback.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Add breadcrumbs
 */
require get_template_directory() . '/inc/components/breadcrumbs/class-shopper-breadcrumbs.php';

/**
 * Add the WooCommerce helper file
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Add TGM class
 */
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'shopper_register_required_plugins' );

function shopper_register_required_plugins() {
	$plugins = array(
		array(
			'name'     => 'Shopper Companion',
			'slug'     => 'shopper-companion',
			'required' => false,
		),
		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => false
		),
		array(
			'name'     => 'Google Maps',
			'slug'     => 'google-maps',
			'required' => false,
		),
		array(
			'name'     => 'WooCommerce',
			'slug'     => 'woocommerce',
			'required' => false,
		),
		array(
			'name'     => 'qTranslate X',
			'slug'     => 'qtranslate-x',
			'required' => false,
		),

	);

	$config = array(
		'id'           => 'shopper',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
