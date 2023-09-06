<?php defined( 'ABSPATH' ) || exit;

/**
 *	PAGE PRELOADER FEATURE
 *	Includes CSS and JS functions
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.48
 */

add_action( 'prime2g_before_head', 'prime2g_page_preloader', 0 );
if ( ! function_exists( 'prime2g_page_preloader' ) ) {
function prime2g_page_preloader() {

$preloaderState	=	get_theme_mod( 'prime2g_use_page_preloader' );
$preloaderOn	=	( 'on' === $preloaderState );
$useSiteLogo	=	( 'use_logo' === $preloaderState );
$useSiteIcon	=	( 'use_icon' === $preloaderState );
$useCustomUrl	=	( 'custom_url' === $preloaderState );	# 1.0.55

if ( ! empty( $preloaderState ) ) {

	$preloader	=	'<div id="prime2gPreloading">';
	$preloader	.=	prime2g_page_preloaderCSS();

	if ( $preloaderOn ) $preloader	.=	'<div id="itsLoading"></div>';
	if ( $useSiteLogo ) $preloader	.=	prime2g_siteLogo();
	if ( $useSiteIcon ) $preloader	.=	'<img src="'. get_site_icon_url( 250, PRIME2G_IMAGE . 'spinner.gif' ) .'" alt />';
	if ( $useCustomUrl ) $preloader	.=	'<img src="'. get_theme_mod( 'prime2g_custom_preloader_img_url' ) .'" alt />';

	$preloader	.=	prime2g_page_preloaderJS();
	$preloader	.=	'</div>';

echo $preloader;
}

}
}


if ( ! function_exists( 'prime2g_page_preloaderCSS' ) ) {
function prime2g_page_preloaderCSS() {
$add_css	=	function_exists( 'prime2g_add_preloader_css' ) ? prime2g_add_preloader_css() : '';

$css	=	'<style id="preloaderCSS" scoped>
#prime2gPreloading{position:fixed;top:0;bottom:0;left:0;right:0;background:var(--content-background);display:grid;
place-items:center;z-index:100000;transition:0.5s;}
#itsLoading{border:10px solid var(--brand-color);border-top:10px solid var(--brand-color-2);width:120px;height:120px;
border-radius:50%;animation:loading 1s linear infinite;}

@keyframes loading {
0%{transform:rotate(0deg);}
100%{transform:rotate(360deg);}
}
'. $add_css .'
</style>';

return $css;
}
}


if ( ! function_exists( 'prime2g_page_preloaderJS' ) ) {
function prime2g_page_preloaderJS() {
$add_js	=	function_exists( 'prime2g_add_preloader_js' ) ? prime2g_add_preloader_js() : '';

$js	=	'<script id="preloaderJS">
function prime2g_clearPreloader() {
let p2Prloadr	=	p2getEl( "#prime2gPreloading" );
setTimeout( ()=>{ p2Prloadr.style.opacity = "0"; p2Prloadr.style.visibility = "hidden"; }, 500 );
setTimeout( ()=>{ p2Prloadr.remove(); p2getEl( "body" ).classList.add( "preloaded" ); }, 1000 );
}

window.addEventListener( "load", prime2g_clearPreloader );
'. $add_js .'
</script>';

return $js;
}
}

