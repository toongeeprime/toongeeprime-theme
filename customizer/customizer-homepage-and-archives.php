<?php defined( 'ABSPATH' ) || exit;
/**
 *	Customizer for Theme Archives
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( ! function_exists( 'prime2g_customizer_home_and_archives' ) ) {

function prime2g_customizer_home_and_archives( $wp_customize ) {

$simple_text	=	[ 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' ];

/**
 *	@since 1.0.55
 */
	$wp_customize->add_setting( 'prime2g_remove_sidebar_in_archives', $simple_text );
	$wp_customize->add_control( 'prime2g_remove_sidebar_in_archives', array(
		'label'		=>	__( 'Remove Sidebar in Archives?', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_remove_sidebar_in_archives',
		'section'	=>	'prime2g_theme_archives_section'
	) );
#	@since 1.0.55 end

	/**
	 *	POSTS HOME TITLE
	 */
	$siteTitle	=	get_bloginfo( 'name' );
	$wp_customize->add_setting( 'prime2g_posts_home_title',
	[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'default' => $siteTitle, 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control( 'prime2g_posts_home_title', array(
		'label'		=>	__( 'Posts Homepage Title', PRIME2G_TEXTDOM ),
		'type'		=>	'text',
		'settings'	=>	'prime2g_posts_home_title',
		'section'	=>	'prime2g_theme_archives_section',
		'input_attrs'	=>	array(
			'placeholder'	=>	$siteTitle
		),
		'active_callback'	=>	'is_home'
	) );

	$wp_customize->add_setting( 'prime2g_posts_home_description', array(
	'type' => 'theme_mod', 'default' => 'Posts Homepage',
	'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'prime2g_posts_home_description', array(
		'label'		=>	__( 'Posts Homepage Description', PRIME2G_TEXTDOM ),
		'type'		=>	'text',
		'settings'	=>	'prime2g_posts_home_description',
		'section'	=>	'prime2g_theme_archives_section',
		'input_attrs'	=>	array( 'placeholder' => 'Posts Homepage' ),
		'active_callback'	=>	'is_home'
	) );

	/* @since 1.0.55 */
	$wp_customize->add_setting( 'prime2g_archive_post_columns_num', $simple_text );
	$wp_customize->add_control( 'prime2g_archive_post_columns_num', array(
		'label'		=>	__( 'Archive Post Columns', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_archive_post_columns_num',
		'section'	=>	'prime2g_theme_archives_section',
		'choices'	=>	[
			''		=>	'1',
			'grid2'	=>	'2',
			'grid3'	=>	'3',
			'grid4'	=>	'4',
			'grid5'	=>	'5',
			'grid6'	=>	'6'
		],
	) );

/* @since 1.0.94 */
if ( prime_child_min_version( '2.4' ) ) {
	$wp_customize->add_setting( 'prime2g_archive_masonry_layout', $simple_text );
	$wp_customize->add_control( 'prime2g_archive_masonry_layout', array(
		'label'		=>	__( 'Use Masonry Layout', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_archive_masonry_layout',
		'section'	=>	'prime2g_theme_archives_section'
	) );
}

	$wp_customize->add_setting( 'prime2g_archive_pagination_type', $simple_text );
	$wp_customize->add_control( 'prime2g_archive_pagination_type', array(
		'label'		=>	__( 'Pagination Type', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_archive_pagination_type',
		'section'	=>	'prime2g_theme_archives_section',
		'choices'	=>	[
			''		=>	'Previous/Next',
			'numbers'	=>	'Numbers'
		],
	) );

	$wp_customize->add_setting( 'prime2g_loop_post_image_height', array(
		'type' => 'theme_mod', 'transport' => 'postMessage',
		'default' => '17', 'sanitize_callback' => 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'prime2g_loop_post_image_height', array(
		'label'		=>	__( 'Post Featured Image Height', PRIME2G_TEXTDOM ),
		'type'		=>	'number',
		'settings'	=>	'prime2g_loop_post_image_height',
		'section'	=>	'prime2g_theme_archives_section',
		'input_attrs'	=>	array(
			'min'		=>	'5',
			'max'		=>	'50'
		)
	) );
#	@since 1.0.55 end

	/**
	 *	HEADER STICKY POSTS
	 */
function p2_show_stky() { return ! empty( get_theme_mod( 'prime2g_theme_show_stickies' ) ); }

	$wp_customize->add_setting( 'prime2g_theme_show_stickies', $simple_text );
	$wp_customize->add_control( 'prime2g_theme_show_stickies', array(
		'label'		=>	__( 'Show Sticky Posts at the Top of Archives?', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_theme_show_stickies',
		'section'	=>	'prime2g_theme_archives_section'
	) );

	$wp_customize->add_setting( 'prime2g_theme_sticky_heading',
	array( 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control( 'prime2g_theme_sticky_heading', array(
		'label'		=>	__( 'Sticky Posts Heading', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_theme_sticky_heading',
		'section'	=>	'prime2g_theme_archives_section',
		'input_attrs'	=>	array( 'placeholder' => 'Featured Posts' ),
		'active_callback'	=>	'p2_show_stky'
	) );

	/**
	 *	STICKY POSTS' POST TYPE & COUNT
	 *	@since 1.0.51
	 */
	$wp_customize->add_setting( 'prime2g_theme_stickies_post_type',
	[ 'type' => 'theme_mod', 'default' => 'post', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control( 'prime2g_theme_stickies_post_type', array(
		'label'		=>	__( 'Stickies\' Post Type', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_theme_stickies_post_type',
		'section'	=>	'prime2g_theme_archives_section',
		'choices'	=>	prime2g_posttypes_names_array(),
		'active_callback'	=>	'p2_show_stky'
	) );

	$wp_customize->add_setting( 'prime2g_theme_stickies_count',
	[ 'type' => 'theme_mod', 'default' => '4', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control( 'prime2g_theme_stickies_count', array(
		'label'		=>	__( 'How many Stickies?', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_theme_stickies_count',
		'section'	=>	'prime2g_theme_archives_section',
		'choices'	=>	[
			'2'	=>	'2', '3'	=>	'3',
			'4'	=>	'4', '5'	=>	'5',
			'6'	=>	'6', '8'	=>	'8',
			'9'	=>	'9', '10'	=>	'10',
			'12'=>	'12', '15'	=>	'15',
			'16'=>	'16', '20'	=>	'20',
			'24'=>	'24', '25'	=>	'25'
		],
		'active_callback'	=>	'p2_show_stky'
	) );

}

}


