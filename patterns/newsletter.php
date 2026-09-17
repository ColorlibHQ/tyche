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
<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section tyche-cta-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section tyche-cta-section" style="padding-top:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","className":"tyche-cta","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|0","left":"var:preset|spacing|0"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center tyche-cta"><!-- wp:column {"width":"45%","className":"tyche-cta__media-column"} -->
<div class="wp-block-column tyche-cta__media-column" style="flex-basis:45%"><!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/about-2.webp' ) ); ?>","dimRatio":0,"overlayColor":"dark","isUserOverlayColor":true,"minHeight":460,"minHeightUnit":"px","className":"tyche-cta__media","layout":{"type":"constrained"}} -->
<div class="wp-block-cover tyche-cta__media" style="min-height:460px"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/about-2.webp' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"className":"tyche-cta__content","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-cta__content"><!-- wp:paragraph {"className":"is-style-tyche-eyebrow"} -->
<p class="is-style-tyche-eyebrow"><?php esc_html_e( 'Members', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"fontSize":"huge"} -->
<h2 class="wp-block-heading has-huge-font-size"><?php esc_html_e( 'Take 10% off your first order', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
<p class="has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'Create a free account and your welcome code is waiting at checkout.', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"is-style-tyche-checks"} -->
<ul class="wp-block-list is-style-tyche-checks"><!-- wp:list-item -->
<li><?php esc_html_e( 'Early access to new collections', 'tyche' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Members-only offers through the year', 'tyche' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Faster checkout and easy returns', 'tyche' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( tyche_store_url( 'myaccount' ) ); ?>"><?php esc_html_e( 'Create an account', 'tyche' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-tyche-outline"} -->
<div class="wp-block-button is-style-tyche-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( tyche_shop_sorted_url( 'date' ) ); ?>"><?php esc_html_e( 'Shop new arrivals', 'tyche' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
