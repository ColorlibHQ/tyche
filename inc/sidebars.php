<?php
/**
 * Sidebar registration
 *
 * @package Tyche
 */

if ( function_exists( 'register_sidebar' ) ) {
	if ( ! function_exists( 'tyche_register_sidebars' ) ) {
		function tyche_register_sidebars() {
			register_sidebar( array(
				                  'name'          => esc_html__( 'Sidebar', 'tyche' ),
				                  'id'            => 'sidebar-1',
				                  'description'   => esc_html__( 'Add widgets here.', 'tyche' ),
				                  'before_widget' => '<section id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</section>',
				                  'before_title'  => '<h2 class="widget-title">',
				                  'after_title'   => '</h2>',
			                  ) );

			register_sidebar( array(
				                  'id'            => 'content-area-1',
				                  'name'          => esc_html__( 'Content Widget Area #1', 'tyche' ),
				                  'description'   => esc_html__( 'Actual page content', 'tyche' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'content-area-2',
				                  'name'          => esc_html__( 'Content Widget Area #2', 'tyche' ),
				                  'description'   => esc_html__( 'Actual page content', 'tyche' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'content-area-3-a',
				                  'name'          => esc_html__( 'Content Widget Area #3 A', 'tyche' ),
				                  'description'   => esc_html__( 'Actual page content', 'tyche' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);
			register_sidebar( array(
				                  'id'            => 'content-area-3-b',
				                  'name'          => esc_html__( 'Content Widget Area #3 B', 'tyche' ),
				                  'description'   => esc_html__( 'Actual page content', 'tyche' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);
			register_sidebar( array(
				                  'id'            => 'content-area-3-c',
				                  'name'          => esc_html__( 'Content Widget Area #3 C', 'tyche' ),
				                  'description'   => esc_html__( 'Actual page content', 'tyche' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);
			register_sidebar( array(
				                  'id'            => 'content-area-4',
				                  'name'          => esc_html__( 'Content Widget Area #4', 'tyche' ),
				                  'description'   => esc_html__( 'Actual page content', 'tyche' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'content-area-5-a',
				                  'name'          => esc_html__( 'Content Widget Area #5 A', 'tyche' ),
				                  'description'   => esc_html__( 'Actual page content', 'tyche' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'content-area-5-b',
				                  'name'          => esc_html__( 'Content Widget Area #5 B', 'tyche' ),
				                  'description'   => esc_html__( 'Actual page content', 'tyche' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'content-area-6',
				                  'name'          => esc_html__( 'Content Widget Area #6', 'tyche' ),
				                  'description'   => esc_html__( 'Actual page content', 'tyche' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'shop-sidebar',
				                  'name'          => esc_html__( '[Shop] Sidebar', 'tyche' ),
				                  'description'   => esc_html__( 'Tyche sidebar', 'tyche' ),
				                  'before_title'  => '<h5 class="widget-title"><span>',
				                  'after_title'   => '</span></h5>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);
			register_sidebar( array(
				                  'id'            => 'footer-sidebar-1',
				                  'name'          => esc_html__( '[Footer] Sidebar #1', 'tyche' ),
				                  'description'   => esc_html__( 'In the footer, first column', 'tyche' ),
				                  'before_title'  => '<h5 class="widget-title"><span>',
				                  'after_title'   => '</span></h5>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'footer-sidebar-2',
				                  'name'          => esc_html__( '[Footer] Sidebar #2', 'tyche' ),
				                  'description'   => esc_html__( 'In the footer, 2nd column', 'tyche' ),
				                  'before_title'  => '<h5 class="widget-title"><span>',
				                  'after_title'   => '</span></h5>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'footer-sidebar-3',
				                  'name'          => esc_html__( '[Footer] Sidebar #3', 'tyche' ),
				                  'description'   => esc_html__( 'In the footer, 3rd column', 'tyche' ),
				                  'before_title'  => '<h5 class="widget-title"><span>',
				                  'after_title'   => '</span></h5>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'footer-sidebar-4',
				                  'name'          => esc_html__( '[Footer] Sidebar #4', 'tyche' ),
				                  'description'   => esc_html__( 'In the footer, 4th column', 'tyche' ),
				                  'before_title'  => '<h5 class="widget-title"><span>',
				                  'after_title'   => '</span></h5>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

		} // function tyche_register_sidebars end

		add_action( 'widgets_init', 'tyche_register_sidebars' );

	} // function exists (tyche_register_sidebars) check
} // function exists (register_sidebar) check
