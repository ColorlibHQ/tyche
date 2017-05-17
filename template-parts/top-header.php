<?php
/**
 * Template part for displaying top header part
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tyche
 */
?>

<!-- Top Header Bar -->
<header class="top-header-bar-container">
    <ul class="top-header-bar container">
        <!-- Email -->
        <li class="top-email">
            <i class="fa fa-envelope-o"></i> <?php echo esc_html( get_theme_mod( 'tyche_top_bar_email', 'tyche@gmail.com' ) ) ?>
        </li>
        <!-- / Email -->
		<?php if ( class_exists( 'WooCommerce' ) ): ?>
            <!-- Cart -->
            <li class="top-cart">
                <a href="<?php echo esc_url( tyche_get_woocommerge_page( 'cart' ) ) ?>"><i
                            class="fa fa-shopping-cart"></i> <?php echo esc_html__( 'My Cart', 'tyche' ) ?>
                    - <?php echo esc_html( get_woocommerce_currency_symbol( get_woocommerce_currency() ) . ' ' . tyche_get_cart_total() ) ?>
                </a>
            </li>
            <!-- / Cart -->
		<?php endif; ?>

		<?php if ( class_exists( 'WooCommerce' ) ): ?>
            <!-- Account -->
            <li class="top-account">
                <a href="<?php echo esc_url( tyche_get_woocommerge_page( 'account' ) ) ?>"><i
                            class="fa fa-user"></i> <?php echo esc_html__( 'Account', 'tyche' ) ?></a>
            </li>
            <!-- / Account -->
		<?php endif; ?>

		<?php if ( function_exists( 'qtranxf_generateLanguageSelectCode' ) ): ?>
            <!-- Multi language picker -->
            <li class="top-multilang">
				<?php
				$type = array( 'type' => 'dropdown' );
				qtranxf_generateLanguageSelectCode( $type, 'tyche_multilang_flag' )
				?>
            </li>
            <!-- / Multi language picker -->
		<?php endif; ?>

		<?php
		$enable_search_bar = get_theme_mod( 'tyche_enable_top_bar_search', 'enabled' );
		?>
		<?php if ( $enable_search_bar === 'enabled' ): ?>
            <!-- Top Search -->
            <li class="top-search">
                <!-- Search Form -->
                <form role="search" method="get" class="pull-right" id="searchform_topbar"
                      action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <label>
                        <span class="screen-reader-text"><?php esc_html__( 'Search for:', 'tyche' ) ?></span>
                        <input class="search-field-top-bar" id="search-field-top-bar" placeholder="Search ..."
                               value="" name="s"
                               type="search">
                    </label>
                    <button id="search-top-bar-submit" type="submit" class="search-top-bar-submit"><span
                                class="fa fa-search"></span></button>
                </form>
            </li>
            <!-- / Top Search -->
		<?php endif; ?>
    </ul>
</header>
<!-- /Top Header Bar -->