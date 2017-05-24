<?php
/**
 * Adsense Banner template
 *
 * @package Tyche
 */

$code = get_theme_mod( 'tyche_banner_adsense_code', '' );

/**
 * In case we don't have an image, we terminate here
 */
if ( empty( $code ) ) {
	return false;
}

echo htmlspecialchars_decode( $code );
