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

if ( ! function_exists( 'is_shop' ) ) return __( 'Shopping inactive on this site!', PRIME2G_TEXTDOM );

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




/**
 *	For some consistency in using these icons
 *	Use JavaScript in Child theme for whatever manipulations
 */
add_shortcode( 'prime_shopping_icons', 'prime2g_woo_icons_template' );
function prime2g_woo_icons_template( $atts = [] ) {
if ( ! function_exists( 'is_shop' ) ) return;

$atts	=	shortcode_atts( array(
'show'	=>	'cart, account, checkout',
'wrap'	=>	'yes',
'cart_count'	=>	'yes',
), $atts );
extract( $atts );

$show	=	str_replace( ' ', '', $show );
$to_show=	explode( ',', $show );
$wrap	=	$wrap === 'yes' ? true : false;

$icons	=	'';
$icons	.=	$wrap ? '<span class="prime_shopping_icons">' :'';

if ( in_array( 'cart', $to_show ) ) {

	// CSS to hide excess cart data
	$x_css	=	'<style>
	.prime_si.cart .total,.prime_si.cart .ii,.prime_si.cart .sep{display:none!important;}
	.prime_si.cart .number{position:absolute;width:15px;height:15px;top:-70%;right:0;font-size:80%;background:red;color:#fff;display:grid;place-content:center;border-radius:50px;}
	.prime_si .empty .number{display:none;}
	</style>';
	$cart_count	=	$cart_count === 'yes' ? $x_css . '<span class="cart_count">'. prime2g_woo_cart_contents_fragments( 'count', false ) .'</span>' : '';
	$icons	.=	'<span class="prime_si cart prel">'. $cart_count .'
	<a href="'. esc_url( wc_get_cart_url() ) .'" title="'. __( 'Shopping cart', PRIME2G_TEXTDOM ) .'">
	<i class="bi bi-cart3"></i>
	</a>
	</span>';
}

if ( in_array( 'account', $to_show ) ) {
	$icons	.=	'<span class="prime_si account">
	<a href="'. esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) .'" title="'. __( 'Account Page', PRIME2G_TEXTDOM ) .'">
	<i class="bi bi-person"></i>
	</a>
	</span>';
}

if ( in_array( 'checkout', $to_show ) ) {
	$icons	.=	'<span class="prime_si checkout">
	<a href="'. esc_url( wc_get_checkout_url() ) .'" title="'. __( 'Checkout', PRIME2G_TEXTDOM ) .'">
	<i class="bi bi-credit-card"></i>
	</a>
	</span>';
}

$icons	.=	$wrap ? '</span>' : '';

return $icons;
}

