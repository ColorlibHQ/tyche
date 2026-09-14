<?php
/**
 * Title: Feature strip
 * Slug: tyche/feature-strip
 * Categories: tyche, featured, banner
 * Description: Three shop promises on a coloured band, the way the front page shows them.
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"backgroundColor":"primary","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-primary-background-color has-background" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)">
	<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":3,"style":{"typography":{"textTransform":"uppercase","fontSize":"15px"}},"textColor":"background"} -->
			<h3 class="wp-block-heading has-background-color has-text-color" style="font-size:15px;text-transform:uppercase"><?php echo esc_html_x( 'Free shipping', 'Pattern heading', 'tyche' ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"13px"}},"textColor":"background"} -->
			<p class="has-background-color has-text-color" style="font-size:13px"><?php echo esc_html_x( 'On every order over 90.00', 'Pattern text', 'tyche' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":3,"style":{"typography":{"textTransform":"uppercase","fontSize":"15px"}},"textColor":"background"} -->
			<h3 class="wp-block-heading has-background-color has-text-color" style="font-size:15px;text-transform:uppercase"><?php echo esc_html_x( 'Call us anytime', 'Pattern heading', 'tyche' ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"13px"}},"textColor":"background"} -->
			<p class="has-background-color has-text-color" style="font-size:13px"><?php echo esc_html_x( 'Weekdays, nine to six', 'Pattern text', 'tyche' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":3,"style":{"typography":{"textTransform":"uppercase","fontSize":"15px"}},"textColor":"background"} -->
			<h3 class="wp-block-heading has-background-color has-text-color" style="font-size:15px;text-transform:uppercase"><?php echo esc_html_x( 'Thirty day returns', 'Pattern heading', 'tyche' ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"13px"}},"textColor":"background"} -->
			<p class="has-background-color has-text-color" style="font-size:13px"><?php echo esc_html_x( 'No questions, no restocking fee', 'Pattern text', 'tyche' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
