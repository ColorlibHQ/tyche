<?php
/**
 * Actions required
 */

wp_enqueue_style( 'plugin-install' );
wp_enqueue_script( 'plugin-install' );
wp_enqueue_script( 'updates' );
?>

<div class="feature-section action-required demo-import-boxed" id="plugin-filter">

	<?php
	global $tyche_required_actions;

	if ( ! empty( $tyche_required_actions ) ) :

		/* tyche_show_required_actions is an array of true/false for each required action that was dismissed */
		$tyche_show_required_actions = get_option( 'tyche_show_required_actions' );
		$hooray = true;

		foreach ( $tyche_required_actions as $tyche_required_action_key => $tyche_required_action_value ) :
			$hidden = false;
			if ( false === $tyche_show_required_actions[ $tyche_required_action_value['id'] ] ) {
				$hidden = true;
			}
			if ( $tyche_required_action_value['check'] ) {
				continue;
			}
			?>
			<div class="tyche-action-required-box">
				<?php if ( ! $hidden ) : ?>
					<span data-action="dismiss"
						  class="dashicons dashicons-visibility tyche-required-action-button"
						  id="<?php echo esc_attr( $tyche_required_action_value['id'] ); ?>"></span>
				<?php else : ?>
					<span data-action="add" class="dashicons dashicons-hidden tyche-required-action-button"
						  id="<?php echo esc_attr( $tyche_required_action_value['id'] ); ?>"></span>
				<?php endif; ?>
				<h3><?php if ( ! empty( $tyche_required_action_value['title'] ) ) : echo esc_html( $tyche_required_action_value['title'] );
endif; ?></h3>
				<p>
					<?php if ( ! empty( $tyche_required_action_value['description'] ) ) : echo esc_html( $tyche_required_action_value['description'] );
endif; ?>
					<?php if ( ! empty( $tyche_required_action_value['help'] ) ) : echo '<br/>' . wp_kses_post( $tyche_required_action_value['help'] );
endif; ?>
				</p>
				<?php
				if ( ! empty( $tyche_required_action_value['plugin_slug'] ) ) {
					$active = $this->check_active( $tyche_required_action_value['plugin_slug'] );
					$url    = $this->create_action_link( $active['needs'], $tyche_required_action_value['plugin_slug'] );
					$label  = '';

					switch ( $active['needs'] ) {
						case 'install':
							$class = 'install-now button';
							$label = esc_html__( 'Install', 'tyche' );
							break;
						case 'activate':
							$class = 'activate-now button button-primary';
							$label = esc_html__( 'Activate', 'tyche' );
							break;
						case 'deactivate':
							$class = 'deactivate-now button';
							$label = esc_html__( 'Deactivate', 'tyche' );
							break;
					}

					?>
					<p class="plugin-card-<?php echo esc_attr( $tyche_required_action_value['plugin_slug'] ) ?> action_button <?php echo ( 'install' !== $active['needs'] && $active['status'] ) ? 'active' : '' ?>">
						<a data-slug="<?php echo esc_attr( $tyche_required_action_value['plugin_slug'] ) ?>"
						   class="<?php echo esc_attr( $class ); ?>"
						   href="<?php echo esc_url( $url ) ?>"> <?php echo esc_html( $label ) ?> </a>
					</p>
					<?php
				};
				?>
			</div>
			<?php
			$hooray = false;
		endforeach;
	endif;

	if ( $hooray ) :
		echo '<span class="hooray">' . esc_html__( 'Hooray! There are no required actions for you right now.', 'tyche' ) . '</span>';
	endif;
	?>

</div>
