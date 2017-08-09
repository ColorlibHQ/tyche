<?php
/**
 * Template part for displaying pages.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tyche
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	the_content();
	wp_link_pages( array(
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'tyche' ),
		'after'  => '</div>',
	) );
	?>
</article><!-- #post-## -->
