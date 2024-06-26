<?php defined( 'ABSPATH' ) || exit;

/**
 *	TEMPLATE ADJUSTMENTS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

add_action( 'template_redirect', 'prime2g_adjust_templates_logic' );
if ( ! function_exists( 'prime2g_adjust_templates_logic' ) ) {
function prime2g_adjust_templates_logic() {

/**
 *	Singular Templates
 */
if ( is_singular() ) {

if ( ! empty( prime2g_get_post_media_embed() ) ) {
	$place	=	get_theme_mod( 'prime2g_video_embed_location', 'prime2g_before_title' );
	add_action( $place, function() { echo prime2g_get_post_media_embed(); }, 5 );
}

global $post;
$removeSidebar	=	get_theme_mod( 'prime2g_remove_sidebar_in_singular', '' );

if ( $post->remove_sidebar === 'remove' || 'and_pages' === $removeSidebar ||
	! is_page() && 'posts' === $removeSidebar || is_page() && 'pages_only' === $removeSidebar
	|| function_exists( 'is_product' ) && is_product() && 'products_only' === $removeSidebar
	)
	prime2g_removeSidebar();

/**
 *	@since 1.0.70
 */
if ( $post->remove_header === 'header_image_css' ) {
echo '<style id="applyCustomHeaderImage">
header#header{background-image:url('. prime2g_get_header_image_url( true ) .');}
</style>';
}

}


/**
 *	Archive Templates
 *	Updated for WooCommerce archives @since 1.0.89
 */
if ( is_home() || is_archive() ) {

	if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
		if ( get_theme_mod( 'prime2g_remove_sidebar_in_product_archives', '0' ) ) prime2g_removeSidebar();
	}
	else {
		if ( get_theme_mod( 'prime2g_remove_sidebar_in_archives', '0' ) ) prime2g_removeSidebar();
	}

}

}
}



