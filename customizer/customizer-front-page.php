<?php defined( 'ABSPATH' ) || exit;

/**
 *	Customizer for Theme Archives
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.41.00
 */

if ( ! function_exists( 'prime2g_customizer_front_page' ) ) {

function prime2g_customizer_front_page( $wp_customize ) {

	/**
	 *	POSTS HOME TITLE
	 */
	$siteTitle	=	get_bloginfo( 'name' );
	$wp_customize->add_setting(
		'prime2g_front_page_title',
		array(
			'type'				=>	'theme_mod',
			'transport'			=>	'refresh',
			'default'			=>	__( 'Welcome to ' . $siteTitle, PRIME2G_TEXTDOM ),
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'prime2g_front_page_title',
		array(
			'label'		=>	__( 'Front Page Title', PRIME2G_TEXTDOM ),
			'type'		=>	'text',
			'settings'	=>	'prime2g_front_page_title',
			'section'	=>	'prime2g_theme_frontpage_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	__( 'Welcome to ' . $siteTitle, PRIME2G_TEXTDOM ),
			),
			'active_callback'	=>	'is_front_page',
		)
	);

}

}