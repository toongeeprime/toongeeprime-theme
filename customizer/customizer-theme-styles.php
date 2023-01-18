<?php defined( 'ABSPATH' ) || exit;

/**
 *	Theme's Customizer Colors
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( ! function_exists( 'prime2g_customizer_theme_styles' ) ) {

function prime2g_customizer_theme_styles( $wp_customize ) {

	$theStyles	=	new ToongeePrime_Styles();


	/**
	 *	THEME DEFAULT STYLE VALUES:
	 */
	$brandClr	=	$theStyles->brandClr;
	$brandClr2	=	$theStyles->brandClr2;
	$bgcolor	=	$theStyles->siteBG;
	$headerbg	=	$theStyles->headerBG;
	$contentbg	=	$theStyles->contentBG;
	$footerbg	=	$theStyles->footerBG;
	$bodyFont	=	$theStyles->bodyFont;
	$headFont	=	$theStyles->headFont;

	/**
	 *	FONTS
	 */
	$themeFonts	=	prime2g_theme_fonts();

	$wp_customize->add_setting(
		'prime2g_site_headings_font',
		array(
			'type'		=>	'theme_mod',
			'default'	=>	$headFont,
		)
	);
	$wp_customize->add_control(
		'prime2g_site_headings_font',
		array(
			'label'		=>	__( 'Font for Site\'s Text Headings', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_site_headings_font',
			'section'	=>	'prime2g_theme_styles_section',
			'choices'	=>	$themeFonts,
		)
	);


	$wp_customize->add_setting(
		'prime2g_site_body_font',
		array(
			'type'		=>	'theme_mod',
			'default'	=>	$bodyFont,
		)
	);
	$wp_customize->add_control(
		'prime2g_site_body_font',
		array(
			'label'		=>	__( 'Font for Site\'s Body', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_site_body_font',
			'section'	=>	'prime2g_theme_styles_section',
			'choices'	=>	$themeFonts,
		)
	);


	/**
	 *	COLOURS
	 */
	$wp_customize->add_setting(
		'prime2g_primary_brand_color',
		array(
			'capability'	=>	'edit_theme_options',
			'default'		=>	$brandClr,
			'sanitize_callback'	=>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'prime2g_primary_brand_color',
			array(
				'label'		=>	__( 'Main Brand Color', PRIME2G_TEXTDOM ),
				'section'	=>	'prime2g_theme_styles_section',
				'settings'	=>	'prime2g_primary_brand_color',
			)
		)
	);


	$wp_customize->add_setting(
		'prime2g_secondary_brand_color',
		array(
			'capability'	=>	'edit_theme_options',
			'default'		=>	$brandClr2,
			'sanitize_callback'	=>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'prime2g_secondary_brand_color',
			array(
				'label'		=>	__( 'Secondary Brand Color', PRIME2G_TEXTDOM ),
				'section'	=>	'prime2g_theme_styles_section',
				'settings'	=>	'prime2g_secondary_brand_color',
			)
		)
	);


	$wp_customize->add_setting(
		'prime2g_background_color',
		array(
			'capability'	=>	'edit_theme_options',
			'default'		=>	$bgcolor,
			'transport'		=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'prime2g_background_color',
			array(
				'label'		=>	__( 'Site Background Color', PRIME2G_TEXTDOM ),
				'section'	=>	'prime2g_theme_styles_section',
				'settings'	=>	'prime2g_background_color',
			)
		)
	);


	$wp_customize->add_setting(
		'prime2g_header_background',
		array(
			'capability'	=>	'edit_theme_options',
			'default'		=>	$headerbg,
			// 'transport'		=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'prime2g_header_background',
			array(
				'label'		=>	__( 'Header Background Color', PRIME2G_TEXTDOM ),
				'section'	=>	'prime2g_theme_styles_section',
				'settings'	=>	'prime2g_header_background',
			)
		)
	);


	$wp_customize->add_setting(
		'prime2g_content_background',
		array(
			'capability'	=>	'edit_theme_options',
			'default'		=>	$contentbg,
			// 'transport'		=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'prime2g_content_background',
			array(
				'label'		=>	__( 'Content Background Color', PRIME2G_TEXTDOM ),
				'section'	=>	'prime2g_theme_styles_section',
				'settings'	=>	'prime2g_content_background',
			)
		)
	);


	$wp_customize->add_setting(
		'prime2g_footer_background',
		array(
			'capability'	=>	'edit_theme_options',
			'default'		=>	$footerbg,
			// 'transport'		=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'prime2g_footer_background',
			array(
				'label'		=>	__( 'Footer Background Color', PRIME2G_TEXTDOM ),
				'section'	=>	'prime2g_theme_styles_section',
				'settings'	=>	'prime2g_footer_background',
			)
		)
	);


}

}
