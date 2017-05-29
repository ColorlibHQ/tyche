<?php
if ( ! defined( 'WPINC' ) ) {
	die();
}

class Tyche_Notify_System extends Epsilon_Notify_System {
	/**
	 * Are the required plugins installed ?
	 */
	public static function check_tgmpa_saved_state() {
		$option = get_option( 'tyche_tgmpa_saved_state' );
		if ( 'plugins-installed' == $option ) {
			return true;
		}

		return false;
	}
}
