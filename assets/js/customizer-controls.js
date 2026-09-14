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

	/* ---------------- repeater: rows built from declared fields ---------------- */

	function initRepeater( context ) {
		$( '.tyche-repeater', context ).each( function () {
			var $repeater = $( this );

			if ( $repeater.data( 'tyche-ready' ) ) {
				return;
			}
			$repeater.data( 'tyche-ready', true );

			var $value = $repeater.find( '.tyche-repeater__value' );
			var $rows = $repeater.find( '.tyche-repeater__rows' );
			var fields = $repeater.data( 'fields' ) || {};
			var chooseLabel = $repeater.attr( 'data-choose' ) || 'Choose image';
			var removeLabel = $repeater.attr( 'data-remove' ) || 'Remove row';

			function serialise() {
				var rows = [];
				$rows.find( '.tyche-repeater__row' ).each( function () {
					var $row = $( this ), row = {};
					$row.find( '[data-field]' ).each( function () {
						row[ $( this ).data( 'field' ) ] = $( this ).val();
					} );
					rows.push( row );
				} );
				$value.val( JSON.stringify( rows ) ).trigger( 'change' );
			}

			function addRow( data ) {
				data = data || {};
				var $row = $( '<div class="tyche-repeater__row"></div>' );

				$.each( fields, function ( name, field ) {
					var label = ( field && field.label ) || name;
					var value = typeof data[ name ] !== 'undefined' ? data[ name ] : '';

					if ( field && field.type === 'image' ) {
						var $wrap = $( '<div class="tyche-repeater__media"></div>' );
						var $img = $( '<img class="tyche-repeater__preview" alt="" />' ).prop( 'hidden', true );
						var $hidden = $( '<input type="hidden" />' ).attr( 'data-field', name ).val( value );
						var $pick = $( '<button type="button" class="button tyche-repeater__pick"></button>' ).text( chooseLabel );
						if ( value ) {
							wp.media.attachment( value ).fetch().then( function () {
								var url = wp.media.attachment( value ).get( 'url' );
								if ( url ) { $img.attr( 'src', url ).prop( 'hidden', false ); }
							} );
						}
						$wrap.append( $( '<span class="tyche-repeater__label"></span>' ).text( label ), $img, $pick, $hidden );
						$row.append( $wrap );
					} else {
						var $label = $( '<label></label>' ).text( label );
						var $input = $( '<input type="text" class="widefat" />' ).attr( 'data-field', name ).val( value );
						$row.append( $label.append( $input ) );
					}
				} );

				$row.append( $( '<button type="button" class="button-link tyche-repeater__remove"></button>' ).text( removeLabel ) );
				$rows.append( $row );
			}

			var existing = $repeater.data( 'rows' );
			if ( typeof existing === 'string' ) {
				try { existing = JSON.parse( existing ); } catch ( e ) { existing = []; }
			}
			$.each( existing || [], function ( i, row ) { addRow( row ); } );

			$repeater.on( 'click', '.tyche-repeater__add', function () {
				addRow( {} );
				serialise();
			} );

			$repeater.on( 'click', '.tyche-repeater__remove', function () {
				$( this ).closest( '.tyche-repeater__row' ).remove();
				serialise();
			} );

			$repeater.on( 'input change', '[data-field]', serialise );

			$repeater.on( 'click', '.tyche-repeater__pick', function () {
				var $media = $( this ).closest( '.tyche-repeater__media' );
				var frame = wp.media( { title: chooseLabel, multiple: false, library: { type: 'image' } } );

				frame.on( 'select', function () {
					var attachment = frame.state().get( 'selection' ).first().toJSON();
					// Store the id: wp_get_attachment_image() takes an id, not a URL.
					$media.find( 'input[data-field]' ).val( attachment.id );
					$media.find( '.tyche-repeater__preview' ).attr( 'src', attachment.url ).prop( 'hidden', false );
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
