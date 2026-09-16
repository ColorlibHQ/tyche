<?php
/**
 * Title: Latest journal posts
 * Slug: tyche/journal
 * Categories: tyche-content
 * Keywords: blog, posts, news
 * Viewport Width: 1400
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
<!-- wp:group {"align":"wide","className":"tyche-section-head","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
<div class="wp-block-group alignwide tyche-section-head">
<!-- wp:group {"className":"tyche-section-head__title","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-section-head__title">
<!-- wp:paragraph {"className":"is-style-tyche-eyebrow"} -->
<p class="is-style-tyche-eyebrow"><?php esc_html_e( 'Stories', 'tyche' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'From the journal', 'tyche' ); ?></h2>
<!-- /wp:heading -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"tyche-section-head__actions","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group tyche-section-head__actions">
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-tyche-link"} -->
<div class="wp-block-button is-style-tyche-link"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'All stories', 'tyche' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:query {"queryId":1,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"align":"wide","className":"tyche-posts"} -->
<div class="wp-block-query alignwide">
<!-- wp:post-template {"className":"tyche-post-cards","layout":{"type":"grid","columnCount":3}} -->
<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","className":"tyche-post-card__media"} /-->
<!-- wp:post-terms {"term":"category","className":"is-style-tyche-eyebrow"} /-->
<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"x-large"} /-->
<!-- wp:post-excerpt {"excerptLength":22,"className":"tyche-post-card__excerpt"} /-->
<!-- wp:post-date {"fontSize":"small"} /-->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph -->
<p><?php esc_html_e( 'No posts were found.', 'tyche' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
</section>
<!-- /wp:group -->
