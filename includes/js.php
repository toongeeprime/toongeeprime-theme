<?php defined( 'ABSPATH' ) || exit;

/**
 *	CONDITIONAL THEME JS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

add_action( 'wp_footer', 'prime2g_conditional_js', 990 );
function prime2g_conditional_js() {
$singular	=	is_singular();
$jsSingular	=	$singular ? 'true' : 'false';

$js	=	'<script id="prime2g_conditional_js">
const	singular	=	'. $jsSingular .';
';

if ( prime2g_video_features_active() ) {
$js	.=
'let sCodeDivs	=	p2getAll( ".wp-video-shortcode" ),
	sCodeVids	=	p2getAll( "video.wp-video-shortcode" ),
	wpVids	=	p2getAll( ".wp-video" );
if ( sCodeVids ) {
sCodeVids.forEach( vid => {
	vid.setAttribute( "width", "100%" ); vid.style.width = "100%";
} );
}
if ( sCodeDivs ) { sCodeDivs.forEach( div => { div.style.width = "auto"; } ); }
if ( wpVids ) { wpVids.forEach( wpv => { wpv.style.width = "auto"; } ); }
';
}

if ( $singular && 'replace_header' === get_theme_mod( 'prime2g_video_embed_location' ) ) {
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
}

/*
let ytHeader	=	p2getEl( "#wp-custom-header" );
ytHeader.classList.add( "unclicked" );
ytHeader.onclick	=	()=>{ ytHeader.classList.remove( "unclicked" ); };
*/

$js	.=	'</script>';

echo $js;
}




prime2g_conditional_customizer_js();
function prime2g_conditional_customizer_js() {
$scriptName	=	basename( $_SERVER[ 'PHP_SELF' ] );
if ( $scriptName === 'customize.php' ) {
if ( prime2g_design_by_network_home() && get_current_blog_id() !== 1 ) {

$js	=	'<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" id="jQueryTmp"></script>
<script id="prime2g_conditional_customizer_js">
jQuery( document ).ready( function() {';

$js	.=	'
setTimeout( ()=>{
let p2gPane	=	jQuery( "#sub-accordion-panel-prime2g_customizer_panel .customize-info" );
p2gPane.append( \'<div style="background:#fff;padding:25px 15px 15px;text-align:center;"><h3>'. __( 'MAIN SITE DESIGNS ARE FROM THE NETWORK HOME', PRIME2G_TEXTDOM ) .'</h3></div>\' );
}, 5000
);
';

$js	.=	'} );
</script>';
echo $js;

}
}
}
