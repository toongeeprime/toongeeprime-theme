<?php defined( 'ABSPATH' ) || exit;

/**
 *	Theme's Fonts Customizer
 *
 *	@package WordPress
 *	Separated function @since ToongeePrime Theme 1.0.55
 */

function prime2g_use_google_fonts() {
	return get_theme_mod( 'prime2g_use_theme_google_fonts', '1' );
}


if ( ! function_exists( 'prime2g_customizer_theme_fonts' ) ) {

function prime2g_customizer_theme_fonts( $wp_customize ) {

	/**
	 *	USE GOOGLE FONTS?
	 *	@since ToongeePrime Theme 1.0.55
	 */
	$wp_customize->add_setting(
		'prime2g_use_theme_google_fonts',
		array( 'type' => 'theme_mod', 'transport' => 'postMessage', 'default' => '1', 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control(
		'prime2g_use_theme_google_fonts',
		array(
			'label'		=>	__( 'Use Google Fonts?', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_use_theme_google_fonts',
			'section'	=>	'prime2g_theme_fonts_section'
		)
	);


	/**
	 *	DEFAULT FONT STYLE VALUES:
	 */
	$theStyles	=	new ToongeePrime_Styles();

	$bodyFont	=	$theStyles->bodyFont;
	$b_AltFont	=	$theStyles->bodyAltFont;
	$headFont	=	$theStyles->headFont;
	$h_AltFont	=	$theStyles->headingsAltFont;
	$t_FWeight	=	$theStyles->titlesF_Weight;

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
			'active_callback'	=>	'prime2g_use_google_fonts'
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
			'active_callback'	=>	'prime2g_use_google_fonts'
		)
	);

	/**
	 *	FALLBACK FONTS
	 *	@since ToongeePrime Theme 1.0.55
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
				'Times New Roman, Times, serif'	=>	__( 'Times New Roman, Times, serif', PRIME2G_TEXTDOM ),
				'Garamond, serif'	=>	__( 'Garamond, serif', PRIME2G_TEXTDOM ),
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
				'Arial, Helvetica, sans-serif'	=>	__( 'Arial, Helvetica, sans-serif', PRIME2G_TEXTDOM ),
				'Geneva, Verdana, sans-serif'	=>	__( 'Geneva, Verdana, sans-serif', PRIME2G_TEXTDOM ),
				'Times New Roman, Times, serif'	=>	__( 'Times New Roman, Times, serif', PRIME2G_TEXTDOM ),
				'Garamond, serif'	=>	__( 'Garamond, serif', PRIME2G_TEXTDOM ),
			),
		)
	);

	$wp_customize->add_setting(
		'prime2g_post_title_font_size',
		array(
			'type' => 'theme_mod', 'transport' => 'postMessage',
			'default' => '2.5', 'sanitize_callback' => 'sanitize_text_field'
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
				'max'		=>	'10',
				'step'		=>	'0.1',
			),
		'active_callback'	=>	function() { return ( is_singular() ); } # leave as is
		)
	);

	$wp_customize->add_setting(
		'prime2g_archive_title_font_size',
		array(
			'type' => 'theme_mod', 'transport' => 'postMessage',
			'default' => '3', 'sanitize_callback' => 'sanitize_text_field'
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
				'max'		=>	'10',
				'step'		=>	'0.1',
			),
		'active_callback'	=>	'is_archive'
		)
	);

	$wp_customize->add_setting(
		'prime2g_page_titles_font_weight',
		array(
			'type' => 'theme_mod', 'transport' => 'postMessage',
			'default' => $t_FWeight, 'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'prime2g_page_titles_font_weight',
		array(
			'label'		=>	__( 'Page Titles Font Weight', PRIME2G_TEXTDOM ),
			'type'		=>	'number',
			'settings'	=>	'prime2g_page_titles_font_weight',
			'section'	=>	'prime2g_theme_fonts_section',
			'input_attrs'	=>	array(
				'min'		=>	'300',
				'max'		=>	'800',
				'step'		=>	'100',
			)
		)
	);

	$wp_customize->add_setting(
		'prime2g_body_text_font_size',
		array(
			'type' => 'theme_mod', 'transport' => 'postMessage',
			'default' => '15', 'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'prime2g_body_text_font_size',
		array(
			'label'		=>	__( 'Body Text Font Size', PRIME2G_TEXTDOM ),
			'type'		=>	'number',
			'settings'	=>	'prime2g_body_text_font_size',
			'section'	=>	'prime2g_theme_fonts_section',
			'input_attrs'	=>	array(
				'min'		=>	'10',
				'max'		=>	'50',
				'step'		=>	'0.1',
			)
		)
	);

}

}

