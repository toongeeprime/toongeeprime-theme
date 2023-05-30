<?php defined( 'ABSPATH' ) || exit;

/**
 *	CONDITIONAL THEME JS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

add_action( 'wp_footer', 'prime2g_conditional_js' );
function prime2g_conditional_js() {
if ( is_singular() && 'replace_header' === get_theme_mod( 'prime2g_video_embed_location' ) ) return;

$js	=	'<script id="prime2g_conditional_js">';

if ( has_header_video() && is_header_video_active() ) {
$js	.=	'var ww_timer	=	setTimeout( function ww_video() {
if ( wp.customHeader.handlers.youtube.player == null ) {
	ww_timer	=	setTimeout( ww_video, 1000 );
} else {
	if ( typeof wp.customHeader.handlers.youtube.player.unMute === "function" ) {
		wp.customHeader.handlers.youtube.player.unMute();
		wp.customHeader.handlers.youtube.player.stopVideo();
	} else {
		ww_timer	=	setTimeout( ww_video, 1000 );
	}
} }, 1000 );
';
}

/*
let ytHeader	=	p2getEl( "#wp-custom-header" );
ytHeader.classList.add( "unclicked" );
ytHeader.onclick	=	()=>{ ytHeader.classList.remove( "unclicked" ); };
*/

$js	.=	'</script>';

echo $js;
}


