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

$postMsg_text	=	[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ];

	/**
	 *	SHUT DOWN WEBSITE
	 */
	$wp_customize->add_setting( 'prime2g_website_shutdown', $postMsg_text );
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

	$wp_customize->add_setting( 'prime2g_shutdown_display', $postMsg_text );
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

	$wp_customize->add_setting( 'prime2g_shutdown_page_id', $postMsg_text );
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
	 *	404 ERROR PAGE
	 *	@since ToongeePrime Theme @ 1.0.55
	 */
	$wp_customize->add_setting( 'prime2g_use_page_for404', $postMsg_text );
	$wp_customize->add_control(
		'prime2g_use_page_for404',
		array(
			'label'		=>	__( 'Use Custom 404 Error Page', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_use_page_for404',
			'section'	=>	'prime2g_site_settings_section'
		)
	);

	$wp_customize->add_setting( 'prime2g_404error_page_id', $postMsg_text );
	$wp_customize->add_control(
		'prime2g_404error_page_id',
		array(
			'label'		=>	__( 'Select 404 Error Page', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_404error_page_id',
			'section'	=>	'prime2g_site_settings_section',
			'choices'	=>	$pages,
			'active_callback'	=> function() { return ! empty( get_theme_mod( 'prime2g_use_page_for404' ) ); }
		)
	);

	/**
	 *	STOP WP HEARTBEAT
	 *	@since ToongeePrime Theme 1.0.49
	 */
	$wp_customize->add_setting( 'prime2g_stop_wp_heartbeat', $postMsg_text );
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

	/**
	 *	CACHE CONTROLS
	 *	@since ToongeePrime Theme 1.0.56
	 */
	function prime2g_a_c_ctrls() { return ( ! empty( get_theme_mod( 'prime2g_activate_chache_controls' ) ) ); }

$time_units	=	[ MINUTE_IN_SECONDS => __( 'Minutes', PRIME2G_TEXTDOM ), HOUR_IN_SECONDS => __( 'Hours', PRIME2G_TEXTDOM ),
DAY_IN_SECONDS => __( 'Days', PRIME2G_TEXTDOM ), WEEK_IN_SECONDS => __( 'Weeks', PRIME2G_TEXTDOM ),
MONTH_IN_SECONDS => __( 'Months', PRIME2G_TEXTDOM ), YEAR_IN_SECONDS => __( 'Years', PRIME2G_TEXTDOM ) ];

	$wp_customize->add_setting( 'prime2g_activate_chache_controls', $postMsg_text );
	$wp_customize->add_control(
		'prime2g_activate_chache_controls',
		array(
			'label'		=>	__( 'Activate Cache Controls', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_activate_chache_controls',
			'section'	=>	'prime2g_site_settings_section'
		)
	);

	$wp_customize->add_setting( 'prime2g_chache_time_singular', $postMsg_text );
	$wp_customize->add_control(
		'prime2g_chache_time_singular',
		array(
			'label'		=>	__( 'Cache Time: Single Entries', PRIME2G_TEXTDOM ),
			'type'		=>	'number',
			'settings'	=>	'prime2g_chache_time_singular',
			'section'	=>	'prime2g_site_settings_section',
			'input_attrs'	=>	[ 'min' => '1' ],
			'active_callback'	=> 'prime2g_a_c_ctrls'
		)
	);

	$wp_customize->add_setting( 'prime2g_chache_seconds_singular', $postMsg_text );
	$wp_customize->add_control(
		'prime2g_chache_seconds_singular',
		array(
			'label'		=>	__( 'Cache Unit: Single Entries', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_chache_seconds_singular',
			'section'	=>	'prime2g_site_settings_section',
			'choices'	=>	$time_units,
			'active_callback'	=> 'prime2g_a_c_ctrls'
		)
	);

	$wp_customize->add_setting( 'prime2g_chache_time_feeds', $postMsg_text );
	$wp_customize->add_control(
		'prime2g_chache_time_feeds',
		array(
			'label'		=>	__( 'Cache Time: Archives', PRIME2G_TEXTDOM ),
			'type'		=>	'number',
			'settings'	=>	'prime2g_chache_time_feeds',
			'section'	=>	'prime2g_site_settings_section',
			'input_attrs'	=>	[ 'min' => '1' ],
			'active_callback'	=> 'prime2g_a_c_ctrls'
		)
	);

	$wp_customize->add_setting( 'prime2g_chache_seconds_feeds', $postMsg_text );
	$wp_customize->add_control(
		'prime2g_chache_seconds_feeds',
		array(
			'label'		=>	__( 'Cache Unit: Archives', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_chache_seconds_feeds',
			'section'	=>	'prime2g_site_settings_section',
			'choices'	=>	$time_units,
			'active_callback'	=> 'prime2g_a_c_ctrls'
		)
	);

}

}


