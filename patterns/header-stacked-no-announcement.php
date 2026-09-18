<?php
/**
 * Title: Header: logo above a centred menu, without announcement bar
 * Slug: tyche/header-stacked-no-announcement
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Swap it in from the Site Editor: select the header and choose Replace.
 * Viewport Width: 1400
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"tyche-header tyche-header\u002d\u002dstacked","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull tyche-header tyche-header--stacked has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:group {"align":"wide","className":"tyche-header__bar tyche-header__bar\u002d\u002dstacked","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
<div class="wp-block-group alignwide tyche-header__bar tyche-header__bar--stacked"><!-- wp:group {"className":"tyche-header__spacer","layout":{"type":"constrained"}} -->
<div class="wp-block-group tyche-header__spacer"></div>
<!-- /wp:group -->

<!-- wp:group {"className":"tyche-header__brand","layout":{"type":"flex","justifyContent":"left","flexWrap":"nowrap"}} -->
<div class="wp-block-group tyche-header__brand"><!-- wp:site-logo {"width":120,"shouldSyncIcon":false} /-->

<!-- wp:site-title {"level":0} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"tyche-header__actions","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","justifyContent":"right","flexWrap":"nowrap"}} -->
<div class="wp-block-group tyche-header__actions"><!-- wp:search {"label":"<?php echo esc_attr__( 'Search', 'tyche' ); ?>","showLabel":false,"placeholder":"<?php echo esc_attr__( 'Search products', 'tyche' ); ?>","buttonText":"<?php echo esc_attr__( 'Search', 'tyche' ); ?>","buttonPosition":"button-only","buttonUseIcon":true,"query":{"post_type":"product"},"className":"tyche-header__search"} /-->

<!-- wp:pattern {"slug":"tyche/header-store-actions"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"tyche-header__subnav","layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-group alignwide tyche-header__subnav"><!-- wp:navigation {"className":"tyche-header__nav","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","justifyContent":"left"}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
