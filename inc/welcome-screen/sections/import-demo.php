<?php
/**
 * Import Demo
 */
$button_text = esc_html__( 'Import Demo Data', 'tyche' );
?>

<div id="import_demo" class="tyche-tab-pane">

	<h1><?php esc_html_e( 'Demo Import.', 'tyche' ); ?></h1>

	<!-- NEWS -->

	<hr/>
	<?php
	$x = new MT_Theme_Importer();
	$x->demo_installer();
	?>
</div>
