<?php
/**
 * Title: Two promotions
 * Slug: tyche/promos
 * Categories: tyche-store
 * Keywords: sale, promotion, banner
 * Viewport Width: 1400
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section" style="padding-top:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:columns {"align":"wide","className":"tyche-promos","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns alignwide tyche-promos"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/promo-1.jpg' ) ); ?>","isUserOverlayColor":true,"minHeight":560,"minHeightUnit":"px","customGradient":"linear-gradient(180deg,rgba(12,10,8,0) 30%,rgba(12,10,8,0.72) 100%)","contentPosition":"bottom left","className":"tyche-promo is-style-tyche-zoom","layout":{"type":"constrained"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left tyche-promo is-style-tyche-zoom" style="min-height:560px"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/promo-1.jpg' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim wp-block-cover__gradient-background has-background-gradient" style="background:linear-gradient(180deg,rgba(12,10,8,0) 30%,rgba(12,10,8,0.72) 100%)"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"className":"is-style-tyche-eyebrow","textColor":"overlay"} -->
<p class="is-style-tyche-eyebrow has-overlay-color has-text-color"><?php esc_html_e( 'Sale', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textColor":"overlay","fontSize":"huge"} -->
<h2 class="wp-block-heading has-overlay-color has-text-color has-huge-font-size"><?php esc_html_e( 'Up to 40% off outerwear', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"overlay"} -->
<p class="has-overlay-color has-text-color"><?php esc_html_e( 'Last season\'s coats and jackets, while sizes last.', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"overlay","textColor":"dark"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-dark-color has-overlay-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( tyche_store_url( 'shop' ) ); ?>"><?php esc_html_e( 'Shop the sale', 'tyche' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/promo-2.jpg' ) ); ?>","isUserOverlayColor":true,"minHeight":560,"minHeightUnit":"px","customGradient":"linear-gradient(180deg,rgba(12,10,8,0) 30%,rgba(12,10,8,0.72) 100%)","contentPosition":"bottom left","className":"tyche-promo is-style-tyche-zoom","layout":{"type":"constrained"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left tyche-promo is-style-tyche-zoom" style="min-height:560px"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/promo-2.jpg' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim wp-block-cover__gradient-background has-background-gradient" style="background:linear-gradient(180deg,rgba(12,10,8,0) 30%,rgba(12,10,8,0.72) 100%)"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"className":"is-style-tyche-eyebrow","textColor":"overlay"} -->
<p class="is-style-tyche-eyebrow has-overlay-color has-text-color"><?php esc_html_e( 'Just landed', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textColor":"overlay","fontSize":"huge"} -->
<h2 class="wp-block-heading has-overlay-color has-text-color has-huge-font-size"><?php esc_html_e( 'The cashmere capsule', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"overlay"} -->
<p class="has-overlay-color has-text-color"><?php esc_html_e( 'Six pieces, three colours and one very soft fabric.', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"overlay","textColor":"dark"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-dark-color has-overlay-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( tyche_store_url( 'shop' ) ); ?>"><?php esc_html_e( 'Discover the capsule', 'tyche' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
