<?php
/**
 * The search form.
 *
 * The theme draws two of these: the one in the top bar, which is a field that sits
 * inline with the other top-bar items, and the ordinary one used on 404 and no-results
 * pages. Both live here rather than being written out in the templates, so a plugin can
 * filter them -- which is what get_search_form() is for, and why the theme guidelines
 * ask for it.
 *
 * Pass the variant through get_search_form():
 *
 *     get_search_form( array( 'tyche_variant' => 'topbar' ) );
 *
 * @package Tyche
 */

$tyche_variant = isset( $args['tyche_variant'] ) ? $args['tyche_variant'] : 'default';
$tyche_id      = wp_unique_id( 'tyche-search-' );

if ( 'topbar' === $tyche_variant ) :
	?>
	<form role="search" method="get" class="pull-right" id="searchform_topbar" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="<?php echo esc_attr( $tyche_id ); ?>">
			<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'tyche' ); ?></span>
		</label>
		<input class="search-field-top-bar" id="<?php echo esc_attr( $tyche_id ); ?>"
			placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'tyche' ); ?>"
			value="<?php echo esc_attr( get_search_query() ); ?>" name="s" type="search">
		<button id="search-top-bar-submit" type="submit" class="search-top-bar-submit">
			<span class="fa-solid fa-magnifying-glass" aria-hidden="true"></span>
			<span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'tyche' ); ?></span>
		</button>
	</form>
	<?php
else :
	?>
	<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="<?php echo esc_attr( $tyche_id ); ?>">
			<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'tyche' ); ?></span>
		</label>
		<input type="search" class="search-field" id="<?php echo esc_attr( $tyche_id ); ?>"
			placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'tyche' ); ?>"
			value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
		<button type="submit" class="search-submit">
			<span class="fa-solid fa-magnifying-glass" aria-hidden="true"></span>
			<span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'tyche' ); ?></span>
		</button>
	</form>
	<?php
endif;
