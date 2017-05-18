<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Tyche_Hooks
 */
class Tyche_WooCommerce_Hooks {
	/**
	 * Tyche_WooCommerce_Hooks constructor.
	 */
	public function __construct() {
		/**
		 * Remove actions
		 */
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_after_main_content' );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' );
		remove_action( 'woocommerce_pagination', 'woocommerce_pagination', 10 );

		/**
		 * Add actions
		 */
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );
		add_action( 'woocommerce_pagination', array( $this, 'woocommerce_pagination' ), 10 );
		add_action( 'after_setup_theme', array( $this, 'wpcom_setup' ) );
	}

	public static function get_cart_total() {
		if ( function_exists( 'WC' ) ) {
			return WC()->cart->cart_contents_total;
		}

		return 0;
	}

	public function wpcom_setup() {
		global $themecolors;

		// Set theme colors for third party services.
		if ( ! isset( $themecolors ) ) {
			$themecolors = array(
				'bg'     => '',
				'border' => '',
				'text'   => '',
				'link'   => '',
				'url'    => '',
			);
		}
	}

	public function woocommerce_pagination() {

		if ( is_singular() ) {
			return;
		}

		global $wp_query;

		/**
		 * Stop execution if there`s only 1 page
		 */
		if ( $wp_query->max_num_pages <= 1 ) {
			return;
		}

		$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
		$max   = intval( $wp_query->max_num_pages );

		/**
		 * Add current page to the array
		 */
		if ( $paged >= 1 ) {
			$links[] = $paged;
		}

		/**
		 * Add the pages around the current page to the array
		 */
		if ( $paged >= 3 ) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}

		echo '<div class="row text-center"><ul class="tyche-pager">' . "\n";

		/**
		 * Previous Post Link
		 */
		if ( get_previous_posts_link() ) {
			printf( '<li>%s</li>' . "\n", get_previous_posts_link( '<span class="fa fa-long-arrow-left"></span> <span class="pager-text prev">' . esc_html__( 'PREV', 'tyche' ) . '</span>' ) );
		}

		/**
		 * Link to first page, plus ellipses if necessary
		 */
		if ( ! in_array( 1, $links ) ) {
			$class = 1 == $paged ? ' class="active"' : '';

			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

			if ( ! in_array( 2, $links ) ) {
				echo '<li>…</li>';
			}
		}

		/**
		 * Link to current page, plus 2 pages in either direction if necessary
		 */
		sort( $links );
		foreach ( (array) $links as $link ) {
			$class = $paged == $link ? ' class="active"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
		}

		/**
		 * Link to last page, plus ellipses if necessary
		 */
		if ( ! in_array( $max, $links ) ) {
			if ( ! in_array( $max - 1, $links ) ) {
				echo '<li>…</li>' . "\n";
			}

			$class = $paged == $max ? ' class="active"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
		}

		/**
		 * Next Post Link
		 */
		if ( get_next_posts_link() ) {
			printf( '<li>%s</li>' . "\n", get_next_posts_link( '<span class="pager-text right">' . esc_html__( 'NEXT', 'tyche' ) . '</span> <span class="fa fa-long-arrow-right"></span>' ) );
		}

		echo '</ul></div>' . "\n";

	}
}