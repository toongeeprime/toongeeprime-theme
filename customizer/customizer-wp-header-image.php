<?php defined( 'ABSPATH' ) || exit;

/**
 *	Theme's Edits on WP's Customizer @ Header
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( ! function_exists( 'prime2g_customizer_wp_header_image' ) ) {

function prime2g_customizer_wp_header_image( $wp_customize ) {

/**
 *	WP Header Video Settings Filter
 *	@since ToongeePrime Theme 1.0.55
 */
	$wp_customize->add_setting(
		'prime2g_video_header_placements',
		[ 'type' => 'theme_mod', 'default' => 'is_front_page', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control(
		'prime2g_video_header_placements',
		array(
			'type'		=>	'select',
			'label'		=>	__( 'Video Header Placement (Overlap Image) - May need Customizer refresh', PRIME2G_TEXTDOM ),
			'settings'	=>	'prime2g_video_header_placements',
			'section'	=>	'header_image',
			'active_callback'	=>	'prime2g_video_features_active',
			'choices'	=>	array(
				'is_front_page'=>	__( 'Front Page Only', PRIME2G_TEXTDOM ),
				'is_archive'	=>	__( 'Archives Only', PRIME2G_TEXTDOM ),
				'prime2g_video_header_front_and_archives'	=>	__( 'Front Page &amp; Archives', PRIME2G_TEXTDOM ),
				'is_singular'	=>	__( 'All Single Entries', PRIME2G_TEXTDOM ),
				''	=>	__( 'Show Sitewide', PRIME2G_TEXTDOM ),
			),
		)
	);

if ( defined( 'CHILD2G_VERSION' ) && CHILD2G_VERSION >= '2.1' ) {

	/**
	 *	Page Title Over Header Video
	 *	@since ToongeePrime Theme 1.0.55
	 */
	$wp_customize->add_setting(
		'prime2g_pagetitle_over_headervideo',
		array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control(
		'prime2g_pagetitle_over_headervideo',
		array(
			'label'		=>	__( 'Show Page Title Over Header Video', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_pagetitle_over_headervideo',
			'section'	=>	'header_image',
			'active_callback'	=>	'prime2g_video_features_active'
		)
	);

}

	/**
	 *	Replace Header Image with Post Thumbnail
	 */
	$wp_customize->add_setting(
		'prime2g_thumb_replace_header',
		array( 'type' => 'theme_mod', 'default' => '', 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control(
		'prime2g_thumb_replace_header',
		array(
			'label'		=>	__( 'Replace Header Image', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_thumb_replace_header',
			'section'	=>	'header_image',
			'choices'	=>	array(
				''	=>	__( 'Replace Image with Post Thumbnail', PRIME2G_TEXTDOM ),
				'retain'	=>	__( 'Retain Header Image', PRIME2G_TEXTDOM )
			),
			'active_callback'	=>	'has_header_image',
		)
	);

	/**
	 *	Header Image Attachment
	 */
	$wp_customize->add_setting(
		'prime2g_header_img_attachment',
		[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'default' => 'scroll', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control(
		'prime2g_header_img_attachment',
		array(
			'label'		=>	__( 'Scroll or Fix Header Image', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_header_img_attachment',
			'section'	=>	'header_image',
			'choices'	=>	array(
				'scroll'		=>	__( 'Scroll Header Image', PRIME2G_TEXTDOM ),
				'fixed'	=>	__( 'Fix Header Image', PRIME2G_TEXTDOM )
			),
			'active_callback'	=>	'has_header_image',
		)
	);

	/**
	 *	Header Image Background Size
	 */
	$wp_customize->add_setting(
		'prime2g_header_background_size',
		array( 'type' => 'theme_mod', 'transport' => 'postMessage', 'default' => '', 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control(
		'prime2g_header_background_size',
		array(
			'label'		=>	__( 'Header Image Size', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_header_background_size',
			'section'	=>	'header_image',
			'choices'	=>	array(
				''	=>	__( 'Cover Header Space', PRIME2G_TEXTDOM ),
				'contain'	=>	__( 'Contain In Header', PRIME2G_TEXTDOM ),
				'initial'	=>	__( 'Initial Image Size', PRIME2G_TEXTDOM )
			),
			'active_callback'	=>	'has_header_image',
		)
	);

	/**
	 *	Header Height
	 *	@since ToongeePrime Theme 1.0.55
	 */
	$wp_customize->add_setting(
		'prime2g_theme_header_height',
		array( 'type' => 'theme_mod', 'transport' => 'postMessage', 'default' => '50', 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control(
		'prime2g_theme_header_height',
		array(
			'label'		=>	__( 'Header Height (VH)', PRIME2G_TEXTDOM ),
			'type'		=>	'number',
			'settings'	=>	'prime2g_theme_header_height',
			'section'	=>	'header_image',
			'input_attrs'	=>	array(
				'min'		=>	'5',
				'max'		=>	'150'
			),
		)
	);
}

}

