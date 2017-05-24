<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tyche
 */

if ( is_active_sidebar( 'shop-sidebar' ) ) { ?>
	<aside id="secondary" class="col-md-4 widget-area" role="complementary">
		<?php dynamic_sidebar( 'shop-sidebar' ); ?>
	</aside><!-- #secondary -->
<?php } else { ?>
	<aside id="secondary" class="col-md-4 widget-area" role="complementary">
		<?php
		$widgets = array(
			'WP_Widget_Search',
			'WP_Widget_Meta',
			'WP_Widget_Recent_Posts',
			'WP_Widget_Tag_Cloud',
			'WP_Widget_Categories',
		);

		if ( class_exists( 'WooCommerce' ) ) {
			$widgets = array(
				'WC_Widget_Product_Search',
			);
		}

		$args = array(
			'before_title' => '<h5 class="widget-title"><span>',
			'after_title'  => '</span></h5>',
		);
		foreach ( $widgets as $widget ) {
			the_widget( $widget, array(), $args );
		}
		?>
	</aside>
<?php } ?>
