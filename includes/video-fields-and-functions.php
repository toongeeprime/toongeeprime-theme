<?php defined( 'ABSPATH' ) || exit;

/**
 *	VIDEO FUNCTIONS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme Theme 1.0.55
 */

function prime2g_video_features_active() {
	return ( prime2g_use_extras() && get_theme_mod( 'prime2g_enable_video_features' ) );
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


