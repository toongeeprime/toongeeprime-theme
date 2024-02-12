<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME' PERFORMANCE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.60
 */
//	LAZY LOAD IMAGES & IFRAMES v Customizer instruction === add attr: loading="lazy"

add_filter( 'style_loader_tag', 'prime2g_style_loader_tag_filter', 10, 4 );
function prime2g_style_loader_tag_filter( $html, $handle, $href, $media ) {
$handles		=	array( 'prime2g_css', 'prime2g_woocommerce_css', 'prime2g_pwa_css', 'prime2g_child_css' );
$non_critical	=	array( PRIME2G_ICONS_HANDLE, 'prime_post_font_url' );

// if ( in_array( $handle, $handles ) ) {
	// $html	=	str_replace( '', '', $html );
// }

if ( in_array( $handle, $non_critical ) ) {
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

