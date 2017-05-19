<?php

class Tyche_Helper {

	/**
	 * @param string $dirname 'foo-bar'
	 *
	 * @return string 'Foo_Bar'
	 */
	public static function dirname_to_classname( $dirname ) {
		$class_name = explode( '-', $dirname );
		$class_name = array_map( 'ucfirst', $class_name );
		$class_name = implode( '_', $class_name );

		return $class_name;
	}

	/**
	 * Proxy function to return posts
	 *
	 * @param $args
	 *
	 * @return WP_Query
	 */
	public static function get_posts( $args ) {

		$atts = array(
			'cat'            => is_array( $args['cats'] ) ? implode( ',', $args['cats'] ) : '',
			'posts_per_page' => $args['limit'],
			'order'          => $args['order'],
			'offset'         => $args['offset'],
			'orderby'        => $args['orderby']
		);

		$posts = new WP_Query( $atts );

		wp_reset_postdata();

		return $posts;
	}

	/**
	 * @param $args
	 *
	 * @return WP_Query
	 */
	public static function get_products( $args ) {
		$atts = array(
			'product_cat'    => is_array( $args['cats'] ) ? implode( ',', $args['cats'] ) : '',
			'posts_per_page' => isset( $args['posts_per_page'] ) ? $args['posts_per_page'] : 10,
			'post_type'      => 'product',
		);

		$posts = new WP_Query( $atts );

		wp_reset_postdata();

		return $posts;
	}

	/**
	 * Function to return a placeholder if the post has no thumbnail
	 *
	 * @param $id
	 *
	 * @return string
	 */
	public static function get_post_image( $id, $size ) {
		$image = get_template_directory_uri() . '/assets/images/picture_placeholder.jpg';
		if ( has_post_thumbnail( $id ) ) {
			$image = get_the_post_thumbnail_url( $id, $size );
		}

		return $image;
	}

	/**
	 * Helper function to echo the post information
	 *
	 * @param $id
	 *
	 * @return string
	 */
	public static function get_post_meta( $id ) {
		$cat      = wp_get_post_categories( $id );
		$comments = wp_count_comments( $id );
		$date     = get_the_date( 'F d, Y', $id );

		if ( empty( $cat ) ) {
			$cat[] = 'Uncategorized';
		}

		$html = '<ul class="meta-list">';
		$html .= '<li class="post-category"><icon class="fa fa-folder"></icon> <a href="' . esc_url( get_category_link( $cat[0] ) ) . '">' . esc_html( get_the_category_by_ID( $cat[0] ) ) . '</a></li>';
		$html .= '<li class="post-comments"><icon class="fa fa-comments"></icon> ' . absint( $comments->approved ) . ' </li>';
		$html .= '<li class="post-date">' . $date . '</li>';
		$html .= '</ul>';

		return $html;
	}

	/**
	 * Helper function to echo the post information
	 *
	 * @param $id
	 *
	 * @return string
	 */
	public static function get_post_meta_without_date( $id ) {
		$comments = wp_count_comments( $id );

		$html = '<ul class="meta-list">';
		$html .= '<li class="post-author"><icon class="fa fa-user"></icon> <a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'nicename' ) ) . '</a></li>';
		$html .= '<li class="post-comments"> <span class="sep">/</span> <icon class="fa fa-comments"></icon> ' . absint( $comments->approved ) . ' </li>';
		$html .= '</ul>';

		return $html;
	}

	/**
	 * @return array
	 */
	public static function check_archive() {

		$return = array(
			'type' => NULL,
			'id'   => NULL,
		);

		if ( is_category() ) {
			$return['type'] = 'category';
			$category       = get_category( get_query_var( 'cat' ) );
			$return['id']   = $category->cat_ID;
		}

		if ( is_tag() ) {
			$return['type'] = 'tags';
			$tags           = get_tags();
			$return['id']   = $tags[0]->term_id;
		}

		if ( is_day() ) {
			$return['type'] = 'day';
			$day            = get_query_var( 'day' );
			$return['id']   = $day;
		}

		if ( is_month() ) {
			$return['type'] = 'month';
			$month          = get_query_var( 'monthnum' );
			$return['id']   = $month;
		}

		if ( is_year() ) {
			$return['type'] = 'year';
			$year           = get_query_var( 'year' );
			$return['id']   = $year;
		}

		return $return;
	}

	/**
	 * Render the breadcrumbs with help of class-breadcrumbs.php
	 *
	 * @return void
	 */
	public static function add_breadcrumbs() {
		$breadcrumbs = new Tyche_Breadcrumbs();
		$breadcrumbs->get_breadcrumbs();
	}

	/**
	 * @return bool
	 */
	public static function on_iis() {
		$sSoftware = strtolower( $_SERVER["SERVER_SOFTWARE"] );
		if ( strpos( $sSoftware, "microsoft-iis" ) !== false ) {
			return true;
		}

		return false;
	}

	/**
	 * Returns true if a blog has more than 1 category.
	 *
	 * @return bool
	 */
	public static function categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'tyche_categories' ) ) ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories(
				array(
					'fields'     => 'ids',
					'hide_empty' => 1,
					// We only need to know if there is more than one category.
					'number'     => 2,
				)
			);

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'tyche_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so newspaper_x_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so newspaper_x_categorized_blog should return false.
			return false;
		}
	}

	/**
	 * Infinite scroll render for jetpack
	 */
	public static function infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			if ( is_search() ) :
				get_template_part( 'template-parts/content', 'search' );
			else :
				get_template_part( 'template-parts/content', get_post_format() );
			endif;
		}
	}

	/**
	 * @param array $args
	 */
	public static function the_posts_navigation( $args = array() ) {
		echo get_the_posts_navigation( $args );
	}

	/**
	 * Post meta
	 */
	public static function post_meta() {
		?>
        <div class="date">
			<?php
			echo '<span class="day">' . esc_html( get_the_date( 'd' ) ) . '</span>';
			echo '<span class="month">' . esc_html( get_the_date( 'M' ) ) . '</span>';
			?>
        </div>
        <div class="title">
			<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
			?>
        </div>
        <div class="meta">
			<?php
			$comments = wp_count_comments( get_the_ID() );
			global $authordata;

			$html = '<ul class="meta-list">';
			$html .= '<li class="post-author"><icon class="fa fa-user"></icon> ' . esc_html__( 'By', 'tyche' ) . ' <a href="' . esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ) . '">' . esc_html( get_the_author_meta( 'nicename' ) ) . '</a></li>';
			$html .= '<li class="post-comments"> <span class="sep">/</span> <icon class="fa fa-comments"></icon> ' . absint( $comments->approved ) . esc_html__( ' Comments', 'tyche' ) . '</li>';
			$html .= '</ul>';

			echo $html;
			?>
        </div>
		<?php
	}

	/**
	 * Entry footer
	 */
	public static function entry_footer() {
		$tags_list = get_the_tag_list( '', esc_html__( ' / ', 'tyche' ) );
		if ( ! empty( $tags_list ) ) {
			echo '<div class="entry-tags">' . esc_html__( 'TAGS: ', 'tyche' ) . $tags_list . '</div>';
		}
	}

	/**
	 * Check if you're in the posts page
	 *
	 * @return bool
	 */
	public static function is_posts_page() {
		return (int) get_queried_object_id() === (int) get_option( 'page_for_posts' );
	}

	/**
	 * Return true if you are on cart and account page
	 *
	 * @return bool
	 */
	public static function has_sidebar() {
		if ( class_exists( 'WooCommerce' ) ) {
			if ( is_cart() || is_account_page() || is_checkout() || is_checkout_pay_page() ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get permalink of a certain page
	 *
	 * @param string $page
	 *
	 * @return bool
	 */
	public static function get_woocommerge_page( $page = '' ) {
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
}