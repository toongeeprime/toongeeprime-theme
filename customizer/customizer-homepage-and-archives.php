<?php defined( 'ABSPATH' ) || exit;

/**
 *	Customizer for Theme Archives
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( ! function_exists( 'prime2g_customizer_home_and_archives' ) ) {

function prime2g_customizer_home_and_archives( $wp_customize ) {

	/**
	 *	POSTS HOME TITLE
	 */
	$siteTitle	=	get_bloginfo( 'name' );
	$wp_customize->add_setting(
		'prime2g_posts_home_title',
		array(
			'type'		=>	'theme_mod',
			'transport'	=>	'postMessage',
			'default'	=>	$siteTitle,
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'prime2g_posts_home_title',
		array(
			'label'		=>	__( 'Posts Homepage Title', PRIME2G_TEXTDOM ),
			'type'		=>	'text',
			'settings'	=>	'prime2g_posts_home_title',
			'section'	=>	'prime2g_theme_archives_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	$siteTitle,
			),
			'active_callback'	=>	'is_home',
		)
	);


	$wp_customize->add_setting(
		'prime2g_posts_home_description',
		array(
			'type'		=>	'theme_mod',
			'default'	=>	'Posts Homepage',
			'transport'	=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'prime2g_posts_home_description',
		array(
			'label'		=>	__( 'Posts Homepage Description', PRIME2G_TEXTDOM ),
			'type'		=>	'text',
			'settings'	=>	'prime2g_posts_home_description',
			'section'	=>	'prime2g_theme_archives_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'Posts Homepage',
			),
			'active_callback'	=>	'is_home',
		)
	);


	/**
	 *	HEADER STICKY POSTS
	 */
	$wp_customize->add_setting( 'prime2g_theme_show_stickies', array( 'type' => 'theme_mod' ) );
	$wp_customize->add_control(
		'prime2g_theme_show_stickies',
		array(
			'label'		=>	__( 'Show Sticky Posts at the Top of Archives?', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_theme_show_stickies',
			'section'	=>	'prime2g_theme_archives_section',
			'choices'	=>	array(
				'show'	=>	__( 'Yes', PRIME2G_TEXTDOM ),
			),
			'active_callback'	=>	function(){ return ( is_home() || is_archive() ); },
		)
	);


	$wp_customize->add_setting(
		'prime2g_theme_sticky_heading',
		array(
			'type'		=>	'theme_mod',
			'transport'	=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'prime2g_theme_sticky_heading',
		array(
			'label'		=>	__( 'Sticky Posts Heading', PRIME2G_TEXTDOM ),
			'settings'	=>	'prime2g_theme_sticky_heading',
			'section'	=>	'prime2g_theme_archives_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'Featured Posts',
			),
			'active_callback'	=>	function(){ return ( is_home() || is_archive() ); }
		)
	);

	/**
	 *	STICKY POSTS' POST TYPE & COUNT
	 *	@since ToongeePrime Theme 1.0.51
	 */
	$wp_customize->add_setting(
	'prime2g_theme_stickies_post_type',
		array(
			'type'	=>	'theme_mod',
			'default'	=>	'post'
		)
	);
	$wp_customize->add_control(
		'prime2g_theme_stickies_post_type',
		array(
			'label'		=>	__( 'Stickies\' Post Type', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_theme_stickies_post_type',
			'section'	=>	'prime2g_theme_archives_section',
			'choices'	=>	prime2g_posttypes_names_array(),
		)
	);

	$wp_customize->add_setting(
	'prime2g_theme_stickies_count', array( 'type' => 'theme_mod','default'	=>	'4' )
	);
	$wp_customize->add_control(
		'prime2g_theme_stickies_count',
		array(
			'label'		=>	__( 'How many Stickies?', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_theme_stickies_count',
			'section'	=>	'prime2g_theme_archives_section',
			'choices'	=>	[
				'2'	=>	'2',
				'3'	=>	'3',
				'4'	=>	'4',
				'6'	=>	'6',
				'8'	=>	'8',
				'9'	=>	'9'
			],
		)
	);

}

}
