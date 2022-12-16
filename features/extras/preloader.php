<?php defined( 'ABSPATH' ) || exit;

/**
 *	PAGE PRELOADER FEATURE
 *	Includes CSS and JS functions
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.48.00
 */

add_action( 'wp_body_open', 'prime2g_page_preloader' );
if ( ! function_exists( 'prime2g_page_preloader' ) ) {

function prime2g_page_preloader() {

$preloaderState	=	get_theme_mod( 'prime2g_use_page_preloader' );
$preloaderOn	=	( 'on' == $preloaderState );
$useSiteLogo	=	( 'use_logo' == $preloaderState );
$useSiteIcon	=	( 'use_icon' == $preloaderState );

if ( '' != $preloaderState ) {
	$iconUrl	=	get_site_icon_url( 250, PRIME2G_IMAGE . 'spinner.gif' );
	$logoImg	=	prime2g_siteLogo();

	$preloader	=	'<div id="prime2gPreloading">';
	$preloader	.=	prime2g_page_preloaderCSS();

	if ( $preloaderOn ) $preloader	.=	'<div id="itsLoading"></div>';
	if ( $useSiteLogo ) $preloader	.=	$logoImg;
	if ( $useSiteIcon ) $preloader	.=	'<img src="' . $iconUrl . '" alt />';

	$preloader	.=	prime2g_page_preloaderJS();
	$preloader	.=	'</div>';

echo $preloader;
}

}

}


if ( ! function_exists( 'prime2g_page_preloaderCSS' ) ) {
function prime2g_page_preloaderCSS() {
$css	=	'<style id="preloaderCSS">
#prime2gPreloading{position:fixed;top:0;bottom:0;left:0;right:0;background:var(--content-background);display:grid;
place-items:center;z-index:100000;transition:0.5s;}
#itsLoading{border:10px solid var(--brand-color);border-top:10px solid var(--brand-color-2);width:120px;height:120px;
border-radius:50%;animation:loading 1s linear infinite;}

@keyframes loading {
0%{transform:rotate(0deg);}
100%{transform:rotate(360deg);}
}
</style>';

return $css;
}
}


if ( ! function_exists( 'prime2g_page_preloaderJS' ) ) {
function prime2g_page_preloaderJS() {
$js	=	'<script id="preloaderJS">
function prime2g_clearPreloader() {
	let p2Prloadr	=	p2getEl( "#prime2gPreloading" );
setTimeout( ()=>{
	p2Prloadr.style.opacity		=	"0";
	p2Prloadr.style.visibility	=	"hidden";
}, 500 );
setTimeout( ()=>{
	p2Prloadr.remove();
	p2getEl( "body" ).classList.add( "preloaded" );
}, 1000 );
}

window.addEventListener( "load", prime2g_clearPreloader );
</script>';

return $js;
}
}


