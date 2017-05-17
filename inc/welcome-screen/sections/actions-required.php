<?php
/**
 * Actions required
 */
?>

<div id="actions_required" class="tyche-tab-pane">

    <h1><?php esc_html_e( 'Actions recommend to make this theme look like in the demo.' ,'tyche' ); ?></h1>

    <!-- NEWS -->
    <hr />

	<?php
	global $tyche_required_actions;

	if( !empty($tyche_required_actions) ):

		/* tyche_show_required_actions is an array of true/false for each required action that was dismissed */
		$tyche_show_required_actions = get_option("tyche_show_required_actions");

		foreach( $tyche_required_actions as $tyche_required_action_key => $tyche_required_action_value ):
			if(@$tyche_show_required_actions[$tyche_required_action_value['id']] === false) continue;
			if(@$tyche_required_action_value['check']) continue;
			?>
			<div class="tyche-action-required-box">
				<span class="dashicons dashicons-no-alt tyche-dismiss-required-action" id="<?php echo $tyche_required_action_value['id']; ?>"></span>
				<h4><?php echo $tyche_required_action_key + 1; ?>. <?php if( !empty($tyche_required_action_value['title']) ): echo $tyche_required_action_value['title']; endif; ?></h4>
				<p><?php if( !empty($tyche_required_action_value['description']) ): echo $tyche_required_action_value['description']; endif; ?></p>
				<?php
					if( !empty($tyche_required_action_value['plugin_slug']) ):
						?><p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin='.$tyche_required_action_value['plugin_slug'] ), 'install-plugin_'.$tyche_required_action_value['plugin_slug'] ) ); ?>" class="button button-primary"><?php if( !empty($tyche_required_action_value['title']) ): echo $tyche_required_action_value['title']; endif; ?></a></p><?php
					endif;
				?>

				<hr />
			</div>
			<?php
		endforeach;
	endif;

	$nr_actions_required = 0;

	/* get number of required actions */
	if( get_option('tyche_show_required_actions') ):
		$tyche_show_required_actions = get_option('tyche_show_required_actions');
	else:
		$tyche_show_required_actions = array();
	endif;

	if( !empty($tyche_required_actions) ):
		foreach( $tyche_required_actions as $tyche_required_action_value ):
			if(( !isset( $tyche_required_action_value['check'] ) || ( isset( $tyche_required_action_value['check'] ) && ( $tyche_required_action_value['check'] == false ) ) ) && ((isset($tyche_show_required_actions[$tyche_required_action_value['id']]) && ($tyche_show_required_actions[$tyche_required_action_value['id']] == true)) || !isset($tyche_show_required_actions[$tyche_required_action_value['id']]) )) :
				$nr_actions_required++;
			endif;
		endforeach;
	endif;

	if( $nr_actions_required == 0 ):
		echo '<p>'.__( 'Hooray! There are no required actions for you right now.','tyche' ).'</p>';
	endif;
	?>

</div>
