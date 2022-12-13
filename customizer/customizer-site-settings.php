<?php defined( 'ABSPATH' ) || exit;

/**
 *	Customizer Site Settings
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.48.50
 */

if ( ! function_exists( 'prime2g_customizer_site_settings' ) ) {

function prime2g_customizer_site_settings( $wp_customize ) {

	/**
	 *	SHUT DOWN WEBSITE
	 */
	$wp_customize->add_setting(
		'prime2g_website_shutdown',
		array(
			'type'		=>	'theme_mod',
		)
	);
	$wp_customize->add_control(
		'prime2g_website_shutdown',
		array(
			'label'		=>	__( 'Shut Down Website?', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_website_shutdown',
			'section'	=>	'prime2g_site_settings_section',
			'choices'	=>	array(
				''	=>	__( '-- Website is live --', PRIME2G_TEXTDOM ),
				'maintenance'	=>	__( 'Set to Maintenance Mode', PRIME2G_TEXTDOM ),
				'coming_soon'	=>	__( 'Set to Coming Soon Mode', PRIME2G_TEXTDOM )
			),
		)
	);

	/**
	 *	STOP WP HEARTBEAT
	 *	@since ToongeePrime Theme 1.0.49.00
	 */
	$wp_customize->add_setting(
		'prime2g_stop_wp_heartbeat',
		array(
			'type'		=>	'theme_mod',
		)
	);
	$wp_customize->add_control(
		'prime2g_stop_wp_heartbeat',
		array(
			'label'		=>	__( 'WP Heartbeat', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_stop_wp_heartbeat',
			'section'	=>	'prime2g_site_settings_section',
			'choices'	=>	array(
				''	=>	__( 'Default', PRIME2G_TEXTDOM ),
				'stop'	=>	__( 'Stop Heartbeat', PRIME2G_TEXTDOM )
			),
		)
	);

}

}


