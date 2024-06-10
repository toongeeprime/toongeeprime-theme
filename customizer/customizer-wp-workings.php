<?php defined( 'ABSPATH' ) || exit;

/**
 *	Theme's Edits on WP's Customizer Options
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

if ( ! function_exists( 'prime2g_customizer_misc_wp_settings' ) ) {

function prime2g_customizer_misc_wp_settings( $wp_customize ) {

$simple_text=	[ 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' ];

/**
 *	Dark Theme Logo
 */
if ( prime2g_use_extras() ) {
	$wp_customize->add_setting( 'prime2g_dark_theme_logo', $simple_text );
	$wp_customize->add_control( new WP_Customize_Media_Control(
	$wp_customize, 'prime2g_dark_theme_logo', array(
		'label'		=>	__( 'Dark Theme Logo', PRIME2G_TEXTDOM ),
		'description'=>	__( 'Logo when theme is switched to dark mode', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_dark_theme_logo',
		'section'	=>	'title_tagline',
		'mime_type' =>	'image'
	) ) );
}

	/**
	 *	LOGO HEIGHT
	 */
	$wp_customize->add_setting( 'prime2g_theme_logo_height',
		[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'default' => '100', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control( 'prime2g_theme_logo_height', array(
		'label'		=>	__( 'Logo Height (px)', PRIME2G_TEXTDOM ),
		'type'		=>	'number',
		'settings'	=>	'prime2g_theme_logo_height',
		'section'	=>	'title_tagline',
		'input_attrs'	=>	[ 'min' => '20', 'max' => '300' ]
	) );
}

}


