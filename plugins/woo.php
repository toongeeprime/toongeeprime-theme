<?php defined( 'ABSPATH' ) || exit;
/**
 *	WOOCOMMERCE WORKINGS
 *	@package WordPress
 *	@package WooCommerce
 *	@since ToongeePrime Theme 1.0
 *
 *	Active if WooCommerce is
 */
if ( class_exists( 'WooCommerce' ) ) :

/**
 *	WooCommerce Breadcrumbs
 *	Updated @since 1.0.80
 */
#	Remove WooCommerce breadcrumbs from default position:
remove_action( 'woocommerce_before_main_content' , 'woocommerce_breadcrumb' , 20, 0 );

if ( ! function_exists( 'prime2g_woo_breadrumb_home_url' ) ) {
add_filter( 'woocommerce_breadcrumb_home_url', 'prime2g_woo_breadrumb_home_url' );
function prime2g_woo_breadrumb_home_url() {
	return esc_url( wc_get_page_permalink( 'shop' ) );
}
}


if ( ! function_exists( 'prime2g_woo_breadcrumb_defaults' ) ) {
add_filter( 'woocommerce_breadcrumb_defaults', 'prime2g_woo_breadcrumb_defaults' );
function prime2g_woo_breadcrumb_defaults() {
return array(
	'delimiter'		=>	' &#187; ',
	'wrap_before'	=>	'<nav id="breadCrumbs" class="woocommerce-breadcrumb breadCrumbs" itemprop="breadcrumb">' . prime2g_home_breadcrumb_span(),
	'wrap_after'	=>	'</nav>',
	// 'before'		=>	__( prime2g_do_woo_texts( 'category_title' ) . ': ', 'woocommerce' ),
	'before'		=>	'',
	'after'			=>	'',
	'home'			=>	_x( prime2g_do_woo_texts( 'shop_title' ), 'breadcrumb', 'woocommerce' ),
);
}
}


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
 *	Restroring Single Product Title
 *	@since 1.0.89
 */
add_action( 'woocommerce_single_product_summary', function() {
if ( 'header' === ToongeePrime_Styles::mods_cache()->title_place &&
get_theme_mod( 'prime2g_remove_header_in_products', 0 ) ) {
	prime2g_title_header( prime2g_title_header_classes() );
}
}, 5 );


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
 *	Changing WooCommerce Texts
 */
function prime2g_do_woo_texts( $get ) {
if ( $get === 'shop_title' ) {
	$text	=	get_theme_mod( 'prime2g_shop_page_title' );	//	mod fallback doesn't work here
	if ( empty( $text ) )
		$text	=	'Shop Homepage';
}
if ( $get === 'category_title' ) {
	$text	=	'Category';
}
return $text;
}


add_filter( 'gettext', 'prime2g_change_woocommerce_texts', 20, 3 );
if ( ! function_exists( 'prime2g_change_woocommerce_texts' ) ) {
function prime2g_change_woocommerce_texts( $translated_text, $text, $domain ) {

switch ( $translated_text ) {
	case 'Return to shop' :
		$translated_text = __( 'Return to ' . prime2g_do_woo_texts( 'shop_title' ), 'woocommerce' );
		break;
	case 'Browse products' :
		$translated_text = __( 'Browse ' . prime2g_do_woo_texts( 'shop_title' ), 'woocommerce' );
		break;
	case 'Related products' :
		$translated_text = __( 'More items like this...', 'woocommerce' );
		break;
}

return $translated_text;
}
}


endif;

