<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Block editor support: a pattern category, block styles and editor styles.
 *
 * Tyche stays a classic theme -- its PHP templates, widget areas and Customizer options
 * all keep working -- but everything the block editor can use is declared here, so a
 * shop built with blocks looks like the rest of the theme.
 *
 * The patterns themselves live in /patterns and are registered by WordPress from their
 * file headers; nothing here has to list them.
 *
 * @package Tyche
 */
class Tyche_Blocks {

	/**
	 * Tyche_Blocks constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_pattern_category' ) );
		add_action( 'init', array( $this, 'register_block_styles' ) );
		add_action( 'after_setup_theme', array( $this, 'add_support' ) );
		add_action( 'enqueue_block_assets', array( $this, 'editor_assets' ) );
	}

	/**
	 * The category the theme's own patterns are filed under.
	 */
	public function register_pattern_category() {
		if ( ! function_exists( 'register_block_pattern_category' ) ) {
			return;
		}

		register_block_pattern_category(
			'tyche',
			array(
				'label'       => esc_html__( 'Tyche', 'tyche' ),
				'description' => esc_html__( 'Shop sections in the Tyche style.', 'tyche' ),
			)
		);
	}

	/**
	 * Block style variations, in the theme's own idiom.
	 */
	public function register_block_styles() {
		if ( ! function_exists( 'register_block_style' ) ) {
			return;
		}

		register_block_style(
			'core/image',
			array(
				'name'         => 'tyche-framed',
				'label'        => __( 'Framed', 'tyche' ),
				'inline_style' => '.wp-block-image.is-style-tyche-framed img {
					padding: 8px;
					border: 1px solid var(--wp--preset--color--border, #ebebeb);
					background: #fff;
				}',
			)
		);

		register_block_style(
			'core/heading',
			array(
				'name'         => 'tyche-underlined',
				'label'        => __( 'Rule beneath', 'tyche' ),
				'inline_style' => '.wp-block-heading.is-style-tyche-underlined {
					position: relative;
					padding-bottom: 14px;
				}
				.wp-block-heading.is-style-tyche-underlined::after {
					position: absolute;
					left: 0;
					bottom: 0;
					width: 46px;
					height: 2px;
					background: var(--wp--preset--color--primary, #f66249);
					content: "";
				}',
			)
		);

		register_block_style(
			'core/group',
			array(
				'name'         => 'tyche-bordered',
				'label'        => __( 'Bordered', 'tyche' ),
				'inline_style' => '.wp-block-group.is-style-tyche-bordered {
					padding: 24px;
					border: 1px solid var(--wp--preset--color--border, #ebebeb);
				}',
			)
		);
	}

	/**
	 * Editor features the theme can honour.
	 */
	public function add_support() {
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/editor.css' );
	}

	/**
	 * The theme's fonts, in the editor as well as the front end, so text is measured the
	 * same in both.
	 */
	public function editor_assets() {
		if ( ! is_admin() ) {
			return;
		}

		wp_enqueue_style(
			'tyche-fonts-editor',
			get_template_directory_uri() . '/assets/css/fonts.css',
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
}
