<?php
/**
 * Title: Order confirmation template body
 * Slug: tyche/hidden-order-confirmation
 * Viewport Width: 1400
 * Inserter: no
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"main","className":"tyche-main tyche-order-confirmation","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|80"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<main class="wp-block-group tyche-main tyche-order-confirmation" style="margin-top:0;padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:woocommerce/order-confirmation-status {"className":"tyche-order-status","fontSize":"x-large"} /-->

<!-- wp:woocommerce/order-confirmation-summary /-->

<!-- wp:woocommerce/order-confirmation-totals-wrapper {"align":"wide"} -->
<!-- wp:pattern {"slug":"woocommerce/order-confirmation-totals-heading"} /-->

<!-- wp:woocommerce/order-confirmation-totals {"lock":{"remove":true}} /-->
<!-- /wp:woocommerce/order-confirmation-totals-wrapper -->

<!-- wp:woocommerce/order-confirmation-downloads-wrapper {"align":"wide"} -->
<!-- wp:pattern {"slug":"woocommerce/order-confirmation-downloads-heading"} /-->

<!-- wp:woocommerce/order-confirmation-downloads {"lock":{"remove":true}} /-->
<!-- /wp:woocommerce/order-confirmation-downloads-wrapper -->

<!-- wp:columns {"align":"wide","className":"wc-block-order-confirmation-address-wrapper","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
<div class="wp-block-columns alignwide wc-block-order-confirmation-address-wrapper"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:woocommerce/order-confirmation-shipping-wrapper {"align":"wide"} -->
<!-- wp:pattern {"slug":"woocommerce/order-confirmation-shipping-heading"} /-->

<!-- wp:woocommerce/order-confirmation-shipping-address {"lock":{"remove":true}} /-->
<!-- /wp:woocommerce/order-confirmation-shipping-wrapper --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:woocommerce/order-confirmation-billing-wrapper {"align":"wide"} -->
<!-- wp:pattern {"slug":"woocommerce/order-confirmation-billing-heading"} /-->

<!-- wp:woocommerce/order-confirmation-billing-address {"lock":{"remove":true}} /-->
<!-- /wp:woocommerce/order-confirmation-billing-wrapper --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:woocommerce/order-confirmation-additional-fields-wrapper {"align":"wide"} -->
<!-- wp:pattern {"slug":"woocommerce/order-confirmation-additional-fields-heading"} /-->

<!-- wp:woocommerce/order-confirmation-additional-fields /-->
<!-- /wp:woocommerce/order-confirmation-additional-fields-wrapper -->

<!-- wp:woocommerce/order-confirmation-additional-information /--></main>
<!-- /wp:group -->
