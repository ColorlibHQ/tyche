<?php
/**
 * Getting started template
 */

$customizer_url = admin_url() . 'customize.php' ;
?>

<div id="getting_started" class="tyche-tab-pane active">

	<div class="tyche-tab-pane-center">

		<h1 class="tyche-welcome-title">Welcome to Tyche! <?php if( !empty($tyche_lite['Version']) ): ?> <sup id="tyche-theme-version"><?php echo esc_attr( $tyche_lite['Version'] ); ?> </sup><?php endif; ?></h1>

		<p><?php esc_html_e( 'Our most popular free one page WordPress theme, Tyche!','tyche'); ?></p>
		<p><?php esc_html_e( 'We want to make sure you have the best experience using Tyche and that is why we gathered here all the necessary informations for you. We hope you will enjoy using Tyche, as much as we enjoy creating great products.', 'tyche' ); ?>

	</div>

	<hr />

	<div class="tyche-tab-pane-center">

		<h1><?php esc_html_e( 'Getting started', 'tyche' ); ?></h1>

		<h4><?php esc_html_e( 'Customize everything in a single place.' ,'tyche' ); ?></h4>
		<p><?php esc_html_e( 'Using the WordPress Customizer you can easily customize every aspect of the theme.', 'tyche' ); ?></p>
		<p><a href="<?php echo esc_url( $customizer_url ); ?>" class="button button-primary"><?php esc_html_e( 'Go to Customizer', 'tyche' ); ?></a></p>

	</div>

	<hr />

	<div class="tyche-tab-pane-center">

		<h1><?php esc_html_e( 'FAQ', 'tyche' ); ?></h1>

	</div>

	<div class="tyche-tab-pane-half tyche-tab-pane-first-half">

		<h4><?php esc_html_e( 'Create a child theme', 'tyche' ); ?></h4>
		<p><?php esc_html_e( 'If you want to make changes to the theme\'s files, those changes are likely to be overwritten when you next update the theme. In order to prevent that from happening, you need to create a child theme. For this, please follow the documentation below.', 'tyche' ); ?></p>
		<p><a target="_blank" href="<?php echo esc_url( 'http://docs.machothemes.com/article/34-how-to-create-a-child-theme' ); ?>" class="button"><?php esc_html_e( 'View how to do this', 'tyche' ); ?></a></p>

		<hr />

		<h4><?php esc_html_e( 'Translate Tyche', 'tyche' ); ?></h4>
		<p><?php esc_html_e( 'In the below documentation you will find an easy way to translate Tyche into your native language or any other language you need for you site.', 'tyche' ); ?></p>
		<p><a target="_blank" href="<?php echo esc_url( 'http://docs.themeisle.com/article/80-how-to-translate-tyche' ); ?>" class="button"><?php esc_html_e( 'View how to do this', 'tyche' ); ?></a></p>


	</div>

	<div class="tyche-tab-pane-half">

		<h4><?php esc_html_e( 'Change the page template', 'tyche' ); ?></h4>
		<p><?php esc_html_e( 'Tyche has three page templates available, two for the blog and one for full width pages. To make sure you take full advantage of those page templates, make sure you read the documentation.', 'tyche' ); ?></p>
		<p><a target="_blank" href="<?php echo esc_url( 'http://docs.themeisle.com/article/32-how-to-change-the-page-template-in-wordpress' ); ?>" class="button"><?php esc_html_e( 'View how to do this', 'tyche' ); ?></a></p>

		<hr />



	</div>

	<div class="tyche-clear"></div>

	<hr />

	<div class="tyche-tab-pane-center">

		<h1><?php esc_html_e( 'View full documentation', 'tyche' ); ?></h1>
		<p><?php esc_html_e( 'Need more details? Please check our full documentation for detailed information on how to use Tyche.', 'tyche' ); ?></p>
		<p><a target="_blank" href="<?php echo esc_url( 'http://docs.machothemes.com/category/106-tyche' ); ?>" class="button button-primary"><?php esc_html_e( 'Read full documentation', 'tyche' ); ?></a></p>

	</div>

	<hr />

	<div class="tyche-clear"></div>

</div>
