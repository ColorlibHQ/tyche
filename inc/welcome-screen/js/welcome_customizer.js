jQuery(document).ready(function () {
    var tyche_aboutpage = tycheWelcomeScreenCustomizerObject.aboutpage;
    var tyche_nr_actions_required = tycheWelcomeScreenCustomizerObject.nr_actions_required;

    /* Number of required actions */
    if ((typeof tyche_aboutpage !== 'undefined') && (typeof tyche_nr_actions_required !== 'undefined') && (tyche_nr_actions_required != '0')) {
        jQuery('#accordion-section-themes .accordion-section-title').append('<a href="' + tyche_aboutpage + '"><span class="tyche-actions-count">' + tyche_nr_actions_required + '</span></a>');
    }


});
