<?php
/**
 * Changelog
 */

$tyche = wp_get_theme( 'tyche' );

?>
<div class="tyche-tab-pane" id="changelog">

	<div class="tyche-tab-pane-center">
	
		<h1>Tyche <?php if( !empty($tyche['Version']) ): ?> <sup id="tyche-theme-version"><?php echo esc_attr( $tyche['Version'] ); ?> </sup><?php endif; ?></h1>

	</div>

	<?php
	WP_Filesystem();
	global $wp_filesystem;
	$tyche_changelog = $wp_filesystem->get_contents( get_template_directory().'/CHANGELOG.md' );
	$tyche_changelog_lines = explode(PHP_EOL, $tyche_changelog);
	foreach($tyche_changelog_lines as $tyche_changelog_line){
		if(substr( $tyche_changelog_line, 0, 3 ) === "###"){
			echo '<hr /><h1>'.substr($tyche_changelog_line,3).'</h1>';
		} else {
			echo $tyche_changelog_line,'<br/>';
		}
	}

	?>
	
</div>