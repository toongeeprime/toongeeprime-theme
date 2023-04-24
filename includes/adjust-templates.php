<?php defined( 'ABSPATH' ) || exit;

/**
 *	TEMPLATE ADJUSTMENTS BY POSTMETA
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

add_action( 'template_redirect', 'prime2g_adjust_templates_logic' );
if ( ! function_exists( 'prime2g_adjust_templates_logic' ) ) {

function prime2g_adjust_templates_logic() {

if ( is_singular() ) {

global $post;

if ( ! empty( prime2g_get_post_media_embed() ) ) {

	$place	=	get_theme_mod( 'prime2g_video_embed_location', 'prime2g_before_title' );
	add_action( $place, function() { echo prime2g_get_post_media_embed(); }, 5 );

}

if ( $post->remove_sidebar === 'remove' ) prime2g_removeSidebar();

}

}

}


