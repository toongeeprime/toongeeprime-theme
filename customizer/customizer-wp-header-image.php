<?php defined( 'ABSPATH' ) || exit;
/**
 *	Edits @ WP's Customizer Header Section
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( !function_exists( 'prime2g_customizer_wp_header_image' ) ) {
function prime2g_customizer_wp_header_image( $wp_customize ) {

$simple_text	=	[ 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' ];
$postMsg_text	=	[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ];

/**
 *	WP Header Video Settings Filter
 *	@since 1.0.55
 */
	$wp_customize->add_setting( 'prime2g_video_header_placements',  array_merge( $simple_text, [ 'default' => 'is_front_page' ] ) );
	$wp_customize->add_control( 'prime2g_video_header_placements', array(
		'type'		=>	'select',
		'label'		=>	__( 'Video Header Placement', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_video_header_placements',
		'section'	=>	'header_image',
		'active_callback'	=>	'prime2g_video_features_active',
		'choices'	=>	array(
			'is_front_page'=>	__( 'Front Page Only', PRIME2G_TEXTDOM ),
			'is_archive'	=>	__( 'Archives Only', PRIME2G_TEXTDOM ),
			'prime2g_video_header_front_and_archives'	=>	__( 'Front Page &amp; Archives', PRIME2G_TEXTDOM ),
			'is_singular'	=>	__( 'All Single Entries', PRIME2G_TEXTDOM ),
			''	=>	__( 'Show Sitewide', PRIME2G_TEXTDOM )
		)
	) );

if ( prime_child_min_version( '2.1' ) ) {
	/**
	 *	Page Title Over Header Video
	 *	@since 1.0.55
	 */
	$wp_customize->add_setting( 'prime2g_pagetitle_over_headervideo', $simple_text );
	$wp_customize->add_control( 'prime2g_pagetitle_over_headervideo', array(
		'label'		=>	__( 'Show Page Title Over Header Video', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_pagetitle_over_headervideo',
		'section'	=>	'header_image',
		'active_callback'	=>	'prime2g_video_features_active'
	) );

	/*	@since 1.0.87	*/
	$wp_customize->add_setting( 'prime2g_autoplay_header_video', $simple_text );
	$wp_customize->add_control( 'prime2g_autoplay_header_video', array(
		'label'		=>	__( 'Autoplay the set Header Video "Muted"', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_autoplay_header_video',
		'section'	=>	'header_image',
		'active_callback'	=>	'prime2g_video_features_active'
	) );
}

	/**
	 *	Replace Header Image with Post Thumbnail
	 */
	$wp_customize->add_setting( 'prime2g_thumb_replace_header', $simple_text );
	$wp_customize->add_control( 'prime2g_thumb_replace_header', array(
		'label'		=>	__( 'Replace Header Image', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_thumb_replace_header',
		'section'	=>	'header_image',
		'choices'	=>	array(
			''	=>	__( 'Replace Image with Post Thumbnail', PRIME2G_TEXTDOM ),
			'retain'	=>	__( 'Retain Header Image', PRIME2G_TEXTDOM )
		),
		'active_callback'	=>	'has_header_image',
	) );

	/**
	 *	Header Image Attachment
	 */
	$wp_customize->add_setting( 'prime2g_header_img_attachment', array_merge( $postMsg_text, [ 'default' => 'scroll' ] ) );
	$wp_customize->add_control( 'prime2g_header_img_attachment', array(
		'label'		=>	__( 'Scroll or Fix Header Image', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_header_img_attachment',
		'section'	=>	'header_image',
		'choices'	=>	array(
			'scroll'=>	__( 'Scroll Header Image', PRIME2G_TEXTDOM ),
			'fixed'	=>	__( 'Fix Header Image', PRIME2G_TEXTDOM )
		),
		'active_callback'	=>	'has_header_image'
	) );

	/**
	 *	Header Image Background Size
	 */
	$wp_customize->add_setting( 'prime2g_header_background_size', $postMsg_text );
	$wp_customize->add_control( 'prime2g_header_background_size', array(
		'label'		=>	__( 'Header Image Size', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_header_background_size',
		'section'	=>	'header_image',
		'choices'	=>	array(
			''	=>	__( 'Cover Header Space', PRIME2G_TEXTDOM ),
			'contain'	=>	__( 'Contain In Header', PRIME2G_TEXTDOM ),
			'initial'	=>	__( 'Initial Image Size', PRIME2G_TEXTDOM )
		),
		'active_callback'	=>	'has_header_image'
	) );

	/**
	 *	Header Height
	 *	@since 1.0.55
	 */
	$wp_customize->add_setting( 'prime2g_theme_header_height', array_merge( $postMsg_text, [ 'default' => '50' ] ) );
	$wp_customize->add_control( 'prime2g_theme_header_height', array(
		'label'		=>	__( 'Header Height (VH)', PRIME2G_TEXTDOM ),
		'type'		=>	'number',
		'settings'	=>	'prime2g_theme_header_height',
		'section'	=>	'header_image',
		'input_attrs'	=>	[ 'min' => '5', 'max' => '150' ]
	) );
}
}


