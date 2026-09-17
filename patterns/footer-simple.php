<?php
/**
 * Title: Footer: simple, centred
 * Slug: tyche/footer-simple
 * Categories: footer
 * Block Types: core/template-part/footer
 * Description: Swap it in from the Site Editor: select the footer and choose Replace.
 * Viewport Width: 1400
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"tyche-footer tyche-footer\u002d\u002dsimple","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|40"}},"backgroundColor":"dark","textColor":"on-dark","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull tyche-footer tyche-footer--simple has-on-dark-color has-dark-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:site-title {"level":0,"className":"tyche-footer__title","style":{"typography":{"textAlign":"center"}}} /-->

<!-- wp:navigation {"overlayMenu":"never","className":"tyche-footer__links","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Shop', 'tyche' ); ?>","url":"<?php echo esc_url( tyche_store_url( 'shop' ) ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'About', 'tyche' ); ?>","url":"<?php echo esc_url( tyche_page_url( 'about' ) ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Delivery and returns', 'tyche' ); ?>","url":"<?php echo esc_url( tyche_page_url( 'delivery-returns' ) ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'FAQ', 'tyche' ); ?>","url":"<?php echo esc_url( tyche_page_url( 'faq' ) ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Contact', 'tyche' ); ?>","url":"<?php echo esc_url( tyche_page_url( 'contact' ) ); ?>","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation -->

<!-- wp:paragraph {"className":"tyche-footer__legal","style":{"typography":{"textAlign":"center"}},"fontSize":"small"} -->
<p class="has-text-align-center tyche-footer__legal has-small-font-size">© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
