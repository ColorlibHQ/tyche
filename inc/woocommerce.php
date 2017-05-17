<?php
/**
 * Custom functions for WooCommerce
 *
 * @package Tyche
 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
remove_action( 'woocommerce_after_main_content', 'woocommerce_after_main_content' );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );

function tyche_get_cart_total() {
	if ( function_exists( 'WC' ) ) {
		return WC()->cart->cart_contents_total;
	}

	return 0;
}

remove_action( 'woocommerce_pagination', 'woocommerce_pagination', 10 );
function woocommerce_pagination() {
	tyche_numeric_posts_nav();
}

add_action( 'woocommerce_pagination', 'woocommerce_pagination', 10 );