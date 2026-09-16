<?php
/**
 * Title: Blog template body
 * Slug: tyche/hidden-blog
 * Viewport Width: 1400
 * Inserter: no
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"main","className":"tyche-main","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|80"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<main class="wp-block-group tyche-main" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--80);margin-top:0">
<!-- wp:group {"align":"wide","className":"tyche-page-head","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group alignwide tyche-page-head">
<!-- wp:heading {"level":1,"className":"tyche-page-title"} -->
<h1 class="wp-block-heading tyche-page-title"><?php esc_html_e( 'Journal', 'tyche' ); ?></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e( 'Styling notes, new collections and the people who make them.', 'tyche' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:query {"queryId":1,"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"align":"wide","className":"tyche-posts"} -->
<div class="wp-block-query alignwide">
<!-- wp:post-template {"className":"tyche-post-cards","layout":{"type":"grid","columnCount":3}} -->
<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","className":"tyche-post-card__media"} /-->
<!-- wp:post-terms {"term":"category","className":"is-style-tyche-eyebrow"} /-->
<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"x-large"} /-->
<!-- wp:post-excerpt {"excerptLength":22,"className":"tyche-post-card__excerpt"} /-->
<!-- wp:post-date {"fontSize":"small"} /-->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"paginationArrow":"arrow","layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->
<!-- wp:query-pagination-numbers /-->
<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination -->

<!-- wp:query-no-results -->
<!-- wp:paragraph -->
<p><?php esc_html_e( 'No posts were found.', 'tyche' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
</main>
<!-- /wp:group -->
