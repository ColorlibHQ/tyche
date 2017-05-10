<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shopper
 */

get_header();
$breadcrumbs_enabled = get_theme_mod( 'shopper_enable_post_breadcrumbs', '1' );
if ( $breadcrumbs_enabled == '1' ) { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
				<?php shopper_breadcrumbs(); ?>
            </div>
        </div>
    </div>
<?php } ?>
    <div class="container">
        <div class="row">
            <div id="primary" class="content-area <?php echo ! shopper_has_sidebar() ? 'col-md-8' : 'col-md-12' ?>">
                <main id="main" class="site-main" role="main">

					<?php
					while ( have_posts() ) : the_post();

						get_template_part( 'template-parts/content', 'page' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>

                </main><!-- #main -->
            </div><!-- #primary -->

			<?php
			if ( ! shopper_has_sidebar() ) {
				get_sidebar();
			}
			?>
        </div>
    </div>
<?php
get_footer();