<?php
/**
 * Title: Product template body
 * Slug: tyche/hidden-product
 * Viewport Width: 1400
 * Inserter: no
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"main","className":"tyche-main","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|80"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<main class="wp-block-group tyche-main" style="margin-top:0;padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:woocommerce/breadcrumbs /-->

<!-- wp:woocommerce/store-notices /-->

<!-- wp:columns {"align":"wide","className":"tyche-product","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|70","left":"var:preset|spacing|70"}}}} -->
<div class="wp-block-columns alignwide tyche-product"><!-- wp:column {"width":"58%","className":"tyche-product__gallery"} -->
<div class="wp-block-column tyche-product__gallery" style="flex-basis:58%"><!-- wp:woocommerce/product-gallery -->
<div class="wp-block-woocommerce-product-gallery wc-block-product-gallery"><!-- wp:woocommerce/product-gallery-thumbnails {"thumbnailSize":"20%","aspectRatio":"4/5"} /-->

<!-- wp:woocommerce/product-gallery-large-image -->
<div class="wp-block-woocommerce-product-gallery-large-image wc-block-product-gallery-large-image__inner-blocks"><!-- wp:woocommerce/product-image {"showProductLink":false,"showSaleBadge":false} -->
<div class="is-loading"></div>
<!-- /wp:woocommerce/product-image -->

<!-- wp:woocommerce/product-sale-badge {"align":"right"} /-->

<!-- wp:woocommerce/product-gallery-large-image-next-previous -->
<div class="wp-block-woocommerce-product-gallery-large-image-next-previous"></div>
<!-- /wp:woocommerce/product-gallery-large-image-next-previous --></div>
<!-- /wp:woocommerce/product-gallery-large-image --></div>
<!-- /wp:woocommerce/product-gallery --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"tyche-product__summary"} -->
<div class="wp-block-column tyche-product__summary"><!-- wp:post-terms {"term":"product_cat","className":"is-style-tyche-eyebrow tyche-product__category"} /-->

<!-- wp:post-title {"level":1,"className":"tyche-product__title","__woocommerceNamespace":"woocommerce/product-query/product-title"} /-->

<!-- wp:woocommerce/product-rating {"isDescendentOfSingleProductTemplate":true} /-->

<!-- wp:woocommerce/product-price {"isDescendentOfSingleProductTemplate":true,"fontSize":"x-large","className":"tyche-product__price"} /-->

<!-- wp:post-excerpt {"excerptLength":60,"className":"tyche-product__excerpt","__woocommerceNamespace":"woocommerce/product-query/product-summary"} /-->

<!-- wp:woocommerce/add-to-cart-with-options {"className":"tyche-product__add"} /-->

<!-- wp:group {"className":"tyche-assurances","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-assurances"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:icon {"icon":"tyche/truck-delivery","className":"tyche-icon"} /-->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php echo esc_html( tyche_free_delivery_line() ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:icon {"icon":"tyche/arrow-back-up","className":"tyche-icon"} /-->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php esc_html_e( 'Free returns within 30 days', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:icon {"icon":"tyche/lock","className":"tyche-icon"} /-->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php esc_html_e( 'Secure checkout', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:woocommerce/product-meta -->
<div class="wp-block-woocommerce-product-meta"><!-- wp:group {"className":"tyche-product__meta","style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-product__meta"><!-- wp:woocommerce/product-sku /-->

<!-- wp:post-terms {"term":"product_tag","prefix":"<?php echo esc_attr__( 'Tags: ', 'tyche' ); ?>"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:woocommerce/product-meta --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"className":"tyche-product__details","layout":{"type":"constrained","contentSize":"880px"}} -->
<div class="wp-block-group tyche-product__details"><!-- wp:woocommerce/product-details -->
<div class="wp-block-woocommerce-product-details alignwide"><!-- wp:accordion {"metadata":{"isDescendantOfProductDetails":true}} -->
<div role="group" class="wp-block-accordion"><!-- wp:accordion-item {"openByDefault":true} -->
<div class="wp-block-accordion-item is-open"><!-- wp:accordion-heading -->
<h3 class="wp-block-accordion-heading has-icon has-icon-right"><button type="button" class="wp-block-accordion-heading__toggle"><span class="wp-block-accordion-heading__toggle-title"><?php esc_html_e( 'Description', 'tyche' ); ?></span><span class="wp-block-accordion-heading__toggle-icon" aria-hidden="true">+</span></button></h3>
<!-- /wp:accordion-heading -->

<!-- wp:accordion-panel -->
<div role="region" class="wp-block-accordion-panel"><!-- wp:woocommerce/product-description /--></div>
<!-- /wp:accordion-panel --></div>
<!-- /wp:accordion-item -->

<!-- wp:accordion-item -->
<div class="wp-block-accordion-item"><!-- wp:accordion-heading -->
<h3 class="wp-block-accordion-heading has-icon has-icon-right"><button type="button" class="wp-block-accordion-heading__toggle"><span class="wp-block-accordion-heading__toggle-title"><?php esc_html_e( 'Additional Information', 'tyche' ); ?></span><span class="wp-block-accordion-heading__toggle-icon" aria-hidden="true">+</span></button></h3>
<!-- /wp:accordion-heading -->

<!-- wp:accordion-panel -->
<div role="region" class="wp-block-accordion-panel"><!-- wp:woocommerce/product-specifications /--></div>
<!-- /wp:accordion-panel --></div>
<!-- /wp:accordion-item -->

<!-- wp:accordion-item -->
<div class="wp-block-accordion-item"><!-- wp:accordion-heading -->
<h3 class="wp-block-accordion-heading has-icon has-icon-right"><button type="button" class="wp-block-accordion-heading__toggle"><span class="wp-block-accordion-heading__toggle-title"><?php esc_html_e( 'Reviews', 'tyche' ); ?></span><span class="wp-block-accordion-heading__toggle-icon" aria-hidden="true">+</span></button></h3>
<!-- /wp:accordion-heading -->

<!-- wp:accordion-panel -->
<div role="region" class="wp-block-accordion-panel"><!-- wp:woocommerce/product-reviews -->
<div class="wp-block-woocommerce-product-reviews"><!-- wp:woocommerce/product-reviews-title /-->

<!-- wp:woocommerce/product-review-template -->
<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"40px"} -->
<div class="wp-block-column" style="flex-basis:40px"><!-- wp:avatar {"size":40,"style":{"border":{"radius":"20px"}}} /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group"><!-- wp:woocommerce/product-review-author-name {"fontSize":"small"} /-->

<!-- wp:woocommerce/product-review-rating /--></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"0px","bottom":"0px"}}},"layout":{"type":"flex"}} -->
<div class="wp-block-group" style="margin-top:0px;margin-bottom:0px"><!-- wp:woocommerce/product-review-date {"fontSize":"small"} /--></div>
<!-- /wp:group -->

<!-- wp:woocommerce/product-review-content /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:woocommerce/product-review-template -->

<!-- wp:woocommerce/product-reviews-pagination -->
<!-- wp:woocommerce/product-reviews-pagination-previous /-->

<!-- wp:woocommerce/product-reviews-pagination-numbers /-->

<!-- wp:woocommerce/product-reviews-pagination-next /-->
<!-- /wp:woocommerce/product-reviews-pagination -->

<!-- wp:woocommerce/product-review-form /--></div>
<!-- /wp:woocommerce/product-reviews --></div>
<!-- /wp:accordion-panel --></div>
<!-- /wp:accordion-item --></div>
<!-- /wp:accordion --></div>
<!-- /wp:woocommerce/product-details --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"tyche-product__related","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide tyche-product__related" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--0)"><!-- wp:group {"align":"wide","className":"tyche-section-head","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
<div class="wp-block-group alignwide tyche-section-head"><!-- wp:group {"className":"tyche-section-head__title","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-section-head__title"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'You may also like', 'tyche' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:woocommerce/product-collection {"queryId":0,"query":{"perPage":4,"pages":0,"offset":0,"postType":"product","order":"asc","orderBy":"title","search":"","exclude":[],"inherit":false,"taxQuery":{},"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","outofstock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[],"relatedBy":{"categories":true,"tags":true}},"tagName":"div","displayLayout":{"type":"flex","columns":4,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"collection":"woocommerce/product-collection/related","queryContextIncludes":["collection"],"align":"wide"} -->
<div class="wp-block-woocommerce-product-collection alignwide"><!-- wp:woocommerce/product-template {"className":"tyche-product-cards"} -->
<!-- wp:woocommerce/product-image {"showSaleBadge":false,"isDescendentOfQueryLoop":true,"className":"tyche-card-media","style":{"dimensions":{"aspectRatio":"4/5"}}} -->
<!-- wp:woocommerce/product-sale-badge {"isDescendentOfQueryLoop":true,"align":"left"} /-->
<!-- /wp:woocommerce/product-image -->

<!-- wp:post-title {"level":3,"isLink":true,"className":"tyche-card-title","__woocommerceNamespace":"woocommerce/product-collection/product-title"} /-->

<!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true,"className":"tyche-card-price"} /-->

<!-- wp:woocommerce/product-button {"isDescendentOfQueryLoop":true,"className":"tyche-card-button"} /-->
<!-- /wp:woocommerce/product-template -->

<!-- wp:woocommerce/product-collection-no-results -->
<!-- wp:group {"className":"tyche-no-results","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-no-results"><!-- wp:heading {"level":3,"fontSize":"x-large"} -->
<h3 class="wp-block-heading has-x-large-font-size"><?php esc_html_e( 'Nothing matches those filters', 'tyche' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e( 'Try removing a filter, or browse everything in the shop.', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-tyche-outline"} -->
<div class="wp-block-button is-style-tyche-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( tyche_store_url( 'shop' ) ); ?>"><?php esc_html_e( 'Clear filters and browse', 'tyche' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
<!-- /wp:woocommerce/product-collection-no-results --></div>
<!-- /wp:woocommerce/product-collection --></div>
<!-- /wp:group --></main>
<!-- /wp:group -->
