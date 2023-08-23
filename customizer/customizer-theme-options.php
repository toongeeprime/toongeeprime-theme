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
	$wp_customize->add_setting(
		'prime2g_dark_theme_logo',
		array(
			'type'	=>	'theme_mod',
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
		array( 'type' => 'theme_mod', 'default' => $dWidth, 'sanitize_callback' => 'sanitize_text_field' )
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
				'100vw'		=>	__( 'Full Width', PRIME2G_TEXTDOM )
			),
		)
	);

	/**
	 *	STYLING ADJUSTMENTS
	 */
	$wp_customize->add_setting(
		'prime2g_site_style_extras',
		[ 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' ]
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
				'stretch_head'	=>	__( 'Stretch Header', PRIME2G_TEXTDOM ),
				'stretch_foot'	=>	__( 'Stretch Footer', PRIME2G_TEXTDOM ),
				'stretch_hf'	=>	__( 'Stretch Header &amp; Footer', PRIME2G_TEXTDOM )
			)
		)
	);

	/**
	 *	SIDEBAR IN SINGULAR
	 *	@since ToongeePrime Theme 1.0.55
	 */
	$wp_customize->add_setting(
		'prime2g_sidebar_position',
		[ 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control(
		'prime2g_sidebar_position',
		array(
			'label'		=>	__( 'Sidebar Position (Sitewide)', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_sidebar_position',
			'section'	=>	'prime2g_theme_options_section',
			'choices'	=>	[
				''		=>	'Right',
				'left'	=>	'Left',
			],
		)
	);

	/**
	 *	PAGE TITLE POSITION
	 */
	$wp_customize->add_setting(
		'prime2g_title_location',
		array( 'type' => 'theme_mod', 'default' => 'content', 'sanitize_callback' => 'sanitize_text_field' )
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
				'header'	=>	__( 'In Header (Replaces site title or logo)', PRIME2G_TEXTDOM ),
			),
		)
	);

	/**
	 *	BREADCRUMBS
	 */
	$wp_customize->add_setting(
		'prime2g_theme_breadcrumbs',
		array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' )
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
 *	@since ToongeePrime Theme 1.0.55
 */
	$wp_customize->add_setting( 'prime2g_theme_add_footer_credits',
		array( 'type' => 'theme_mod', 'default' => '1', 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control(
		'prime2g_theme_add_footer_credits',
		array(
			'label'		=>	__( 'Footer Credits', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_theme_add_footer_credits',
			'section'	=>	'prime2g_theme_options_section'
		)
	);

if ( defined( 'CHILD2G_VERSION' ) && CHILD2G_VERSION >= '2.0' ) {

	$wp_customize->add_setting( 'prime2g_theme_add_footer_logo',
		array( 'type' => 'theme_mod', 'default' => '1', 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control(
		'prime2g_theme_add_footer_logo',
		array(
			'label'		=>	__( 'Footer Logo', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_theme_add_footer_logo',
			'section'	=>	'prime2g_theme_options_section'
		)
	);

	/**
	 *	FOOTER COLUMNS
	 */
	$wp_customize->selective_refresh->add_partial(
		'prime2g_footer_columns_num',
		array(
			'selector'	=>	'#sitebasebar',
			'settings'	=>	'prime2g_footer_columns_num',
			'container_inclusive'	=>	true,
			'render_callback'		=>	'prime2g_footer_widgets',
			'fallback_refresh'		=>	false
		)
	);

	$wp_customize->add_setting(
		'prime2g_footer_columns_num',
		array(
			'type'	=>	'theme_mod',
			'transport'	=>	'postMessage',
			'default'	=>	'4',
			'sanitize_callback'	=>	'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'prime2g_footer_columns_num',
		array(
			'label'		=>	__( 'Footer Columns', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_footer_columns_num',
			'section'	=>	'prime2g_theme_options_section',
			'choices'	=>	array(
				'1'	=>	'1', '2'	=>	'2',
				'3'	=>	'3', '4'	=>	'4',
				'5'	=>	'5', '6'	=>	'6',
			),
		)
	);

}
#	@since ToongeePrime Theme 1.0.55 end	#

	/**
	 *	FOOTER CREDITS
	 */
	$wp_customize->add_setting(
		'prime2g_footer_credit_power',
		array(
			'type'		=>	'theme_mod',
			'transport'	=>	'postMessage',
			'default'	=>	'Powered by',
			'sanitize_callback'	=>	'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'prime2g_footer_credit_power',
		array(
			'label'		=>	__( 'Powered by text (Footer)', PRIME2G_TEXTDOM ),
			'type'		=>	'text',
			'settings'	=>	'prime2g_footer_credit_power',
			'section'	=>	'prime2g_theme_options_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'Powered by',
				'maxlength'		=>	'125'
			),
		)
	);

	$wp_customize->add_setting(
		'prime2g_footer_credit_name',
		array(
			'type'		=>	'theme_mod',
			'transport'	=>	'postMessage',
			'default'	=>	'ToongeePrime Theme',
			'sanitize_callback'	=>	'sanitize_text_field'
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
				'maxlength'		=>	'125'
			),
		)
	);

	$wp_customize->add_setting(
		'prime2g_footer_credit_url',
		array(
			'type'		=>	'theme_mod',
			'transport'	=>	'postMessage',
			'default'	=>	'https://akawey.com/',
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
				'maxlength'		=>	'125'
			),
		)
	);

	/**
	 *	@since ToongeePrime Theme 1.0.48.50
	 */
	$wp_customize->add_setting(
		'prime2g_footer_credit_append',
		array(
			'type'		=>	'theme_mod',
			'transport'	=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'prime2g_footer_credit_append',
		array(
			'label'		=>	__( 'Append to credit', PRIME2G_TEXTDOM ),
			'type'		=>	'text',
			'settings'	=>	'prime2g_footer_credit_append',
			'section'	=>	'prime2g_theme_options_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'All rights reserved.',
				'maxlength'		=>	'125'
			),
		)
	);

}

}


