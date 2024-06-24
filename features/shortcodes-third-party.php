<?php defined( 'ABSPATH' ) || exit;
/**
 *	SHORTCODES FOR THIRD-PARTY FEATURES
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

/**
 *	LOTTIE FILES
 *	Though oEmbeds can simply be used, this is for more control in layouts
 */
add_shortcode( 'prime2g_lottie', 'prime2g_lottie_player' );
function prime2g_lottie_player( $atts ) {
$atts	=	shortcode_atts( [
'source'	=>	'',
'speed'		=>	'1', // max of 3
'loop'		=>	'yes',
'autoplay'	=>	'yes',
'playonhover'=>	'',
'controls'	=>	'',
'background'=>	'transparent', // or #hex color code
'width'		=>	'300px',
'height'	=>	'300px',
'direction'	=>	'forward',
'playmode'	=>	'',
'class'		=>	'centered',
'id'		=>	'',
'customcss'	=>	'' // if adding custom css
], $atts );

extract( $atts );

$loop		=	$loop === 'yes' ? ' loop' : '';
$hover		=	$playonhover === 'yes' ? ' hover' : '';
$autoplay	=	$autoplay === 'yes' ? ' autoplay' : '';
$controls	=	$controls === 'yes' ? ' controls' : '';
$disableSD	=	$customcss === 'yes' ? ' disableShadowDOM' : '';
$direction	=	in_array( $direction, [ 'back', 'backward', 'backwards', '-1' ] ) ? '-1' : '1';
$playmode	=	$playmode === 'bounce' ? 'bounce' : 'normal';
$id     	=	$id ? ' id="'. $id .'"' : '';

$hook	=	is_login() ? 'login_footer' : 'wp_footer';

if ( ! defined( 'P2G_LOTTIESCRIPT' ) ) {
add_action( $hook, function() {
echo '<script defer src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>';
}, 100 );
define( 'P2G_LOTTIESCRIPT', true );
}

return '<div class="lottie-div">
<dotlottie-player'. $id .' src="'. $source .'" background="'. $background .'" speed="'. $speed .'" class="lottie-player '. $class .'" 
style="width:'. $width .'; height:'. $height .'" direction="'. $direction .'" 
playMode="'. $playmode .'"'. $loop . $hover . $autoplay . $controls . $disableSD .'></dotlottie-player>
</div>';
}



add_shortcode( 'prime_map', 'prime2g_map_shortcode' );
function prime2g_map_shortcode( $atts ) {
$atts	=	shortcode_atts( [
'address'	=>	'',
'map'		=>	'google',
'height'	=>	'400px',
'zoom'		=>	'15',
'maptype'	=>	'roadmap',
'id'		=>	'google-maps-display'
], $atts );
extract( $atts );

$address	=	str_replace( ' ', '+', $address );

if ( $address ) {

$embed	=	'<div id="'. $id .'" class="prime_map" style="max-width:100%;overflow:hidden;color:red;width:100%;height:'. $height .';">
<div style="height:100%;width:100%;max-width:100%;">';

if ( $map === 'google' ) {
$embed	.=	'<iframe style="height:100%;width:100%;border:0;" frameborder="0"
src="https://www.google.com/maps/embed/v1/place?q='. $address .'&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8&zoom='. $zoom .'&maptype='. $maptype .'">
</iframe>
<a class="auth-map-data embed-ded-maphtml" rel="nofollow" href="https://www.bootstrapskins.com/themes">premium bootstrap themes</a>
<style>#'. $id .' img.text-marker{max-width:none!important;background:none!important;}#'. $id .' img{max-width:none}</style>';
}

$embed	.=	'</div>
</div><!-- .prime_map -->';

}
else {
$embed	=	'<strong><p>NO ADDRESS FOR MAP</p></strong>';
}

return $embed;
}



