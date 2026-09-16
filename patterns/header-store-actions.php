<?php
/**
 * Title: Header store icons
 * Slug: tyche/header-store-actions
 * Viewport Width: 1400
 * Inserter: no
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;
?>
<?php if ( tyche_has_woocommerce() ) : ?>
<!-- wp:woocommerce/customer-account {"displayStyle":"icon_only","iconStyle":"line","iconClass":"wc-block-customer-account__account-icon","className":"tyche-header__account"} /-->
<!-- wp:woocommerce/mini-cart {"miniCartIcon":"bag","addToCartBehaviour":"open_drawer","hasHiddenPrice":true,"className":"tyche-header__cart"} /-->
<?php endif; ?>
