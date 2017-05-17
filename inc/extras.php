<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Tyche
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function tyche_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}

add_filter( 'body_class', 'tyche_body_classes' );


/**
 * Get an attachment ID given a URL.
 *
 * @param string $url
 *
 * @return int Attachment ID on success, 0 on failure
 */
function tyche_get_attachment_id( $url ) {
	$attachment_id = 0;
	$dir           = wp_upload_dir();
	if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?
		$file       = basename( $url );
		$query_args = array(
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
			'fields'      => 'ids',
			'meta_query'  => array(
				array(
					'value'   => $file,
					'compare' => 'LIKE',
					'key'     => '_wp_attachment_metadata',
				),
			)
		);
		$query      = new WP_Query( $query_args );
		if ( $query->have_posts() ) {
			foreach ( $query->posts as $post_id ) {
				$meta                = wp_get_attachment_metadata( $post_id );
				$original_file       = basename( $meta['file'] );
				$cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
				if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
					$attachment_id = $post_id;
					break;
				}
			}
		}
	}

	return $attachment_id;
}

function tyche_numeric_posts_nav() {

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

function tyche_has_sidebar() {
	if ( class_exists( 'WooCommerce' ) ) {
		if ( is_cart() || is_account_page() ) {
			return true;
		}
	}

	return false;
}

function tyche_is_posts_page() {
	return (int) get_queried_object_id() === (int) get_option( 'page_for_posts' );
}

function tyche_get_woocommerge_page( $page = '' ) {
	switch ( $page ) {
		case 'cart':
			return get_permalink( get_option( 'woocommerce_cart_page_id' ) );
			break;
		case 'account':
			return get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
			break;
		default:
			return false;
			break;
	}
}

/**
 * Render breadcrumbs
 */
if ( ! function_exists( 'tyche_breadcrumbs' ) ) {
	/**
	 * Render the breadcrumbs with help of class-breadcrumbs.php
	 *
	 * @return void
	 */
	function tyche_breadcrumbs() {
		$breadcrumbs = new Tyche_Breadcrumbs();
		$breadcrumbs->get_breadcrumbs();
	}
}
