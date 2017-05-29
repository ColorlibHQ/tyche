<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Tyche
 */
class Tyche {
	/**
	 * Tyche constructor.
	 *
	 * Theme specific actions and filters
	 */
	public function __construct() {
		/**
		 * Start theme setup
		 */
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ) );
		/**
		 * Enqueue styles and scripts
		 */
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueues' ) );
		/**
		 * Admin enqueue
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueues' ) );
		/**
		 * Declare content width
		 */
		add_action( 'after_setup_theme', array( $this, 'content_width' ), 10 );
		/**
		 * Grab all class methods and initiate automatically
		 */
		$methods = get_class_methods( 'Tyche' );
		foreach ( $methods as $method ) {
			if ( strpos( $method, 'init_' ) !== false ) {
				$this->$method();
			}
		}
	}

	/**
	 * Tyche sidebars
	 */
	public function init_sidebars() {
		new Tyche_Sidebars();
	}

	/**
	 * Tyche customizer
	 */
	public function init_customizer() {
		new Tyche_Customizer();
	}

	/**
	 * Initiate kirki
	 */
	public function init_kirki() {
		new Tyche_Kirki();
	}

	/**
	 *
	 */
	public function init_hooks() {
		new Tyche_Hooks();
	}

	/**
	 * Initiate woocommerce hooks
	 */
	public function init_woocommerce_hooks() {
		new Tyche_WooCommerce_Hooks();
	}

	/**
	 * Init Epsilon Framework
	 */
	public function init_epsilon() {
		$args = array(
			'sections' => array( 'recommended-actions', 'pro' ),
			'path'     => '/inc/libraries',
		);

		new Epsilon_Framework( $args );
	}

	/**
	 * Initiate the welcome screen
	 */
	public function init_welcome_screen() {
		if ( is_admin() ) {
			global $tyche_required_actions, $tyche_recommended_plugins;
			$tyche_recommended_plugins = array();
			/*
			 * id - unique id; required
			 * title
			 * description
			 * check - check for plugins (if installed)
			 * plugin_slug - the plugin's slug (used for installing the plugin)
			 *
			 */

			$tyche_required_actions = array(
				array(
					'id'          => 'tyche-req-ac-install-additional-plugins',
					'title'       => esc_html__( 'Recommended Plugins', 'tyche' ),
					'description' => esc_html__( 'To fully take advantage of the tyche theme, please install the recommended plugins', 'tyche' ),
					'check'       => Tyche_Notify_System::check_tgmpa_saved_state(),
				),
			);

			new Tyche_Welcome_Screen();
		}
	}

	/**
	 * Enqueue styles and scripts
	 */
	public function enqueues() {
		/**
		 * Enqueue styles
		 */
		wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Karla:400,700' );
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/vendors/fontawesome/font-awesome.min.css' );
		wp_enqueue_style( 'owlCarousel', get_template_directory_uri() . '/assets/vendors/owl-carousel/owl.carousel.min.css' );
		wp_enqueue_style( 'owlCarousel-theme', get_template_directory_uri() . '/assets/vendors/owl-carousel/owl.theme.default.css' );
		wp_enqueue_style( 'dashicons' );
		wp_enqueue_style( 'tyche', get_stylesheet_uri() );

		$scheme = get_theme_mod( 'tyche_color_scheme', 'red' );
		if ( 'red' !== $scheme ) {
			wp_enqueue_style( 'tyche-style', get_stylesheet_directory_uri() . '/assets/css/style-' . $scheme . '.css' );
		} else {
			wp_enqueue_style( 'tyche-style', get_stylesheet_directory_uri() . '/assets/css/style.css' );
		}

		/**
		 * Enqueue scripts
		 */
		wp_enqueue_script( 'tyche-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '', true );
		wp_enqueue_script( 'tyche-multilang-menu', get_template_directory_uri() . '/assets/vendors/menu/menu.min.js', array(), '', true );
		wp_enqueue_script( 'owlCarousel', get_template_directory_uri() . '/assets/vendors/owl-carousel/owl.carousel.min.js', array( 'jquery' ), '1.3.3', true );
		wp_enqueue_script( 'jquery-zoom', get_template_directory_uri() . '/assets/vendors/jquery-zoom/jquery.zoom.min.js', array( 'jquery' ), '1.3.3', true );
		wp_register_script( 'adsenseloader', get_template_directory_uri() . '/assets/vendors/adsenseloader/jquery.adsenseloader.min.js', array( 'jquery' ), '1.0.0', true );
		wp_register_script( 'tyche-scripts', get_template_directory_uri() . '/assets/js/functions.js', array(
			'jquery',
			'jquery-zoom',
			'owlCarousel',
		), '', false );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		wp_enqueue_script( 'tyche-scripts' );
	}

	/**
	 * Admin enqueues
	 */
	public function admin_enqueues() {
		global $pagenow;
		if ( 'widgets.php' === $pagenow ) {
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_style( 'thickbox' );

			wp_enqueue_script( 'tyche_media_upload_js', get_template_directory_uri() . '/inc/customizer/assets/js/upload-media.js', array( 'jquery' ) );
			wp_enqueue_style( 'tyche_media_upload_css', get_template_directory_uri() . '/inc/customizer/assets/css/upload-media.css' );
		}
	}

	/**
	 * Theme setup
	 */
	public function theme_setup() {
		/**
		 * Load text domain
		 */
		load_theme_textdomain( 'tyche', get_template_directory() . '/languages' );

		/**
		 * Image sizes
		 */
		add_image_size( 'tyche-blog-post-image', '730', '435', true );
		add_image_size( 'tyche-slider-image', '1600', '545', true );
		add_image_size( 'tyche-product-layout-c', '160', '120', true );
		add_image_size( 'tyche-recent-post-list-image', '65', '65', true );
		add_image_size( 'tyche-recent-post-alternate-image', '160', '90', true );

		/**
		 * Menus
		 */
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary', 'tyche' ),
				'social'  => esc_html__( 'Copyright Social', 'tyche' ),
			)
		);
		/**
		 * Theme Supports
		 */
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
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
		add_theme_support( 'custom-header', apply_filters( 'tyche_custom_header_args', array(
			'default-image'      => '',
			'default-text-color' => '000000',
			'width'              => 1000,
			'height'             => 250,
			'flex-height'        => true,
		) ) );

		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add theme support for Infinite Scroll.
		add_theme_support( 'infinite-scroll', array(
			'container' => 'main',
			'render'    => array( 'Tyche_Helper', 'infinite_scroll_render' ),
			'footer'    => 'page',
		) );
	}

	/**
	 * Content width
	 */
	public function content_width() {
		if ( ! isset( $GLOBALS['content_width'] ) ) {
			$GLOBALS['content_width'] = 600;
		}
	}
}
