<?php defined( 'ABSPATH' ) || exit;

/**
 *	Social Media Settings and Controls
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	ToongeePrime Theme Customizer Sections
 */

function prime2g_customizer_socialmedia_and_contacts( $wp_customize ) {

// Social Media Settings & Controls:
	$wp_customize->add_setting(
		'prime2g_facebook_url',
		array(
			'type'				=>	'theme_mod',
			// 'default'			=>	$fb_url,
			'transport'			=>	'refresh',
			'sanitize_callback'	=>	'esc_url',
		)
	);
	$wp_customize->add_control(
		'prime2g_fb_url',
		array(
			'label'		=>	__( 'Facebook Page Url', 'toongeeprime-theme' ),
			'type'		=>	'url',
			'settings'	=>	'prime2g_facebook_url',
			'section'	=>	'prime2g_socialmedia_links_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'https://www.facebook.com/akaweyonline',
			),
		)
	);


	$wp_customize->add_setting(
		'prime2g_instagram_url',
		array(
			'type'				=>	'theme_mod',
			'transport'			=>	'refresh',
			'sanitize_callback'	=>	'esc_url',
		)
	);
	$wp_customize->add_control(
		'prime2g_ig_url',
		array(
			'label'		=>	__( 'Insagram Url', 'toongeeprime-theme' ),
			'type'		=>	'url',
			'settings'	=>	'prime2g_instagram_url',
			'section'	=>	'prime2g_socialmedia_links_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'https://www.instagram.com/akaweyonline',
			),
		)
	);


	$wp_customize->add_setting(
		'prime2g_twitter_url',
		array(
			'type'				=>	'theme_mod',
			'transport'			=>	'refresh',
			'sanitize_callback'	=>	'esc_url',
		)
	);
	$wp_customize->add_control(
		'prime2g_tw_url',
		array(
			'label'		=>	__( 'Twitter Url', 'toongeeprime-theme' ),
			'type'		=>	'url',
			'settings'	=>	'prime2g_twitter_url',
			'section'	=>	'prime2g_socialmedia_links_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'https://www.twitter.com/akaweyonline',
			),
		)
	);


	$wp_customize->add_setting(
		'prime2g_contact_email',
		array(
			'type'				=>	'theme_mod',
			'transport'			=>	'refresh',
			'sanitize_callback'	=>	'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'prime2g_ct_email',
		array(
			'label'		=>	__( 'Contact Email', 'toongeeprime-theme' ),
			'type'		=>	'email',
			'settings'	=>	'prime2g_contact_email',
			'section'	=>	'prime2g_socialmedia_links_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'contact@mymail.com',
			),
		)
	);


	$wp_customize->add_setting(
		'prime2g_contact_address',
		array(
			'type'				=>	'theme_mod',
			'transport'			=>	'refresh',
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'prime2g_contact_address',
		array(
			'label'		=>	__( 'Contact Address', 'toongeeprime-theme' ),
			'type'		=>	'text',
			'settings'	=>	'prime2g_contact_address',
			'section'	=>	'prime2g_socialmedia_links_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'Enter your business contact address',
				'maxlength'		=>	'125',
			),
		)
	);


	$wp_customize->add_setting(
		'prime2g_contact_phone',
		array(
			'type'				=>	'theme_mod',
			'transport'			=>	'refresh',
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'prime2g_ct_phone',
		array(
			'label'		=>	__( 'Contact Phone Number', 'toongeeprime-theme' ),
			'type'		=>	'phone',
			'settings'	=>	'prime2g_contact_phone',
			'section'	=>	'prime2g_socialmedia_links_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'2348012345678',
				'maxlength'		=>	'13',
				'pattern'		=>	'[0-9]{13}',
			),
		)
	);


	$wp_customize->add_setting(
		'prime2g_whatsapp_number',
		array(
			'type'				=>	'theme_mod',
			'transport'			=>	'refresh',
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'prime2g_wa_number',
		array(
			'label'		=>	__( 'WhatsApp Number', 'toongeeprime-theme' ),
			'type'		=>	'phone',
			'settings'	=>	'prime2g_whatsapp_number',
			'section'	=>	'prime2g_socialmedia_links_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'2348012345678',
				'maxlength'		=>	'13',
				'pattern'		=>	'[0-9]{13}',
			),
		)
	);

}

