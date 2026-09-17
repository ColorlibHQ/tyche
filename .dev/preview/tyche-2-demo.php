<?php
/**
 * Plugin Name: Tyche 2.0 preview — no orders
 * Description: Lets visitors use the Tyche 2.0 preview store's whole checkout without an order ever being placed.
 *
 * The preview exists so people can see the checkout, and people will fill it in
 * with their real name and address. Placing the order would store those details
 * on a demo site and try to email a customer. So the checkout request is refused
 * before WooCommerce creates an order, with a message saying why. Nothing is
 * written, and the rest of the store -- cart, drawer, shipping, totals -- behaves
 * exactly as it would on a real shop.
 *
 * Applies only to the /tyche-2/ site on this network.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether the current request belongs to the preview site.
 *
 * @return bool
 */
function tyche_preview_is_site() {
	return '/tyche-2/' === get_blog_details( get_current_blog_id() )->path;
}

/**
 * Refuse the block checkout's place-order request.
 */
add_filter(
	'rest_pre_dispatch',
	function ( $result, $server, $request ) {
		if ( null !== $result || ! tyche_preview_is_site() || 'POST' !== $request->get_method() ) {
			return $result;
		}
		if ( ! preg_match( '#^/wc/store(/v\d+)?/checkout/?$#', $request->get_route() ) ) {
			return $result;
		}
		return new WP_Error(
			'tyche_preview_checkout',
			'This is a preview store, so orders cannot be placed. Everything up to this step works as it would in a real shop.',
			array( 'status' => 403 )
		);
	},
	10,
	3
);

/**
 * The same for the classic checkout form, should a page use it.
 */
add_action(
	'woocommerce_after_checkout_validation',
	function ( $data, $errors ) {
		if ( tyche_preview_is_site() ) {
			$errors->add( 'tyche_preview_checkout', 'This is a preview store, so orders cannot be placed.' );
		}
	},
	10,
	2
);
