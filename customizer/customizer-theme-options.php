<?php defined( 'ABSPATH' ) || exit;

/**
 *	Theme's Main Customizer Options
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( ! function_exists( 'prime2g_customizer_theme_options' ) ) {

function prime2g_customizer_theme_options( $wp_customize ) {

	$theStyles	=	new ToongeePrime_Styles();

	/**
	 *	Dark Theme Logo
	 */
	$logo_url = '';

	$wp_customize->add_setting(
		'prime2g_dark_theme_logo',
		array(
			'type'				=>	'theme_mod',
			// 'default'		=>	$logo_url,
			'transport'			=>	'refresh',
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control( new WP_Customize_Media_Control(
		$wp_customize,
			'prime2g_dark_theme_logo',
			array(
				'label'		=>	__( 'Dark Theme Logo', PRIME2G_TEXTDOM ),
				'settings'	=>	'prime2g_dark_theme_logo',
				'section'	=>	'prime2g_theme_options_section',
				'mime_type' =>	'image',
			)
		)
	);


	/**
	 *	THEME WIDTHS
	 */
	$dWidth	=	$theStyles->siteWidth;

	$wp_customize->add_setting(
		'prime2g_site_width',
		array(
			'type'		=>	'theme_mod',
			'default'	=>	$dWidth,
		)
	);
	$wp_customize->add_control(
		'prime2g_site_width',
		array(
			'label'		=>	__( 'Site\'s Width', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_site_width',
			'section'	=>	'prime2g_theme_options_section',
			'choices'	=>	array(
				'1100px'	=>	__( 'Default', PRIME2G_TEXTDOM ),
				'960px'		=>	__( 'Narrow', PRIME2G_TEXTDOM ),
				'1250px'	=>	__( 'Wide', PRIME2G_TEXTDOM ),
				'100vw'		=>	__( 'Full Width', PRIME2G_TEXTDOM ),
			),
		)
	);


	/**
	 *	MAIN MENU POSITION
	 */
	$wp_customize->add_setting(
		'prime2g_menu_position',
		array(
			'type'		=>	'theme_mod',
			'default'	=>	'top',
		)
	);
	$wp_customize->add_control(
		'prime2g_menu_position',
		array(
			'label'		=>	__( 'Main Menu Position', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_menu_position',
			'section'	=>	'prime2g_theme_options_section',
			'choices'	=>	array(
				'top'	=>	__( 'Top of Header', PRIME2G_TEXTDOM ),
				'bottom'	=>	__( 'Bottom of Header', PRIME2G_TEXTDOM ),
				'fixed'	=>	__( 'Fixed At Top', PRIME2G_TEXTDOM )
			),
		)
	);


	/**
	 *	STYLING ADJUSTMENTS
	 */
	$wp_customize->add_setting(
		'prime2g_site_style_extras',
		array(
			'type'		=>	'theme_mod',
		)
	);
	$wp_customize->add_control(
		'prime2g_site_style_extras',
		array(
			'label'		=>	__( 'Extra Styling Adjustments', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_site_style_extras',
			'section'	=>	'prime2g_theme_options_section',
			'choices'	=>	array(
				''	=>	__( 'None', PRIME2G_TEXTDOM ),
				'stretch_hf'	=>	__( 'Stretch Header &amp; Footer', PRIME2G_TEXTDOM ),
			),
		)
	);


	/**
	 *	PAGE TITLE POSITION
	 */
	$wp_customize->add_setting(
		'prime2g_title_location',
		array(
			'type'		=>	'theme_mod',
			'default'	=>	'content',
		)
	);
	$wp_customize->add_control(
		'prime2g_title_location',
		array(
			'label'		=>	__( 'Page Title Location', PRIME2G_TEXTDOM ),
			'type'		=>	'radio',
			'settings'	=>	'prime2g_title_location',
			'section'	=>	'prime2g_theme_options_section',
			'choices'	=>	array(
				'content'	=>	__( 'In Content', PRIME2G_TEXTDOM ),
				'header'		=>	__( 'In Header (Replaces site title or logo)', PRIME2G_TEXTDOM ),
			),
		)
	);


	/**
	 *	Logo Beside Menu
	 */
	$wp_customize->add_setting(
		'prime2g_logo_with_menu',
		array(
			'type'		=>	'theme_mod',
		)
	);
	$wp_customize->add_control(
		'prime2g_logo_with_menu',
		array(
			'label'		=>	__( 'Show Logo by Main Menu', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_logo_with_menu',
			'section'	=>	'prime2g_theme_options_section'
		)
	);


	/**
	 *	BREADCRUMBS
	 */
	$wp_customize->add_setting(
		'prime2g_theme_breadcrumbs',
		array(
			'type'		=>	'theme_mod',
		)
	);
	$wp_customize->add_control(
		'prime2g_theme_breadcrumbs',
		array(
			'label'		=>	__( 'Show Breadcrumbs (Not on Homepage)', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_theme_breadcrumbs',
			'section'	=>	'prime2g_theme_options_section'
		)
	);


	/**
	 *	FOOTER CREDITS
	 */
	$wp_customize->add_setting(
		'prime2g_footer_credit_power',
		array(
			'type'				=>	'theme_mod',
			'transport'			=>	'refresh',
			'default'			=>	'Powered by',
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'prime2g_footer_credit_power',
		array(
			'label'		=>	__( 'Powered by text', PRIME2G_TEXTDOM ),
			'type'		=>	'text',
			'settings'	=>	'prime2g_footer_credit_power',
			'section'	=>	'prime2g_theme_options_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'Powered by',
				'maxlength'		=>	'125',
			),
		)
	);


	$wp_customize->add_setting(
		'prime2g_footer_credit_name',
		array(
			'type'				=>	'theme_mod',
			'transport'			=>	'refresh',
			'default'			=>	'ToongeePrime Theme',
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'prime2g_footer_credit_name',
		array(
			'label'		=>	__( 'Credit goes to', PRIME2G_TEXTDOM ),
			'type'		=>	'text',
			'settings'	=>	'prime2g_footer_credit_name',
			'section'	=>	'prime2g_theme_options_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'ToongeePrime Theme',
				'maxlength'		=>	'125',
			),
		)
	);


	$wp_customize->add_setting(
		'prime2g_footer_credit_url',
		array(
			'type'				=>	'theme_mod',
			'transport'			=>	'refresh',
			'default'			=>	'https://akawey.com/',
			'sanitize_callback'	=>	'esc_url',
		)
	);
	$wp_customize->add_control(
		'prime2g_footer_credit_url',
		array(
			'label'		=>	__( 'Credit Link', PRIME2G_TEXTDOM ),
			'type'		=>	'url',
			'settings'	=>	'prime2g_footer_credit_url',
			'section'	=>	'prime2g_theme_options_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'https://akawey.com/',
				'maxlength'		=>	'125',
			),
		)
	);


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
			'section'	=>	'prime2g_theme_options_section',
			'choices'	=>	array(
				''	=>	__( '-- Website is live --', PRIME2G_TEXTDOM ),
				'maintenance'	=>	__( 'Set to Maintenance Mode', PRIME2G_TEXTDOM ),
				'coming_soon'	=>	__( 'Set to Coming Soon Mode', PRIME2G_TEXTDOM )
			),
		)
	);


}

}

