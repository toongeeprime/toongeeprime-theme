<?php defined( 'ABSPATH' ) || exit;

/**
 *	Singular Entries
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

if ( ! function_exists( 'prime2g_customizer_singular_entries' ) ) {

function prime2g_customizer_singular_entries( $wp_customize ) {

$simple_text	=	[ 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' ];

	$wp_customize->add_setting( 'prime2g_remove_sidebar_in_singular', $simple_text );
	$wp_customize->add_control( 'prime2g_remove_sidebar_in_singular', array(
		'label'		=>	__( 'Remove Sidebar in Single Entries', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_remove_sidebar_in_singular',
		'section'	=>	'prime2g_singular_entries_section',
		'choices'	=>	array(
			''		=>	__( 'Keep Sidebar', PRIME2G_TEXTDOM ),
			'posts'	=>	__( 'Remove but Exclude Pages', PRIME2G_TEXTDOM ),
			'and_pages'	=>	__( 'Also Remove in Pages', PRIME2G_TEXTDOM ),
			'pages_only'=>	__( 'Remove in "Pages Only"', PRIME2G_TEXTDOM )
		)
	) );

	$wp_customize->add_setting( 'prime2g_entry_byline_usage', $simple_text );
	$wp_customize->add_control( 'prime2g_entry_byline_usage', array(
		'label'		=>	__( 'Bylines', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_entry_byline_usage',
		'section'	=>	'prime2g_singular_entries_section',
		'choices'	=>	array(
			''		=>	__( 'Author and Date', PRIME2G_TEXTDOM ),
			'author_only'	=>	__( 'Author Only', PRIME2G_TEXTDOM ),
			'date_only'		=>	__( 'Date Only', PRIME2G_TEXTDOM ),
			'remove_byline'	=>	__( 'Remove Byline', PRIME2G_TEXTDOM )
		)
	) );

	$wp_customize->add_setting( 'prime2g_use_theme_css_js_custom_fields',
		[ 'type' => 'theme_mod', 'default' => 0, 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control( 'prime2g_use_theme_css_js_custom_fields', array(
		'label'		=>	__( 'Use Legacy CSS Field', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_use_theme_css_js_custom_fields',
		'section'	=>	'prime2g_singular_entries_section'
	) );

}

}
