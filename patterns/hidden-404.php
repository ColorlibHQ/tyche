<?php
/**
 * Title: 404 template body
 * Slug: tyche/hidden-404
 * Viewport Width: 1400
 * Inserter: no
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"main","className":"tyche-main","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<main class="wp-block-group tyche-main" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80);margin-top:0">
<!-- wp:group {"className":"tyche-404","layout":{"type":"constrained","contentSize":"620px"}} -->
<div class="wp-block-group tyche-404">
<!-- wp:paragraph {"align":"center","className":"is-style-tyche-eyebrow"} -->
<p class="has-text-align-center is-style-tyche-eyebrow"><?php esc_html_e( 'Error 404', 'tyche' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"textAlign":"center","className":"tyche-page-title"} -->
<h1 class="wp-block-heading has-text-align-center tyche-page-title"><?php esc_html_e( 'This page has moved on', 'tyche' ); ?></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","textColor":"muted"} -->
<p class="has-text-align-center has-muted-color has-text-color"><?php esc_html_e( 'The link may be old, or the product may have sold out. Try a search, or start again from the shop.', 'tyche' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:search {"label":"<?php echo esc_attr__( 'Search', 'tyche' ); ?>","showLabel":false,"placeholder":"<?php echo esc_attr__( 'Search products', 'tyche' ); ?>","buttonText":"<?php echo esc_attr__( 'Search', 'tyche' ); ?>","query":{"post_type":"product"},"className":"tyche-404__search"} /-->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( tyche_store_url( 'shop' ) ); ?>"><?php esc_html_e( 'Back to the shop', 'tyche' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"tyche/hidden-404-products"} /-->
</main>
<!-- /wp:group -->
