<?php
/**
 * Title: About page
 * Slug: tyche/page-about
 * Categories: tyche-pages
 * Keywords: about, story, brand
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
<p class="has-text-align-center is-style-tyche-eyebrow"><?php esc_html_e( 'Our story', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"tyche-page-title","style":{"typography":{"textAlign":"center"}}} -->
<h1 class="wp-block-heading has-text-align-center tyche-page-title"><?php esc_html_e( 'Clothes worth keeping', 'tyche' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"textAlign":"center"}},"textColor":"muted","fontSize":"large"} -->
<p class="has-text-align-center has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'We make a small collection of well-made clothing and accessories, and we stand behind every piece.', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section" style="padding-top:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","className":"tyche-story","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|80","left":"var:preset|spacing|80"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center tyche-story"><!-- wp:column {"width":"45%"} -->
<div class="wp-block-column" style="flex-basis:45%"><!-- wp:image {"aspectRatio":"4/5","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/about-1.webp' ) ); ?>" alt="<?php esc_attr_e( 'Horn buttons on the cuff of a tweed jacket', 'tyche' ); ?>" style="aspect-ratio:4/5;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"is-style-tyche-eyebrow"} -->
<p class="is-style-tyche-eyebrow"><?php esc_html_e( 'Since 2014', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'We started with one coat and a list of things we wished it did better', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Our founder spent a winter taking apart the coats she loved, to see why some lasted and others did not. The answer was never the label. It was the cloth, the seams and the care someone took with them.', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Today we work with a handful of mills and workshops we visit every season. We make fewer pieces, in small runs, and we fix what we sell.', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"backgroundColor":"surface","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:group {"align":"wide","className":"tyche-section-head","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
<div class="wp-block-group alignwide tyche-section-head"><!-- wp:group {"className":"tyche-section-head__title","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-section-head__title"><!-- wp:paragraph {"className":"is-style-tyche-eyebrow"} -->
<p class="is-style-tyche-eyebrow"><?php esc_html_e( 'Values', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'What we care about', 'tyche' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:columns {"align":"wide","className":"tyche-icon-items","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
<div class="wp-block-columns alignwide tyche-icon-items"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"tyche-usp","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-usp"><!-- wp:icon {"icon":"tyche/leaf","className":"tyche-icon tyche-icon\u002d\u002dlarge"} /-->

<!-- wp:heading {"level":3,"className":"tyche-usp__title","fontSize":"large","fontFamily":"figtree"} -->
<h3 class="wp-block-heading tyche-usp__title has-figtree-font-family has-large-font-size"><?php esc_html_e( 'Better materials', 'tyche' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e( 'Traceable wool, organic cotton and leather from tanneries we have visited.', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"tyche-usp","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-usp"><!-- wp:icon {"icon":"tyche/recycle","className":"tyche-icon tyche-icon\u002d\u002dlarge"} /-->

<!-- wp:heading {"level":3,"className":"tyche-usp__title","fontSize":"large","fontFamily":"figtree"} -->
<h3 class="wp-block-heading tyche-usp__title has-figtree-font-family has-large-font-size"><?php esc_html_e( 'Made to be mended', 'tyche' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e( 'Free repairs in the first year, and spare buttons in every pocket.', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"tyche-usp","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-usp"><!-- wp:icon {"icon":"tyche/heart","className":"tyche-icon tyche-icon\u002d\u002dlarge"} /-->

<!-- wp:heading {"level":3,"className":"tyche-usp__title","fontSize":"large","fontFamily":"figtree"} -->
<h3 class="wp-block-heading tyche-usp__title has-figtree-font-family has-large-font-size"><?php esc_html_e( 'Fair from start to finish', 'tyche' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e( 'We pay the workshops we use a fair price and publish who they are.', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:columns {"align":"wide","className":"tyche-about-gallery","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|30"}}}} -->
<div class="wp-block-columns alignwide tyche-about-gallery"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"aspectRatio":"3/4","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/about-2.webp' ) ); ?>" alt="<?php esc_attr_e( 'Hands holding a coffee cup against a grey wool coat and rust scarf', 'tyche' ); ?>" style="aspect-ratio:3/4;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"aspectRatio":"3/4","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/about-3.webp' ) ); ?>" alt="<?php esc_attr_e( 'Grey, navy and charcoal knitted fabrics side by side', 'tyche' ); ?>" style="aspect-ratio:3/4;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"aspectRatio":"3/4","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/about-4.webp' ) ); ?>" alt="<?php esc_attr_e( 'A woman walking through a field wrapped in a pale blue blanket scarf', 'tyche' ); ?>" style="aspect-ratio:3/4;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section tyche-cta-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section tyche-cta-section" style="padding-top:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","className":"tyche-cta","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|0","left":"var:preset|spacing|0"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center tyche-cta"><!-- wp:column {"width":"45%","className":"tyche-cta__media-column"} -->
<div class="wp-block-column tyche-cta__media-column" style="flex-basis:45%"><!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/about-2.webp' ) ); ?>","dimRatio":0,"overlayColor":"dark","isUserOverlayColor":true,"minHeight":460,"minHeightUnit":"px","className":"tyche-cta__media","layout":{"type":"constrained"}} -->
<div class="wp-block-cover tyche-cta__media" style="min-height:460px"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/about-2.webp' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"className":"tyche-cta__content","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group tyche-cta__content"><!-- wp:paragraph {"className":"is-style-tyche-eyebrow"} -->
<p class="is-style-tyche-eyebrow"><?php esc_html_e( 'Members', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"fontSize":"huge"} -->
<h2 class="wp-block-heading has-huge-font-size"><?php esc_html_e( 'Take 10% off your first order', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
<p class="has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'Create a free account and your welcome code is waiting at checkout.', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"is-style-tyche-checks"} -->
<ul class="wp-block-list is-style-tyche-checks"><!-- wp:list-item -->
<li><?php esc_html_e( 'Early access to new collections', 'tyche' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Members-only offers through the year', 'tyche' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Faster checkout and easy returns', 'tyche' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( tyche_store_url( 'myaccount' ) ); ?>"><?php esc_html_e( 'Create an account', 'tyche' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-tyche-outline"} -->
<div class="wp-block-button is-style-tyche-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( tyche_shop_sorted_url( 'date' ) ); ?>"><?php esc_html_e( 'Shop new arrivals', 'tyche' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
