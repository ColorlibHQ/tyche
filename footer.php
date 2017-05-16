<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Shopper
 */

?>

</div><!-- #content -->
</div>

<!-- Footer -->
<footer id="colophon" class="site-footer" role="contentinfo">
	<?php get_sidebar( 'footer' ) ?>
</footer>
<!-- / Footer -->
<?php
$enable_copyright = get_theme_mod( 'shopper_enable_copyright', '1' )
?>
<?php if ( $enable_copyright !== '0' ): ?>
    <!-- Copyright -->
    <footer class="site-copyright">
        <div class="site-info ">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
						<?php
						if ( has_nav_menu( 'social' ) ) {

							wp_nav_menu(
								array(
									'theme_location'  => 'social',
									'container'       => 'div',
									'container_id'    => 'menu-social',
									'container_class' => 'menu pull-left',
									'menu_id'         => 'menu-social-items',
									'menu_class'      => 'menu-items',
									'depth'           => 1,
									'link_before'     => '<span class="screen-reader-text">',
									'link_after'      => '</span>',
									'fallback_cb'     => '',
								)
							);
						}
						?>

						<?php if ( $enable_copyright !== '0' ): ?>
                            <div class="copyright-text pull-right">
								<?php echo wp_kses_post( get_theme_mod( 'shopper_copyright_contents', sprintf( 'Copyright &copy; ' . date( "Y" ) . ' <span class="sep">|</span> <a href="%s">Theme: Shopper</a> <span class="sep">|</span> Powered by WordPress.', 'https://colorlib.com/wp/themes/shopper/' ) ) ); ?>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- / Copyright -->
<?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>