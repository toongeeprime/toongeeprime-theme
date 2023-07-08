<?php defined( 'ABSPATH' ) || exit;

/**
 *	OF WOOCOMMERCE
 *
 *	@package WordPress
 *	@package WooCommerce
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	File active if WooCommerce is active
 */
if ( class_exists( 'WooCommerce' ) ) :


/**
 *	Get WooCommerce Mini Cart
 *	@since ToongeePrime Theme 1.0.45.50
 */
if ( ! function_exists( 'prime2g_get_woo_mini_cart' ) ) {
function prime2g_get_woo_mini_cart() {
	include PRIME2G_THEME . 'woocommerce/cart/mini-cart.php';
}
}


/**
 *	Add to Cart Fragments
 *	@since ToongeePrime Theme 1.0.44
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'prime2g_add_to_cart_fragments', 10, 1 );
if ( ! function_exists( 'prime2g_add_to_cart_fragments' ) ) {
function prime2g_add_to_cart_fragments( $fragments ) {
	$count	=	WC()->cart->get_cart_contents_count();
	ob_start(); ?>

	<!-- div and function to use in theme **preferably wrapped** -->
	<div class="widget_shopping_cart_content">
		<?php woocommerce_mini_cart(); ?>
	</div>

<?php
	$fragments[ 'span.cart_items_count' ]	=	'<span class="cart_items_count p-abso">' . $count . '</span>';
	$fragments[ 'div.minicartdiv' ]	=	ob_get_clean();

return $fragments;
}
}


/**
 *	Remove WooCommerce breadcrumbs for Theme's
 */
remove_action( 'woocommerce_before_main_content' , 'woocommerce_breadcrumb' , 20, 0 );


/**
 *	Remove excess WooCommerce wrappings
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );


/**
 *	Remove WooCommerce Titles to use Theme's
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_filter( 'woocommerce_page_title', 'prime2g_remove_woo_page_title' );
function prime2g_remove_woo_page_title( $page_title ) { return ''; }


/**
 *	Default Shop Description
 */
function prime2g_woo_shop_description() {
	return __( 'This is where you can browse products in this store.', 'woocommerce' );
}


/**
 *	Hint users of the product they are currently viewing
 *	- before related products
 */
add_action( 'woocommerce_after_single_product_summary', 'prime2g_product_in_view' );
function prime2g_product_in_view() {
	echo '<p id="prime_item_in_view" class="clear">' . __( 'You are viewing "' . get_the_title() . '"', 'woocommerce' ) . '</p>';
}


/**
 *	Add classes to body
 */
add_filter( 'body_class', 'prime2g_woo_body_classes' );
if ( ! function_exists( 'prime2g_woo_body_classes' ) ) {
function prime2g_woo_body_classes( $classes ) {
	if ( is_cart() && ( WC()->cart->get_cross_sells() ) ) {
		$classes[]	=	'has_cross_sells';
	}
return $classes;
}
}


/**
 *	Add classes to body
 */
add_filter( 'wp_title', 'prime2g_woo_wp_title' );
function prime2g_woo_wp_title( $title ) {
	if ( is_shop() ) {
		return get_theme_mod( 'prime2g_shop_page_title', 'Shop Homepage' ) . ' | ';
	}
	else {
		return $title;
	}
}


/**
 *	Changing WooCommerce Texts
 */
function prime2g_do_woo_texts( $get ) {
if ( $get == 'shop title' ) {
	$text	=	get_theme_mod( 'prime2g_shop_page_title' );
	if ( empty( $text ) ) $text = 'Shop Homepage';
}
return $text;
}


add_filter( 'gettext', 'prime2g_change_woocommerce_texts', 20, 3 );
if ( ! function_exists( 'prime2g_change_woocommerce_texts' ) ) {
function prime2g_change_woocommerce_texts( $translated_text, $text, $domain ) {

switch ( $translated_text ) {
	case 'Return to shop' :
		$translated_text = __( 'Return to ' . prime2g_do_woo_texts( 'shop title' ), 'woocommerce' );
		break;
	case 'Browse products' :
		$translated_text = __( 'Browse ' . prime2g_do_woo_texts( 'shop title' ), 'woocommerce' );
		break;
	case 'Related products' :
		$translated_text = __( 'More items like this...', 'woocommerce' );
		break;
}

return $translated_text;
}
}



endif;

