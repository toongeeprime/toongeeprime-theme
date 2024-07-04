<?php defined( 'ABSPATH' ) || exit;
/**
 *	WOOCOMMERCE MINI CART
 *	@package WordPress
 *	@package WooCommerce
 *	@since ToongeePrime Theme 1.0.89
 */

if ( class_exists( 'WooCommerce' ) ):

add_shortcode( 'prime_mini_cart', 'prime2g_woo_mini_cart_shortcode' );

/**
 *	Theme WooCommerce Mini Cart Shortcode
 */
if ( ! function_exists( 'prime2g_woo_mini_cart_shortcode' ) ) {
function prime2g_woo_mini_cart_shortcode( $atts = [] ) {
#	woocommerce_mini_cart() creates critical errors in admin post edit screen
if ( is_cart() || is_admin() ) return '';

$atts	=	shortcode_atts( [ 'title' => 'Your Cart' ], $atts );
extract( $atts );

ob_start();
echo prime2g_woo_mini_cart_css(); ?>

<div class="prime_mini_cart">
<h3 id="cart-heading" class="cart-title">
<i class="bi bi-cart3"></i>
<?php _e( $title, PRIME2G_TEXTDOM ); ?>
</h3>

<div class="widget_shopping_cart_content"><?php woocommerce_mini_cart(); ?></div>

</div>
<?php return ob_get_clean();
}
}


/**
 *	Show cart contents/total template
 */
function prime2g_woo_cart_contents_fragments( $get = 'span', $echo = true ) {
if ( is_cart() || is_checkout() ) return '';
global $woocommerce;

$count	=	$woocommerce->cart ? $woocommerce->cart->cart_contents_count : 0;
$cart_total	=	$count ? $woocommerce->cart->get_cart_total() : '';
$empty_class	=	$count == 0 ? ' empty' : '';
$class	=	'cart_count_fragmt';

// $items	=	'<span class="items">'. sprintf( _n( '%d item', '%d items', $count, PRIME2G_TEXTDOM ), $count ) .'</span>';
$items	=	$count == 1 ? ' item' : ' items';
$items	=	'<span class="items'. $empty_class .'"><span class="number">'. $count . '</span><span class="ii">' . __( $items, PRIME2G_TEXTDOM ) .'</span></span>';
$total	=	'<span class="total'. $empty_class .'">'. $cart_total .'</span>';

$link_open	=	'<a class="'. $class .'" href="'. esc_url( wc_get_cart_url() ) .'" title="'. __( 'View your shopping cart', PRIME2G_TEXTDOM ) .'">';
$link_close	=	'</a>';

$span_open	=	'<span class="'. $class .'">';
$span_close	=	'</span>';

$link_fragments	=	$link_open . $items . '<span class="sep"> - </span>' . $total . $link_close;
$span_fragments	=	$span_open . $items . '<span class="sep"> - </span>' . $total . $span_close;


if ( $get === 'span' ) {
	if ( $echo ) echo $span_fragments;
	else return $span_fragments;
}
elseif ( $get === 'total' ) {
	$output	=	$span_open . $total . $span_close;
	if ( $echo ) echo $output;
	else return $output;
}
elseif ( $get === 'items' ) {
	$output	=	$span_open . $items . $span_close;
	if ( $echo ) echo $output;
	else return $output;
}

elseif ( $get === 'link' ) {
	if ( $echo ) echo $link_fragments;
	else return $link_fragments;
}
elseif ( $get === 'linktotal' ) {
	$output	=	$link_open . $total . $link_close;
	if ( $echo ) echo $output;
	else return $output;
}
elseif ( $get === 'linkitems' ) {
	$output	=	$link_open . $items . $link_close;
	if ( $echo ) echo $output;
	else return $output;
}
elseif ( $get === 'count' ) {
	$output	=	$span_open . '<span class="items'. $empty_class .'"><span class="number">' . $count . '</span></span>' . $span_close;
	if ( $echo ) echo $output;
	else return $output;
}

else {	#	! $get returns this object for woocommerce_add_to_cart_fragments filter
return (object) [
	'span'	=>	'span.' . $class,
	'link'	=>	'a.' . $class
];
}
}


/**
 *	Show cart contents/total Ajax
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'prime2g_woo_add_to_cart_fragments' );
if ( ! function_exists( 'prime2g_woo_add_to_cart_fragments' ) ) {
function prime2g_woo_add_to_cart_fragments( $fragments ) {
ob_start();

#	Using default <span>
prime2g_woo_cart_contents_fragments();
$fragments[ prime2g_woo_cart_contents_fragments( '' )->span ]	=	ob_get_clean();

return $fragments;
}
}


endif;
