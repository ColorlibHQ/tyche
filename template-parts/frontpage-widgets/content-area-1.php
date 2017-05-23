<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<?php if ( is_active_sidebar( 'content-area-1' ) ) { ?>
    <!-- Content Area #1 -->
    <section class="content-area-1">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
					<?php
					dynamic_sidebar( 'content-area-1' );
					?>
                </div>
            </div>
        </div>
    </section>
    <!-- / Content Area #1 -->
<?php }