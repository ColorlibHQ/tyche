<?php
/**
 * Title: Brand story with photograph
 * Slug: tyche/story
 * Categories: tyche-content
 * Keywords: about, story, craft
 * Viewport Width: 1400
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"backgroundColor":"surface","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","className":"tyche-story","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|80","left":"var:preset|spacing|80"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center tyche-story"><!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:image {"aspectRatio":"4/5","scale":"cover","sizeSlug":"large","linkDestination":"none","className":"tyche-story__image"} -->
<figure class="wp-block-image size-large tyche-story__image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/story-1.webp' ) ); ?>" alt="<?php esc_attr_e( 'Folded grey knitwear stacked on an oak table', 'tyche' ); ?>" style="aspect-ratio:4/5;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"is-style-tyche-eyebrow"} -->
<p class="is-style-tyche-eyebrow"><?php esc_html_e( 'Our craft', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"fontSize":"huge"} -->
<h2 class="wp-block-heading has-huge-font-size"><?php esc_html_e( 'Made to be worn for years, not seasons', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
<p class="has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'Every piece starts with a fabric we can trace and a maker we have met. We cut in small runs, finish by hand and repair what we sell, so the coat you buy this autumn is still the one you wear in ten years.', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"is-style-tyche-checks"} -->
<ul class="wp-block-list is-style-tyche-checks"><!-- wp:list-item -->
<li><?php esc_html_e( 'Traceable wool from family-run farms', 'tyche' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Finished by hand in small batches', 'tyche' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Free repairs for the first year', 'tyche' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-tyche-outline"} -->
<div class="wp-block-button is-style-tyche-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( tyche_page_url( 'about' ) ); ?>"><?php esc_html_e( 'Read our story', 'tyche' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
