<?php /* Template Name: Front Page Template */ ?>

<?php get_header(); ?>

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
<?php } ?>

<?php if ( is_active_sidebar( 'content-area-2' ) ) { ?>
    <!-- Content Area #2 -->
    <section class="content-area-2">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
					<?php
					dynamic_sidebar( 'content-area-2' );
					?>
                </div>
            </div>
        </div>
    </section>
    <!-- / Content Area #2 -->
<?php } ?>

<?php if ( is_active_sidebar( 'content-area-3-a' ) || is_active_sidebar( 'content-area-3-b' ) || is_active_sidebar( 'content-area-3-c' ) ) { ?>
    <!-- Content Area #3 -->
    <section class="content-area-3">
        <div class="container">
            <div class="row">
				<?php if ( is_active_sidebar( 'content-area-3-a' ) ) { ?>
                    <div class="col-md-4 col-xs-12">
						<?php
						dynamic_sidebar( 'content-area-3-a' );
						?>
                    </div>
				<?php } ?>
				<?php if ( is_active_sidebar( 'content-area-3-b' ) ) { ?>
                    <div class="col-md-4 col-xs-12">
						<?php
						dynamic_sidebar( 'content-area-3-b' );
						?>
                    </div>
				<?php } ?>
				<?php if ( is_active_sidebar( 'content-area-3-c' ) ) { ?>
                    <div class="col-md-4 col-xs-12">
						<?php
						dynamic_sidebar( 'content-area-3-c' );
						?>
                    </div>
				<?php } ?>
            </div>
        </div>
    </section>
    <!-- / Content Area #3 -->
<?php } ?>

<?php if ( is_active_sidebar( 'content-area-4' ) ) { ?>
    <!-- Content Area #4 -->
    <section class="content-area-4">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
					<?php
					dynamic_sidebar( 'content-area-4' );
					?>
                </div>
            </div>
        </div>
    </section>
    <!-- / Content Area #4 -->
<?php } ?>

<?php if ( is_active_sidebar( 'content-area-5-a' ) || is_active_sidebar( 'content-area-5-b' ) ) { ?>
    <!-- Content Area #5 -->
    <section class="content-area-5">
        <div class="container">
            <div class="row">
				<?php if ( is_active_sidebar( 'content-area-5-a' ) ) { ?>
                    <div class="col-md-6 col-xs-12">
						<?php
						dynamic_sidebar( 'content-area-5-a' );
						?>
                    </div>
				<?php } ?>
				<?php if ( is_active_sidebar( 'content-area-5-b' ) ) { ?>
                    <div class="col-md-6 col-xs-12">
						<?php
						dynamic_sidebar( 'content-area-5-b' );
						?>
                    </div>
				<?php } ?>
            </div>
        </div>
    </section>
    <!-- / Content Area #5 -->
<?php } ?>

<?php if ( is_active_sidebar( 'content-area-6' ) ) { ?>
    <!-- Content Area #6 -->
    <section class="content-area-6">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
					<?php
					dynamic_sidebar( 'content-area-6' );
					?>
                </div>
            </div>
        </div>
    </section>
    <!-- / Content Area #6 -->
<?php } ?>

<?php get_footer(); ?>
