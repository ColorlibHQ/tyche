<?php

/**
 * Welcome Screen Class
 */
class Ensign_Welcome {

	/**
	 * Constructor for the welcome screen
	 */
	public function __construct() {
		/* create dashbord page */
		add_action( 'admin_menu', array( $this, 'tyche_welcome_register_menu' ) );

		/* activation notice */
		add_action( 'load-themes.php', array( $this, 'tyche_activation_admin_notice' ) );

		/* enqueue script and style for welcome screen */
		add_action( 'admin_enqueue_scripts', array( $this, 'tyche_welcome_style_and_scripts' ) );

		/* enqueue script for customizer */
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'tyche_welcome_scripts_for_customizer' ) );

		/* load welcome screen */
		add_action( 'tyche_welcome', array( $this, 'tyche_welcome_getting_started' ), 10 );
		add_action( 'tyche_welcome', array( $this, 'tyche_welcome_actions_required' ), 20 );

		if ( class_exists( 'MT_Theme_Importer' ) ) {
			add_action( 'tyche_welcome', array( $this, 'tyche_welcome_import_demo' ), 30 );
		}

		add_action( 'tyche_welcome', array( $this, 'tyche_welcome_changelog' ), 50 );


		/* ajax callback for dismissable required actions */
		add_action( 'wp_ajax_tyche_dismiss_required_action', array(
			$this,
			'tyche_dismiss_required_action_callback'
		) );
		add_action( 'wp_ajax_nopriv_tyche_dismiss_required_action', array(
			$this,
			'tyche_dismiss_required_action_callback'
		) );

	}

	/**
	 * Creates the dashboard page
	 *
	 * @see   add_theme_page()
	 * @since 1.8.2.4
	 */
	public function tyche_welcome_register_menu() {
		add_theme_page( 'About Tyche', 'About Tyche', 'edit_theme_options', 'tyche-welcome', array(
			$this,
			'tyche_welcome_screen'
		) );
	}

	/**
	 * Adds an admin notice upon successful activation.
	 *
	 * @since 1.8.2.4
	 */
	public function tyche_activation_admin_notice() {
		global $pagenow;

		if ( is_admin() && ( 'themes.php' == $pagenow ) && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'tyche_welcome_admin_notice' ), 99 );
		}
	}

	/**
	 * Display an admin notice linking to the welcome screen
	 *
	 * @since 1.8.2.4
	 */
	public function tyche_welcome_admin_notice() {
		?>
		<div class="updated notice is-dismissible">
			<p><?php echo sprintf( esc_html__( 'Welcome! Thank you for choosing Tyche! To fully take advantage of the best our theme can offer please make sure you visit our %swelcome page%s.', 'tyche' ), '<a href="' . esc_url( admin_url( 'themes.php?page=tyche-welcome' ) ) . '">', '</a>' ); ?></p>
			<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=tyche-welcome' ) ); ?>" class="button"
			      style="text-decoration: none;"><?php _e( 'Get started with Tyche', 'tyche' ); ?></a></p>
		</div>
		<?php
	}

	/**
	 * Load welcome screen css and javascript
	 *
	 * @since  1.8.2.4
	 */
	public function tyche_welcome_style_and_scripts( $hook_suffix ) {

		if ( 'appearance_page_tyche-welcome' == $hook_suffix ) {
			wp_enqueue_style( 'tyche-welcome-screen-css', get_template_directory_uri() . '/inc/admin/welcome-screen/css/welcome.css' );
			wp_enqueue_script( 'tyche-welcome-screen-js', get_template_directory_uri() . '/inc/admin/welcome-screen/js/welcome.js', array( 'jquery' ) );

			global $tyche_required_actions;

			$nr_actions_required = 0;

			/* get number of required actions */
			if ( get_option( 'tyche_show_required_actions' ) ):
				$tyche_show_required_actions = get_option( 'tyche_show_required_actions' );
			else:
				$tyche_show_required_actions = array();
			endif;

			if ( ! empty( $tyche_required_actions ) ):
				foreach ( $tyche_required_actions as $tyche_required_action_value ):
					if ( ( ! isset( $tyche_required_action_value['check'] ) || ( isset( $tyche_required_action_value['check'] ) && ( $tyche_required_action_value['check'] == false ) ) ) && ( ( isset( $tyche_show_required_actions[ $tyche_required_action_value['id'] ] ) && ( $tyche_show_required_actions[ $tyche_required_action_value['id'] ] == true ) ) || ! isset( $tyche_show_required_actions[ $tyche_required_action_value['id'] ] ) ) ) :
						$nr_actions_required ++;
					endif;
				endforeach;
			endif;

			wp_localize_script( 'tyche-welcome-screen-js', 'tycheWelcomeScreenObject', array(
				'nr_actions_required'      => $nr_actions_required,
				'ajaxurl'                  => admin_url( 'admin-ajax.php' ),
				'template_directory'       => get_template_directory_uri(),
				'no_required_actions_text' => esc_html__( 'Hooray! There are no required actions for you right now.', 'tyche' )
			) );
		}
	}

	/**
	 * Load scripts for customizer page
	 *
	 * @since  1.8.2.4
	 */
	public function tyche_welcome_scripts_for_customizer() {

		wp_enqueue_style( 'tyche-welcome-screen-customizer-css', get_template_directory_uri() . '/inc/admin/welcome-screen/css/welcome_customizer.css' );
		wp_enqueue_script( 'tyche-welcome-screen-customizer-js', get_template_directory_uri() . '/inc/admin/welcome-screen/js/welcome_customizer.js', array( 'jquery' ), '20120206', true );

		global $tyche_required_actions;

		$nr_actions_required = 0;

		/* get number of required actions */
		if ( get_option( 'tyche_show_required_actions' ) ):
			$tyche_show_required_actions = get_option( 'tyche_show_required_actions' );
		else:
			$tyche_show_required_actions = array();
		endif;

		if ( ! empty( $tyche_required_actions ) ):
			foreach ( $tyche_required_actions as $tyche_required_action_value ):
				if ( ( ! isset( $tyche_required_action_value['check'] ) || ( isset( $tyche_required_action_value['check'] ) && ( $tyche_required_action_value['check'] == false ) ) ) && ( ( isset( $tyche_show_required_actions[ $tyche_required_action_value['id'] ] ) && ( $tyche_show_required_actions[ $tyche_required_action_value['id'] ] == true ) ) || ! isset( $tyche_show_required_actions[ $tyche_required_action_value['id'] ] ) ) ) :
					$nr_actions_required ++;
				endif;
			endforeach;
		endif;

		wp_localize_script( 'tyche-welcome-screen-customizer-js', 'tycheWelcomeScreenCustomizerObject', array(
			'nr_actions_required' => $nr_actions_required,
			'aboutpage'           => esc_url( admin_url( 'themes.php?page=tyche-welcome#actions_required' ) ),
			'customizerpage'      => esc_url( admin_url( 'customize.php#actions_required' ) ),
			'themeinfo'           => esc_html__( 'View Theme Info', 'tyche' ),
		) );
	}

	/**
	 * Dismiss required actions
	 *
	 * @since 1.8.2.4
	 */
	public function tyche_dismiss_required_action_callback() {

		global $tyche_required_actions;

		$tyche_dismiss_id = ( isset( $_GET['dismiss_id'] ) ) ? $_GET['dismiss_id'] : 0;

		echo $tyche_dismiss_id; /* this is needed and it's the id of the dismissable required action */

		if ( ! empty( $tyche_dismiss_id ) ):

			/* if the option exists, update the record for the specified id */
			if ( get_option( 'tyche_show_required_actions' ) ):

				$tyche_show_required_actions = get_option( 'tyche_show_required_actions' );

				$tyche_show_required_actions[ $tyche_dismiss_id ] = false;

				update_option( 'tyche_show_required_actions', $tyche_show_required_actions );

			/* create the new option,with false for the specified id */
			else:

				$tyche_show_required_actions_new = array();

				if ( ! empty( $tyche_required_actions ) ):

					foreach ( $tyche_required_actions as $tyche_required_action ):

						if ( $tyche_required_action['id'] == $tyche_dismiss_id ):
							$tyche_show_required_actions_new[ $tyche_required_action['id'] ] = false;
						else:
							$tyche_show_required_actions_new[ $tyche_required_action['id'] ] = true;
						endif;

					endforeach;

					update_option( 'tyche_show_required_actions', $tyche_show_required_actions_new );

				endif;

			endif;

		endif;

		die(); // this is required to return a proper result
	}


	/**
	 * Welcome screen content
	 *
	 * @since 1.8.2.4
	 */
	public function tyche_welcome_screen() {

		require_once( ABSPATH . 'wp-load.php' );
		require_once( ABSPATH . 'wp-admin/admin.php' );
		require_once( ABSPATH . 'wp-admin/admin-header.php' );
		?>

		<ul class="tyche-nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#getting_started" aria-controls="getting_started" role="tab"
			                                          data-toggle="tab"><?php esc_html_e( 'Getting started', 'tyche' ); ?></a>
			</li>
			<li role="presentation" class="tyche-w-red-tab"><a href="#actions_required"
			                                                    aria-controls="actions_required" role="tab"
			                                                    data-toggle="tab"><?php esc_html_e( 'Actions required', 'tyche' ); ?></a>
			</li>
			<?php if ( class_exists( 'MT_Theme_Importer' ) ) { ?>
				<li role="presentation"><a href="#import_demo" aria-controls="import_demo" role="tab"
				                           data-toggle="tab"><?php esc_html_e( 'Import Demo', 'tyche' ); ?></a></li>
			<?php } ?>
			<li role="presentation"><a href="#changelog" aria-controls="changelog" role="tab"
			                           data-toggle="tab"><?php esc_html_e( 'Changelog', 'tyche' ); ?></a></li>
		</ul>

		<div class="tyche-tab-content">

			<?php
			/**
			 * @hooked tyche_welcome_getting_started - 10
			 * @hooked tyche_welcome_actions_required - 20
			 * @hooked tyche_welcome_changelog - 50
			 */
			do_action( 'tyche_welcome' ); ?>

		</div>
		<?php
	}

	/**
	 * Getting started
	 *
	 * @since 1.8.2.4
	 */
	public function tyche_welcome_getting_started() {
		require_once( get_template_directory() . '/inc/admin/welcome-screen/sections/getting-started.php' );
	}

	/**
	 * Actions required
	 *
	 * @since 1.8.2.4
	 */
	public function tyche_welcome_actions_required() {
		require_once( get_template_directory() . '/inc/admin/welcome-screen/sections/actions-required.php' );
	}

	/**
	 * Changelog
	 *
	 * @since 1.8.2.4
	 */
	public function tyche_welcome_import_demo() {
		require_once( get_template_directory() . '/inc/admin/welcome-screen/sections/import-demo.php' );
	}

	/**
	 * Changelog
	 *
	 * @since 1.8.2.4
	 */
	public function tyche_welcome_changelog() {
		require_once( get_template_directory() . '/inc/admin/welcome-screen/sections/changelog.php' );
	}

}

new Ensign_Welcome();
