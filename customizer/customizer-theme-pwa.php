<?php defined( 'ABSPATH' ) || exit;

/**
 *	Theme's Progressive Web App (PWA)
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

if ( ! function_exists( 'prime2g_customizer_theme_pwa' ) ) {

function prime2g_customizer_theme_pwa( $wp_customize ) {

if ( ! prime2g_add_theme_pwa() ) return;

	$wp_customize->add_setting(
		'prime2g_use_theme_pwa',
		[ 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control(
		'prime2g_use_theme_pwa',
		array(
			'label'		=>	__( 'Activate Web App?', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_use_theme_pwa',
			'section'	=>	'prime2g_theme_pwa_section'
		)
	);


if ( is_multisite() && get_current_blog_id() === 1 ) {
	$wp_customize->add_setting(
		'prime2g_route_starturl_to_networkhome',
		[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control(
		'prime2g_route_starturl_to_networkhome',
		array(
			'label'		=>	__( 'Start All Sites\' Apps at Network Home?', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_route_starturl_to_networkhome',
			'section'	=>	'prime2g_theme_pwa_section'
		)
	);
}


	$wp_customize->add_setting(
		'prime2g_pwapp_primaryicon',
		array(
			'type'	=>	'theme_mod',
			'transport'	=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control( new WP_Customize_Cropped_Image_Control(
		$wp_customize,
			'prime2g_pwapp_primaryicon',
			array(
				'label'		=>	__( 'Main App Icon', PRIME2G_TEXTDOM ),
				'settings'	=>	'prime2g_pwapp_primaryicon',
				'section'	=>	'prime2g_theme_pwa_section',
				'width'		=>	144,
				'height'	=>	144,
				'mime_type' =>	'image',
			)
		)
	);


	$wp_customize->add_setting(
		'prime2g_pwapp_shortname',
		array(
			'type'		=>	'theme_mod',
			'default'	=>	'Web App',
			'transport'	=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'prime2g_pwapp_shortname',
		array(
			'label'		=>	__( 'Web App Short Name', PRIME2G_TEXTDOM ),
			'settings'	=>	'prime2g_pwapp_shortname',
			'section'	=>	'prime2g_theme_pwa_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	__( 'Web App', PRIME2G_TEXTDOM ),
				'maxlength'		=>	12,
			)
		)
	);


	$wp_customize->add_setting(
		'prime2g_pwapp_orientation',
		[
		'type' => 'theme_mod', 'default' => 'portrait',
		'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage'
		]
	);
	$wp_customize->add_control(
		'prime2g_pwapp_orientation',
		array(
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
				'any'	=>	__( 'Any', PRIME2G_TEXTDOM ),
			]
		)
	);


	$wp_customize->add_setting(
		'prime2g_pwapp_display',
		[
		'type' => 'theme_mod', 'transport' => 'postMessage',
		'default' => 'standalone', 'sanitize_callback' => 'sanitize_text_field'
		]
	);
	$wp_customize->add_control(
		'prime2g_pwapp_display',
		array(
			'label'		=>	__( 'Web App Display Type', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_pwapp_display',
			'section'	=>	'prime2g_theme_pwa_section',
			'choices'	=>	array(
				'standalone'	=>	__( 'Standalone', PRIME2G_TEXTDOM ),
				'fullscreen'	=>	__( 'Full Screen', PRIME2G_TEXTDOM ),
				'minimal-ui'	=>	__( 'Minimal', PRIME2G_TEXTDOM ),
				'browser'	=>	__( 'Browser', PRIME2G_TEXTDOM ),
			),
		)
	);


	$wp_customize->add_setting(
		'prime2g_pwapp_themecolor',
		array(
			'capability'=>	'edit_theme_options',
			'default'	=>	'#ffffff',
			'sanitize_callback'	=>	'sanitize_hex_color',
			'transport'	=>	'postMessage'
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'prime2g_pwapp_themecolor',
			array(
				'label'		=>	__( 'App\'s Theme Color', PRIME2G_TEXTDOM ),
				'section'	=>	'prime2g_theme_pwa_section',
				'settings'	=>	'prime2g_pwapp_themecolor',
			)
		)
	);


	$wp_customize->add_setting(
		'prime2g_pwapp_backgroundcolor',
		array(
			'capability'=>	'edit_theme_options',
			'default'	=>	'#ffffff',
			'sanitize_callback'	=>	'sanitize_hex_color',
			'transport'	=>	'postMessage'
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'prime2g_pwapp_backgroundcolor',
			array(
				'label'		=>	__( 'App\'s Background Color', PRIME2G_TEXTDOM ),
				'section'	=>	'prime2g_theme_pwa_section',
				'settings'	=>	'prime2g_pwapp_backgroundcolor',
			)
		)
	);


}

}
