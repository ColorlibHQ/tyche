<?php
/**
 * Title: Header with announcement bar
 * Slug: tyche/header
 * Block Types: core/template-part/header
 * Viewport Width: 1400
 * Inserter: no
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"tyche-announcement","backgroundColor":"dark","textColor":"on-dark","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull tyche-announcement has-dark-background-color has-background has-on-dark-color has-text-color" style="padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)">
<!-- wp:paragraph {"align":"center","fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size"><?php echo wp_kses_post( __( 'Free delivery on orders over $75 &middot; Free 30-day returns', 'tyche' ) ); ?> <a href="<?php echo esc_url( tyche_store_url( 'shop' ) ); ?>"><?php esc_html_e( 'Shop new in', 'tyche' ); ?></a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"tyche-header","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull tyche-header has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)">
<!-- wp:group {"align":"wide","className":"tyche-header__bar","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
<div class="wp-block-group alignwide tyche-header__bar">
<!-- wp:navigation {"overlayMenu":"mobile","className":"tyche-header__nav","layout":{"type":"flex","justifyContent":"left"},"style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} /-->
<!-- wp:group {"className":"tyche-header__brand","layout":{"type":"flex","justifyContent":"center","flexWrap":"nowrap"}} -->
<div class="wp-block-group tyche-header__brand">
<!-- wp:site-logo {"width":120,"shouldSyncIcon":false} /-->
<!-- wp:site-title {"level":0} /-->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"tyche-header__actions","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","justifyContent":"right","flexWrap":"nowrap"}} -->
<div class="wp-block-group tyche-header__actions">
<!-- wp:search {"label":"<?php echo esc_attr__( 'Search', 'tyche' ); ?>","showLabel":false,"placeholder":"<?php echo esc_attr__( 'Search products', 'tyche' ); ?>","buttonText":"<?php echo esc_attr__( 'Search', 'tyche' ); ?>","buttonPosition":"button-only","buttonUseIcon":true,"query":{"post_type":"product"},"className":"tyche-header__search"} /-->
<!-- wp:pattern {"slug":"tyche/header-store-actions"} /-->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
