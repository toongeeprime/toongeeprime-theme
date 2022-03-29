<?php defined( 'ABSPATH' ) || exit;

/**
 *	Theme's Customizer Sections
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	ToongeePrime Theme Customizer Sections
 */
if ( ! function_exists( 'prime2g_customizer_sections' ) ) {

function prime2g_customizer_sections( $wp_customize ) {

	$wp_customize->add_section(
		'prime2g_theme_options_section',
		array(
			'title'			=>	__( 'Theme Options', 'toongeeprime-theme' ),
			'panel'			=>	'prime2g_customizer_panel',
			'description'	=>	__( 'Set theme options', 'toongeeprime-theme' ),
			'capability'	=>	'edit_theme_options',
		)
	);

	$wp_customize->add_section(
		'prime2g_theme_styles_section',
		array(
			'title'			=>	__( 'Theme Styles', 'toongeeprime-theme' ),
			'panel'			=>	'prime2g_customizer_panel',
			'description'	=>	__( 'Colors &amp; Fonts', 'toongeeprime-theme' ),
			'capability'	=>	'edit_theme_options',
		)
	);

	$wp_customize->add_section(
		'prime2g_theme_archives_section',
		array(
			'title'			=>	__( 'Posts Home &amp; Archives', 'toongeeprime-theme' ),
			'panel'			=>	'prime2g_customizer_panel',
			'description'	=>	__( 'Theme Archives and Posts Homepage', 'toongeeprime-theme' ),
			'capability'	=>	'edit_theme_options',
			'active_callback'	=>	function(){ return ( is_home() || is_archive() ); },
		)
	);

	$wp_customize->add_section(
		'prime2g_socialmedia_links_section',
		array(
			'title'			=>	__( 'Social Media &amp; Contacts', 'toongeeprime-theme' ),
			'panel'			=>	'prime2g_customizer_panel',
			'description'	=>	__( 'Add social media links and contact details', 'toongeeprime-theme' ),
			'capability'	=>	'edit_theme_options',
		)
	);



if ( class_exists( 'woocommerce' ) ) {
	$wp_customize->add_section(
		'prime2g_woocommerce_edits_section',
		array(
			'title'			=>	__( 'WooCommerce Customizations', 'toongeeprime-theme' ),
			'panel'			=>	'prime2g_customizer_panel',
			'description'	=>	__( 'Set WooCommerce Customizations', 'toongeeprime-theme' ),
			'capability'	=>	'edit_theme_options',
		)
	);
}


}

}


