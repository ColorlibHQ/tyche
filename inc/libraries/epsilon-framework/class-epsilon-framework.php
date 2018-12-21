<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once dirname( __FILE__ ) . '/class-epsilon-autoloader.php';

/**
 * Class Epsilon_Framework
 */
class Epsilon_Framework {
	/**
	 * @var array|mixed
	 */
	private $controls = array();
	/**
	 * @var array|mixed
	 */
	private $sections = array();
	/**
	 * @var mixed|string
	 */
	private $path = '/inc/libraries';

	/**
	 * Epsilon_Framework constructor.
	 *
	 * @param $args array
	 */
	public function __construct( $args ) {
		foreach ( $args as $k => $v ) {

			if ( ! in_array( $k, array( 'controls', 'sections', 'path' ) ) ) {
				continue;
			}

			$this->$k = $v;
		}

		/**
		 * Customizer enqueues & controls
		 */
		add_action( 'customize_register', array( $this, 'init_controls' ), 0 );

		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customizer_enqueue_scripts' ), 25 );
		add_action( 'customize_preview_init', array( $this, 'customize_preview_styles' ), 25 );

		/**
		 *
		 */
		add_action( 'wp_ajax_epsilon_framework_ajax_action', array(
			$this,
			'epsilon_framework_ajax_action',
		) );

	}

	/**
	 * Init custom controls
	 *
	 * @param object $wp_customize
	 */
	public function init_controls( $wp_customize ) {
		$path = get_template_directory() . $this->path . '/epsilon-framework';

		foreach ( $this->controls as $control ) {
			if ( file_exists( $path . '/controls/class-epsilon-control-' . $control . '.php' ) ) {
				require_once $path . '/controls/class-epsilon-control-' . $control . '.php';
			}
		}

		foreach ( $this->sections as $section ) {
			if ( file_exists( $path . '/sections/class-epsilon-section-' . $section . '.php' ) ) {
				require_once $path . '/sections/class-epsilon-section-' . $section . '.php';
			}
		}
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 */
	public function customize_preview_styles() {
		wp_enqueue_style( 'epsilon-styles', get_template_directory_uri() . $this->path . '/epsilon-framework/assets/css/style.css' );
		wp_enqueue_script( 'epsilon-previewer', get_template_directory_uri() . $this->path . '/epsilon-framework/assets/js/epsilon-previewer.js', array(
			'jquery',
			'customize-preview',
		), 2, true );

		wp_localize_script( 'epsilon-previewer', 'WPUrls', array(
			'siteurl' => get_option( 'siteurl' ),
			'theme'   => get_template_directory_uri(),
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		) );
	}

	/*
	 * Our Customizer script
	 *
	 * Dependencies: Customizer Controls script (core)
	 */
	public function customizer_enqueue_scripts() {
		wp_enqueue_script( 'epsilon-object', get_template_directory_uri() . $this->path . '/epsilon-framework/assets/js/epsilon.min.js', array(
			'jquery',
			'customize-controls',
		) );
		wp_localize_script( 'epsilon-object', 'WPUrls', array(
			'siteurl' => get_option( 'siteurl' ),
			'theme'   => get_template_directory_uri(),
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		) );
		wp_enqueue_style( 'epsilon-styles', get_template_directory_uri() . $this->path . '/epsilon-framework/assets/css/style.css' );

	}

	/**
	 * Ajax handler
	 */
	public function epsilon_framework_ajax_action() {
		if ( 'epsilon_framework_ajax_action' !== $_POST['action'] ) {
			wp_die(
				json_encode(
					array(
						'status' => false,
						'error'  => 'Not allowed',
					)
				)
			);
		}

		$this->_check_user_role();
		$args_action = array_map( 'sanitize_text_field', wp_unslash( $_POST['args']['action'] ) );
		$this->_check_structure( $args_action );
		$this->_check_class( $args_action[0] );

		$class  = $_POST['args']['action'][0];
		$method = $_POST['args']['action'][1];
		$args = isset( $_POST['args']['args'] ) ? $_POST['args']['args'] : $_POST['args'];
		$args = array_map( 'sanitize_text_field', wp_unslash( $args ) );

		$response = $class::$method( $args );

		if ( 'ok' == $response ) {
			wp_die(
				json_encode(
					array(
						'status'  => true,
						'message' => 'ok',
					)
				)
			);
		}

		wp_die(
			json_encode(
				array(
					'status'  => false,
					'message' => 'nok',
				)
			)
		);
	}

	/**
	 * @param $args
	 *
	 * @return string
	 */
	public static function dismiss_required_action( $args ) {
		$option = get_option( 'tyche_show_required_actions' );

		if ( $option ) :
			$option[ $args['id'] ] = false;
			update_option( 'tyche_show_required_actions', $option );
		else :
			$option = array(
				$args['id'] => false,
			);
			update_option( 'tyche_show_required_actions', $option );
		endif;

		return 'ok';
	}

	/**
	 * Send response
	 *
	 * @param array $args
	 */
	public function send_response( $args = array() ) {
		wp_die( wp_json_encode( $args ) );
	}
	/**
	 * Sanitizers
	 *
	 * @param $args
	 *
	 * @return array|string
	 */
	public static function sanitize_arguments( $args ) {
		if ( is_array( $args ) ) {
			return array_map( 'sanitize_text_field', $args );
		} else {
			return sanitize_text_field( $args );
		}
	}
	/**
	 * Output sanitizers
	 *
	 * @param $args
	 *
	 * @return array|string
	 */
	public static function sanitize_arguments_for_output( $args ) {
		if ( is_array( $args ) ) {
			return array_map( 'Epsilon_Ajax_Controller::sanitize_arguments_for_output', $args );
		} else {
			return wp_kses_post( $args );
		}
	}
	/**
	 * Not logged in
	 *
	 * @return string
	 */
	public static function not_logged_notice() {
		return esc_html__( 'You must be logged in to do that!', 'epsilon-framework' );
	}
	/**
	 * Checks nonce
	 *
	 * @return bool
	 */
	private function _check_nonce() {
		if ( isset( $_POST['args'], $_POST['args']['nonce'] ) && ! wp_verify_nonce( sanitize_key( $_POST['args']['nonce'] ), 'epsilon_nonce' ) ) {
			$this->send_response(
				array(
					'status' => false,
					'error'  => esc_html__( 'Not allowed', 'epsilon-framework' ),
				)
			);
		}
		return true;
	}
	/**
	 * Check if class exists
	 *
	 * @param string $class
	 *
	 * @return bool
	 */
	private function _check_class( $class = '' ) {
		if ( ! class_exists( $class ) || ! in_array( $class, array( 'Epsilon_Framework', 'Epsilon_Notifications' ) ) ) {
			$this->send_response(
				array(
					'status' => false,
					'error'  => esc_html__( 'Class does not exist', 'epsilon-framework' ),
				)
			);
		}
		return true;
	}
	/**
	 * Check array structure
	 *
	 * @param $action
	 *
	 * @return bool
	 */
	private function _check_structure( $action ) {
		if ( count( $action ) !== 2 ) {
			$this->send_response(
				array(
					'status' => false,
					'error'  => esc_html__( 'Not allowed', 'epsilon-framework' ),
				)
			);
		}
		return true;
	}
	/**
	 * Check user role
	 */
	private function _check_user_role() {
		$super_admin = is_super_admin( get_current_user_id() );
		if ( ! $super_admin ) {
			$this->send_response(
				array(
					'status' => false,
					'error'  => esc_html__( 'You must be a Super User!', 'epsilon-framework' ),
				)
			);
		}
		return true;
	}

}
