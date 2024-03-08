<?php defined( 'ABSPATH' ) || exit;

/**
 *	Customizer Advanced Options & Settings
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.70
 */
if ( ! function_exists( 'prime2g_customizer_advanced_settings' ) ) {

add_action( 'wp_head', function() { echo get_theme_mod( 'prime2g_insert_into_html_head' ); } );
add_action( 'wp_body_open', function() { echo get_theme_mod( 'prime2g_insert_into_html_body_open' ); } );
add_action( 'wp_footer', function() { echo get_theme_mod( 'prime2g_insert_into_html_body_close' ); } );

function prime2g_customizer_advanced_settings( $wp_customize ) {

function prime_c_a_s_sanitizer( $text ) {
return wp_kses( $text, array( 
// 'a'		=>	array(
	// 'href'	=>	true,	// array/bool
	// 'title'	=>	[]
// ),
	// 'meta'	=>	[], // ??
	'link'	=>	[
		'href' => [], 'type' => [], 'rel' => []
	],
	'style'	=>	[
		'id' => [], 'src' => [], 'media' => [], 'title' => []
	],
	'script'=>	[
	'id' => [], 'type' => [], 'async' => [], 'defer' => [], 'src' => [], 'crossorigin' => [], 'integrity' => [], 'referrerpolicy' => []
	]
) );
}

$postMsg_text	=	[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'prime_c_a_s_sanitizer' ];

	/**
	 *	ADD SCRIPTS TO THEME
	 *	@since 1.0.70
	 */
	$wp_customize->add_setting( 'prime2g_insert_into_html_head', $postMsg_text );	# @hook wp_head
	$wp_customize->add_control( 'prime2g_insert_into_html_head', array(
		'label'		=>	__( 'Insert into Webpage <head>', PRIME2G_TEXTDOM ),
		'type'		=>	'textarea',
		'settings'	=>	'prime2g_insert_into_html_head',
		'section'	=>	'prime2g_site_advanced_section',
		'input_attrs'	=>	[ 'placeholder' => 'Add text/code' ]
	) );

	$wp_customize->add_setting( 'prime2g_insert_into_html_body_open', $postMsg_text );	# @hook wp_body_open
	$wp_customize->add_control( 'prime2g_insert_into_html_body_open', array(
		'label'		=>	__( 'Insert into Webpage <body> Open', PRIME2G_TEXTDOM ),
		'type'		=>	'textarea',
		'settings'	=>	'prime2g_insert_into_html_body_open',
		'section'	=>	'prime2g_site_advanced_section',
		'input_attrs'	=>	[ 'placeholder' => 'Add text/code' ]
	) );

	$wp_customize->add_setting( 'prime2g_insert_into_html_body_close', $postMsg_text );	# @hook wp_footer
	$wp_customize->add_control( 'prime2g_insert_into_html_body_close', array(
		'label'		=>	__( 'Insert into Webpage <body> Close', PRIME2G_TEXTDOM ),
		'type'		=>	'textarea',
		'settings'	=>	'prime2g_insert_into_html_body_close',
		'section'	=>	'prime2g_site_advanced_section',
		'input_attrs'	=>	[ 'placeholder' => 'Add text/code' ]
	) );

}
}




