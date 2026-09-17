<?php
/**
 * Rebuild the preview's Home page from the current patterns.
 *
 * The page stores its sections as blocks, expanded from the patterns when the
 * store was seeded, so a pattern change never reaches it on its own. Run after
 * deploying a theme change to a homepage section:
 *
 *   wp eval-file refresh-home.php --url=https://colorlibhub.com/tyche-2/
 */

defined( 'ABSPATH' ) || exit;

function tyche_refresh_expand( $content, $depth = 0 ) {
	if ( $depth > 5 ) {
		return $content;
	}
	$registry = WP_Block_Patterns_Registry::get_instance();
	$out      = '';
	foreach ( parse_blocks( $content ) as $block ) {
		if ( 'core/pattern' === $block['blockName'] && ! empty( $block['attrs']['slug'] ) ) {
			$pattern = $registry->get_registered( $block['attrs']['slug'] );
			$out    .= $pattern ? tyche_refresh_expand( $pattern['content'], $depth + 1 ) . "\n\n" : '';
			continue;
		}
		$out .= serialize_block( $block );
	}
	return $out;
}

$home = (int) get_option( 'page_on_front' );
if ( ! $home ) {
	WP_CLI::error( 'No static front page is set.' );
}

$pattern = WP_Block_Patterns_Registry::get_instance()->get_registered( 'tyche/page-home' );
wp_update_post(
	array(
		'ID'           => $home,
		// wp_update_post() unslashes; without wp_slash() block attributes break.
		'post_content' => wp_slash( tyche_refresh_expand( $pattern['content'] ) ),
	)
);
WP_CLI::success( "Home page $home rebuilt from tyche/page-home." );
