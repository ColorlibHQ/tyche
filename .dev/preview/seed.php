<?php
/**
 * Tyche 2.0 preview store: settings, products, pages, journal and menu.
 *
 *   wp eval-file seed.php /path/to/assets --url=https://colorlibhub.com/tyche-2/
 *
 * Safe to run again: products, pages and posts are matched by slug and updated,
 * images by a source-file meta key. No globals are relied on -- `wp eval-file`
 * runs this inside a function, where `global` does not see file-level variables.
 */

defined( 'ABSPATH' ) || exit;

require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$assets = isset( $args[0] ) ? rtrim( $args[0], '/' ) . '/' : '';
if ( ! $assets || ! is_dir( $assets ) ) {
	WP_CLI::error( 'Pass the assets directory as the first argument.' );
}

$admins = get_users( array( 'role' => 'administrator', 'number' => 1, 'fields' => 'ids' ) );
wp_set_current_user( $admins ? $admins[0] : 1 );

/* -------------------------------------------------------------------------
 * Helpers
 * ---------------------------------------------------------------------- */

function tyche_demo_image( $assets, $file, $alt ) {
	$existing = get_posts( array( 'post_type' => 'attachment', 'post_status' => 'inherit', 'meta_key' => '_tyche_demo_source', 'meta_value' => $file, 'numberposts' => 1, 'fields' => 'ids' ) );
	if ( $existing ) {
		update_post_meta( $existing[0], '_wp_attachment_image_alt', $alt );
		return $existing[0];
	}
	$tmp = wp_tempnam( $file );
	copy( $assets . $file, $tmp );
	$id = media_handle_sideload( array( 'name' => $file, 'tmp_name' => $tmp ), 0 );
	if ( is_wp_error( $id ) ) {
		WP_CLI::warning( "$file: " . $id->get_error_message() );
		return 0;
	}
	update_post_meta( $id, '_tyche_demo_source', $file );
	update_post_meta( $id, '_wp_attachment_image_alt', $alt );
	return $id;
}

function tyche_demo_term( $name, $slug, $description ) {
	$term = get_term_by( 'slug', $slug, 'product_cat' );
	if ( ! $term ) {
		$made = wp_insert_term( $name, 'product_cat', array( 'slug' => $slug, 'description' => $description ) );
		return is_wp_error( $made ) ? 0 : (int) $made['term_id'];
	}
	wp_update_term( $term->term_id, 'product_cat', array( 'name' => $name, 'description' => $description ) );
	return (int) $term->term_id;
}

function tyche_demo_attribute( $name, $slug, $terms ) {
	$id = wc_attribute_taxonomy_id_by_name( $slug );
	if ( ! $id ) {
		$id = wc_create_attribute( array( 'name' => $name, 'slug' => $slug, 'type' => 'select', 'has_archives' => false ) );
	}
	$taxonomy = wc_attribute_taxonomy_name( $slug );
	if ( ! taxonomy_exists( $taxonomy ) ) {
		register_taxonomy( $taxonomy, array( 'product' ), array( 'hierarchical' => false ) );
	}
	$ids = array();
	foreach ( $terms as $term ) {
		$found = term_exists( $term, $taxonomy );
		if ( ! $found ) {
			$found = wp_insert_term( $term, $taxonomy );
		}
		$ids[] = (int) ( is_array( $found ) ? $found['term_id'] : $found );
	}
	return array( (int) $id, $taxonomy, $ids );
}

function tyche_page_url_id( $slug ) {
	$ids = get_posts( array( 'name' => $slug, 'post_type' => 'page', 'numberposts' => 1, 'fields' => 'ids' ) );
	return $ids ? $ids[0] : 0;
}

function tyche_demo_blocks( $paragraphs ) {
	$out = array();
	foreach ( $paragraphs as $p ) {
		$out[] = "<!-- wp:paragraph -->\n<p>" . $p . "</p>\n<!-- /wp:paragraph -->";
	}
	return implode( "\n\n", $out );
}

/** Expand pattern references into the blocks they contain, so pages are editable. */
function tyche_demo_expand( $content, $depth = 0 ) {
	if ( $depth > 5 ) {
		return $content;
	}
	$registry = WP_Block_Patterns_Registry::get_instance();
	$out      = '';
	foreach ( parse_blocks( $content ) as $block ) {
		if ( 'core/pattern' === $block['blockName'] && ! empty( $block['attrs']['slug'] ) ) {
			$pattern = $registry->get_registered( $block['attrs']['slug'] );
			$out    .= $pattern ? tyche_demo_expand( $pattern['content'], $depth + 1 ) . "\n\n" : '';
			continue;
		}
		$out .= serialize_block( $block );
	}
	return $out;
}

function tyche_demo_page( $slug, $title, $content, $template = 'page-no-title' ) {
	$found = get_posts( array( 'name' => $slug, 'post_type' => 'page', 'post_status' => array( 'publish', 'draft', 'private' ), 'numberposts' => 1 ) );
	$data  = array(
		'post_title'     => $title,
		'post_name'      => $slug,
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'post_content'   => wp_slash( $content ),
		'comment_status' => 'closed',
	);
	if ( $found ) {
		$data['ID'] = $found[0]->ID;
	}
	$id = wp_insert_post( $data );
	if ( $template ) {
		update_post_meta( $id, '_wp_page_template', $template );
	}
	return $id;
}

/* -------------------------------------------------------------------------
 * Site and WooCommerce settings
 * ---------------------------------------------------------------------- */

update_option( 'blogname', 'Tyche' );
update_option( 'blogdescription', 'Considered clothing, made to last' );
update_option( 'blog_public', 0 );
update_option( 'permalink_structure', '/%postname%/' );
update_option( 'default_comment_status', 'closed' );

if ( class_exists( 'WC_Install' ) ) {
	WC_Install::install();
}

$settings = array(
	'woocommerce_currency'                 => 'USD',
	'woocommerce_default_country'          => 'US:NY',
	'woocommerce_store_address'            => '12 Market Street',
	'woocommerce_store_city'               => 'New York',
	'woocommerce_store_postcode'           => '10001',
	'woocommerce_calc_taxes'               => 'no',
	'woocommerce_coming_soon'              => 'no',
	'woocommerce_enable_reviews'           => 'yes',
	'woocommerce_enable_review_rating'     => 'yes',
	'woocommerce_review_rating_verification_label' => 'yes',
	'woocommerce_enable_myaccount_registration' => 'no',
	'woocommerce_enable_guest_checkout'    => 'yes',
	'woocommerce_ship_to_countries'        => 'specific',
	'woocommerce_specific_ship_to_countries' => array( 'US' ),
	'woocommerce_default_customer_address' => 'base',
);
foreach ( $settings as $key => $value ) {
	update_option( $key, $value );
}

// Pay on delivery, so the checkout shows a real payment step. The preview's
// mu-plugin refuses to place the order, so no customer details are stored.
update_option( 'woocommerce_cod_settings', array( 'enabled' => 'yes', 'title' => 'Pay on delivery', 'description' => 'Pay with cash or card when your order arrives.', 'instructions' => '', 'enable_for_methods' => array(), 'enable_for_virtual' => 'yes' ) );

// Shipping: one zone, standard delivery, free over $75 -- the amount the theme's copy promises.
$zone = null;
foreach ( WC_Shipping_Zones::get_zones() as $candidate ) {
	if ( 'United States' === $candidate['zone_name'] ) {
		$zone = new WC_Shipping_Zone( $candidate['id'] );
	}
}
if ( ! $zone ) {
	$zone = new WC_Shipping_Zone();
	$zone->set_zone_name( 'United States' );
	$zone->add_location( 'US', 'country' );
	$zone->save();
	$flat = $zone->add_shipping_method( 'flat_rate' );
	update_option( 'woocommerce_flat_rate_' . $flat . '_settings', array( 'title' => 'Standard delivery', 'tax_status' => 'none', 'cost' => '8' ) );
	$free = $zone->add_shipping_method( 'free_shipping' );
	update_option( 'woocommerce_free_shipping_' . $free . '_settings', array( 'title' => 'Free delivery', 'requires' => 'min_amount', 'min_amount' => '75', 'ignore_discounts' => 'no' ) );
}

/* -------------------------------------------------------------------------
 * Catalogue
 * ---------------------------------------------------------------------- */

$cats = array(
	'coats'       => tyche_demo_term( 'Coats', 'coats', 'Wool, cashmere and faux fur, cut to layer over knitwear.' ),
	'knitwear'    => tyche_demo_term( 'Knitwear', 'knitwear', 'Soft layers for cold mornings, knitted from merino and wool blends.' ),
	'dresses'     => tyche_demo_term( 'Dresses', 'dresses', 'Easy shapes that work from morning to evening.' ),
	'tops'        => tyche_demo_term( 'Shirts and tops', 'tops', 'Crisp poplin, silk and everyday cotton.' ),
	'accessories' => tyche_demo_term( 'Accessories', 'accessories', 'Bags, boots and the finishing touches.' ),
);
$uncategorized = get_term_by( 'slug', 'uncategorized', 'product_cat' );
if ( $uncategorized ) {
	update_option( 'default_product_cat', $cats['accessories'] );
	wp_delete_term( $uncategorized->term_id, 'product_cat' );
}

$care_wool   = 'Dry flat after a cool hand wash, or use a wool cycle at 30 degrees. Fold rather than hang.';
$care_cotton = 'Machine wash at 30 degrees with similar colours. Warm iron.';

// slug => [ name, category, price, sale, photo, alt, short, long, care, featured ]
$products = array(
	'burgundy-wool-coat'    => array( 'Burgundy Wool Coat', 'coats', '289', '229', 'burgundy-wool-coat.jpg', 'A woman in a burgundy wool coat, grey scarf and knitted beanie in the snow', 'A double-faced wool coat in deep burgundy, cut to sit over a chunky knit.', 'Our warmest coat, in a double-faced wool with a brushed finish on both sides, so it needs no lining. A relaxed shoulder leaves room for knitwear, and deep welt pockets sit where your hands fall.', $care_wool, true ),
	'grey-wool-coat'        => array( 'Grey Wool Coat', 'coats', '259', '', 'grey-wool-coat.jpg', 'Hands holding a coffee cup against a grey wool coat and rust scarf', 'A mid-weight wool coat in heathered grey that goes with everything.', 'Woven in a mill that has made coating cloth for three generations, with a soft handle and a subtle fleck. Single-breasted, with horn buttons and a full cupro lining.', $care_wool, false ),
	'faux-fur-gilet'        => array( 'Faux Fur Gilet', 'coats', '149', '', 'faux-fur-gilet.jpg', 'A woman in a camel faux fur gilet over a black top', 'A sleeveless faux fur layer in warm camel, lined in soft jersey.', 'All the warmth of a gilet with none of the bulk under a coat. The pile is dense and soft, the lining is brushed jersey, and it hooks closed at the front.', 'Spot clean only. Brush gently with a soft brush.', false ),
	'chunky-knit-jumper'    => array( 'Chunky Knit Jumper', 'knitwear', '149', '119', 'chunky-knit-jumper.jpg', 'A woman in a cream chunky knit jumper resting on white linen', 'A relaxed, hand-finished jumper in a soft wool blend.', 'Knitted on hand-operated machines and finished by hand, with dropped shoulders, deep ribbed cuffs and a gently cropped body.', $care_wool, true ),
	'cream-cardigan'        => array( 'Cream Cardigan', 'knitwear', '129', '', 'cream-cardigan.jpg', 'A cream cardigan worn open over a black lace top', 'A long, loose cardigan in undyed cream wool.', 'Cut long enough to wrap, with horn buttons and patch pockets. The yarn is undyed, so the cream is the natural colour of the wool.', $care_wool, false ),
	'everyday-grey-sweater' => array( 'Everyday Grey Sweater', 'knitwear', '79', '', 'everyday-grey-sweater.jpg', 'Hands resting on jeans in a grey knit sweater', 'The crew neck we wear more than anything else, in soft grey marl.', 'A fine gauge that layers under a coat and a weight that works on its own. Ribbed hem and cuffs keep their shape wash after wash.', $care_wool, false ),
	'grey-sweater-dress'    => array( 'Grey Sweater Dress', 'dresses', '139', '', 'grey-sweater-dress.jpg', 'A woman in a pale grey knit dress with bell sleeves and over-the-knee boots', 'A soft knit dress with bell sleeves, cut above the knee.', 'Knitted in a light, warm yarn with a subtle rib, so it skims rather than clings. The bell sleeves are wide enough to push up.', $care_wool, false ),
	'mustard-knit-dress'    => array( 'Mustard Knit Dress', 'dresses', '119', '95', 'mustard-knit-dress.jpg', 'A woman in a mustard knit dress and tweed coat on a stairway', 'A ribbed midi dress in warm mustard, with a tie waist.', 'Knitted in a fine rib that holds its shape, with a detachable tie at the waist and a length that works with boots.', $care_wool, true ),
	'pink-silk-blouse'      => array( 'Pink Silk Blouse', 'tops', '110', '', 'pink-silk-blouse.jpg', 'A woman in a pale pink blouse reading with a mug of tea', 'A washed silk blouse in pale pink, with a relaxed fit.', 'Sand-washed silk with a soft, matte finish. A camp collar, a chest pocket and a curved hem that looks right tucked or loose.', 'Hand wash cold or dry clean. Cool iron on the reverse.', false ),
	'leopard-print-tee'     => array( 'Leopard Print Tee', 'tops', '45', '35', 'leopard-print-tee.jpg', 'A leopard print tee tucked into black high-waisted trousers', 'A cotton tee in a small leopard print.', 'Heavyweight organic cotton jersey, garment dyed and printed, with a slightly boxy fit.', $care_cotton, false ),
	'black-poplin-shirt'    => array( 'Black Poplin Shirt', 'tops', '85', '', 'black-poplin-shirt.jpg', 'A woman in a black shirt holding a white cup', 'A crisp cotton poplin shirt in black.', 'Tightly woven poplin with a clean collar, mother-of-pearl buttons and a back yoke with a small pleat for movement.', $care_cotton, false ),
	'white-poplin-shirt'    => array( 'White Poplin Shirt', 'tops', '85', '', 'white-poplin-shirt.jpg', 'A woman in a white shirt holding a white cup', 'The white shirt, in crisp organic cotton poplin.', 'Tightly woven poplin with a clean collar, mother-of-pearl buttons and a back yoke with a small pleat for movement.', $care_cotton, false ),
	'floral-chain-bag'      => array( 'Floral Chain Bag', 'accessories', '120', '89', 'floral-chain-bag.jpg', 'A black floral bag with a gold chain strap beside sunglasses', 'A structured shoulder bag in a dark floral print.', 'Printed canvas with leather trim, a chain strap that doubles for a short handle, and a magnetic clasp. Fits a phone, keys and a small wallet.', 'Wipe with a dry cloth.', true ),
	'patent-clutch'         => array( 'Patent Clutch', 'accessories', '65', '', 'patent-clutch.jpg', 'A black patent clutch held against blue jeans', 'A slim black patent clutch for evenings out.', 'Glossy patent leather with a zip top and a suede-lined interior.', 'Wipe with a soft dry cloth.', false ),
	'leather-messenger-bag' => array( 'Leather Messenger Bag', 'accessories', '189', '', 'leather-messenger-bag.jpg', 'A brown leather messenger bag resting on a stone wall', 'A vegetable-tanned leather bag that ages beautifully.', 'Thick, vegetable-tanned leather with brass buckles, two front pockets and a padded sleeve that fits a 13-inch laptop.', 'Condition the leather twice a year.', false ),
	'quilted-ankle-boots'   => array( 'Quilted Ankle Boots', 'accessories', '159', '', 'quilted-ankle-boots.jpg', 'Black quilted ankle boots on a wet pavement', 'Black leather ankle boots with a quilted panel and a stacked heel.', 'Soft leather uppers, a quilted side panel, an inside zip and a rubber sole with grip for wet pavements.', 'Wipe clean and use a leather protector.', false ),
	'strappy-heeled-boots'  => array( 'Strappy Heeled Boots', 'accessories', '175', '', 'strappy-heeled-boots.jpg', 'Black strappy heeled ankle boots on a white floor', 'Cut-out heeled boots in black suede.', 'Soft suede with strap cut-outs, a slim heel and a cushioned insole.', 'Brush with a suede brush.', false ),
	'round-frame-glasses'   => array( 'Round Frame Glasses', 'accessories', '69', '', 'round-frame-glasses.jpg', 'Round wire-frame glasses resting on a soft blush blanket', 'Round wire frames with clear lenses.', 'Lightweight metal frames with adjustable nose pads and spring hinges. Supplied with a linen case.', 'Clean with the cloth supplied.', false ),
);

$product_ids = array();
foreach ( $products as $slug => $p ) {
	list( $name, $cat, $price, $sale, $photo, $alt, $short, $long, $care, $featured ) = $p;
	$found   = get_page_by_path( $slug, OBJECT, 'product' );
	$product = $found ? wc_get_product( $found->ID ) : new WC_Product_Simple();
	$product->set_name( $name );
	$product->set_slug( $slug );
	$product->set_status( 'publish' );
	$product->set_regular_price( $price );
	$product->set_sale_price( $sale );
	$product->set_short_description( $short );
	$product->set_description( tyche_demo_blocks( array( $long, '<strong>Care.</strong> ' . $care ) ) );
	$product->set_category_ids( array( $cats[ $cat ] ) );
	$product->set_featured( $featured );
	$product->set_sku( strtoupper( 'TY-' . substr( md5( $slug ), 0, 6 ) ) );
	$product->set_stock_status( 'patent-clutch' === $slug ? 'outofstock' : 'instock' );
	$product->set_image_id( tyche_demo_image( $assets, $photo, $alt ) );
	$product->set_reviews_allowed( false );
	$product_ids[ $slug ] = $product->save();
}

// The variable product: sizes and colours, a gallery, one size sold out.
list( $size_id, $size_tax, $size_terms ) = tyche_demo_attribute( 'Size', 'size', array( 'XS', 'S', 'M', 'L', 'XL' ) );
list( $colour_id, $colour_tax, $colour_terms ) = tyche_demo_attribute( 'Colour', 'colour', array( 'Grey marl', 'Oatmeal' ) );

$found    = get_page_by_path( 'merino-rollneck', OBJECT, 'product' );
$rollneck = $found ? wc_get_product( $found->ID ) : new WC_Product_Variable();
$rollneck->set_name( 'Merino Rollneck' );
$rollneck->set_slug( 'merino-rollneck' );
$rollneck->set_status( 'publish' );
$rollneck->set_short_description( 'Fine-gauge merino with a soft rolled neck. Light enough to layer, warm enough on its own.' );
$rollneck->set_description( tyche_demo_blocks( array( 'Knitted from extra-fine merino in a relaxed fit, with a rolled neck that folds down or wears up. The model is 178cm and wears a size M.', '<strong>Care.</strong> ' . $care_wool ) ) );
$rollneck->set_category_ids( array( $cats['knitwear'] ) );
$rollneck->set_featured( true );
$rollneck->set_sku( 'TY-ROLL01' );
$rollneck->set_image_id( tyche_demo_image( $assets, 'merino-rollneck.jpg', 'A woman pulling up the neck of a soft grey merino rollneck' ) );
$rollneck->set_gallery_image_ids( array(
	tyche_demo_image( $assets, 'merino-rollneck-detail.jpg', 'Close-up of the rolled neck and fine knit' ),
	tyche_demo_image( $assets, 'everyday-grey-sweater.jpg', 'Hands resting on jeans in a grey knit sweater' ),
) );
$attrs = array();
foreach ( array( array( $size_id, $size_tax, $size_terms ), array( $colour_id, $colour_tax, $colour_terms ) ) as $i => $a ) {
	$attr = new WC_Product_Attribute();
	$attr->set_id( $a[0] );
	$attr->set_name( $a[1] );
	$attr->set_options( $a[2] );
	$attr->set_position( $i );
	$attr->set_visible( true );
	$attr->set_variation( true );
	$attrs[] = $attr;
}
$rollneck->set_attributes( $attrs );
$rollneck->set_reviews_allowed( false );
$rollneck_id = $rollneck->save();
if ( ! $rollneck->get_children() ) {
	foreach ( array( 'xs', 's', 'm', 'l', 'xl' ) as $size ) {
		foreach ( array( 'grey-marl', 'oatmeal' ) as $colour ) {
			$v = new WC_Product_Variation();
			$v->set_parent_id( $rollneck_id );
			$v->set_attributes( array( $size_tax => $size, $colour_tax => $colour ) );
			$v->set_regular_price( '95' );
			$v->set_stock_status( ( 'xl' === $size && 'oatmeal' === $colour ) ? 'outofstock' : 'instock' );
			$v->save();
		}
	}
	WC_Product_Variable::sync( $rollneck_id );
}
$product_ids['merino-rollneck'] = $rollneck_id;

// Reviews, then close reviews so the preview never collects names and emails.
$reviews = array(
	'burgundy-wool-coat' => array( array( 'Hannah M.', 5, 'Heavier and better made than anything I have bought in years. It arrived in two days, beautifully packed.' ), array( 'Tom W.', 4, 'A beautiful coat. It runs slightly large, so size down if you are between sizes.' ) ),
	'merino-rollneck'    => array( array( 'Priya S.', 5, 'Soft, warm and it still looks new after a winter of wearing it almost every day.' ) ),
	'chunky-knit-jumper' => array( array( 'Daniel R.', 5, 'I sent back one size and had the swap within the week, no questions asked.' ), array( 'Lena K.', 5, 'The cosiest thing I own. Worth every penny.' ) ),
);
foreach ( $reviews as $slug => $list ) {
	$post_id = $product_ids[ $slug ];
	if ( get_comments( array( 'post_id' => $post_id, 'type' => 'review', 'count' => true ) ) ) {
		continue;
	}
	foreach ( $list as $r ) {
		$cid = wp_insert_comment( array( 'comment_post_ID' => $post_id, 'comment_author' => $r[0], 'comment_author_email' => '', 'comment_content' => $r[2], 'comment_type' => 'review', 'comment_approved' => 1 ) );
		update_comment_meta( $cid, 'rating', $r[1] );
		update_comment_meta( $cid, 'verified', 1 );
	}
	WC_Comments::clear_transients( $post_id );
}

/* -------------------------------------------------------------------------
 * Pages, journal, menu
 * ---------------------------------------------------------------------- */

// Every page exists before any pattern renders: patterns resolve links to
// /about/, /faq/ and the posts page as they render, and the theme remembers a
// missing page for the rest of the request.
$registry = WP_Block_Patterns_Registry::get_instance();
$pages    = array(
	'about'            => array( 'Our story', 'tyche/page-about' ),
	'contact'          => array( 'Contact', 'tyche/page-contact' ),
	'faq'              => array( 'FAQ', 'tyche/page-faq' ),
	'delivery-returns' => array( 'Delivery and returns', 'tyche/page-shipping' ),
	'size-guide'       => array( 'Size guide', 'tyche/page-size-guide' ),
);
$home    = tyche_demo_page( 'home', 'Home', '' );
$journal = tyche_demo_page( 'journal', 'Journal', '', '' );
foreach ( $pages as $slug => $page ) {
	tyche_demo_page( $slug, $page[0], '' );
}
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $home );
update_option( 'page_for_posts', $journal );

foreach ( $pages as $slug => $page ) {
	tyche_demo_page( $slug, $page[0], $registry->get_registered( $page[1] )['content'] );
}
tyche_demo_page( 'home', 'Home', tyche_demo_expand( $registry->get_registered( 'tyche/page-home' )['content'] ) );

foreach ( array( 'hello-world' => 'post', 'sample-page' => 'page' ) as $slug => $type ) {
	$default = get_page_by_path( $slug, OBJECT, $type );
	if ( $default ) {
		wp_delete_post( $default->ID, true );
	}
}

$care  = term_exists( 'Care guides', 'category' ) ?: wp_insert_term( 'Care guides', 'category' );
$style = term_exists( 'Style notes', 'category' ) ?: wp_insert_term( 'Style notes', 'category' );
$care  = (int) ( is_array( $care ) ? $care['term_id'] : $care );
$style = (int) ( is_array( $style ) ? $style['term_id'] : $style );

$posts = array(
	'how-to-care-for-wool' => array( 'How to care for wool so it lasts for years', $care, 'journal-wool-care.jpg', 'Grey, navy and charcoal knitted fabrics side by side', '-12 days', array(
		'Wool looks after itself better than almost any fabric. It resists stains and odours, so most knitwear needs washing far less often than you think.',
		'Air a jumper between wears by laying it flat near an open window. When it does need a wash, use cool water and a wool detergent, press the water out in a towel rather than wringing, and dry it flat away from direct heat.',
		'Store knitwear folded, never on a hanger, which stretches the shoulders. A drawer with a cedar block keeps moths away through summer.',
	) ),
	'five-ways-to-wear-a-blanket-scarf' => array( 'Five ways to wear a blanket scarf', $style, 'journal-blanket-scarf.jpg', 'A woman walking through a field wrapped in a pale blue blanket scarf', '-20 days', array(
		'A blanket scarf is the most useful thing in a winter wardrobe: a scarf, a wrap and, on a cold evening, very nearly a coat.',
		'Fold it into a triangle and wear it over a coat with the point at the back. Loop it twice for a chunky collar. Drape it over the shoulders as a shawl. Belt it over a knit dress. Or simply throw it around your shoulders on the walk home.',
	) ),
	'how-to-layer-for-a-cold-morning' => array( 'How to layer for a cold morning', $style, 'journal-cold-morning.jpg', 'A woman in a burgundy coat walking along a snowy lakeside path', '-28 days', array(
		'The secret to staying warm is thin layers, not thick ones. Warm air gets trapped between them, and you can take one off when you come inside.',
		'Start with a fine merino base, add a knit, and finish with a wool coat that has room across the shoulders. A scarf and a beanie do more than any extra jumper.',
	) ),
);
foreach ( $posts as $slug => $p ) {
	list( $title, $cat, $photo, $alt, $when, $body ) = $p;
	$found = get_page_by_path( $slug, OBJECT, 'post' );
	$data  = array(
		'post_title'     => $title,
		'post_name'      => $slug,
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'post_content'   => wp_slash( tyche_demo_blocks( $body ) ),
		'post_excerpt'   => $body[0],
		'post_category'  => array( $cat ),
		'post_date'      => gmdate( 'Y-m-d H:i:s', strtotime( $when ) ),
		'comment_status' => 'closed',
	);
	if ( $found ) {
		$data['ID'] = $found->ID;
	}
	$post_id = wp_insert_post( $data );
	set_post_thumbnail( $post_id, tyche_demo_image( $assets, $photo, $alt ) );
}
$uncat = get_term_by( 'slug', 'uncategorized', 'category' );
if ( $uncat ) {
	update_option( 'default_category', $style );
	wp_delete_term( $uncat->term_id, 'category' );
}

// Primary menu: the header's Navigation block uses the newest menu when none is chosen.
$links = array(
	array( 'Shop', get_permalink( wc_get_page_id( 'shop' ) ), 'page', wc_get_page_id( 'shop' ) ),
	array( 'Coats', get_term_link( $cats['coats'] ), 'taxonomy', $cats['coats'] ),
	array( 'Knitwear', get_term_link( $cats['knitwear'] ), 'taxonomy', $cats['knitwear'] ),
	array( 'Dresses', get_term_link( $cats['dresses'] ), 'taxonomy', $cats['dresses'] ),
	array( 'Accessories', get_term_link( $cats['accessories'] ), 'taxonomy', $cats['accessories'] ),
	array( 'Journal', get_permalink( $journal ), 'page', $journal ),
	array( 'Our story', get_permalink( tyche_page_url_id( 'about' ) ), 'page', tyche_page_url_id( 'about' ) ),
);
$menu = '';
foreach ( $links as $l ) {
	$menu .= '<!-- wp:navigation-link ' . wp_json_encode( array( 'label' => $l[0], 'url' => $l[1], 'kind' => $l[2] === 'taxonomy' ? 'taxonomy' : 'post-type', 'type' => $l[2] === 'taxonomy' ? 'product_cat' : 'page', 'id' => (int) $l[3], 'isTopLevelLink' => true ) ) . " /-->\n";
}
$nav = get_posts( array( 'post_type' => 'wp_navigation', 'name' => 'primary', 'numberposts' => 1, 'post_status' => 'publish' ) );
$nav_data = array( 'post_type' => 'wp_navigation', 'post_title' => 'Primary', 'post_name' => 'primary', 'post_status' => 'publish', 'post_content' => wp_slash( $menu ) );
if ( $nav ) {
	$nav_data['ID'] = $nav[0]->ID;
}
wp_insert_post( $nav_data );

flush_rewrite_rules();
WP_CLI::success( sprintf( '%d products, home %d, journal %d', count( $product_ids ), $home, $journal ) );
