<?php
/**
 * Which template the front page uses.
 *
 * templates/front-page.html is the designed store homepage. WordPress would use
 * it for the front page no matter what Settings > Reading says, so a store that
 * chose one of its own pages as the front page would lose that page's content
 * to Tyche's sample homepage -- and every site updating from Tyche 1.x, where a
 * static front page was the recommended set-up, would wake up to it.
 *
 * So the designed homepage only takes the front page while the site shows its
 * latest posts there. Once a page is chosen, that page renders with the page
 * template, as it would under any theme. The same homepage is offered as the
 * "Store homepage" pattern when a new page is created.
 *
 * @package Tyche
 */

defined( 'ABSPATH' ) || exit;

/**
 * Drop front-page from the hierarchy when a static front page is set.
 *
 * @param string[] $templates Template candidates, most specific first.
 * @return string[]
 */
function tyche_front_page_template_hierarchy( $templates ) {
	if ( 'page' === get_option( 'show_on_front' ) && (int) get_option( 'page_on_front' ) > 0 ) {
		return array();
	}

	return $templates;
}
add_filter( 'frontpage_template_hierarchy', 'tyche_front_page_template_hierarchy' );
