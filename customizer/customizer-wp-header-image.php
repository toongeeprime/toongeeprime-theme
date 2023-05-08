<?php defined( 'ABSPATH' ) || exit;

/**
 *	Theme's Edits on WP's Customizer Options
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( ! function_exists( 'prime2g_customizer_wp_header_image' ) ) {

function prime2g_customizer_wp_header_image( $wp_customize ) {

	/**
	 *	Replace Header Image with Post Thumbnail
	 */
	$wp_customize->add_setting(
		'prime2g_thumb_replace_header',
		array(
			'type'		=>	'theme_mod',
			'default'	=>	'',
		)
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
		array(
			'type'		=>	'theme_mod',
			'transport'	=>	'postMessage',
			'default'	=>	'scroll',
		)
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
		array(
			'type'		=>	'theme_mod',
			'transport'	=>	'postMessage',
			'default'	=>	'',
		)
	);
	$wp_customize->add_control(
		'prime2g_header_background_size',
		array(
			'label'		=>	__( 'Header Background Image Size', PRIME2G_TEXTDOM ),
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
		array(
			'type'		=>	'theme_mod',
			'transport'	=>	'postMessage',
			'default'	=>	'10',
		)
	);
	$wp_customize->add_control(
		'prime2g_theme_header_height',
		array(
			'label'		=>	__( 'Header Height (VH)', PRIME2G_TEXTDOM ),
			'type'		=>	'number',
			'settings'	=>	'prime2g_theme_header_height',
			'section'	=>	'header_image',
			'input_attrs'	=>	array(
				'min'		=>	'10',
				'max'		=>	'100',
			),
		)
	);

}

}


