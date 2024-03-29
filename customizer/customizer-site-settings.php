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
	 *	ADMIN ACCESS CONTROL
	 *	@since @ 1.0.73
	 */
	$wp_customize->add_setting( 'prime2g_admin_access_capability', $postMsg_text );
	$wp_customize->add_control( 'prime2g_admin_access_capability', array(
		'label'		=>	__( 'Redirect Users from Admin?', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_admin_access_capability',
		'section'	=>	'prime2g_site_settings_section',
		'choices'	=>	array(
			''		=>	__( '-- No Redirects --', PRIME2G_TEXTDOM ),
			'edit_posts'			=>	__( 'Redirect non Authors', PRIME2G_TEXTDOM ),
			'edit_others_posts'		=>	__( 'Redirect non Editors', PRIME2G_TEXTDOM ),
			'edit_theme_options'	=>	__( 'Redirect non Administrators', PRIME2G_TEXTDOM ),
			'custom_capability'		=>	__( 'Redirect by Custom Capability', PRIME2G_TEXTDOM )
		)
	) );

	$wp_customize->add_setting( 'prime2g_admin_access_custom_capability', $postMsg_text );
	$wp_customize->add_control( 'prime2g_admin_access_custom_capability', array(
		'label'		=>	__( 'Define Custom Capability', PRIME2G_TEXTDOM ),
		'type'		=>	'text',
		'settings'	=>	'prime2g_admin_access_custom_capability',
		'section'	=>	'prime2g_site_settings_section',
		'input_attrs'	=>	array(
			'placeholder'	=>	__( 'custom_user_capability', PRIME2G_TEXTDOM )
		),
		'active_callback'	=>	function() { return 'custom_capability' === get_theme_mod( 'prime2g_admin_access_capability' ); },
	) );

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


