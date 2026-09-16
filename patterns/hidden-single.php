<?php
/**
 * Title: Single template body
 * Slug: tyche/hidden-single
 * Viewport Width: 1400
 * Inserter: no
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"main","className":"tyche-main","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|80"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<main class="wp-block-group tyche-main" style="margin-top:0;padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:group {"className":"tyche-post-head","layout":{"type":"constrained"}} -->
<div class="wp-block-group tyche-post-head"><!-- wp:post-terms {"term":"category","className":"is-style-tyche-eyebrow","style":{"typography":{"textAlign":"center"}}} /-->

<!-- wp:post-title {"level":1,"className":"tyche-page-title","style":{"typography":{"textAlign":"center"}}} /-->

<!-- wp:group {"className":"tyche-post-meta","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-group tyche-post-meta"><!-- wp:post-date {"metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"fontSize":"small"} /-->

<!-- wp:post-author-name {"fontSize":"small"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:post-featured-image {"aspectRatio":"16/9","align":"wide","className":"tyche-post-hero"} /-->

<!-- wp:post-content {"className":"tyche-prose","layout":{"type":"constrained"}} /-->

<!-- wp:post-terms {"term":"post_tag","className":"tyche-post-tags"} /-->

<!-- wp:group {"className":"tyche-post-nav","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
<div class="wp-block-group tyche-post-nav"><!-- wp:post-navigation-link {"type":"previous","showTitle":true,"arrow":"arrow"} /-->

<!-- wp:post-navigation-link {"showTitle":true,"arrow":"arrow"} /--></div>
<!-- /wp:group -->

<!-- wp:comments {"className":"tyche-comments"} -->
<div class="wp-block-comments tyche-comments"><!-- wp:comments-title /-->

<!-- wp:comment-template -->
<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"40px"} -->
<div class="wp-block-column" style="flex-basis:40px"><!-- wp:avatar {"size":40,"style":{"border":{"radius":"20px"}}} /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:comment-author-name {"fontSize":"small"} /-->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"0px","bottom":"0px"}}},"layout":{"type":"flex"}} -->
<div class="wp-block-group" style="margin-top:0px;margin-bottom:0px"><!-- wp:comment-date {"fontSize":"small"} /-->

<!-- wp:comment-edit-link {"fontSize":"small"} /--></div>
<!-- /wp:group -->

<!-- wp:comment-content /-->

<!-- wp:comment-reply-link {"fontSize":"small"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:comment-template -->

<!-- wp:comments-pagination -->
<!-- wp:comments-pagination-previous /-->

<!-- wp:comments-pagination-numbers /-->

<!-- wp:comments-pagination-next /-->
<!-- /wp:comments-pagination -->

<!-- wp:post-comments-form /--></div>
<!-- /wp:comments --></main>
<!-- /wp:group -->
