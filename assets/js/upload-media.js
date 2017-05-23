jQuery(document).ready(function ($) {
	$(document).on("click", ".upload_image_button", function () {

		jQuery.data(document.body, 'prevElement', $(this).prev());

		window.send_to_editor = function (html) {
			var imgurl = jQuery(html).attr('src');
			var inputText = jQuery.data(document.body, 'prevElement');

			if ( inputText != undefined && inputText != '' ) {
				inputText.val(imgurl);
			}

			tb_remove();
		};

		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		return false;
	});

	$(document).on('click', '.widget-layouts > a', function (e) {
		var layout = $(this).data('layout'),
				select = $(this).parent().siblings('.layout-select'),
				options = select.find('option'),
				siblings = $(this).siblings('a');

		$.each(siblings, function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
		});

		$(this).addClass('selected');

		$.each(options, function () {
			if ( $(this)[ 0 ].hasAttribute('selected') ) {
				$(this).removeAttr('selected');
			}
		});

		select.val(layout);
		select.trigger('change');

	});
});