<?php
/**
 * The notice a site updating from Tyche 1.x sees.
 *
 * 2.0 is a block theme. Menus, the logo, products and pages carry over; the 1.x
 * homepage slider, front-page widget sections, colour schemes and Customizer
 * options do not, because a block theme has no Customizer. A store owner should
 * hear that from the theme, once, rather than discover it on the live site.
 *
 * Nothing here changes site data. The notice shows only to people who can edit
 * the theme, only on the dashboard and the Themes screen, only on sites that
 * actually ran 1.x, and each person can dismiss it.
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether this site stored settings from Tyche 1.x.
 *
 * @return bool
 */
function tyche_has_1x_settings() {
	$keys = array(
		'tyche_slider_bg',
		'tyche_frontpage_sections',
		'tyche_enable_main_slider',
		'tyche_color_scheme',
		'tyche_shop_layout',
		'tyche_banner_image',
		'tyche_footer_layout',
		'tyche_enable_top_bar',
	);

	foreach ( $keys as $key ) {
		if ( false !== get_theme_mod( $key, false ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Print the notice.
 */
function tyche_upgrade_notice() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || ! in_array( $screen->id, array( 'dashboard', 'themes' ), true ) ) {
		return;
	}

	if ( get_user_meta( get_current_user_id(), 'tyche_dismissed_2_0_notice', true ) || ! tyche_has_1x_settings() ) {
		return;
	}

	$dismiss = wp_nonce_url( add_query_arg( 'tyche-dismiss-notice', '2-0' ), 'tyche-dismiss-notice' );
	?>
	<div class="notice notice-info">
		<p><strong><?php esc_html_e( 'Tyche 2.0 is a block theme.', 'tyche' ); ?></strong></p>
		<p>
			<?php esc_html_e( 'Your menus, logo, products and pages carry over. The Tyche 1.x homepage slider, front-page widget sections, colour schemes and Customizer options are no longer used: the header, footer, shop and every other template are now designed in the Site Editor.', 'tyche' ); ?>
		</p>
		<p>
			<?php esc_html_e( 'If Settings > Reading shows one of your pages as the front page, that page is still your homepage. To use the new store homepage, add the "Store homepage" pattern to that page, or set the front page to show your latest posts.', 'tyche' ); ?>
		</p>
		<p>
			<a class="button button-primary" href="<?php echo esc_url( admin_url( 'site-editor.php' ) ); ?>"><?php esc_html_e( 'Open the Site Editor', 'tyche' ); ?></a>
			<a class="button" href="<?php echo esc_url( admin_url( 'options-reading.php' ) ); ?>"><?php esc_html_e( 'Reading settings', 'tyche' ); ?></a>
			<a class="button-link" href="<?php echo esc_url( $dismiss ); ?>"><?php esc_html_e( 'Dismiss', 'tyche' ); ?></a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'tyche_upgrade_notice' );

/**
 * Dismiss the notice for the current user.
 *
 * The request is only honoured with a valid nonce from the dismiss link and for
 * someone allowed to see the notice in the first place.
 */
function tyche_dismiss_upgrade_notice() {
	if ( ! isset( $_GET['tyche-dismiss-notice'] ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	check_admin_referer( 'tyche-dismiss-notice' );
	update_user_meta( get_current_user_id(), 'tyche_dismissed_2_0_notice', 1 );

	wp_safe_redirect( remove_query_arg( array( 'tyche-dismiss-notice', '_wpnonce' ) ) );
	exit;
}
add_action( 'admin_init', 'tyche_dismiss_upgrade_notice' );
