<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME SHORTCODE: GET POSTS & DISPLAY POSTS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 ***
 *	Upgraded @since ToongeePrime Theme 1.0.45
 */

add_shortcode( 'prime2g_display_posts', 'prime2g_posts_shortcode' );
function prime2g_posts_shortcode( $atts ) {
$atts	=	shortcode_atts(
array(
	'count'	=>	5,
	'words'	=>	10,
	'order'	=>	'DESC',	# ASC
	'orderby'	=>	'rand',
	'post_type'	=>	'post',
	'taxonomy'	=>	'category',
	'inornot'	=>	'NOT IN',
	'terms'		=>	'uncategorized',
	'looptemplate'	=>	null,	#	@since 1.0.46
	'read_more'	=>	'Read more',#	@since 1.0.50
	'set_cache'	=>	false,	#	should be used by the starting shortcode in a group
	'use_cache'	=>	false,	#	should be used by outputting shortcodes in the group
	'cache_name'=>	'prime2g_posts_shortcode',	#	should be named according to groups
	'offset'	=>	0,
	'device'	=>	'',	#	@since 1.0.55
	'pagination'=>	0,	#	works when shortcode is used in a "page"
	'image_size'	=>	'medium',	#	@since 1.0.70
	'image_to_video'=>	'',
	'site_id'	=>	null,
	'randomize_sites'	=>	'',
	'no_result'	=>	'No entries found for this shortcode request',	#	@since 1.0.71
	'post_ids'	=>	''	#	@since 1.0.79
),
$atts
);

/**
 *	@since ToongeePrime Theme 1.0.71
 */
return prime2g_get_posts_output( $atts );
}

