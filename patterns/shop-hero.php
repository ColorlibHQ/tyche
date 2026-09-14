<?php
/**
 * Title: Shop hero
 * Slug: tyche/shop-hero
 * Categories: tyche, banner, featured
 * Description: A full-width cover with a season headline and two calls to action.
 */
?>
<!-- wp:cover {"overlayColor":"darker","dimRatio":40,"minHeight":520,"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60);min-height:520px">
	<span aria-hidden="true" class="wp-block-cover__background has-darker-background-color has-background-dim-40 has-background-dim"></span>
	<div class="wp-block-cover__inner-container">
		<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"3px","fontSize":"13px"}},"textColor":"primary"} -->
		<p class="has-primary-color has-text-color" style="font-size:13px;letter-spacing:3px;text-transform:uppercase"><?php echo esc_html_x( 'New season', 'Pattern eyebrow', 'tyche' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":1,"fontSize":"xx-large","textColor":"background"} -->
		<h1 class="wp-block-heading has-background-color has-text-color has-xx-large-font-size"><?php echo esc_html_x( 'The autumn collection', 'Pattern heading', 'tyche' ); ?></h1>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"fontSize":"large","textColor":"background"} -->
		<p class="has-background-color has-text-color has-large-font-size"><?php echo esc_html_x( 'Coats, knitwear and everything else worth owning when the weather turns.', 'Pattern text', 'tyche' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
		<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)">
			<!-- wp:button -->
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button"><?php echo esc_html_x( 'Shop now', 'Pattern button', 'tyche' ); ?></a></div>
			<!-- /wp:button -->
			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button"><?php echo esc_html_x( 'Look book', 'Pattern button', 'tyche' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
</div>
<!-- /wp:cover -->
