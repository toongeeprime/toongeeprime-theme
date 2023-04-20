<?php defined( 'ABSPATH' ) || exit;

/**
 *	Theme's Fonts Customizer
 *
 *	@package WordPress
 *	Separated function @since ToongeePrime Theme 1.55.00
 */

if ( ! function_exists( 'prime2g_customizer_theme_fonts' ) ) {

function prime2g_customizer_theme_fonts( $wp_customize ) {

	$theStyles	=	new ToongeePrime_Styles();

	/**
	 *	DEFAULT FONT STYLE VALUES:
	 */
	$bodyFont	=	$theStyles->bodyFont;
	$b_AltFont	=	$theStyles->bodyAltFont;
	$headFont	=	$theStyles->headFont;
	$h_AltFont	=	$theStyles->headingsAltFont;

	/**
	 *	FONTS
	 */
	$themeFonts	=	prime2g_theme_fonts();

	$wp_customize->add_setting(
		'prime2g_site_headings_font',
		array( 'type' => 'theme_mod', 'default' => $headFont, 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control(
		'prime2g_site_headings_font',
		array(
			'label'		=>	__( 'Font for Site\'s Headings', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_site_headings_font',
			'section'	=>	'prime2g_theme_fonts_section',
			'choices'	=>	$themeFonts,
		)
	);

	$wp_customize->add_setting(
		'prime2g_site_body_font',
		array( 'type' => 'theme_mod', 'default' => $bodyFont, 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control(
		'prime2g_site_body_font',
		array(
			'label'		=>	__( 'Font for Site\'s Body', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_site_body_font',
			'section'	=>	'prime2g_theme_fonts_section',
			'choices'	=>	$themeFonts,
		)
	);

	/**
	 *	FALLBACK FONTS
	 *	@since ToongeePrime Theme 1.0.55.00
	 */
	$wp_customize->add_setting(
		'prime2g_body_fallback_fonts',
		array(
			'type' => 'theme_mod', 'transport' => 'postMessage',
			'default' => $b_AltFont, 'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'prime2g_body_fallback_fonts',
		array(
			'label'		=>	__( 'Body Text Alt Fonts', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_body_fallback_fonts',
			'section'	=>	'prime2g_theme_fonts_section',
			'choices'	=>	array(
				'Arial, Helvetica, sans-serif'	=>	__( 'Arial, Helvetica, sans-serif', PRIME2G_TEXTDOM ),
				'Geneva, Verdana, sans-serif'	=>	__( 'Geneva, Verdana, sans-serif', PRIME2G_TEXTDOM ),
			),
		)
	);

	$wp_customize->add_setting(
		'prime2g_headings_fallback_fonts',
		array(
			'type' => 'theme_mod', 'transport' => 'postMessage',
			'default' => $h_AltFont, 'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'prime2g_headings_fallback_fonts',
		array(
			'label'		=>	__( 'Heading Texts Alt Fonts', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_headings_fallback_fonts',
			'section'	=>	'prime2g_theme_fonts_section',
			'choices'	=>	array(
				'Times New Roman, Times, serif'	=>	__( 'Times New Roman, Times, serif', PRIME2G_TEXTDOM ),
				'Garamond, serif'	=>	__( 'Garamond, serif', PRIME2G_TEXTDOM ),
			),
		)
	);

	$wp_customize->add_setting(
		'prime2g_post_title_font_size',
		array(
			'type' => 'theme_mod', 'transport' => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'prime2g_post_title_font_size',
		array(
			'label'		=>	__( 'Post Title Font Size', PRIME2G_TEXTDOM ),
			'type'		=>	'number',
			'settings'	=>	'prime2g_post_title_font_size',
			'section'	=>	'prime2g_theme_fonts_section',
			'input_attrs'	=>	array(
				'min'		=>	'1',
				'max'		=>	'100',
			),
			'active_callback'	=>	function() { return ( is_singular() ); },
		)
	);

	$wp_customize->add_setting(
		'prime2g_archive_title_font_size',
		array(
			'type' => 'theme_mod', 'transport' => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'prime2g_archive_title_font_size',
		array(
			'label'		=>	__( 'Archive Title Font Size', PRIME2G_TEXTDOM ),
			'type'		=>	'number',
			'settings'	=>	'prime2g_archive_title_font_size',
			'section'	=>	'prime2g_theme_fonts_section',
			'input_attrs'	=>	array(
				'min'		=>	'1',
				'max'		=>	'100',
			),
			'active_callback'	=>	function() { return ( ! is_singular() ); },
		)
	);

}

}
