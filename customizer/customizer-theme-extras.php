<?php defined( 'ABSPATH' ) || exit;
/**
 *	Extra Theme Features for Customizer
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.48
 */

if ( ! function_exists( 'prime2g_customizer_theme_extras' ) ) {
function prime2g_customizer_theme_extras( $wp_customize ) {

$get	=	[ 'index' => 'ID', 'value' => 'post_title', 'emptyoption' => true ];
$args	=	[ 'post_type' => 'page', 'posts_per_page' => -1, 'post_status' => 'publish' ];
$option	=	[ 'cache_name' => 'getpages', 'get' => 'posts' ];
$pages	=	prime2g_get_postsdata_array( $get, $args, $option );

$postMsg_text	=	[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ];

	/**
	 *	PAGE PRELOADER
	 */
	$wp_customize->add_setting( 'prime2g_use_page_preloader',
		array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control( 'prime2g_use_page_preloader', array(
		'label'		=>	__( 'Page Preloader', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_use_page_preloader',
		'section'	=>	'prime2g_theme_extras_section',
		'choices'	=>	array(
			''		=>	__( 'Preloader Off', PRIME2G_TEXTDOM ),
			'on'	=>	__( 'Preloader On', PRIME2G_TEXTDOM ),
			'use_logo'	=>	__( 'Preloader On: Use Site Logo', PRIME2G_TEXTDOM ),
			'use_icon'	=>	__( 'Preloader On: Use Site Icon', PRIME2G_TEXTDOM ),
			'custom_url'	=>	__( 'Preloader On: Custom Image URL', PRIME2G_TEXTDOM ),	# @ 1.0.55
		)
	) );

	/**
	 *	@since ToongeePrime Theme 1.0.55
	 */
	$wp_customize->add_setting( 'prime2g_custom_preloader_img_url',
		[ 'type' => 'theme_mod', 'sanitize_callback' => 'esc_url' ]
	);
	$wp_customize->add_control( 'prime2g_custom_preloader_img_url', array(
		'label'		=>	__( 'Custom Preloader Image URL', PRIME2G_TEXTDOM ),
		'type'		=>	'url',
		'settings'	=>	'prime2g_custom_preloader_img_url',
		'section'	=>	'prime2g_theme_extras_section',
		'active_callback'	=>	function() { return ( 'custom_url' === get_theme_mod( 'prime2g_use_page_preloader' ) ); },
		'input_attrs'	=>	array(
			'placeholder'	=>	get_home_url() . '/preloader-image.gif',
		)
	) );

	/**
	 *	DARK THEME SWITCH
	 *	@since ToongeePrime Theme 1.0.49
	 */
	$wp_customize->add_setting( 'prime2g_dark_theme_switch',
		array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control( 'prime2g_dark_theme_switch', array(
		'label'		=>	__( 'Dark Theme Switch', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_dark_theme_switch',
		'section'	=>	'prime2g_theme_extras_section',
		'choices'	=>	array(
			''		=>	__( 'Off', PRIME2G_TEXTDOM ),
			'on'	=>	__( 'Activate Switch', PRIME2G_TEXTDOM ),
			'on_dbody'	=>	__( 'Activate - Ensure Dark Body', PRIME2G_TEXTDOM ),
		)
	) );

if ( prime_child_min_version( '2.3' ) ) {
	/**
	 *	404 ERROR PAGE
	 *	@since @ 1.0.55
	 */
	$wp_customize->add_setting( 'prime2g_use_page_for404', $postMsg_text );
	$wp_customize->add_control( 'prime2g_use_page_for404', array(
		'label'		=>	__( 'Use Custom 404 Error Page', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_use_page_for404',
		'section'	=>	'prime2g_theme_extras_section'
	) );

	$wp_customize->add_setting( 'prime2g_404error_page_id', $postMsg_text );
	$wp_customize->add_control( 'prime2g_404error_page_id', array(
		'label'		=>	__( 'Select 404 Error Page', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_404error_page_id',
		'section'	=>	'prime2g_theme_extras_section',
		'choices'	=>	$pages,
		'active_callback'	=> function() { return ! empty( get_theme_mod( 'prime2g_use_page_for404' ) ); }
	) );

	/**
	 *	LOGIN PAGE
	 *	@since @ 1.0.73
	 */
	function p2g_useCLogin() { return ! empty( get_theme_mod( 'prime2g_use_custom_login_page' ) ); }

	$wp_customize->add_setting( 'prime2g_use_custom_login_page', $postMsg_text );
	$wp_customize->add_control( 'prime2g_use_custom_login_page', array(
		'label'		=>	__( 'Use Custom Login Page', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_use_custom_login_page',
		'section'	=>	'prime2g_theme_extras_section'
	) );

	$wp_customize->add_setting( 'prime2g_custom_login_page_id', $postMsg_text );
	$wp_customize->add_control( 'prime2g_custom_login_page_id', array(
		'label'		=>	__( 'Select Custom Login Page "Content"', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_custom_login_page_id',
		'section'	=>	'prime2g_theme_extras_section',
		'choices'	=>	$pages,
		'active_callback'	=> 'p2g_useCLogin'
	) );

	$wp_customize->add_setting( 'prime2g_wp_login_page_slug', $postMsg_text );
	$wp_customize->add_control( 'prime2g_wp_login_page_slug', array(
		'label'		=>	__( 'Custom Login Page Slug', PRIME2G_TEXTDOM ),
		'type'		=>	'text',
		'settings'	=>	'prime2g_wp_login_page_slug',
		'section'	=>	'prime2g_theme_extras_section',
		'active_callback'	=> 'p2g_useCLogin',
		'input_attrs'	=>	[ 'placeholder' => 'Example: login-page or dashboard' ]
	) );
}

}
}


