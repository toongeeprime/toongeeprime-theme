<?php defined( 'ABSPATH' ) || exit;
/**
 *	Progressive Web App Settings
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

if ( ! function_exists( 'prime2g_customizer_theme_pwa' ) ) {
function prime2g_customizer_theme_pwa( $wp_customize ) {
if ( ! prime2g_add_theme_pwa() ) return;

$postMsg_text	=	[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ];

if ( $network = is_multisite() ) {
	switch_to_blog( 1 );
	$route	=	get_theme_mod( 'prime2g_route_apps_to_networkhome' );
	restore_current_blog();
	if ( $route && get_current_blog_id() !== 1 ) return;
}

	$wp_customize->add_setting( 'prime2g_use_theme_pwa', $postMsg_text );
	$wp_customize->add_control( 'prime2g_use_theme_pwa', array(
		'label'		=>	__( 'Activate Web App?', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_use_theme_pwa',
		'section'	=>	'prime2g_theme_pwa_section'
	) );

if ( $network && get_current_blog_id() === 1 ) {
	$wp_customize->add_setting( 'prime2g_route_apps_to_networkhome', $postMsg_text );
	$wp_customize->add_control( 'prime2g_route_apps_to_networkhome', array(
		'label'		=>	__( 'Route All Sites\' Apps to Network Home?', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_route_apps_to_networkhome',
		'section'	=>	'prime2g_theme_pwa_section'
	) );
}

	$wp_customize->add_setting( 'prime2g_add_homepage_to_cache', $postMsg_text );
	$wp_customize->add_control( 'prime2g_add_homepage_to_cache', array(
		'label'		=>	__( 'Add Homepage to App\'s Cache', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_add_homepage_to_cache',
		'section'	=>	'prime2g_theme_pwa_section'
	) );

	$wp_customize->add_setting( 'prime2g_use_navigation_preload', $postMsg_text );
	$wp_customize->add_control( 'prime2g_use_navigation_preload', array(
		'label'		=>	__( 'Use Navigation Preload', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_use_navigation_preload',
		'section'	=>	'prime2g_theme_pwa_section'
	) );

	$wp_customize->add_setting( 'prime2g_pwapp_shortname', array_merge( $postMsg_text, [ 'default' => 'Web App' ] ) );
	$wp_customize->add_control( 'prime2g_pwapp_shortname', array(
		'label'		=>	__( 'Web App Short Name', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_pwapp_shortname',
		'section'	=>	'prime2g_theme_pwa_section',
		'input_attrs'	=>	array(
			'placeholder'	=>	__( 'Web App', PRIME2G_TEXTDOM ),
			'maxlength'		=>	12
		)
	) );

	$wp_customize->add_setting( 'prime2g_pwa_description', $postMsg_text );
	$wp_customize->add_control( 'prime2g_pwa_description', array(
		'label'		=>	__( 'Web App Description', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_pwa_description',
		'section'	=>	'prime2g_theme_pwa_section',
		'input_attrs'	=>	array(
			'placeholder'	=>	'Describe your web app to users, briefly',
			'maxlength'	=>	100
		)
	) );

	$wp_customize->add_setting( 'prime2g_add_request_to_pwa_cache', array_merge( $postMsg_text, [ 'default' => 'true' ] ) );
	$wp_customize->add_control( 'prime2g_add_request_to_pwa_cache', array(
		'label'		=>	__( 'Save Contents For Offline Browsing?', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_add_request_to_pwa_cache',
		'section'	=>	'prime2g_theme_pwa_section',
		'choices'	=>	[
			'false'	=>	__( 'Do Not Save', PRIME2G_TEXTDOM ),
			'true'	=>	__( 'Yes, Save Offline', PRIME2G_TEXTDOM )
		]
	) );

	$wp_customize->add_setting( 'prime2g_pwapp_orientation', array_merge( $postMsg_text, [ 'default' => 'portrait' ] ) );
	$wp_customize->add_control( 'prime2g_pwapp_orientation', array(
		'label'		=>	__( 'Web App Orientation', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_pwapp_orientation',
		'section'	=>	'prime2g_theme_pwa_section',
		'choices'	=>	[
			'portrait'	=>	__( 'Portrait', PRIME2G_TEXTDOM ),
			'landscape'	=>	__( 'Landscape', PRIME2G_TEXTDOM ),
			'portrait-primary'	=>	__( 'Portrait Primary', PRIME2G_TEXTDOM ),
			'landscape-primary'	=>	__( 'Landscape Primary', PRIME2G_TEXTDOM ),
			'portrait-secondary'	=>	__( 'Portrait Secondary', PRIME2G_TEXTDOM ),
			'landscape-secondary'	=>	__( 'Landscape Secondary', PRIME2G_TEXTDOM ),
			'natural'	=>	__( 'Natural', PRIME2G_TEXTDOM ),
			'any'		=>	__( 'Any', PRIME2G_TEXTDOM )
		]
	) );

	$wp_customize->add_setting( 'prime2g_pwapp_display', array_merge( $postMsg_text, [ 'default' => 'standalone' ] ) );
	$wp_customize->add_control( 'prime2g_pwapp_display', array(
		'label'		=>	__( 'Web App Display Type', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_pwapp_display',
		'section'	=>	'prime2g_theme_pwa_section',
		'choices'	=>	array(
			'standalone'	=>	__( 'Standalone', PRIME2G_TEXTDOM ),
			'fullscreen'	=>	__( 'Full Screen', PRIME2G_TEXTDOM ),
			'minimal-ui'	=>	__( 'Minimal', PRIME2G_TEXTDOM ),
			'browser'		=>	__( 'Browser', PRIME2G_TEXTDOM )
		)
	) );

	$wp_customize->add_setting( 'prime2g_pwapp_themecolor', array_merge( $postMsg_text, [ 'default' => '#d7e5f4' ] ) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
	$wp_customize, 'prime2g_pwapp_themecolor', array(
			'label'		=>	__( 'App\'s Theme Color', PRIME2G_TEXTDOM ),
			'section'	=>	'prime2g_theme_pwa_section',
			'settings'	=>	'prime2g_pwapp_themecolor'
		)
	) );

	$wp_customize->add_setting( 'prime2g_pwapp_backgroundcolor', array_merge( $postMsg_text, [ 'default' => '#ffffff' ] ) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
	$wp_customize, 'prime2g_pwapp_backgroundcolor', array(
			'label'		=>	__( 'App\'s Background Color', PRIME2G_TEXTDOM ),
			'section'	=>	'prime2g_theme_pwa_section',
			'settings'	=>	'prime2g_pwapp_backgroundcolor'
		)
	) );

	$wp_customize->add_setting( 'prime2g_pwa_cache_strategy', array_merge( $postMsg_text, [ 'default' => PWA_NETWORKFIRST ] ) );
	$wp_customize->add_control( 'prime2g_pwa_cache_strategy', array(
		'label'		=>	__( 'Web App Sourcing Strategy', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_pwa_cache_strategy',
		'section'	=>	'prime2g_theme_pwa_section',
		'choices'	=>	array(
			PWA_CACHEFIRST		=>	__( 'Cache First', PRIME2G_TEXTDOM ),
			PWA_NETWORKFIRST	=>	__( 'Network First', PRIME2G_TEXTDOM ),
			PWA_CACHEONLY		=>	__( 'Cache Only', PRIME2G_TEXTDOM ),
			PWA_NETWORKONLY		=>	__( 'Network Only', PRIME2G_TEXTDOM ),
			PWA_STALE_REVAL		=>	__( 'Cache &amp; Revalidate', PRIME2G_TEXTDOM )
		)
	) );

	$wp_customize->add_setting( 'prime2g_pwapp_version', $postMsg_text );
	$wp_customize->add_control( 'prime2g_pwapp_version', array(
		'label'		=>	__( 'App Version', PRIME2G_TEXTDOM ),
		'description'=>	__( 'NOTE: Set this before applying App Update', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_pwapp_version',
		'section'	=>	'prime2g_theme_pwa_section',
		'input_attrs'	=>	array(
			'placeholder'	=>	'1.00.xx',
			'maxlength'		=>	7
		)
	) );

	#	LAUNCH HANDLER: @since 1.0.97
	$wp_customize->add_setting( 'prime2g_pwa_launch_handler', array_merge( $postMsg_text, [ 'default' => 'auto' ] ) );
	$wp_customize->add_control( 'prime2g_pwa_launch_handler', array(
		'label'		=>	__( 'Launch Handler (Advanced)', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_pwa_launch_handler',
		'section'	=>	'prime2g_theme_pwa_section',
		'choices'	=>	array(
			'auto'		=>	__( 'Auto', PRIME2G_TEXTDOM ),
			'focus-existing'	=>	__( 'Focus Existing', PRIME2G_TEXTDOM ),
			'navigate-existing'	=>	__( 'Navigate Existing', PRIME2G_TEXTDOM ),
			'navigate-new'		=>	__( 'Navigate New', PRIME2G_TEXTDOM )
		)
	) );

	$wp_customize->add_setting( 'prime2g_pwapp_cache_exclude_paths', $postMsg_text );
	$wp_customize->add_control( 'prime2g_pwapp_cache_exclude_paths', array(
		'label'		=>	__( 'Paths to Exclude from Cache (Advanced)', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_pwapp_cache_exclude_paths',
		'section'	=>	'prime2g_theme_pwa_section',
		'input_attrs'	=>	array(
			'placeholder'	=>	'Separate by comma.'
		)
	) );

	$wp_customize->add_setting( 'prime2g_pwapp_endpoints_to_request', $postMsg_text );
	$wp_customize->add_control( 'prime2g_pwapp_endpoints_to_request', array(
		'label'		=>	__( 'Always Request Endpoints (Advanced)', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_pwapp_endpoints_to_request',
		'section'	=>	'prime2g_theme_pwa_section',
		'input_attrs'	=>	array(
			'placeholder'	=>	'Separate by comma. E.g. ?, /endpoint, /api'
		)
	) );

	$wp_customize->add_setting( 'prime2g_pwa_categories', $postMsg_text );
	$wp_customize->add_control( 'prime2g_pwa_categories', array(
		'label'		=>	__( 'App Categories (to web stores)', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_pwa_categories',
		'section'	=>	'prime2g_theme_pwa_section',
		'input_attrs'	=>	array(
			'placeholder'	=>	'Separate by comma. E.g. books, education'
		)
	) );

prime2g_customizer_theme_pwa_images( $wp_customize );	#	@since 1.0.97
}
}

