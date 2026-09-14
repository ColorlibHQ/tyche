<?php
/**
 * Title: Product grid
 * Slug: tyche/product-grid
 * Categories: tyche, woocommerce, products
 * Description: A titled row of products, using WooCommerce's own product blocks when the plugin is active.
 */
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:heading {"style":{"typography":{"textTransform":"uppercase"}},"fontSize":"x-large"} -->
	<h2 class="wp-block-heading has-x-large-font-size" style="text-transform:uppercase"><?php echo esc_html_x( 'New arrivals', 'Pattern heading', 'tyche' ); ?></h2>
	<!-- /wp:heading -->
	<!-- wp:separator {"backgroundColor":"primary","className":"is-style-wide"} -->
	<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background is-style-wide"/>
	<!-- /wp:separator -->
	<?php if ( class_exists( 'WooCommerce' ) ) : ?>
		<!-- wp:woocommerce/product-new {"columns":4,"rows":1} /-->
	<?php else : ?>
		<!-- wp:paragraph -->
		<p><?php echo esc_html_x( 'Activate WooCommerce to show products here.', 'Pattern text', 'tyche' ); ?></p>
		<!-- /wp:paragraph -->
	<?php endif; ?>
</div>
<!-- /wp:group -->
