<?php
/**
 * Title: Newsletter band
 * Slug: tyche/newsletter
 * Categories: tyche, call-to-action
 * Description: A dark full-width band inviting a sign-up, for a form block or shortcode.
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"backgroundColor":"dark","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-dark-background-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
	<!-- wp:heading {"textAlign":"center","textColor":"background","fontSize":"x-large"} -->
	<h2 class="wp-block-heading has-text-align-center has-background-color has-text-color has-x-large-font-size"><?php echo esc_html_x( 'Ten percent off your first order', 'Pattern heading', 'tyche' ); ?></h2>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"align":"center","textColor":"border"} -->
	<p class="has-text-align-center has-border-color has-text-color"><?php echo esc_html_x( 'Join the list. One email a month, no more than that.', 'Pattern text', 'tyche' ); ?></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
