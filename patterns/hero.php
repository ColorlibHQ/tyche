<?php
/**
 * Title: Hero: full-width photograph
 * Slug: tyche/hero
 * Categories: tyche-store
 * Keywords: hero, banner, cover
 * Viewport Width: 1400
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/hero-1.jpg' ) ); ?>","dimRatio":30,"overlayColor":"dark","isUserOverlayColor":true,"minHeight":86,"minHeightUnit":"vh","contentPosition":"bottom left","align":"full","className":"tyche-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull has-custom-content-position is-position-bottom-left tyche-hero" style="min-height:86vh"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/hero-1.jpg' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim-30 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"tyche-hero__content","layout":{"type":"default"}} -->
<div class="wp-block-group tyche-hero__content"><!-- wp:paragraph {"className":"is-style-tyche-eyebrow","textColor":"overlay"} -->
<p class="is-style-tyche-eyebrow has-overlay-color has-text-color"><?php esc_html_e( 'New season', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"tyche-hero__title","textColor":"overlay","fontSize":"colossal"} -->
<h1 class="wp-block-heading tyche-hero__title has-overlay-color has-text-color has-colossal-font-size"><?php esc_html_e( 'The autumn edit', 'tyche' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tyche-hero__lede","textColor":"overlay","fontSize":"large"} -->
<p class="tyche-hero__lede has-overlay-color has-text-color has-large-font-size"><?php esc_html_e( 'Wool coats, soft knitwear and the pieces you will reach for all season long.', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"overlay","textColor":"contrast"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-contrast-color has-overlay-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( tyche_store_url( 'shop' ) ); ?>"><?php esc_html_e( 'Shop new arrivals', 'tyche' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"textColor":"overlay","className":"is-style-tyche-outline"} -->
<div class="wp-block-button is-style-tyche-outline"><a class="wp-block-button__link has-overlay-color has-text-color wp-element-button" href="#"><?php esc_html_e( 'Explore the lookbook', 'tyche' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->
