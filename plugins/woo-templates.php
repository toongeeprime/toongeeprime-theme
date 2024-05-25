<?php defined( 'ABSPATH' ) || exit;
/**
 *	WOOCOMMERCE THEME TEMPLATES
 *
 *	@package WordPress
 *	@package WooCommerce
 *	@since ToongeePrime Theme 1.0.90
 */

function prime2g_woo_shop_template_page_override() {
$pageID	=	get_theme_mod( 'prime2g_woo_shop_override_template_page_id' );
if ( empty( $pageID ) ) return;

$pageID	=	(int) $pageID;
$page	=	new WP_Query( [ 'post_type' => 'page', 'p' => $pageID ] );

if ( $page->have_posts() ) {
	while ( $page->have_posts() ) {
		$page->the_post();
		the_content();
		break;
	}
}
wp_reset_postdata();
}




add_shortcode( 'prime_product_categories_images', 'prime2g_woo_product_categories_images' );
function prime2g_woo_product_categories_images( $atts = [] ) {

if ( ! function_exists( 'is_shop' ) ) return;

$atts	=	shortcode_atts( array(
'shuffle'	=>	'',
'cat_ids'	=>	'',
'hide_empty'=>	'1',
'count'		=>	''
), $atts );
extract( $atts );

$categories	=	[];

if ( $cat_ids ) {
	$cat_ids	=	explode( ',', $cat_ids );
	foreach ( $cat_ids as $id ) {
		$categories[]	=	get_term( $id, 'product_cat' );
	}
}
else if ( is_woocommerce() && is_archive() ) {
	$cat_id		=	is_shop() ? 0 : get_queried_object_id();
	$categories	=	get_terms( [ 'taxonomy' => 'product_cat', 'parent' => $cat_id, 'hide_empty' => (int) $hide_empty ] );
}
else {
	$categories	=	get_terms( [ 'taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => (int) $hide_empty ] );
}

if ( empty( $categories ) ) return __( 'Product category not found!', PRIME2G_TEXTDOM );

if ( $shuffle === 'yes' ) shuffle( $categories );

if ( is_numeric( $count ) ) $categories	=	array_slice( $categories, 0, (int) $count );

$images	=	'<section id="prime_prod_categ_img_wrap"><div id="prime_prod_categ_img_links" class="flex justifC">';

foreach ( $categories as $cat ) {
if ( ! $cat ) continue;
$imgurl	=	prime2g_get_term_image_url( $cat->term_id );
$link	=	get_term_link( $cat->term_id, 'product_cat' );
$images	.=	'<div class="prime_prod_cat_img"><a href="'. $link .'" title="'. $cat->name .'">
<span style="background-image:url('. $imgurl .');"></span>
<h4>'. $cat->name .'</h4>
</a></div>';
}

$images	.=	'</div></section>';

if ( $categories ) return '<style>'. prime2g_prod_categ_imgs_css() . '</style>' . $images;
}

