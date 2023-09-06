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
$option	=	[ 'cacheName' => 'getpages', 'get' => 'posts' ];
$pages	=	prime2g_get_postsdata_array( $get, $args, $option );

	/**
	 *	SHUT DOWN WEBSITE
	 */
	$wp_customize->add_setting(
		'prime2g_website_shutdown',
		[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control(
		'prime2g_website_shutdown',
		array(
			'label'		=>	__( 'Shut Down Website?', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_website_shutdown',
			'section'	=>	'prime2g_site_settings_section',
			'choices'	=>	array(
				''		=>	__( '-- Website is live --', PRIME2G_TEXTDOM ),
				'maintenance'	=>	__( 'Set to Maintenance Mode', PRIME2G_TEXTDOM ),
				'coming_soon'	=>	__( 'Set to Coming Soon Mode', PRIME2G_TEXTDOM )
			),
		)
	);

	/**
	 *	SHUTDOWN DISPLAY
	 *	@since ToongeePrime Theme @ 1.0.55
	 */
	function prime2g_c_siteNotSD() { return ( ! empty( get_theme_mod( 'prime2g_website_shutdown' ) ) ); }

	$wp_customize->add_setting(
		'prime2g_shutdown_display',
		[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control(
		'prime2g_shutdown_display',
		array(
			'label'		=>	__( 'Shutdown Display (To display a page, homepage must be set to *Static)', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_shutdown_display',
			'section'	=>	'prime2g_site_settings_section',
			'choices'	=>	array(
				''		=>	__( 'Default', PRIME2G_TEXTDOM ),
				'use_page'	=>	__( 'Use a Page for Shutdown', PRIME2G_TEXTDOM )
			),
			'active_callback'	=> 'prime2g_c_siteNotSD'
		)
	);

	$wp_customize->add_setting(
		'prime2g_shutdown_page_id',
		[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control(
		'prime2g_shutdown_page_id',
		array(
			'label'		=>	__( 'Select Shutdown Page', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_shutdown_page_id',
			'section'	=>	'prime2g_site_settings_section',
			'choices'	=>	$pages,
			'active_callback'	=> function() {
				return ( 'use_page' === get_theme_mod( 'prime2g_shutdown_display' ) && prime2g_c_siteNotSD() );
			}
		)
	);

	/**
	 *	STOP WP HEARTBEAT
	 *	@since ToongeePrime Theme 1.0.49
	 */
	$wp_customize->add_setting(
		'prime2g_stop_wp_heartbeat',
		[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control(
		'prime2g_stop_wp_heartbeat',
		array(
			'label'		=>	__( 'Stop Excess Scripts', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_stop_wp_heartbeat',
			'section'	=>	'prime2g_site_settings_section',
			'choices'	=>	array(
				''	=>	__( 'Default', PRIME2G_TEXTDOM ),
				'stop'	=>	__( 'Stop', PRIME2G_TEXTDOM )
			),
		)
	);

}

}
