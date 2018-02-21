<?php

function tyche_get_loop_prop( $prop ) {

	if ( function_exists( 'wc_get_loop_prop' ) ) {
		return wc_get_loop_prop( $prop );
	}
	return true;
}
