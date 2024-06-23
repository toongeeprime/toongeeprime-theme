<?php defined( 'ABSPATH' ) || exit;
/**
 *	THEME' PERFORMANCE
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.60
 */

add_filter( 'style_loader_tag', 'prime2g_style_loader_tag_filter', 10, 4 );
function prime2g_style_loader_tag_filter( $html, $handle, $href, $media ) {
// $criticals		=	[ 'prime2g_css', 'prime2g_child_css', 'prime2g_woocommerce_css' ];

#	non-criticals
if ( in_array( $handle, [ PRIME2G_ICONS_HANDLE, 'prime_post_font_url' ] ) ) {
$html	=	'<link rel="preload" href="'. $href .'" id="'. $handle .'" as="style" media="'. $media .'" onload="this.onload=null;this.rel=\'stylesheet\'" />
<noscript><link rel="stylesheet" href="'. $href .'" id="'. $handle .'"></noscript>';
}

return $html;
}


add_filter( 'script_loader_tag', 'prime2g_script_loader_tag_filter', 10, 3 );
function prime2g_script_loader_tag_filter( $tag, $handle, $src ) {
$handles	=	array( 'prime2g_pwa_js', 'prime2g_pwa_scripts', 'prime2g_child_js' );

if ( in_array( $handle, $handles ) ) {
	$tag	=	str_replace( ' src=', ' async src=', $tag );
}

return $tag;
}



/**
 *	PRINT SCRIPTS?
 *	@since 1.0.97
 */
if ( ! empty( get_theme_mod( 'prime2g_optimize_theme_files' ) ) ) {

#	CSS
add_action( 'wp_enqueue_scripts', function() {
	wp_dequeue_style( 'prime2g_child_css' );
	wp_dequeue_style( 'prime2g_woocommerce_css' );
}, 55 );

add_action( 'wp_head', function() {
echo '<style id="prime2g_css">'. file_get_contents( get_theme_file_uri( '/files/theme-min.css' ) ) .'</style>';

if ( class_exists( 'woocommerce' ) )
	echo '
<style id="prime2g_woocommerce_css">'. file_get_contents( get_theme_file_uri( '/files/prime_woocommerce.css' ) ) .'</style>';

echo '
<style id="prime2g_child_css">'. file_get_contents( get_theme_file_uri( '/files/child.css' ) ) .'</style>';
}, 50 );


#	Theme JS
add_action( 'wp_head', function() {
echo '<script id="prime2g_js">'. file_get_contents( get_theme_file_uri( '/files/theme-min.js' ) ) .'</script>';
}, 5 );

add_action( 'wp_footer', function() {
echo '<script id="prime2g_footer_js">'. file_get_contents( get_theme_file_uri( '/files/footer.js' ) ) .'</script>';
} );

}


