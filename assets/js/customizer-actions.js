/**
 * Dismissing a setup action in the Customizer.
 *
 * wp.apiFetch is core, and it attaches the wp_rest nonce itself, so there is no nonce
 * handling to get wrong here.
 */
( function ( wp ) {
	'use strict';

	if ( ! wp || ! wp.customize || ! wp.apiFetch ) {
		return;
	}

	/*
	 * A section with no controls in it is not "contextually active", and the Customizer
	 * hides it. This one is all content and no controls, so it says so for itself --
	 * the same thing core's own themes section does.
	 */
	wp.customize.sectionConstructor['tyche-actions'] = wp.customize.Section.extend( {
		attachEvents: function () {},
		isContextuallyActive: function () {
			return true;
		}
	} );

	wp.customize.bind( 'ready', function () {
		var section = document.getElementById( 'accordion-section-tyche_recommended_actions' );

		if ( ! section ) {
			return;
		}

		var empty = section.querySelector( '.tyche-actions__empty' );

		function refreshEmptyState() {
			if ( ! empty ) {
				return;
			}
			empty.hidden = section.querySelectorAll( '.tyche-action' ).length > 0;
		}

		section.addEventListener( 'click', function ( event ) {
			var button = event.target.closest( '.tyche-action__dismiss' );

			if ( ! button ) {
				return;
			}

			var item = button.closest( '.tyche-action' );
			var id = item && item.getAttribute( 'data-action-id' );

			if ( ! id ) {
				return;
			}

			button.disabled = true;

			wp.apiFetch( {
				path: 'tyche/v1/dismiss-action',
				method: 'POST',
				data: { id: id }
			} ).then( function () {
				item.parentNode.removeChild( item );
				refreshEmptyState();
			} ).catch( function () {
				// Leave the row in place so the state on screen still matches the server.
				button.disabled = false;
			} );
		} );

		refreshEmptyState();
	} );
}( window.wp ) );
