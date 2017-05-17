<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Tyche
 */

if ( ! function_exists( 'tyche_post_meta' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function tyche_post_meta() {
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
endif;

if ( ! function_exists( 'tyche_entry_footer' ) ):
	function tyche_entry_footer() {
		$tags_list = get_the_tag_list( '', esc_html__( ' / ', 'tyche' ) );
		if ( ! empty( $tags_list ) ) {
			echo '<div class="entry-tags">' . esc_html__( 'TAGS: ', 'tyche' ) . $tags_list . '</div>';
		}
	}
endif;
/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function tyche_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'tyche_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			                                     'fields'     => 'ids',
			                                     'hide_empty' => 1,
			                                     // We only need to know if there is more than one category.
			                                     'number'     => 2,
		                                     ) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'tyche_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so tyche_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so tyche_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in tyche_categorized_blog.
 */
function tyche_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'tyche_categories' );
}

add_action( 'edit_category', 'tyche_category_transient_flusher' );
add_action( 'save_post', 'tyche_category_transient_flusher' );