<?php
/**
 * Title: Footer with link columns
 * Slug: tyche/footer
 * Block Types: core/template-part/footer
 * Viewport Width: 1400
 * Inserter: no
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"tyche-footer","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|40"}}},"backgroundColor":"dark","textColor":"on-dark","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull tyche-footer has-on-dark-color has-dark-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:columns {"align":"wide","className":"tyche-footer__columns","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns alignwide tyche-footer__columns"><!-- wp:column {"width":"36%"} -->
<div class="wp-block-column" style="flex-basis:36%"><!-- wp:site-title {"level":0,"className":"tyche-footer__title"} /-->

<!-- wp:paragraph {"className":"tyche-footer__about"} -->
<p class="tyche-footer__about"><?php esc_html_e( 'Considered clothing and everyday essentials, made to be worn for years and shipped with care.', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"iconColor":"overlay","iconColorValue":"#ffffff","size":"has-normal-icon-size","className":"is-style-logos-only tyche-footer__social","layout":{"type":"flex"}} -->
<ul class="wp-block-social-links has-normal-icon-size has-icon-color is-style-logos-only tyche-footer__social"><!-- wp:social-link {"url":"#","service":"instagram"} /-->

<!-- wp:social-link {"url":"#","service":"pinterest"} /-->

<!-- wp:social-link {"url":"#","service":"tiktok"} /-->

<!-- wp:social-link {"url":"#","service":"facebook"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"className":"tyche-footer__heading"} -->
<h2 class="wp-block-heading tyche-footer__heading"><?php esc_html_e( 'Shop', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:navigation {"overlayMenu":"never","className":"tyche-footer__links","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<!-- wp:navigation-link {"label":"New arrivals","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Best sellers","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Sale","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Gift cards","url":"#","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"className":"tyche-footer__heading"} -->
<h2 class="wp-block-heading tyche-footer__heading"><?php esc_html_e( 'Help', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:navigation {"overlayMenu":"never","className":"tyche-footer__links","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<!-- wp:navigation-link {"label":"Delivery","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Returns \u0026 exchanges","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Size guide","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Contact us","url":"#","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"className":"tyche-footer__heading"} -->
<h2 class="wp-block-heading tyche-footer__heading"><?php esc_html_e( 'About', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:navigation {"overlayMenu":"never","className":"tyche-footer__links","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<!-- wp:navigation-link {"label":"Our story","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Journal","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Sustainability","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Stores","url":"#","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:separator {"align":"wide","className":"is-style-wide tyche-footer__rule"} -->
<hr class="wp-block-separator alignwide has-alpha-channel-opacity is-style-wide tyche-footer__rule"/>
<!-- /wp:separator -->

<!-- wp:group {"align":"wide","className":"tyche-footer__bottom","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
<div class="wp-block-group alignwide tyche-footer__bottom"><!-- wp:paragraph {"className":"tyche-footer__legal","fontSize":"small"} -->
<p class="tyche-footer__legal has-small-font-size">© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:pattern {"slug":"tyche/footer-payments"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
