<?php defined( 'ABSPATH' ) || exit;

/**
 *	VIDEO AFFAIRS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme Theme 1.0.55
 */
function prime2g_video_features_active() {
	return ( prime2g_use_extras() && get_theme_mod( 'prime2g_enable_video_features' ) );
}



/**
 *	WP Header Video Settings Filter
 */
add_filter( 'header_video_settings', 'prime2g_header_video_settings' );
if ( ! function_exists( 'prime2g_header_video_settings' ) ) {
function prime2g_header_video_settings( $settings ) {

$video_url	=	get_header_video_url();

$height		=	wp_is_mobile() ? 280 : 500;

	$settings[ 'videoUrl' ]		=	$video_url;
	$settings[ 'posterUrl' ]	=	false;
	$settings[ 'width' ]		=	1750;
	$settings[ 'height' ]		=	$height;
	$settings[ 'minWidth' ]		=	280;
	$settings[ 'minHeight' ]	=	250;
	$settings[ 'l10n' ]		=	array(
		'pause'		=>	__( 'Pause Video', PRIME2G_TEXTDOM ),
		'play'		=>	__( 'Play Video', PRIME2G_TEXTDOM ),
		'pauseSpeak'=>	__( 'Video is paused.', PRIME2G_TEXTDOM ),
		'playSpeak'	=>	__( 'Video is playing.', PRIME2G_TEXTDOM )
	);

return $settings;
}
}



#	callbacks for video-active-callback @ custom-header theme support:
function prime2g_video_header_front_and_archives() { return ( is_front_page() || is_archive() ); }
function prime2g_video_header_use_postvideo() {
	global $post; return ( is_singular() && ( $post->video_url ) );
}



function prime2g_posttypes_with_video_features() : array {
	if ( ! prime2g_use_extras() ) return [];

	$ptypes	=	get_theme_mod( 'prime2g_videos_for_posttypes', 'post' );
	return explode( ',', $ptypes );
}



if ( ! function_exists( 'prime2g_post_has_media_field' ) ) {

function prime2g_post_has_media_field( $post ) {
	if ( $post->video_url || $post->audio_url ) return true;
}

}



if ( ! function_exists( 'prime2g_get_post_media_embed' ) ) {

function prime2g_get_post_media_embed( $media = 'video', $post = null ) {
if ( ! prime2g_video_features_active() ) return;

global $wp_embed;

if ( ! $post ) { global $post; }

$get	=	$media ?: 'video';

	switch( $get ) {
		case 'audio'	:	$embed	=	$post->audio_url; break;
		default	:	$embed	=	$post->video_url; break;
	}

return '<div class="prime2g_embedded_media '. $get .'">'. $wp_embed->autoembed( $embed ) .'</div>';
}

}

