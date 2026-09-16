<?php
/**
 * Title: Account sign-up call to action
 * Slug: tyche/newsletter
 * Categories: tyche-store
 * Keywords: newsletter, signup, cta
 * Viewport Width: 1400
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"backgroundColor":"dark","textColor":"on-dark","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section has-on-dark-color has-dark-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","className":"tyche-newsletter","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center tyche-newsletter"><!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:heading {"textColor":"overlay","fontSize":"huge"} -->
<h2 class="wp-block-heading has-overlay-color has-text-color has-huge-font-size"><?php esc_html_e( 'Take 10% off your first order', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"on-dark","fontSize":"large"} -->
<p class="has-on-dark-color has-text-color has-large-font-size"><?php esc_html_e( 'Create an account for early access to new collections, members-only offers and faster checkout.', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","className":"tyche-newsletter__action"} -->
<div class="wp-block-column is-vertically-aligned-center tyche-newsletter__action"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"overlay","textColor":"contrast"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-contrast-color has-overlay-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( tyche_store_url( 'myaccount' ) ); ?>"><?php esc_html_e( 'Create an account', 'tyche' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
