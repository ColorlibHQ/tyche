<?php
/**
 * Title: Contact page
 * Slug: tyche/page-contact
 * Categories: tyche-pages
 * Keywords: contact, address, hours
 * Block Types: core/post-content
 * Post Types: page
 * Description: A complete page layout, offered when you create a page.
 * Viewport Width: 1400
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:group {"className":"tyche-page-intro","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"680px"}} -->
<div class="wp-block-group tyche-page-intro"><!-- wp:paragraph {"className":"is-style-tyche-eyebrow","style":{"typography":{"textAlign":"center"}}} -->
<p class="has-text-align-center is-style-tyche-eyebrow"><?php esc_html_e( 'Contact', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"tyche-page-title","style":{"typography":{"textAlign":"center"}}} -->
<h1 class="wp-block-heading has-text-align-center tyche-page-title"><?php esc_html_e( 'We are here to help', 'tyche' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"textAlign":"center"}},"textColor":"muted","fontSize":"large"} -->
<p class="has-text-align-center has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'Write to us about an order, sizing or anything else. We answer every message within one working day.', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section" style="padding-top:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"tyche-usp","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-usp"><!-- wp:icon {"icon":"tyche/headset","className":"tyche-icon tyche-icon\u002d\u002dlarge"} /-->

<!-- wp:heading {"className":"tyche-usp__title","fontSize":"large","fontFamily":"figtree"} -->
<h2 class="wp-block-heading tyche-usp__title has-figtree-font-family has-large-font-size"><?php esc_html_e( 'Customer care', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php echo wp_kses_post( __( 'hello@example.com<br>+1 (555) 014-2030', 'tyche' ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"tyche-usp","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-usp"><!-- wp:icon {"icon":"tyche/clock","className":"tyche-icon tyche-icon\u002d\u002dlarge"} /-->

<!-- wp:heading {"className":"tyche-usp__title","fontSize":"large","fontFamily":"figtree"} -->
<h2 class="wp-block-heading tyche-usp__title has-figtree-font-family has-large-font-size"><?php esc_html_e( 'Opening hours', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php echo wp_kses_post( __( 'Monday to Friday, 9am to 6pm<br>Saturday, 10am to 4pm', 'tyche' ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"tyche-usp","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-usp"><!-- wp:icon {"icon":"tyche/map-pin","className":"tyche-icon tyche-icon\u002d\u002dlarge"} /-->

<!-- wp:heading {"className":"tyche-usp__title","fontSize":"large","fontFamily":"figtree"} -->
<h2 class="wp-block-heading tyche-usp__title has-figtree-font-family has-large-font-size"><?php esc_html_e( 'Visit the studio', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php echo wp_kses_post( __( '12 Market Street<br>Portland, OR 97204', 'tyche' ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section" style="padding-top:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:image {"aspectRatio":"21/9","scale":"cover","sizeSlug":"large","linkDestination":"none","align":"wide"} -->
<figure class="wp-block-image alignwide size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/contact-1.webp' ) ); ?>" alt="<?php esc_attr_e( 'A brown leather messenger bag resting on a stone wall', 'tyche' ); ?>" style="aspect-ratio:21/9;object-fit:cover"/></figure>
<!-- /wp:image --></section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"backgroundColor":"surface","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"620px"}} -->
<div class="wp-block-group"><!-- wp:heading {"style":{"typography":{"textAlign":"center"}}} -->
<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'Looking for a quick answer?', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"textAlign":"center"}},"textColor":"muted"} -->
<p class="has-text-align-center has-muted-color has-text-color"><?php esc_html_e( 'Most questions about orders, delivery and returns are answered in our help pages.', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-tyche-outline"} -->
<div class="wp-block-button is-style-tyche-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Read the FAQ', 'tyche' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-tyche-outline"} -->
<div class="wp-block-button is-style-tyche-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Delivery and returns', 'tyche' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
