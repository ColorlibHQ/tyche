<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Tyche_Hooks
 */
class Tyche_Hooks {
	/**
	 * Tyche_Hooks constructor.
	 */
	public function __construct() {
		/**
		 * Custom body classes
		 */
		add_filter( 'body_class', array( $this, 'body_classes' ) );
		/**
		 * Flush the category transient on category edit or post save
		 */
		add_action( 'edit_category', array( $this, 'category_transient_flusher' ) );
		add_action( 'save_post', array( $this, 'category_transient_flusher' ) );
		/**
		 * Fix responsive videos
		 */
		add_filter( 'embed_oembed_html', array( $this, 'fix_responsive_videos' ), 10, 3 );
		add_filter( 'video_embed_html', array( $this, 'fix_responsive_videos' ) );

		/**
		 * Add ajax functionality
		 */
		add_action( 'wp_ajax_tyche_ajax_action', array(
			$this,
			'tyche_ajax_action',
		) );
		add_action( 'wp_ajax_nopriv_tyche_ajax_action', array(
			$this,
			'tyche_ajax_action',
		) );
	}

	/**
	 * Flush out the transients used in categorized blog.
	 */
	public function category_transient_flusher() {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Like, beat it. Dig?
		delete_transient( 'tyche_categories' );
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 */
	public function body_classes( $classes ) {
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

	/**
	 * @param $html
	 *
	 * @return string
	 */
	public function fix_responsive_videos( $html ) {
		return '<div class="responsive-video-container">' . $html . '</div>';
	}

	/**
	 * Ajax handler
	 */
	public function tyche_ajax_action() {
		if ( 'tyche_ajax_action' !== $_POST['action'] ) {
			wp_die( json_encode( array(
				'status' => false,
				'error' => 'Not allowed',
			) ) );
		}

		if ( 2 !== count( $_POST['args']['action'] ) ) {
			wp_die( json_encode( array(
				'status' => false,
				'error' => 'Not allowed',
			) ) );
		}

		if ( ! class_exists( $_POST['args']['action'][0] ) ) {
			wp_die( json_encode( array(
				'status' => false,
				'error' => 'Class does not exist',
			) ) );
		}

		$class  = $_POST['args']['action'][0];
		$method = $_POST['args']['action'][1];
		$args   = $_POST['args']['args'];

		$response = $class::$method( $args );

		if ( 'ok' == $response ) {
			wp_die( json_encode( array(
				'status' => true,
				'message' => 'ok',
			) ) );
		}

		wp_die( json_encode( array(
			'status' => false,
			'message' => 'nok',
		) ) );
	}
}
