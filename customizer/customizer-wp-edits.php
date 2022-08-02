<?php defined( 'ABSPATH' ) || exit;

/**
 *	Theme's Edits on WP's Customizer Options
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( ! function_exists( 'prime2g_customizer_wp_edits' ) ) {

function prime2g_customizer_wp_edits( $wp_customize ) {

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
			'label'		=>	__( 'Replace Header Image', 'toongeeprime-theme' ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_thumb_replace_header',
			'section'	=>	'header_image',
			'choices'	=>	array(
				''	=>	__( 'Replace Image with Post Thumbnail', 'toongeeprime-theme' ),
				'retain'	=>	__( 'Retain Header Image', 'toongeeprime-theme' )
			),
		)
	);

}

}

