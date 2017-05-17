var Tyche = {
	initMainSlider   : function () {
		jQuery('#main-slider').owlCarousel({
			loop           : true,
			nav            : true,
			items          : 1,
			dots           : false,
			mouseDrag      : true,
			navText        : [
				"<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>" ],
			navClass       : [ "main-slider-previous", "main-slider-next" ],
			autoplay       : true,
			autoplayTimeout: 17000,
			responsive     : {
				1  : {
					nav: false
				},
				600: {
					nav: false
				},
				991: {
					nav: true,

				}
			}
		});
	},
	initProductSlider: function () {
		var elements = jQuery('.tyche-product-slider');
		elements.each(function () {
			var selector = jQuery(this);
			jQuery(this).owlCarousel({
				loop      : false,
				margin    : 30,
				responsive: {
					1  : {
						items: 1
					},
					600: {
						items: 2
					},
					991: {
						items: parseInt(jQuery(this).attr('data-attr-elements'))
					}
				}
			});

			jQuery(".tyche-product-slider-navigation .prev").on('click', function (event) {
				event.preventDefault();
				selector.trigger('prev.owl.carousel');
			});
			jQuery(".tyche-product-slider-navigation .next").on('click', function (event) {
				event.preventDefault();
				selector.trigger('next.owl.carousel');
			});
		});

	},
	initMultiLang    : function () {
		var $selector = jQuery('#tyche_multilang_flag-chooser');
		if ( !$selector.length ) {
			return false;
		}
		var $active = $selector.find('.active'),
				$class = $active.attr('class'),
				$wrapper = jQuery('.top-multilang');
		/* Remove active class */
		$class = $class.replace(' active', '');
		/* Remove lang prefix class */
		$class = $class.replace('lang-', '');

		switch ( $class ) {
			case 'en':
				$class = 'uk';
				break;
		}

		var $image = tyche_variables.flags + $class + '.png';
		$wrapper.prepend('<img src="' + $image + '" alt="country flag" />');
	}

};

jQuery(document).ready(function ($) {
	Tyche.initMainSlider();
	Tyche.initMultiLang();
	Tyche.initProductSlider();

});

jQuery(window).load(function () {

});