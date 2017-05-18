<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tyche
 */
get_header();

if ( is_main_site() ) {
	$header = get_custom_header();
	//echo '<img style="width:100%" src="' . esc_url( $header->url ) . '" class="img-responsive" />';
}

$breadcrumbs_enabled = get_theme_mod( 'tyche_enable_post_breadcrumbs', '1' );
if ( $breadcrumbs_enabled == '1' ) { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
				<?php Tyche_Helper::add_breadcrumbs(); ?>
            </div>
        </div>
    </div>
<?php } ?>
    <div class="container">
        <div class="row">
            <div id="primary" class="content-area col-md-8">
                <main id="main" class="site-main" role="main">

					<?php
					if ( have_posts() ) :

						if ( Tyche_Helper::is_posts_page() ) : ?>
                            <header>
                                <h1 class="page-title"><?php echo esc_html( get_the_title( (int) get_option( 'page_for_posts' ) ) ); ?></h1>
                            </header>
						<?php endif;

						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );

						endwhile;

						the_posts_navigation();

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif; ?>

                </main><!-- #main -->
            </div><!-- #primary -->
			<?php
			get_sidebar();
			?>
        </div>
    </div>
<?php
get_footer();