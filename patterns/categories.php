<?php
/**
 * Title: Shop by category tiles
 * Slug: tyche/categories
 * Categories: tyche-store
 * Keywords: category, collection, tiles
 * Viewport Width: 1400
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section tyche-categories","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section tyche-categories" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:group {"align":"wide","className":"tyche-section-head","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
<div class="wp-block-group alignwide tyche-section-head"><!-- wp:group {"className":"tyche-section-head__title","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-section-head__title"><!-- wp:paragraph {"className":"is-style-tyche-eyebrow"} -->
<p class="is-style-tyche-eyebrow"><?php esc_html_e( 'Collections', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Shop by category', 'tyche' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"tyche-section-head__actions","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group tyche-section-head__actions"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-tyche-link"} -->
<div class="wp-block-button is-style-tyche-link"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( tyche_store_url( 'shop' ) ); ?>"><?php esc_html_e( 'View all', 'tyche' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:columns {"align":"wide","className":"tyche-tiles","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns alignwide tyche-tiles"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/cat-coats.webp' ) ); ?>","isUserOverlayColor":true,"customGradient":"linear-gradient(180deg,rgba(12,10,8,0) 30%,rgba(12,10,8,0.72) 100%)","contentPosition":"bottom left","className":"tyche-tile is-style-tyche-zoom","style":{"dimensions":{"aspectRatio":"4/5"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left tyche-tile is-style-tyche-zoom"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/cat-coats.webp' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim wp-block-cover__gradient-background has-background-gradient" style="background:linear-gradient(180deg,rgba(12,10,8,0) 30%,rgba(12,10,8,0.72) 100%)"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"level":3,"className":"tyche-tile__title","textColor":"overlay","fontSize":"xx-large"} -->
<h3 class="wp-block-heading tyche-tile__title has-overlay-color has-text-color has-xx-large-font-size"><a href="<?php echo esc_url( tyche_store_url( 'shop' ) ); ?>"><?php esc_html_e( 'Coats', 'tyche' ); ?></a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"overlay","fontSize":"small"} -->
<p class="has-overlay-color has-text-color has-small-font-size"><?php esc_html_e( 'Wool, cashmere and waxed cotton', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/cat-knitwear.webp' ) ); ?>","isUserOverlayColor":true,"customGradient":"linear-gradient(180deg,rgba(12,10,8,0) 30%,rgba(12,10,8,0.72) 100%)","contentPosition":"bottom left","className":"tyche-tile is-style-tyche-zoom","style":{"dimensions":{"aspectRatio":"4/5"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left tyche-tile is-style-tyche-zoom"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/cat-knitwear.webp' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim wp-block-cover__gradient-background has-background-gradient" style="background:linear-gradient(180deg,rgba(12,10,8,0) 30%,rgba(12,10,8,0.72) 100%)"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"level":3,"className":"tyche-tile__title","textColor":"overlay","fontSize":"xx-large"} -->
<h3 class="wp-block-heading tyche-tile__title has-overlay-color has-text-color has-xx-large-font-size"><a href="<?php echo esc_url( tyche_store_url( 'shop' ) ); ?>"><?php esc_html_e( 'Knitwear', 'tyche' ); ?></a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"overlay","fontSize":"small"} -->
<p class="has-overlay-color has-text-color has-small-font-size"><?php esc_html_e( 'Soft layers for cold mornings', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/cat-dresses.webp' ) ); ?>","isUserOverlayColor":true,"customGradient":"linear-gradient(180deg,rgba(12,10,8,0) 30%,rgba(12,10,8,0.72) 100%)","contentPosition":"bottom left","className":"tyche-tile is-style-tyche-zoom","style":{"dimensions":{"aspectRatio":"4/5"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left tyche-tile is-style-tyche-zoom"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/cat-dresses.webp' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim wp-block-cover__gradient-background has-background-gradient" style="background:linear-gradient(180deg,rgba(12,10,8,0) 30%,rgba(12,10,8,0.72) 100%)"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"level":3,"className":"tyche-tile__title","textColor":"overlay","fontSize":"xx-large"} -->
<h3 class="wp-block-heading tyche-tile__title has-overlay-color has-text-color has-xx-large-font-size"><a href="<?php echo esc_url( tyche_store_url( 'shop' ) ); ?>"><?php esc_html_e( 'Dresses', 'tyche' ); ?></a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"overlay","fontSize":"small"} -->
<p class="has-overlay-color has-text-color has-small-font-size"><?php esc_html_e( 'Easy shapes, day to evening', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/cat-accessories.webp' ) ); ?>","isUserOverlayColor":true,"customGradient":"linear-gradient(180deg,rgba(12,10,8,0) 30%,rgba(12,10,8,0.72) 100%)","contentPosition":"bottom left","className":"tyche-tile is-style-tyche-zoom","style":{"dimensions":{"aspectRatio":"4/5"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left tyche-tile is-style-tyche-zoom"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/cat-accessories.webp' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim wp-block-cover__gradient-background has-background-gradient" style="background:linear-gradient(180deg,rgba(12,10,8,0) 30%,rgba(12,10,8,0.72) 100%)"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"level":3,"className":"tyche-tile__title","textColor":"overlay","fontSize":"xx-large"} -->
<h3 class="wp-block-heading tyche-tile__title has-overlay-color has-text-color has-xx-large-font-size"><a href="<?php echo esc_url( tyche_store_url( 'shop' ) ); ?>"><?php esc_html_e( 'Accessories', 'tyche' ); ?></a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"overlay","fontSize":"small"} -->
<p class="has-overlay-color has-text-color has-small-font-size"><?php esc_html_e( 'Scarves, bags and finishing touches', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
