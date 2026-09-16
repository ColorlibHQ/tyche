<?php
/**
 * Title: Checkout header
 * Slug: tyche/checkout-header
 * Block Types: core/template-part/header
 * Viewport Width: 1400
 * Inserter: no
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"tyche-header tyche-checkout-header","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull tyche-header tyche-checkout-header has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)">
<!-- wp:group {"align":"wide","className":"tyche-header__bar","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
<div class="wp-block-group alignwide tyche-header__bar">
<!-- wp:paragraph {"className":"tyche-checkout-header__back","fontSize":"small"} -->
<p class="tyche-checkout-header__back has-small-font-size"><a href="<?php echo esc_url( tyche_store_url( 'cart' ) ); ?>"><?php esc_html_e( 'Back to cart', 'tyche' ); ?></a></p>
<!-- /wp:paragraph -->
<!-- wp:group {"className":"tyche-header__brand","layout":{"type":"flex","justifyContent":"center","flexWrap":"nowrap"}} -->
<div class="wp-block-group tyche-header__brand">
<!-- wp:site-logo {"width":120,"shouldSyncIcon":false} /-->
<!-- wp:site-title {"level":0} /-->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"tyche-checkout-header__secure","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","justifyContent":"right","flexWrap":"nowrap"}} -->
<div class="wp-block-group tyche-checkout-header__secure">
<!-- wp:icon {"icon":"tyche/lock","className":"tyche-icon"} /-->
<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php esc_html_e( 'Secure checkout', 'tyche' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
