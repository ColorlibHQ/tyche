<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Tyche_Frontpage
 */
class Tyche_Frontpage {
	/**
	 * Holds the active sidebars
	 *
	 * @var array
	 */
	public $sidebars = array();

	/**
	 * Construct the frontpage class
	 *
	 * Tyche_Frontpage constructor.
	 */
	public function __construct() {
		/**
		 * Let's setup the sidebars in the frontend, fallback -> all sidebars
		 */
		$this->set_sidebars(
			get_theme_mod( 'tyche_frontpage_sections',
				array(
					'content-area-1',
					'content-area-2',
					'content-area-3',
					'content-area-4',
					'content-area-5',
				)
			)
		);

		$this->generate_output();
	}

	/**
	 * We need to setup the sidebars, so we can load them appropriately
	 */
	public function set_sidebars( $sidebars ) {
		$this->sidebars = $sidebars;
	}

	/**
	 * Generate output
	 */
	public function generate_output() {
		foreach ( $this->sidebars as $sidebar ) {
			$arg = '';
			do_action( 'before_' . $sidebar, $arg );

			get_template_part( 'template-parts/frontpage-widgets/' . $sidebar );

			do_action( 'after_' . $sidebar, $arg );

		}
	}
}
