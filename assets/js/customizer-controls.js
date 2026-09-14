/**
 * Behaviour for the theme's custom customizer controls.
 *
 * jQuery UI sortable and wp.media are both bundled with WordPress; nothing here is a
 * third-party dependency.
 */
( function ( $, wp ) {
	'use strict';

	/* ---------------- sortable: order + on/off ---------------- */

	function readSortable( $control ) {
		var values = [];
		$control.find( '.tyche-sortable__item' ).each( function () {
			if ( $( this ).find( 'input[type="checkbox"]' ).prop( 'checked' ) ) {
				values.push( $( this ).data( 'value' ) );
			}
		} );
		return values.join( ',' );
	}

	function syncSortable( $control ) {
		var $input = $control.find( '.tyche-sortable__value' );
		$input.val( readSortable( $control ) ).trigger( 'change' );
	}

	function initSortable( context ) {
		$( '.tyche-sortable', context ).each( function () {
			var $list = $( this );
			var $control = $list.closest( '.customize-control' );

			if ( $list.data( 'tyche-ready' ) ) {
				return;
			}
			$list.data( 'tyche-ready', true );

			$list.sortable( {
				handle: '.tyche-sortable__handle',
				update: function () {
					syncSortable( $control );
				}
			} );

			$list.on( 'change', 'input[type="checkbox"]', function () {
				$( this ).closest( '.tyche-sortable__item' ).toggleClass( 'is-off', ! this.checked );
				syncSortable( $control );
			} );
		} );
	}

	/* ---------------- repeater: slider rows ---------------- */

	function initRepeater( context ) {
		$( '.tyche-repeater', context ).each( function () {
			var $repeater = $( this );

			if ( $repeater.data( 'tyche-ready' ) ) {
				return;
			}
			$repeater.data( 'tyche-ready', true );

			var $value = $repeater.find( '.tyche-repeater__value' );
			var $rows = $repeater.find( '.tyche-repeater__rows' );
			var template = $repeater.find( '.tyche-repeater__template' ).html();

			function serialise() {
				var rows = [];
				$rows.find( '.tyche-repeater__row' ).each( function () {
					var $row = $( this );
					rows.push( {
						image: $row.find( '.tyche-repeater__preview' ).attr( 'src' ) || '',
						title: $row.find( '[data-field="title"]' ).val() || '',
						subtitle: $row.find( '[data-field="subtitle"]' ).val() || '',
						link: $row.find( '[data-field="link"]' ).val() || ''
					} );
				} );
				$value.val( JSON.stringify( rows ) ).trigger( 'change' );
			}

			function addRow( data ) {
				var $row = $( template );
				data = data || {};
				$row.find( '[data-field="title"]' ).val( data.title || '' );
				$row.find( '[data-field="subtitle"]' ).val( data.subtitle || '' );
				$row.find( '[data-field="link"]' ).val( data.link || '' );
				if ( data.image ) {
					$row.find( '.tyche-repeater__preview' ).attr( 'src', data.image ).prop( 'hidden', false );
				}
				$rows.append( $row );
			}

			var existing;
			try {
				existing = JSON.parse( $value.val() || '[]' );
			} catch ( e ) {
				existing = [];
			}
			$.each( existing, function ( i, row ) {
				addRow( row );
			} );

			$repeater.on( 'click', '.tyche-repeater__add', function () {
				addRow( {} );
				serialise();
			} );

			$repeater.on( 'click', '.tyche-repeater__remove', function () {
				$( this ).closest( '.tyche-repeater__row' ).remove();
				serialise();
			} );

			$repeater.on( 'input change', 'input[data-field]', serialise );

			$repeater.on( 'click', '.tyche-repeater__pick', function () {
				var $row = $( this ).closest( '.tyche-repeater__row' );
				var frame = wp.media( { title: 'Slide image', multiple: false, library: { type: 'image' } } );

				frame.on( 'select', function () {
					var attachment = frame.state().get( 'selection' ).first().toJSON();
					$row.find( '.tyche-repeater__preview' ).attr( 'src', attachment.url ).prop( 'hidden', false );
					serialise();
				} );

				frame.open();
			} );
		} );
	}

	/* ---------------- code editor ---------------- */

	function initCode( context ) {
		if ( ! wp.codeEditor || ! wp.codeEditor.initialize ) {
			return;
		}
		$( '.tyche-code-editor', context ).each( function () {
			if ( $( this ).data( 'tyche-ready' ) ) {
				return;
			}
			$( this ).data( 'tyche-ready', true );

			var textarea = this;
			var editor = wp.codeEditor.initialize( textarea );

			// Keep the textarea, which is what the Customizer is bound to, in step.
			if ( editor && editor.codemirror ) {
				editor.codemirror.on( 'change', function ( cm ) {
					textarea.value = cm.getValue();
					$( textarea ).trigger( 'change' );
				} );
			}
		} );
	}

	/* ---------------- dashicons: reflect selection ---------------- */

	function initDashicons( context ) {
		$( '.tyche-dashicons', context ).on( 'change', 'input[type="radio"]', function () {
			$( this ).closest( '.tyche-dashicons' )
				.find( '.tyche-dashicons__option' ).removeClass( 'is-selected' );
			$( this ).closest( '.tyche-dashicons__option' ).addClass( 'is-selected' );
		} );
	}

	function initAll( context ) {
		initSortable( context );
		initRepeater( context );
		initCode( context );
		initDashicons( context );
	}

	$( function () {
		initAll( document );
	} );

	// Controls inside a section are rendered when the section is first opened.
	if ( wp.customize ) {
		wp.customize.bind( 'ready', function () {
			wp.customize.control.each( function ( control ) {
				control.deferred.embedded.done( function () {
					initAll( control.container );
				} );
			} );
		} );
	}
}( jQuery, window.wp ) );
