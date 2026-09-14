/**
 * Customizer preview tidy-up after a widget is refreshed.
 *
 * It used to re-initialise Owl Carousel and rebind the product slider arrows here. The
 * carousels are carousel.js now, which binds its own controls when the preview reloads,
 * so all that is left is re-wrapping the selects the theme styles.
 */
( function ( $ ) {
	if ( 'undefined' === typeof wp || ! wp.customize || ! wp.customize.selectiveRefresh ) {
		return;
	}

	wp.customize.selectiveRefresh.bind( 'widget-updated', function () {
		$( 'select' ).each( function () {
			var $select = $( this );

			if ( 'rating' === $select.attr( 'id' ) ) {
				return;
			}

			if ( $select.parent().hasClass( 'styled-select' ) || $select.parent().hasClass( 'value' ) ) {
				return;
			}

			$select.wrap( '<div class="styled-select"></div>' );
		} );
	} );
}( jQuery ) );
