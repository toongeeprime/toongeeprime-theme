<?php defined( 'ABSPATH' ) || exit;

/**
 *	Social Media Settings and Controls
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

function prime2g_customizer_socialmedia_and_contacts( $wp_customize ) {

	/**
	 *	Selective refresh added @since ToongeePrime Theme 1.0.50
	 */
	$wp_customize->selective_refresh->add_partial(
		'prime2g_facebook_url',
		array(
			'selector'		=>	'#footerWrap .socials_contacts',
			'settings'		=>	[ 'prime2g_facebook_url', 'prime2g_instagram_url',
			'prime2g_twitter_url', 'prime2g_youtube_url', 'prime2g_linkedin_url',
			'prime2g_tiktok_url', 'prime2g_telegram_url', 'prime2g_contact_email',
			'prime2g_contact_phone', 'prime2g_whatsapp_number' ],
			'container_inclusive'	=>	false,
			'render_callback'		=>	'prime2g_theme_mod_social_and_contacts',
			'fallback_refresh'		=>	true,
		)
	);

	/**
	 *	Show? @since ToongeePrime Theme 1.0.55
	 */
	$wp_customize->add_setting(
		'prime2g_show_socials_and_contacts',
		array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 1 )
	);
	$wp_customize->add_control(
		'prime2g_show_socials_and_contacts',
		array(
			'label'		=>	__( 'Show Icon Links', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_show_socials_and_contacts',
			'section'	=>	'prime2g_socialmedia_links_section'
		)
	);

	// Social Media Settings & Controls
	$wp_customize->add_setting(
		'prime2g_facebook_url',
		array( 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'esc_url' )
	);
	$wp_customize->add_control(
		'prime2g_facebook_url',
		array(
			'label'		=>	__( 'Facebook Page Url', PRIME2G_TEXTDOM ),
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
		array( 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'esc_url' )
	);
	$wp_customize->add_control(
		'prime2g_instagram_url',
		array(
			'label'		=>	__( 'Insagram Url', PRIME2G_TEXTDOM ),
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
		array( 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'esc_url' )
	);
	$wp_customize->add_control(
		'prime2g_twitter_url',
		array(
			'label'		=>	__( 'Twitter Url', PRIME2G_TEXTDOM ),
			'type'		=>	'url',
			'settings'	=>	'prime2g_twitter_url',
			'section'	=>	'prime2g_socialmedia_links_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'https://www.twitter.com/akaweyonline',
			),
		)
	);

	$wp_customize->add_setting(
		'prime2g_youtube_url',
		array( 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'esc_url' )
	);
	$wp_customize->add_control(
		'prime2g_youtube_url',
		array(
			'label'		=>	__( 'YouTube Url', PRIME2G_TEXTDOM ),
			'type'		=>	'url',
			'settings'	=>	'prime2g_youtube_url',
			'section'	=>	'prime2g_socialmedia_links_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'https://www.youtube.com/c/Akaweyline',
			),
		)
	);

	$wp_customize->add_setting(
		'prime2g_linkedin_url',
		array( 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'esc_url' )
	);
	$wp_customize->add_control(
		'prime2g_linkedin_url',
		array(
			'label'		=>	__( 'LinkedIn Url', PRIME2G_TEXTDOM ),
			'type'		=>	'url',
			'settings'	=>	'prime2g_linkedin_url',
			'section'	=>	'prime2g_socialmedia_links_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'https://www.linkedin.com/akaweyonline',
			),
		)
	);

	$wp_customize->add_setting(
		'prime2g_tiktok_url',
		array( 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'esc_url' )
	);
	$wp_customize->add_control(
		'prime2g_tiktok_url',
		array(
			'label'		=>	__( 'TikTok Url', PRIME2G_TEXTDOM ),
			'type'		=>	'url',
			'settings'	=>	'prime2g_tiktok_url',
			'section'	=>	'prime2g_socialmedia_links_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'https://www.tiktok.com/@username',
			),
		)
	);

	$wp_customize->add_setting(
		'prime2g_telegram_url',
		array( 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'esc_url' )
	);
	$wp_customize->add_control(
		'prime2g_telegram_url',
		array(
			'label'		=>	__( 'Telegram Url', PRIME2G_TEXTDOM ),
			'type'		=>	'url',
			'settings'	=>	'prime2g_telegram_url',
			'section'	=>	'prime2g_socialmedia_links_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'https://t.me/username',
			),
		)
	);

	$wp_customize->add_setting(
		'prime2g_contact_email',
		array(
			'type'		=>	'theme_mod',
			'transport'	=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_email'
		)
	);
	$wp_customize->add_control(
		'prime2g_contact_email',
		array(
			'label'		=>	__( 'Contact Email', PRIME2G_TEXTDOM ),
			'type'		=>	'email',
			'settings'	=>	'prime2g_contact_email',
			'section'	=>	'prime2g_socialmedia_links_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'contact@mymail.com'
			),
		)
	);

	$wp_customize->add_setting(
		'prime2g_contact_address',
		array(
			'type'		=>	'theme_mod',
			'transport'	=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'prime2g_contact_address',
		array(
			'label'		=>	__( 'Contact Address', PRIME2G_TEXTDOM ),
			'type'		=>	'text',
			'settings'	=>	'prime2g_contact_address',
			'section'	=>	'prime2g_socialmedia_links_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'Enter your business contact address',
				'maxlength'		=>	'125'
			),
		)
	);

	$wp_customize->add_setting(
		'prime2g_contact_phone',
		array(
			'type'		=>	'theme_mod',
			'transport'	=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'prime2g_contact_phone',
		array(
			'label'		=>	__( 'Contact Phone Number', PRIME2G_TEXTDOM ),
			'type'		=>	'phone',
			'settings'	=>	'prime2g_contact_phone',
			'section'	=>	'prime2g_socialmedia_links_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'2348012345678',
				'maxlength'		=>	'16',
				// 'pattern'		=>	'[0-9]{16}',
			),
		)
	);

	$wp_customize->add_setting(
		'prime2g_whatsapp_number',
		array(
			'type'		=>	'theme_mod',
			'transport'	=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'prime2g_whatsapp_number',
		array(
			'label'		=>	__( 'WhatsApp Number', PRIME2G_TEXTDOM ),
			'type'		=>	'phone',
			'settings'	=>	'prime2g_whatsapp_number',
			'section'	=>	'prime2g_socialmedia_links_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'2348012345678',
				'maxlength'		=>	'16',
				// 'pattern'		=>	'[0-9]{16}',
			),
		)
	);

}


