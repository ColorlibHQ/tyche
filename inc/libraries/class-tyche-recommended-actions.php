<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The theme's setup checklist, shown in the Customizer.
 *
 * Everything here is core WordPress: a WP_Customize_Section subclass for the panel, the
 * REST API for dismissals, and wp.apiFetch for the request. The list this replaces came
 * from a bundled framework whose dismissal endpoint took a class and method name out of
 * $_POST with no nonce; this one is a single route guarded by a capability check, and
 * the nonce is core's own.
 *
 * @package Tyche
 */
class Tyche_Recommended_Actions {

	const OPTION = 'tyche_dismissed_actions';

	const REST_NAMESPACE = 'tyche/v1';

	/**
	 * Tyche_Recommended_Actions constructor.
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'register_section' ), 20 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * The setup steps, each with a check that says whether it is already done.
	 *
	 * @return array
	 */
	/**
	 * The setup steps.
	 *
	 * Values here are plain, unescaped strings on purpose: the customizer section
	 * renders them through a wp.template, where {{ }} escapes. Escaping in PHP too
	 * double-escapes -- an apostrophe reaches the panel as &#039;, and esc_url()'s
	 * &#038; separators survive into the href, breaking the query string.
	 */
	public static function get_actions() {
		$actions = array(
			array(
				'id'           => 'tyche-set-static-front-page',
				'title'        => __( 'Set a static front page', 'tyche' ),
				'description'  => __( 'Tyche\'s storefront front page only appears when Settings, Reading is set to show a static page.', 'tyche' ),
				'done'         => Tyche_Notify_System::is_not_static_page(),
				'button_url'   => self_admin_url( 'options-reading.php' ),
				'button_label' => __( 'Open Reading settings', 'tyche' ),
			),
			array(
				'id'           => 'tyche-install-woocommerce',
				'title'        => __( 'Install WooCommerce', 'tyche' ),
				'description'  => __( 'Tyche is a shop theme. Without WooCommerce the product, cart and checkout templates have nothing to render.', 'tyche' ),
				'done'         => Tyche_Notify_System::check_plugin_is_active( 'woocommerce' ),
				'button_url'   => self_admin_url( 'plugin-install.php?s=woocommerce&tab=search&type=term' ),
				'button_label' => __( 'Find WooCommerce', 'tyche' ),
			),
			array(
				'id'           => 'tyche-add-products',
				'title'        => __( 'Add a few products', 'tyche' ),
				'description'  => __( 'The front page pulls its product rows from your catalogue, so it stays empty until there are products to show.', 'tyche' ),
				'done'         => self::has_products(),
				'button_url'   => self_admin_url( 'post-new.php?post_type=product' ),
				'button_label' => __( 'Add a product', 'tyche' ),
			),
			array(
				'id'           => 'tyche-set-menu',
				'title'        => __( 'Build the main menu', 'tyche' ),
				'description'  => __( 'Assign a menu to the Primary location so visitors can reach your shop and category pages.', 'tyche' ),
				'done'         => self::has_primary_menu(),
				'button_url'   => self_admin_url( 'nav-menus.php' ),
				'button_label' => __( 'Open menus', 'tyche' ),
			),
			array(
				'id'           => 'tyche-add-widgets',
				'title'        => __( 'Fill the front page widget areas', 'tyche' ),
				'description'  => __( 'The front page is built from widget areas. Drop a widget into one to see a section appear.', 'tyche' ),
				'done'         => self::has_front_page_widgets(),
				'button_url'   => self_admin_url( 'widgets.php' ),
				'button_label' => __( 'Open widgets', 'tyche' ),
			),
		);

		$dismissed = (array) get_option( self::OPTION, array() );

		return array_values(
			array_filter(
				$actions,
				function ( $action ) use ( $dismissed ) {
					return ! in_array( $action['id'], $dismissed, true );
				}
			)
		);
	}

	/**
	 * @return bool
	 */
	private static function has_products() {
		if ( ! post_type_exists( 'product' ) ) {
			return false;
		}

		$counts = wp_count_posts( 'product' );

		return ! empty( $counts->publish );
	}

	/**
	 * @return bool
	 */
	private static function has_primary_menu() {
		$locations = get_nav_menu_locations();

		return ! empty( $locations['primary'] );
	}

	/**
	 * @return bool
	 */
	private static function has_front_page_widgets() {
		foreach ( array( 'content-area-1', 'content-area-2-a', 'content-area-2-b' ) as $sidebar ) {
			if ( is_active_sidebar( $sidebar ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @param WP_Customize_Manager $wp_customize Customizer instance.
	 */
	public function register_section( $wp_customize ) {
		require_once get_template_directory() . '/inc/customizer/class-tyche-customize-section-actions.php';

		// Without this the Customizer never prints the section's Underscore template,
		// so the section renders with its title and nothing inside it.
		$wp_customize->register_section_type( 'Tyche_Customize_Section_Actions' );

		$actions = self::get_actions();

		if ( empty( $actions ) ) {
			return;
		}

		$wp_customize->add_section(
			new Tyche_Customize_Section_Actions(
				$wp_customize,
				'tyche_recommended_actions',
				array(
					'title'      => esc_html__( 'Set up Tyche', 'tyche' ),
					'priority'   => 0,
					'capability' => 'edit_theme_options',
					'actions'    => $actions,
				)
			)
		);
	}

	/**
	 * Customizer pane assets.
	 */
	public function enqueue() {
		wp_enqueue_style(
			'tyche-customizer-actions',
			get_template_directory_uri() . '/assets/css/customizer-actions.css',
			array(),
			wp_get_theme()->get( 'Version' )
		);

		wp_enqueue_script(
			'tyche-customizer-actions',
			get_template_directory_uri() . '/assets/js/customizer-actions.js',
			array( 'customize-controls', 'wp-api-fetch' ),
			wp_get_theme()->get( 'Version' ),
			true
		);
	}

	/**
	 * One route, one capability check. wp-api-fetch sends the wp_rest nonce itself.
	 */
	public function register_routes() {
		register_rest_route(
			self::REST_NAMESPACE,
			'/dismiss-action',
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'dismiss_action' ),
				'permission_callback' => function () {
					return current_user_can( 'edit_theme_options' );
				},
				'args'                => array(
					'id' => array(
						'required'          => true,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_key',
						'validate_callback' => array( $this, 'is_known_action' ),
					),
				),
			)
		);
	}

	/**
	 * Only ids this theme actually defines may be stored.
	 *
	 * @param string $id Action id.
	 *
	 * @return bool
	 */
	public function is_known_action( $id ) {
		return in_array( $id, self::known_ids(), true );
	}

	/**
	 * @return array
	 */
	private static function known_ids() {
		return array(
			'tyche-set-static-front-page',
			'tyche-install-woocommerce',
			'tyche-add-products',
			'tyche-set-menu',
			'tyche-add-widgets',
		);
	}

	/**
	 * @param WP_REST_Request $request Request.
	 *
	 * @return WP_REST_Response
	 */
	public function dismiss_action( WP_REST_Request $request ) {
		$id        = $request->get_param( 'id' );
		$dismissed = (array) get_option( self::OPTION, array() );

		if ( ! in_array( $id, $dismissed, true ) ) {
			$dismissed[] = $id;
			update_option( self::OPTION, array_values( array_intersect( $dismissed, self::known_ids() ) ) );
		}

		return new WP_REST_Response( array( 'dismissed' => $id ), 200 );
	}
}
