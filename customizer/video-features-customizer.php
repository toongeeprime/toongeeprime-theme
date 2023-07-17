<?php defined( 'ABSPATH' ) || exit;

/**
 *	VIDEO FEATURES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme Theme 1.0.55
 */

function p2gvfactive() { return get_theme_mod( 'prime2g_enable_video_features' ); }

if ( ! function_exists( 'prime2g_theme_video_features' ) ) {

function prime2g_theme_video_features( $wp_customize ) {

if ( ! prime2g_use_extras() ) return;

	$wp_customize->add_setting(
		'prime2g_enable_video_features',
		array( 'type' => 'theme_mod', 'sanitize_callback'	=>	'sanitize_text_field' )
	);
	$wp_customize->add_control(
		'prime2g_enable_video_features',
		array(
			'label'		=>	__( 'Enable Video Features', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_enable_video_features',
			'section'	=>	'prime2g_media_features_section'
		)
	);

	$wp_customize->add_setting(
		'prime2g_videos_for_posttypes',
		array(
			'type'	=>	'theme_mod',
			'default'	=>	'post',
			'transport'	=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'prime2g_videos_for_posttypes',
		array(
			'label'		=>	__( 'Video features in Post Types (Separate post type slugs with comma)', PRIME2G_TEXTDOM ),
			'settings'	=>	'prime2g_videos_for_posttypes',
			'section'	=>	'prime2g_media_features_section',
			'active_callback'	=>	'p2gvfactive',
			'input_attrs'	=>	array(
				'placeholder'	=>	'post, page',
			),
		)
	);

	$wp_customize->add_setting(
		'prime2g_video_embed_location',
		array(
			'type'	=>	'theme_mod',
			'default'	=>	'prime2g_after_title',
			'sanitize_callback'	=>	'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'prime2g_video_embed_location',
		array(
			'type'		=>	'select',
			'label'		=>	__( 'Video Embed Location on Post', PRIME2G_TEXTDOM ),
			'settings'	=>	'prime2g_video_embed_location',
			'section'	=>	'prime2g_media_features_section',
			'active_callback'	=>	function() { return ( p2gvfactive() && is_singular() ); },
			'choices'	=>	array(
				'prime2g_before_title'	=>	__( 'Before Post Title', PRIME2G_TEXTDOM ),	# values === hook names
				'prime2g_after_title'	=>	__( 'After Post Title', PRIME2G_TEXTDOM ),
				'prime2g_before_post'	=>	__( 'Before Post Content', PRIME2G_TEXTDOM ),
				'prime2g_after_post'	=>	__( 'After Post Content', PRIME2G_TEXTDOM ),
				'replace_header'	=>	__( 'Replace Header', PRIME2G_TEXTDOM ),	# values !== hook name
			),
		)
	);

	$wp_customize->add_setting(
		'prime2g_replace_ftimage_with_video',
		array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control(
		'prime2g_replace_ftimage_with_video',
		array(
			'label'		=>	__( 'Replace Post Image with Video (Archives)', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_replace_ftimage_with_video',
			'section'	=>	'prime2g_media_features_section',
			'active_callback'	=>	function() { return ( p2gvfactive() && is_archive() ); },
		)
	);

}

}


