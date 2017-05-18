<?php
/**
 * Template part for displaying author info.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tyche
 */

global $post;
// Grab the current author
$curauth = get_userdata( $post->post_author );

if ( is_single() && ! empty( $curauth->description ) && get_theme_mod( 'tyche_enable_author_box', 'enabled' ) === 'enabled' ) { ?>
    <!-- Author description -->
    <div class="author-description">
        <!-- Avatar -->
        <div class="col-md-2 tyche-avatar">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 50 ); ?>
        </div>
        <!-- .Avatar -->
        <!-- Short Description -->
        <div class="col-md-10" itemscope="" itemtype="http://schema.org/Person">
            <h4 class="post-author"><?php echo get_the_author_posts_link(); ?></h4>
            <a class="post-author-website" href="<?php echo get_the_author_meta( 'url' ) ?>"><?php echo
				get_the_author_meta( 'url' ) ?></a>
            <p><?php the_author_meta( 'description' ); ?></p>
        </div>
        <!-- .Short Description -->
    </div>
    <!-- .Author description -->
<?php } ?>
