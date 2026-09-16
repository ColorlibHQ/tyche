<?php
/**
 * Title: Product carousel: best sellers
 * Slug: tyche/products-best
 * Categories: tyche-store
 * Keywords: products, carousel, best sellers
 * Viewport Width: 1400
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<?php if ( tyche_has_woocommerce() ) : ?>
<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section tyche-product-row","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section tyche-product-row" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
<!-- wp:group {"align":"wide","className":"tyche-section-head","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
<div class="wp-block-group alignwide tyche-section-head">
<!-- wp:group {"className":"tyche-section-head__title","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-section-head__title">
<!-- wp:paragraph {"className":"is-style-tyche-eyebrow"} -->
<p class="is-style-tyche-eyebrow"><?php esc_html_e( 'Most loved', 'tyche' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Best sellers', 'tyche' ); ?></h2>
<!-- /wp:heading -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"tyche-section-head__actions","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group tyche-section-head__actions">
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-tyche-link"} -->
<div class="wp-block-button is-style-tyche-link"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( tyche_store_url( 'shop' ) ); ?>"><?php esc_html_e( 'Shop best sellers', 'tyche' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:woocommerce/product-collection {"queryId":0,"query":{"perPage":8,"pages":0,"offset":0,"postType":"product","order":"desc","orderBy":"popularity","search":"","exclude":[],"inherit":false,"taxQuery":{},"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","outofstock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[]},"tagName":"div","displayLayout":{"type":"carousel","columns":4,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"queryContextIncludes":["collection"],"className":"tyche-products is-carousel","collection":"woocommerce/product-collection/best-sellers","align":"wide"} -->
<div class="wp-block-woocommerce-product-collection alignwide">
<!-- wp:group {"className":"tyche-carousel-nav","layout":{"type":"flex","justifyContent":"right","flexWrap":"nowrap"}} -->
<div class="wp-block-group tyche-carousel-nav">
<!-- wp:woocommerce/product-gallery-large-image-next-previous {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-woocommerce-product-gallery-large-image-next-previous"></div>
<!-- /wp:woocommerce/product-gallery-large-image-next-previous -->
</div>
<!-- /wp:group -->

<!-- wp:woocommerce/product-template {"className":"tyche-product-cards","layout":{"type":"flex","justifyContent":"left","verticalAlignment":"top","flexWrap":"nowrap","orientation":"horizontal"}} -->
<!-- wp:woocommerce/product-image {"showSaleBadge":false,"imageSizing":"single","isDescendentOfQueryLoop":true,"className":"tyche-card-media","style":{"dimensions":{"aspectRatio":"4/5"}}} -->
<!-- wp:woocommerce/product-sale-badge {"isDescendentOfQueryLoop":true,"align":"left"} /-->
<!-- /wp:woocommerce/product-image -->

<!-- wp:post-title {"level":3,"isLink":true,"className":"tyche-card-title","__woocommerceNamespace":"woocommerce/product-collection/product-title"} /-->

<!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true,"className":"tyche-card-price"} /-->

<!-- wp:woocommerce/product-button {"isDescendentOfQueryLoop":true,"className":"tyche-card-button"} /-->
<!-- /wp:woocommerce/product-template -->

<!-- wp:woocommerce/product-collection-no-results -->
<!-- wp:group {"className":"tyche-no-results","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-no-results">
<!-- wp:heading {"level":3,"fontSize":"x-large"} -->
<h3 class="wp-block-heading has-x-large-font-size"><?php esc_html_e( 'Nothing matches those filters', 'tyche' ); ?></h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e( 'Try removing a filter, or browse everything in the shop.', 'tyche' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-tyche-outline"} -->
<div class="wp-block-button is-style-tyche-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( tyche_store_url( 'shop' ) ); ?>"><?php esc_html_e( 'Clear filters and browse', 'tyche' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
<!-- /wp:woocommerce/product-collection-no-results -->
</div>
<!-- /wp:woocommerce/product-collection -->
</section>
<!-- /wp:group -->
<?php endif; ?>
