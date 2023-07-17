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
			'type'		=>	'theme_mod',
			'transport'	=>	'postMessage',
			'default'	=>	__( 'Welcome to ' . $siteTitle, PRIME2G_TEXTDOM ),
			'sanitize_callback'	=>	'sanitize_text_field'
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
			'active_callback'	=>	function() { return ( is_front_page() && ! is_home() ); },
		)
	);


	/**
	 *	HOMEPAGE HEADLINES
	 */
	$wp_customize->add_setting(
		'prime2g_theme_show_headlines',
		[ 'type'	=>	'theme_mod', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control(
		'prime2g_theme_show_headlines',
		array(
			'label'		=>	__( 'Show Headlines Section?', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_theme_show_headlines',
			'section'	=>	'prime2g_theme_archives_section',
			'choices'	=>	array(
				'show'	=>	__( 'Yes', PRIME2G_TEXTDOM ),
			),
			'active_callback'	=>	'is_home',
		)
	);

	$wp_customize->add_setting(
		'prime2g_headlines_category',
		[ 'type' => 'theme_mod', 'default' => '1', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control(
		'prime2g_headlines_category',
		array(
			'label'		=>	__( 'Headlines Category', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_headlines_category',
			'section'	=>	'prime2g_theme_archives_section',
			'choices'	=>	prime2g_categs_and_ids_array(),
			'active_callback'	=>	'is_home',
		)
	);

}

}
