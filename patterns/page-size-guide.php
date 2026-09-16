<?php
/**
 * Title: Size guide page
 * Slug: tyche/page-size-guide
 * Categories: tyche-pages
 * Keywords: size, fit, measurements
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
<p class="has-text-align-center is-style-tyche-eyebrow"><?php esc_html_e( 'Fit', 'tyche' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"tyche-page-title","style":{"typography":{"textAlign":"center"}}} -->
<h1 class="wp-block-heading has-text-align-center tyche-page-title"><?php esc_html_e( 'Size guide', 'tyche' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"textAlign":"center"}},"textColor":"muted","fontSize":"large"} -->
<p class="has-text-align-center has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'Body measurements in centimetres. Each product page also lists the garment\'s own measurements.', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section" style="padding-top:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained","contentSize":"880px"}} -->
<div class="wp-block-group"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Women', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:table {"className":"is-style-stripes"} -->
<figure class="wp-block-table is-style-stripes"><table class="has-fixed-layout"><thead><tr><th><?php esc_html_e( 'Size', 'tyche' ); ?></th><th><?php esc_html_e( 'UK', 'tyche' ); ?></th><th><?php esc_html_e( 'US', 'tyche' ); ?></th><th><?php esc_html_e( 'Bust (cm)', 'tyche' ); ?></th><th><?php esc_html_e( 'Waist (cm)', 'tyche' ); ?></th><th><?php esc_html_e( 'Hips (cm)', 'tyche' ); ?></th></tr></thead><tbody><tr><td>XS</td><td>6</td><td>2</td><td>80</td><td>62</td><td>88</td></tr><tr><td>S</td><td>8</td><td>4</td><td>84</td><td>66</td><td>92</td></tr><tr><td>M</td><td>10</td><td>6</td><td>88</td><td>70</td><td>96</td></tr><tr><td>L</td><td>12</td><td>8</td><td>93</td><td>75</td><td>101</td></tr><tr><td>XL</td><td>14</td><td>10</td><td>98</td><td>80</td><td>106</td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Men', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:table {"className":"is-style-stripes"} -->
<figure class="wp-block-table is-style-stripes"><table class="has-fixed-layout"><thead><tr><th><?php esc_html_e( 'Size', 'tyche' ); ?></th><th><?php esc_html_e( 'Chest (cm)', 'tyche' ); ?></th><th><?php esc_html_e( 'Waist (cm)', 'tyche' ); ?></th><th><?php esc_html_e( 'Sleeve (cm)', 'tyche' ); ?></th></tr></thead><tbody><tr><td>S</td><td>92</td><td>78</td><td>63</td></tr><tr><td>M</td><td>100</td><td>86</td><td>64</td></tr><tr><td>L</td><td>108</td><td>94</td><td>65</td></tr><tr><td>XL</td><td>116</td><td>102</td><td>66</td></tr></tbody></table></figure>
<!-- /wp:table --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"tyche-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"backgroundColor":"surface","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull tyche-section has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|80","left":"var:preset|spacing|80"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:image {"aspectRatio":"4/5","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/size-1.webp' ) ); ?>" alt="<?php esc_attr_e( 'A woman in a soft grey rollneck sweater', 'tyche' ); ?>" style="aspect-ratio:4/5;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'How to measure', 'tyche' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:list {"className":"is-style-tyche-checks"} -->
<ul class="wp-block-list is-style-tyche-checks"><!-- wp:list-item -->
<li><?php esc_html_e( 'Chest: around the fullest part, under your arms', 'tyche' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Waist: around your natural waistline', 'tyche' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Hips: around the fullest part of your hips', 'tyche' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Sleeve: from the centre back of your neck to your wrist', 'tyche' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e( 'Between two sizes? Our pieces are cut relaxed, so choose the smaller size for a closer fit.', 'tyche' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
