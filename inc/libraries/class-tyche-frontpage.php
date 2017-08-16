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
			get_theme_mod(
				'tyche_frontpage_sections',
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
		foreach ( $this->sidebars as $index => $sidebar ) {
			if ( ! is_active_sidebar( $sidebar ) ) {
				unset( $this->sidebars[ $index ] );
			}
		}
	}

	/**
	 * Generate output
	 */
	public function generate_output() {
		if ( empty( $this->sidebars ) ) {
			$this->generate_normal_page();
		}

		foreach ( $this->sidebars as $sidebar ) {
			$arg = '';
			do_action( 'before_' . $sidebar, $arg );

			get_template_part( 'template-parts/frontpage-widgets/' . $sidebar );

			do_action( 'after_' . $sidebar, $arg );

		}
	}

	/**
	 * Generates a normal page if we don't have any sidebars set
	 */
	public function generate_normal_page() {
		$breadcrumbs_enabled = get_theme_mod( 'tyche_enable_post_breadcrumbs', true );
		if ( $breadcrumbs_enabled ) { ?>
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
				<div id="primary" class="content-area col-md-8 tyche-has-sidebar">
					<main id="main" class="site-main" role="main">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content-page' );
						endwhile;
						?>
					</main>
				</div>
				<?php
				get_sidebar();
				?>
			</div>
		</div>
		<?php
	}
}
