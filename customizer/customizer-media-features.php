<?php defined( 'ABSPATH' ) || exit;

/**
 *	Media Features
 *
 *	@package WordPress
 *	@since ToongeePrime Theme Theme 1.0.50.00
 */

if ( ! function_exists( 'prime2g_customizer_media_features' ) ) {

function prime2g_customizer_media_features( $wp_customize ) {

	/**
	 *	NEWS REEL
	 */
	prime2g_theme_news_reel( $wp_customize );

}

}



