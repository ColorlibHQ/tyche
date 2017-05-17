jQuery(document).ready(function () {

    /* If there are required actions, add an icon with the number of required actions in the About tyche page -> Actions required tab */
    var tyche_nr_actions_required = tycheWelcomeScreenObject.nr_actions_required;

    if ((typeof tyche_nr_actions_required !== 'undefined') && (tyche_nr_actions_required != '0')) {
        jQuery('li.tyche-w-red-tab a').append('<span class="tyche-actions-count">' + tyche_nr_actions_required + '</span>');
    }

    /* Dismiss required actions */
    jQuery(".tyche-dismiss-required-action").click(function () {

        var id = jQuery(this).attr('id');
        console.log(id);
        jQuery.ajax({
            type: "GET",
            data: {action: 'tyche_dismiss_required_action', dismiss_id: id},
            dataType: "html",
            url: tycheWelcomeScreenObject.ajaxurl,
            beforeSend: function (data, settings) {
                jQuery('.tyche-tab-pane#actions_required h1').append('<div id="temp_load" style="text-align:center"><img src=' + tycheWelcomeScreenObject.template_directory + '"/inc/welcome-screenjax-loader.gif" /></div>');
            },
            success: function (data) {
                jQuery("#temp_load").remove();
                /* Remove loading gif */
                jQuery('#' + data).parent().remove();
                /* Remove required action box */

                var tyche_actions_count = jQuery('.tyche-actions-count').text();
                /* Decrease or remove the counter for required actions */
                if (typeof tyche_actions_count !== 'undefined') {
                    if (tyche_actions_count == '1') {
                        jQuery('.tyche-actions-count').remove();
                        jQuery('.tyche-tab-pane#actions_required').append('<p>' + tycheWelcomeScreenObject.no_required_actions_text + '</p>');
                    }
                    else {
                        jQuery('.tyche-actions-count').text(parseInt(tyche_actions_count) - 1);
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    /* Tabs in welcome page */
    function tyche_welcome_page_tabs(event) {
        jQuery(event).parent().addClass("active");
        jQuery(event).parent().siblings().removeClass("active");
        var tab = jQuery(event).attr("href");
        jQuery(".tyche-tab-pane").not(tab).css("display", "none");
        jQuery(tab).fadeIn();
    }

    var tyche_actions_anchor = location.hash;

    if ((typeof tyche_actions_anchor !== 'undefined') && (tyche_actions_anchor != '')) {
        tyche_welcome_page_tabs('a[href="' + tyche_actions_anchor + '"]');
    }

    jQuery(".tyche-nav-tabs a").click(function (event) {
        event.preventDefault();
        tyche_welcome_page_tabs(this);
    });

    /* Tab Content height matches admin menu height for scrolling purpouses */
    $tab = jQuery('.tyche-tab-content > div');
    $admin_menu_height = jQuery('#adminmenu').height();
    if ((typeof $tab !== 'undefined') && (typeof $admin_menu_height !== 'undefined')) {
        $newheight = $admin_menu_height - 180;
        $tab.css('min-height', $newheight);
    }

});
