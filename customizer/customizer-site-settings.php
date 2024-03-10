<?php defined( 'ABSPATH' ) || exit;

/**
 *	Customizer Site Settings
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.48.50
 */

if ( ! function_exists( 'prime2g_customizer_site_settings' ) ) {

function prime2g_customizer_site_settings( $wp_customize ) {

$get	=	[ 'index' => 'ID', 'value' => 'post_title', 'emptyoption' => true ];
$args	=	[ 'post_type' => 'page', 'posts_per_page' => -1, 'post_status' => 'publish' ];
$option	=	[ 'cache_name' => 'getpages', 'get' => 'posts' ];
$pages	=	prime2g_get_postsdata_array( $get, $args, $option );

$postMsg_text	=	[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ];

	/**
	 *	SHUT DOWN WEBSITE
	 */
	$wp_customize->add_setting( 'prime2g_website_shutdown', $postMsg_text );
	$wp_customize->add_control( 'prime2g_website_shutdown', array(
		'label'		=>	__( 'Shut Down Website?', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_website_shutdown',
		'section'	=>	'prime2g_site_settings_section',
		'choices'	=>	array(
			''		=>	__( '-- Website is live --', PRIME2G_TEXTDOM ),
			'maintenance'	=>	__( 'Set to Maintenance Mode', PRIME2G_TEXTDOM ),
			'coming_soon'	=>	__( 'Set to Coming Soon Mode', PRIME2G_TEXTDOM )
		)
	) );

	/**
	 *	SHUTDOWN DISPLAY
	 *	@since @ 1.0.55
	 */
	function prime2g_c_siteIsSD() { return ( ! empty( get_theme_mod( 'prime2g_website_shutdown' ) ) ); }

	$wp_customize->add_setting( 'prime2g_shutdown_display', $postMsg_text );
	$wp_customize->add_control( 'prime2g_shutdown_display', array(
		'label'		=>	__( 'Shutdown Display (To display a page, homepage must be set to *Static)', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_shutdown_display',
		'section'	=>	'prime2g_site_settings_section',
		'choices'	=>	array(
			''		=>	__( 'Default', PRIME2G_TEXTDOM ),
			'use_page'	=>	__( 'Use a Page for Shutdown', PRIME2G_TEXTDOM )
		),
		'active_callback'	=> 'prime2g_c_siteIsSD'
	) );

	$wp_customize->add_setting( 'prime2g_shutdown_page_id', $postMsg_text );
	$wp_customize->add_control( 'prime2g_shutdown_page_id', array(
		'label'		=>	__( 'Select Shutdown Page', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_shutdown_page_id',
		'section'	=>	'prime2g_site_settings_section',
		'choices'	=>	$pages,
		'active_callback'	=> function() {
			return ( 'use_page' === get_theme_mod( 'prime2g_shutdown_display' ) && prime2g_c_siteIsSD() );
		}
	) );

	/**
	 *	404 ERROR PAGE
	 *	@since @ 1.0.55
	 */
	$wp_customize->add_setting( 'prime2g_use_page_for404', $postMsg_text );
	$wp_customize->add_control( 'prime2g_use_page_for404', array(
		'label'		=>	__( 'Use Custom 404 Error Page', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_use_page_for404',
		'section'	=>	'prime2g_site_settings_section'
	) );

	$wp_customize->add_setting( 'prime2g_404error_page_id', $postMsg_text );
	$wp_customize->add_control( 'prime2g_404error_page_id', array(
		'label'		=>	__( 'Select 404 Error Page', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_404error_page_id',
		'section'	=>	'prime2g_site_settings_section',
		'choices'	=>	$pages,
		'active_callback'	=> function() { return ! empty( get_theme_mod( 'prime2g_use_page_for404' ) ); }
	) );

if ( prime_child_min_version( '2.3' ) ) {
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
		'section'	=>	'prime2g_site_settings_section'
	) );

	$wp_customize->add_setting( 'prime2g_custom_login_page_id', $postMsg_text );
	$wp_customize->add_control( 'prime2g_custom_login_page_id', array(
		'label'		=>	__( 'Select Custom Login Page "Content"', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_custom_login_page_id',
		'section'	=>	'prime2g_site_settings_section',
		'choices'	=>	$pages,
		'active_callback'	=> 'p2g_useCLogin'
	) );

	$wp_customize->add_setting( 'prime2g_wp_login_page_slug', $postMsg_text );
	$wp_customize->add_control( 'prime2g_wp_login_page_slug', array(
		'label'		=>	__( 'Custom Login Page Slug', PRIME2G_TEXTDOM ),
		'type'		=>	'text',
		'settings'	=>	'prime2g_wp_login_page_slug',
		'section'	=>	'prime2g_site_settings_section',
		'active_callback'	=> 'p2g_useCLogin',
		'input_attrs'	=>	[ 'placeholder' => 'Example: login-page or dashboard' ]
	) );

	$wp_customize->add_setting( 'prime2g_admin_access_capability', $postMsg_text );
	$wp_customize->add_control( 'prime2g_admin_access_capability', array(
		'label'		=>	__( 'Redirect Users from Admin?', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_admin_access_capability',
		'section'	=>	'prime2g_site_settings_section',
		'choices'	=>	array(
			''		=>	__( '-- No Redirects --', PRIME2G_TEXTDOM ),
			'edit_posts'			=>	__( 'Redirect if user is not an Author', PRIME2G_TEXTDOM ),
			'edit_others_posts'		=>	__( 'Redirect if user is not an Editor', PRIME2G_TEXTDOM ),
			'edit_theme_options'	=>	__( 'Redirect if user is not an Administrator', PRIME2G_TEXTDOM )
		),
		'active_callback'	=> 'p2g_useCLogin'
	) );
}

	/**
	 *	STOP WP HEARTBEAT
	 *	@since 1.0.49
	 */
	$wp_customize->add_setting( 'prime2g_stop_wp_heartbeat', $postMsg_text );
	$wp_customize->add_control( 'prime2g_stop_wp_heartbeat', array(
		'label'		=>	__( 'Stop WP Heartbeat', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_stop_wp_heartbeat',
		'section'	=>	'prime2g_site_settings_section',
		'choices'	=>	array(
			''	=>	__( 'Leave Running', PRIME2G_TEXTDOM ),
			'stop'	=>	__( 'Stop', PRIME2G_TEXTDOM )
		)
	) );

}

}



