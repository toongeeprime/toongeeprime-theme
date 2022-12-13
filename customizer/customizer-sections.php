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
			'title'			=>	__( 'Theme Options', PRIME2G_TEXTDOM ),
			'panel'			=>	'prime2g_customizer_panel',
			'description'	=>	__( 'Set Theme Options', PRIME2G_TEXTDOM ),
			'capability'	=>	'edit_theme_options',
		)
	);

	$wp_customize->add_section(
		'prime2g_theme_styles_section',
		array(
			'title'			=>	__( 'Theme Styles', PRIME2G_TEXTDOM ),
			'panel'			=>	'prime2g_customizer_panel',
			'description'	=>	__( 'Colors &amp; Fonts', PRIME2G_TEXTDOM ),
			'capability'	=>	'edit_theme_options',
		)
	);

	$wp_customize->add_section(
		'prime2g_theme_frontpage_section',
		array(
			'title'			=>	__( 'Front Page', PRIME2G_TEXTDOM ),
			'panel'			=>	'prime2g_customizer_panel',
			'description'	=>	__( 'Customize The Front Page', PRIME2G_TEXTDOM ),
			'capability'	=>	'edit_theme_options',
			'active_callback'	=>	'is_front_page',
		)
	);

	$wp_customize->add_section(
		'prime2g_theme_archives_section',
		array(
			'title'			=>	__( 'Posts Home &amp; Archives', PRIME2G_TEXTDOM ),
			'panel'			=>	'prime2g_customizer_panel',
			'description'	=>	__( 'Archives and Posts Homepage', PRIME2G_TEXTDOM ),
			'capability'	=>	'edit_theme_options',
			'active_callback'	=>	function(){ return ( is_home() || is_archive() ); },
		)
	);

	$wp_customize->add_section(
		'prime2g_socialmedia_links_section',
		array(
			'title'			=>	__( 'Social Media &amp; Contacts', PRIME2G_TEXTDOM ),
			'panel'			=>	'prime2g_customizer_panel',
			'description'	=>	__( 'Social media links and contact details', PRIME2G_TEXTDOM ),
			'capability'	=>	'edit_theme_options',
		)
	);


	/**
	 *	Theme Extras
	 *	@since ToongeePrime Theme 1.0.48.00
	 */
	$wp_customize->add_section(
		'prime2g_theme_extras_section',
		array(
			'title'			=>	__( 'Extra Features', PRIME2G_TEXTDOM ),
			'panel'			=>	'prime2g_customizer_panel',
			'description'	=>	__( 'Extra features for the theme', PRIME2G_TEXTDOM ),
			'capability'	=>	'edit_theme_options',
			'active_callback'	=>	'prime2g_use_extras',
		)
	);


	/**
	 *	Site Settings
	 *	@since ToongeePrime Theme 1.0.48.50
	 */
	$wp_customize->add_section(
		'prime2g_site_settings_section',
		array(
			'title'			=>	__( 'Site Settings', PRIME2G_TEXTDOM ),
			'panel'			=>	'prime2g_customizer_panel',
			'description'	=>	__( 'Settings affecting your site', PRIME2G_TEXTDOM ),
			'capability'	=>	'edit_theme_options',
		)
	);


if ( class_exists( 'woocommerce' ) ) {
	$wp_customize->add_section(
		'prime2g_woocommerce_edits_section',
		array(
			'title'			=>	__( 'WooCommerce Customizations', PRIME2G_TEXTDOM ),
			'panel'			=>	'prime2g_customizer_panel',
			'description'	=>	__( 'Set WooCommerce Customizations', PRIME2G_TEXTDOM ),
			'capability'	=>	'edit_theme_options',
		)
	);
}

}

}

