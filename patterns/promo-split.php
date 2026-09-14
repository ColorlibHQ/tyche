<?php
/**
 * Title: Promo split
 * Slug: tyche/promo-split
 * Categories: tyche, featured, call-to-action
 * Description: Two side-by-side promotional panels for categories or a sale.
 */
?>
<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"},"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}}} -->
<div class="wp-block-columns alignwide" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
	<!-- wp:column -->
	<div class="wp-block-column">
		<!-- wp:cover {"overlayColor":"dark","dimRatio":50,"minHeight":320,"layout":{"type":"constrained"}} -->
		<div class="wp-block-cover" style="min-height:320px">
			<span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim"></span>
			<div class="wp-block-cover__inner-container">
				<!-- wp:heading {"level":3,"textColor":"background","fontSize":"large"} -->
				<h3 class="wp-block-heading has-background-color has-text-color has-large-font-size"><?php echo esc_html_x( 'Outerwear', 'Pattern heading', 'tyche' ); ?></h3>
				<!-- /wp:heading -->
				<!-- wp:buttons -->
				<div class="wp-block-buttons"><!-- wp:button -->
				<div class="wp-block-button"><a class="wp-block-button__link wp-element-button"><?php echo esc_html_x( 'Browse', 'Pattern button', 'tyche' ); ?></a></div>
				<!-- /wp:button --></div>
				<!-- /wp:buttons -->
			</div>
		</div>
		<!-- /wp:cover -->
	</div>
	<!-- /wp:column -->
	<!-- wp:column -->
	<div class="wp-block-column">
		<!-- wp:cover {"overlayColor":"primary","dimRatio":30,"minHeight":320,"layout":{"type":"constrained"}} -->
		<div class="wp-block-cover" style="min-height:320px">
			<span aria-hidden="true" class="wp-block-cover__background has-primary-background-color has-background-dim-30 has-background-dim"></span>
			<div class="wp-block-cover__inner-container">
				<!-- wp:heading {"level":3,"textColor":"background","fontSize":"large"} -->
				<h3 class="wp-block-heading has-background-color has-text-color has-large-font-size"><?php echo esc_html_x( 'Mid-season sale', 'Pattern heading', 'tyche' ); ?></h3>
				<!-- /wp:heading -->
				<!-- wp:buttons -->
				<div class="wp-block-buttons"><!-- wp:button -->
				<div class="wp-block-button"><a class="wp-block-button__link wp-element-button"><?php echo esc_html_x( 'Shop the sale', 'Pattern button', 'tyche' ); ?></a></div>
				<!-- /wp:button --></div>
				<!-- /wp:buttons -->
			</div>
		</div>
		<!-- /wp:cover -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->
