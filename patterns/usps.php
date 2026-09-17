<?php
/**
 * Title: Store promises with icons
 * Slug: tyche/usps
 * Categories: tyche-store
 * Keywords: delivery, returns, features, promises
 * Viewport Width: 1400
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section tyche-promises-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section tyche-promises-section" style="padding-top:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:group {"align":"wide","className":"tyche-promises","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide tyche-promises"><!-- wp:columns {"className":"tyche-promises__items","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|0","left":"var:preset|spacing|0"}}}} -->
<div class="wp-block-columns tyche-promises__items"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"tyche-promise","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group tyche-promise"><!-- wp:icon {"icon":"tyche/truck-delivery","className":"tyche-icon tyche-promise__icon"} /-->

<!-- wp:group {"className":"tyche-promise__copy","style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-promise__copy"><!-- wp:heading {"level":3,"className":"tyche-promise__title","fontSize":"medium","fontFamily":"figtree"} -->
<h3 class="wp-block-heading tyche-promise__title has-figtree-font-family has-medium-font-size"><?php echo esc_html( tyche_free_delivery_line( 'short' ) ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tyche-promise__text","textColor":"muted","fontSize":"small"} -->
<p class="tyche-promise__text has-muted-color has-text-color has-small-font-size"><?php esc_html_e( 'Tracked delivery in two to four working days.', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"tyche-promise","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group tyche-promise"><!-- wp:icon {"icon":"tyche/arrow-back-up","className":"tyche-icon tyche-promise__icon"} /-->

<!-- wp:group {"className":"tyche-promise__copy","style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-promise__copy"><!-- wp:heading {"level":3,"className":"tyche-promise__title","fontSize":"medium","fontFamily":"figtree"} -->
<h3 class="wp-block-heading tyche-promise__title has-figtree-font-family has-medium-font-size"><?php esc_html_e( '30-day returns', 'tyche' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tyche-promise__text","textColor":"muted","fontSize":"small"} -->
<p class="tyche-promise__text has-muted-color has-text-color has-small-font-size"><?php esc_html_e( 'Changed your mind? Send it back for free.', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"tyche-promise","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group tyche-promise"><!-- wp:icon {"icon":"tyche/lock","className":"tyche-icon tyche-promise__icon"} /-->

<!-- wp:group {"className":"tyche-promise__copy","style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-promise__copy"><!-- wp:heading {"level":3,"className":"tyche-promise__title","fontSize":"medium","fontFamily":"figtree"} -->
<h3 class="wp-block-heading tyche-promise__title has-figtree-font-family has-medium-font-size"><?php esc_html_e( 'Secure payment', 'tyche' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tyche-promise__text","textColor":"muted","fontSize":"small"} -->
<p class="tyche-promise__text has-muted-color has-text-color has-small-font-size"><?php esc_html_e( 'Card, wallet and pay-later options at checkout.', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"tyche-promise","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group tyche-promise"><!-- wp:icon {"icon":"tyche/headset","className":"tyche-icon tyche-promise__icon"} /-->

<!-- wp:group {"className":"tyche-promise__copy","style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-promise__copy"><!-- wp:heading {"level":3,"className":"tyche-promise__title","fontSize":"medium","fontFamily":"figtree"} -->
<h3 class="wp-block-heading tyche-promise__title has-figtree-font-family has-medium-font-size"><?php esc_html_e( 'Real people', 'tyche' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tyche-promise__text","textColor":"muted","fontSize":"small"} -->
<p class="tyche-promise__text has-muted-color has-text-color has-small-font-size"><?php esc_html_e( 'Our team answers every message within a day.', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
