<?php
/**
 * Title: Header: logo on the left
 * Slug: tyche/header-left
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Swap it in from the Site Editor: select the header and choose Replace.
 * Viewport Width: 1400
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"tyche-announcement","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"backgroundColor":"dark","textColor":"on-dark","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull tyche-announcement has-on-dark-color has-dark-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)"><!-- wp:paragraph {"style":{"typography":{"textAlign":"center"}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size"><?php echo esc_html( tyche_free_delivery_line() ); ?><?php echo wp_kses_post( __( ' &middot; Free 30-day returns', 'tyche' ) ); ?> <a href="<?php echo esc_url( tyche_store_url( 'shop' ) ); ?>"><?php esc_html_e( 'Shop new in', 'tyche' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"tyche-header","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull tyche-header has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:group {"align":"wide","className":"tyche-header__bar tyche-header__bar\u002d\u002dleft","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
<div class="wp-block-group alignwide tyche-header__bar tyche-header__bar--left"><!-- wp:group {"className":"tyche-header__brand","layout":{"type":"flex","justifyContent":"left","flexWrap":"nowrap"}} -->
<div class="wp-block-group tyche-header__brand"><!-- wp:site-logo {"width":120,"shouldSyncIcon":false} /-->

<!-- wp:site-title {"level":0} /--></div>
<!-- /wp:group -->

<!-- wp:navigation {"className":"tyche-header__nav","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","justifyContent":"left"}} /-->

<!-- wp:group {"className":"tyche-header__actions","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","justifyContent":"right","flexWrap":"nowrap"}} -->
<div class="wp-block-group tyche-header__actions"><!-- wp:search {"label":"<?php echo esc_attr__( 'Search', 'tyche' ); ?>","showLabel":false,"placeholder":"<?php echo esc_attr__( 'Search products', 'tyche' ); ?>","buttonText":"<?php echo esc_attr__( 'Search', 'tyche' ); ?>","buttonPosition":"button-only","buttonUseIcon":true,"query":{"post_type":"product"},"className":"tyche-header__search"} /-->

<!-- wp:pattern {"slug":"tyche/header-store-actions"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
