<?php defined( 'ABSPATH' ) || exit;

/**
 *	SHORTCODES FOR THIRD-PARTY FEATURES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

/**
 *	LOTTIE FILES
 *
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


