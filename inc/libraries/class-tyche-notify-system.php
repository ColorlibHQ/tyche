<?php
if ( ! defined( 'WPINC' ) ) {
	die();
}

class Tyche_Notify_System extends Epsilon_Notify_System {
	/**
	 * Are the required plugins installed ?
	 *
	 * @return bool
	 */
	public static function check_plugins() {
		$plugins = array(
			'contact-form-7' => false,
			'google-maps'    => false,
			'woocommerce'    => false,
			'polylang'       => false,
			'kirki'          => false,
		);

		$arr = array();

		foreach ( $plugins as $k => $v ) {
			$activated = false;
			$installed = self::check_plugin_is_installed( $k );
			if ( $installed ) {
				$activated = self::check_plugin_is_active( $k );
			}

			$arr[ $k ] = $activated;
		}

		$filtered = array_filter( $arr );

		if ( 5 === count( $filtered ) ) {
			return true;
		}

		return false;
	}
}
