<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Registers the theme's customizer options using only core WordPress controls.
 *
 * This replaces the Kirki wrapper. The theme reads every one of its options with
 * get_theme_mod(), and never used Kirki's CSS output or its typography fields, so Kirki
 * was only ever registering controls -- which core can do. Setting ids are unchanged, so
 * values saved by earlier versions are still read by this one.
 *
 * The add_panel/add_section/add_field signatures match the ones the option files already
 * call, and the field arguments keep Kirki's vocabulary (settings, choices, required) so
 * those files did not have to be rewritten field by field.
 *
 * @package Tyche
 */
class Tyche_Customizer_Fields {

	/**
	 * @var WP_Customize_Manager|null
	 */
	protected static $manager = null;

	/**
	 * @param WP_Customize_Manager $wp_customize Customizer instance.
	 */
	public static function set_manager( $wp_customize ) {
		self::$manager = $wp_customize;
	}

	/**
	 * @param string $id   Panel id.
	 * @param array  $args Panel arguments.
	 */
	public static function add_panel( $id = '', $args = array() ) {
		if ( ! self::$manager ) {
			return;
		}

		self::$manager->add_panel( $id, $args );
	}

	/**
	 * @param string $id   Section id.
	 * @param array  $args Section arguments.
	 */
	public static function add_section( $id, $args = array() ) {
		if ( ! self::$manager ) {
			return;
		}

		self::$manager->add_section( $id, $args );
	}

	/**
	 * @param string $config_id Kept for call compatibility; unused.
	 * @param array  $args      Field arguments.
	 */
	public static function add_field( $config_id, $args ) {
		unset( $config_id );

		if ( ! self::$manager || empty( $args['settings'] ) || empty( $args['type'] ) ) {
			return;
		}

		$id   = $args['settings'];
		$type = $args['type'];

		self::$manager->add_setting(
			$id,
			array(
				'type'              => 'theme_mod',
				'default'           => isset( $args['default'] ) ? $args['default'] : '',
				'transport'         => isset( $args['transport'] ) ? $args['transport'] : 'refresh',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => isset( $args['sanitize_callback'] ) && is_callable( $args['sanitize_callback'] )
					? $args['sanitize_callback']
					: self::sanitizer( $type, $args ),
			)
		);

		$common = array(
			'label'           => isset( $args['label'] ) ? $args['label'] : '',
			'description'     => isset( $args['description'] ) ? $args['description'] : '',
			'section'         => isset( $args['section'] ) ? $args['section'] : 'theme_options_general',
			'priority'        => isset( $args['priority'] ) ? $args['priority'] : 10,
			'settings'        => $id,
			'active_callback' => self::active_callback( $args ),
		);

		self::add_control_for_type( $type, $id, $args, $common );
	}

	/**
	 * @param string $type   Field type.
	 * @param string $id     Setting id.
	 * @param array  $args   Original field arguments.
	 * @param array  $common Shared control arguments.
	 */
	protected static function add_control_for_type( $type, $id, $args, $common ) {
		$choices = isset( $args['choices'] ) ? $args['choices'] : array();

		switch ( $type ) {
			case 'image':
				self::$manager->add_control(
					new WP_Customize_Image_Control( self::$manager, $id, $common )
				);
				break;

			case 'toggle':
				self::$manager->add_control( $id, $common + array( 'type' => 'checkbox' ) );
				break;

			case 'number':
				self::$manager->add_control(
					$id,
					$common + array(
						'type'        => 'number',
						'input_attrs' => array(
							'min'  => isset( $choices['min'] ) ? $choices['min'] : 0,
							'max'  => isset( $choices['max'] ) ? $choices['max'] : 100,
							'step' => isset( $choices['step'] ) ? $choices['step'] : 1,
						),
					)
				);
				break;

			case 'radio':
			case 'radio-buttonset':
				self::$manager->add_control( $id, $common + array( 'type' => 'radio', 'choices' => $choices ) );
				break;

			case 'select':
				self::$manager->add_control( $id, $common + array( 'type' => 'select', 'choices' => $choices ) );
				break;

			case 'textarea':
				self::$manager->add_control( $id, $common + array( 'type' => 'textarea' ) );
				break;

			case 'code':
				self::$manager->add_control(
					new Tyche_Customize_Control_Code( self::$manager, $id, $common + array( 'choices' => $choices ) )
				);
				break;

			case 'palette':
				self::$manager->add_control(
					new Tyche_Customize_Control_Palette( self::$manager, $id, $common + array( 'choices' => $choices ) )
				);
				break;

			case 'dashicons':
				self::$manager->add_control(
					new Tyche_Customize_Control_Dashicons( self::$manager, $id, $common )
				);
				break;

			case 'sortable':
				self::$manager->add_control(
					new Tyche_Customize_Control_Sortable( self::$manager, $id, $common + array( 'choices' => $choices ) )
				);
				break;

			case 'repeater':
				self::$manager->add_control(
					new Tyche_Customize_Control_Repeater(
						self::$manager,
						$id,
						$common + array( 'fields' => isset( $args['fields'] ) ? $args['fields'] : array() )
					)
				);
				break;

			case 'text':
			default:
				self::$manager->add_control( $id, $common + array( 'type' => 'text' ) );
				break;
		}
	}

	/**
	 * Kirki's "required" is a list of conditions on other settings. Core expresses the
	 * same thing as an active_callback, so the conditions are translated rather than
	 * dropped -- without this every conditional field would show all the time.
	 *
	 * @param array $args Field arguments.
	 *
	 * @return callable|string
	 */
	protected static function active_callback( $args ) {
		if ( empty( $args['required'] ) || ! is_array( $args['required'] ) ) {
			return '__return_true';
		}

		$conditions = $args['required'];

		return function () use ( $conditions ) {
			foreach ( $conditions as $condition ) {
				if ( empty( $condition['setting'] ) ) {
					continue;
				}

				$value    = get_theme_mod( $condition['setting'] );
				$expected = isset( $condition['value'] ) ? $condition['value'] : true;
				$operator = isset( $condition['operator'] ) ? $condition['operator'] : '==';

				switch ( $operator ) {
					case '!=':
						$matches = ( $value != $expected ); // phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
						break;
					case '>':
						$matches = ( $value > $expected );
						break;
					case '<':
						$matches = ( $value < $expected );
						break;
					case 'in':
						$matches = in_array( $value, (array) $expected, false ); // phpcs:ignore WordPress.PHP.StrictInArray.FoundNonStrictFalse
						break;
					default:
						$matches = ( $value == $expected ); // phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
				}

				if ( ! $matches ) {
					return false;
				}
			}

			return true;
		};
	}

	/**
	 * Every setting gets a sanitize_callback; the theme directory requires it.
	 *
	 * @param string $type Field type.
	 * @param array  $args Field arguments.
	 *
	 * @return callable
	 */
	protected static function sanitizer( $type, $args ) {
		$choices = isset( $args['choices'] ) ? $args['choices'] : array();

		switch ( $type ) {
			case 'toggle':
				return array( __CLASS__, 'sanitize_checkbox' );

			case 'number':
				return 'absint';

			case 'image':
				return 'esc_url_raw';

			case 'code':
			case 'textarea':
				return 'wp_kses_post';

			case 'radio':
			case 'radio-buttonset':
			case 'select':
			case 'palette':
				return function ( $value ) use ( $choices ) {
					return array_key_exists( $value, $choices ) ? $value : '';
				};

			case 'dashicons':
				return 'sanitize_html_class';

			case 'sortable':
				return function ( $value ) use ( $choices ) {
					$value = is_array( $value ) ? $value : explode( ',', (string) $value );

					return array_values( array_intersect( array_map( 'sanitize_key', $value ), array_keys( $choices ) ) );
				};

			case 'repeater':
				$fields = isset( $args['fields'] ) ? $args['fields'] : array();

				return function ( $value ) use ( $fields ) {
					return Tyche_Customizer_Fields::sanitize_repeater( $value, $fields );
				};

			default:
				return 'sanitize_text_field';
		}
	}

	/**
	 * @param mixed $value Raw value.
	 *
	 * @return bool
	 */
	public static function sanitize_checkbox( $value ) {
		return ( '1' === $value || 1 === $value || true === $value || 'true' === $value );
	}

	/**
	 * Repeater rows arrive as JSON from the control and are stored as an array.
	 *
	 * An array, not a JSON string, because main-slider.php iterates the value directly.
	 * Each subfield is sanitised by its declared type, so the image comes back as an
	 * attachment id rather than a URL -- which is what wp_get_attachment_image() takes.
	 *
	 * @param mixed $value  Raw value.
	 * @param array $fields Subfield definitions.
	 *
	 * @return array
	 */
	public static function sanitize_repeater( $value, $fields = array() ) {
		$rows = is_string( $value ) ? json_decode( $value, true ) : $value;

		if ( ! is_array( $rows ) ) {
			return array();
		}

		$clean = array();

		foreach ( $rows as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}

			$out = array();

			foreach ( $fields as $name => $field ) {
				$raw  = isset( $row[ $name ] ) ? $row[ $name ] : '';
				$type = isset( $field['type'] ) ? $field['type'] : 'text';

				if ( 'image' === $type ) {
					$out[ $name ] = absint( $raw );
				} elseif ( 'url' === $type || preg_match( '/_url$/', $name ) ) {
					$out[ $name ] = esc_url_raw( $raw );
				} else {
					$out[ $name ] = sanitize_text_field( $raw );
				}
			}

			$clean[] = $out;
		}

		return $clean;
	}
}
