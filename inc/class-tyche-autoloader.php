<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Tyche_Autoloader
 */
class Tyche_Autoloader {
	public function __construct() {
		spl_autoload_register( array( $this, 'load' ) );
	}

	/**
	 * @param $class
	 */
	public function load( $class ) {
		$parts = explode( '_', $class );
		$bind  = implode( '-', $parts );

		$directories = array(
			get_template_directory() . '/inc/',
			get_template_directory() . '/inc/libraries/',
			get_template_directory() . '/inc/helpers/',
			get_template_directory() . '/inc/customizer/',
			get_template_directory() . '/inc/libraries/epsilon-framework/',
			get_template_directory() . '/inc/libraries/welcome-screen/'
		);

		foreach ( $directories as $directory ) {
			if ( file_exists( $directory . '/class-' . strtolower( $bind ) . '.php' ) ) {
				require_once $directory . '/class-' . strtolower( $bind ) . '.php';

				return;
			}
		}

		/**
		 * Load widgets
		 */
		if ( ( count( $parts ) > 2 ) && $parts[0] == 'Widget' && $parts[1] == 'Tyche' ) {
			$path = get_template_directory() . '/inc/libraries/widgets/' . strtolower( $bind ) . '/class-' . strtolower( $bind ) . '.php';
			if ( file_exists( $path ) ) {
				require_once $path;
			}
		}

	}
}

$autoloader = new Tyche_Autoloader();