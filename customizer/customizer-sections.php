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
/**
 *	@since ToongeePrime Theme 1.0.57
 */
$network	=	is_multisite();
$is_site1	=	( $network && get_current_blog_id() === 1 );

function p2g_on_stylx( $network ) {
return ! $network || prime2g_designing_at_networkhome() || $network && ! prime2g_design_by_network_home();
}


	$wp_customize->add_section( 'prime2g_theme_options_section', array(
		'title'		=>	__( 'Theme Options', PRIME2G_TEXTDOM ),
		'panel'		=>	'prime2g_customizer_panel',
		'description'	=>	__( 'Set Theme Options', PRIME2G_TEXTDOM ),
		'capability'	=>	'edit_theme_options',
		'active_callback'	=>	function() use( $network, $is_site1 ) {
		$homeOptions	=	prime2g_constant_is_true( 'PRIME2G_OPTIONS_BY_NETWORK_HOME' );
		return ! $network || $homeOptions && $is_site1 || $network && ! $homeOptions; }
	) );

	$wp_customize->add_section( 'prime2g_theme_colors_section',	# Renamed from styles_section @1.0.55
	array(
		'title'		=>	__( 'Theme Colors', PRIME2G_TEXTDOM ),
		'panel'		=>	'prime2g_customizer_panel',
		'description'	=>	__( 'Theme Colors Settings', PRIME2G_TEXTDOM ),
		'capability'	=>	'edit_theme_options',
		'active_callback'	=>	'p2g_on_stylx'
	) );

	/**
	 *	Theme Fonts
	 *	@since 1.0.55
	 */
	$wp_customize->add_section( 'prime2g_theme_fonts_section', array(
		'title'		=>	__( 'Theme Fonts', PRIME2G_TEXTDOM ),
		'panel'		=>	'prime2g_customizer_panel',
		'description'	=>	__( 'Theme Fonts Settings', PRIME2G_TEXTDOM ),
		'capability'	=>	'edit_theme_options',
		'active_callback'	=>	'p2g_on_stylx'
	) );

	$wp_customize->add_section( 'prime2g_theme_frontpage_section', array(
		'title'		=>	__( 'Front Page', PRIME2G_TEXTDOM ),
		'panel'		=>	'prime2g_customizer_panel',
		'description'	=>	__( 'Customize The Front Page', PRIME2G_TEXTDOM ),
		'capability'	=>	'edit_theme_options',
		'active_callback'	=>	'is_front_page'
	) );

	/**
	 *	Media Features
	 *	@since 1.0.55
	 */
	$wp_customize->add_section( 'prime2g_theme_menus_section', array(
		'title'		=>	__( 'Theme Menus', PRIME2G_TEXTDOM ),
		'panel'		=>	'prime2g_customizer_panel',
		'description'	=>	__( 'Menu Settings for the Theme', PRIME2G_TEXTDOM ),
		'capability'	=>	'edit_theme_options',
		'active_callback'	=>	function() use( $network, $is_site1 ) {
		$homeMenus	=	prime2g_constant_is_true( 'PRIME2G_MENUS_BY_NETWORK_HOME' );
		return ! $network || $homeMenus && $is_site1 || $network && ! $homeMenus; }
	) );

	$wp_customize->add_section( 'prime2g_theme_archives_section', array(
		'title'		=>	__( 'Posts Home &amp; Archives', PRIME2G_TEXTDOM ),
		'panel'		=>	'prime2g_customizer_panel',
		'description'	=>	__( 'Archives and Posts Homepage', PRIME2G_TEXTDOM ),
		'capability'	=>	'edit_theme_options',
		'active_callback'	=>	function() { return ( is_home() || is_archive() ); }
	) );

	$wp_customize->add_section( 'prime2g_singular_entries_section', array(
		'title'		=>	__( 'Singular Entries', PRIME2G_TEXTDOM ),
		'panel'		=>	'prime2g_customizer_panel',
		'description'	=>	__( 'Single posts, pages and other contents', PRIME2G_TEXTDOM ),
		'capability'	=>	'edit_theme_options',
		'active_callback'	=>	function() { return is_singular(); } # LEAVE AS IS
	) );

	$wp_customize->add_section( 'prime2g_socialmedia_links_section', array(
		'title'		=>	__( 'Social Media &amp; Contacts', PRIME2G_TEXTDOM ),
		'panel'		=>	'prime2g_customizer_panel',
		'description'	=>	__( 'Social media links and contact details', PRIME2G_TEXTDOM ),
		'capability'	=>	'edit_theme_options',
		'active_callback'	=>	function() use( $network, $is_site1 ) {
		$homeSocials	=	prime2g_constant_is_true( 'PRIME2G_SOCIALS_BY_NETWORK_HOME' );
		return ! $network || $homeSocials && $is_site1 || $network && ! $homeSocials; }
	) );

	/**
	 *	Media Features
	 *	@since 1.0.50
	 */
	$wp_customize->add_section( 'prime2g_media_features_section', array(
		'title'		=>	__( 'Media Features', PRIME2G_TEXTDOM ),
		'panel'		=>	'prime2g_customizer_panel',
		'description'	=>	__( 'Settings for Media Features', PRIME2G_TEXTDOM ),
		'capability'	=>	'edit_theme_options'
	) );

	/**
	 *	Progreesive Web App (PWA)
	 *	@since 1.0.55
	 */
	$wp_customize->add_section( 'prime2g_theme_pwa_section', array(
		'title'		=>	__( 'Web App', PRIME2G_TEXTDOM ),
		'panel'		=>	'prime2g_customizer_panel',
		'description'	=>	__( 'Theme\'s Web Application', PRIME2G_TEXTDOM ),
		'capability'	=>	'edit_theme_options',
		'active_callback'	=>	'prime2g_add_theme_pwa'
	) );

if ( prime2g_use_extras() ) {
	/**
	 *	Theme Extras
	 *	@since 1.0.48
	 */
	$wp_customize->add_section( 'prime2g_theme_extras_section', array(
		'title'		=>	__( 'Extra Features', PRIME2G_TEXTDOM ),
		'panel'		=>	'prime2g_customizer_panel',
		'description'	=>	__( 'Extra features for the theme', PRIME2G_TEXTDOM ),
		'capability'	=>	'edit_theme_options',
		'active_callback'	=>	function() use( $network, $is_site1 ) {
		$homeExtras	=	prime2g_constant_is_true( 'PRIME2G_EXTRAS_BY_NETWORK_HOME' );
		return ! $network || $homeExtras && $is_site1 || $network && ! $homeExtras; }
	) );

	/**
	 *	SMTP Mail Settings
	 *	@since 1.0.55
	 */
	$wp_customize->add_section( 'prime2g_theme_smtp_section', array(
		'title'		=>	__( 'SMTP Mail Settings', PRIME2G_TEXTDOM ),
		'panel'		=>	'prime2g_customizer_panel',
		'description'	=>	__( 'Configure SMTP Mailing Settings', PRIME2G_TEXTDOM ),
		'capability'	=>	'edit_theme_options'
	) );
}

if ( class_exists( 'woocommerce' ) ) {
	$wp_customize->add_section( 'prime2g_woocommerce_edits_section', array(
		'title'		=>	__( 'WooCommerce Customizations', PRIME2G_TEXTDOM ),
		'panel'		=>	'prime2g_customizer_panel',
		'description'	=>	__( 'Set WooCommerce Customizations', PRIME2G_TEXTDOM ),
		'capability'	=>	'edit_theme_options'
	) );
}

	/**
	 *	Site Settings
	 *	@since 1.0.48.50
	 */
	$wp_customize->add_section( 'prime2g_site_settings_section', array(
		'title'		=>	__( 'Site Settings/Status', PRIME2G_TEXTDOM ),
		'panel'		=>	'prime2g_customizer_panel',
		'description'	=>	__( 'Settings affecting your site', PRIME2G_TEXTDOM ),
		'capability'	=>	'edit_theme_options'
	) );

	/**
	 *	Site Performance
	 *	@since 1.0.59
	 */
	$wp_customize->add_section( 'prime2g_site_performance_section', array(
		'title'		=>	__( 'Site Performance', PRIME2G_TEXTDOM ),
		'panel'		=>	'prime2g_customizer_panel',
		'description'	=>	__( 'Site Performance Settings', PRIME2G_TEXTDOM ),
		'capability'	=>	'edit_theme_options',
		'active_callback'	=>	function() use( $network, $is_site1 ) {
		$homeOptions	=	prime2g_constant_is_true( 'PRIME2G_OPTIONS_BY_NETWORK_HOME' );
		return ! $network || $homeOptions && $is_site1 || $network && ! $homeOptions; }
	) );

}

}


