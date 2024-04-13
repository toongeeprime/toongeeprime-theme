<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME SHORTCODE: GET & DISPLAY POSTS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *****
 *	Upgraded @since 1.0.45; Compressed @since 1.0.80
 */

add_shortcode( 'prime2g_display_posts', 'prime2g_posts_shortcode' );
function prime2g_posts_shortcode( $atts ) {
$options	=	array_merge(
prime2g_get_posts_output_default_options(),
[
	'cache_name'=>	'prime2g_posts_shortcode',
	'no_result'	=>	'No entries found for this shortcode request'
]
);

$atts	=	shortcode_atts( $options, $atts );

/**
 *	@since 1.0.71
 */
return prime2g_get_posts_output( $atts );
}

