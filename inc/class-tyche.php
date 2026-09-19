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

		// Added backwards compatibility with WooCommerce lower than 3.3.0
		require_once 'tyche-functions.php';
	}

	/**
	 * Block editor support
	 */
	public function init_blocks() {
		new Tyche_Blocks();
	}

	/**
	 * The Customizer setup checklist
	 */
	public function init_recommended_actions() {
		new Tyche_Recommended_Actions();
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
	 * Enqueue styles and scripts
	 */
	public function enqueues() {
		/*
		 * Every asset this theme owns is versioned with the theme version. Left
		 * empty, WordPress stamps its own version instead, so the URL stays
		 * identical across theme releases -- and a CDN serving these as immutable
		 * then keeps handing out the previous release's file forever.
		 */
		$version = wp_get_theme()->get( 'Version' );

		/**
		 * Enqueue styles
		 */
		wp_enqueue_style( 'tyche-fonts', get_template_directory_uri() . '/assets/css/fonts.css', array(), $version );
		/*
		 * Font Awesome 7, self-hosted. The bundled stylesheet is subsetted to the glyphs
		 * this theme renders, which is a fraction of the full set. A site that needs the
		 * rest -- for a widget, a page builder or a child theme -- can swap it:
		 *
		 *     add_filter( 'tyche_full_fontawesome', '__return_true' );
		 */
		$fa_uri = get_template_directory_uri() . '/assets/vendors/fontawesome7/';

		if ( apply_filters( 'tyche_full_fontawesome', false ) ) {
			wp_enqueue_style( 'tyche-icons', $fa_uri . 'fontawesome.min.css', array(), '7.3.1-1' );
			wp_enqueue_style( 'tyche-icons-solid', $fa_uri . 'solid.min.css', array( 'tyche-icons' ), '7.3.1' );
			wp_enqueue_style( 'tyche-icons-regular', $fa_uri . 'regular.min.css', array( 'tyche-icons' ), '7.3.1' );
			wp_enqueue_style( 'tyche-icons-brands', $fa_uri . 'brands.min.css', array( 'tyche-icons' ), '7.3.1' );
		} else {
			wp_enqueue_style( 'tyche-icons', $fa_uri . 'subset/fontawesome-subset.min.css', array(), '7.3.1-1' );
		}
		wp_enqueue_style( 'dashicons' );
		wp_enqueue_style( 'tyche', get_stylesheet_uri(), array(), $version );

		$scheme = get_theme_mod( 'tyche_color_scheme', 'red' );
		if ( 'red' !== $scheme ) {
			wp_enqueue_style( 'tyche-style', get_stylesheet_directory_uri() . '/assets/css/style-' . sanitize_key( $scheme ) . '.css', array(), $version );
		} else {
			wp_enqueue_style( 'tyche-style', get_stylesheet_directory_uri() . '/assets/css/style.css', array(), $version );
		}

		/*
		 * Loaded after the colour scheme, and declaring it as a dependency, so the
		 * refresh always layers on top of whichever scheme is active rather than
		 * relying on enqueue order. See the file header for why it is not in the SASS.
		 */
		wp_enqueue_style(
			'tyche-refresh',
			get_template_directory_uri() . '/assets/css/refresh.css',
			array( 'tyche-style' ),
			$version
		);

		$color = get_theme_mod( 'header_textcolor', '#ffffff' );
		if ( '#ffffff' === $color ) {
			$custom_css = '
                .site-header .site-title{
                    color: #" . esc_html( $color ) . ";
                }';
			wp_add_inline_style( 'tyche-style', $custom_css );
		}

		/**
		 * Enqueue scripts
		 */
		wp_enqueue_script( 'tyche-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), $version, true );
		wp_enqueue_script( 'tyche-multilang-menu', get_template_directory_uri() . '/assets/vendors/menu/menu.min.js', array(), $version, true );
		wp_enqueue_script( 'tyche-carousel', get_template_directory_uri() . '/assets/js/carousel.js', array(), $version, true );
		wp_localize_script(
			'tyche-carousel',
			'tycheCarousel',
			array(
				'previous' => esc_html__( 'Previous slide', 'tyche' ),
				'next'     => esc_html__( 'Next slide', 'tyche' ),
			)
		);
		wp_enqueue_script( 'tyche-jquery-zoom', get_template_directory_uri() . '/assets/vendors/jquery-zoom/jquery.zoom.min.js', array( 'jquery' ), '1.3.3', true );
		wp_register_script( 'tyche-adsenseloader', get_template_directory_uri() . '/assets/vendors/adsenseloader/jquery.adsenseloader.min.js', array( 'jquery' ), '1.0.0', true );
		wp_register_script(
			'tyche-scripts',
			get_template_directory_uri() . '/assets/js/functions.js',
			array(
				'jquery',
				'tyche-jquery-zoom',
			),
			$version,
			false
		);
		$tyche_helper = array(
			'initZoom' => 1,
			'ajaxURL' => admin_url( 'admin-ajax.php' ),
		);

		if ( false === get_theme_mod( 'tyche_enable_zoom_image_product', true ) ) {
			$tyche_helper['initZoom'] = 0;
		}

		wp_localize_script( 'tyche-scripts', 'tycheHelper', $tyche_helper );

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

			wp_enqueue_script( 'tyche_media_upload_js', get_template_directory_uri() . '/inc/customizer/assets/js/upload-media.js', array( 'jquery' ), $version );
			wp_enqueue_style( 'tyche_media_upload_css', get_template_directory_uri() . '/inc/customizer/assets/css/upload-media.css', array(), $version );

			wp_localize_script(
				'tyche_media_upload_js', 'EpsilonWPUrls', array(
					'siteurl' => get_option( 'siteurl' ),
					'theme'   => get_template_directory_uri(),
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
				)
			);
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
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);
		add_theme_support(
			'custom-logo',
			array(
				'height'     => 70,
				'width'      => 165,
				'flex-width' => true,
			)
		);
		add_theme_support(
			'custom-header',
			apply_filters(
				'tyche_custom_header_args',
				array(
					'default-image'      => '',
					'default-text-color' => '000000',
					'width'              => 1920,
					'height'             => 250,
					'flex-height'        => true,
				)
			)
		);

		// The Customizer offers a background colour and image; declaring support is what
		// puts those controls there.
		add_theme_support(
			'custom-background',
			apply_filters(
				'tyche_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add theme support for Infinite Scroll.
		add_theme_support(
			'infinite-scroll',
			array(
				'container' => 'main',
				'render'    => array( 'Tyche_Helper', 'infinite_scroll_render' ),
				'footer'    => 'page',
			)
		);
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
