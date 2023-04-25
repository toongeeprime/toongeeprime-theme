<?php defined( 'ABSPATH' ) || exit;

/**
 *	Theme's Customizer Colors
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	Renamed from prime2g_customizer_theme_styles @since 1.0.55
 */

if ( ! function_exists( 'prime2g_customizer_theme_colors' ) ) {

function prime2g_customizer_theme_colors( $wp_customize ) {

	$theStyles	=	new ToongeePrime_Styles();


	/**
	 *	DEFAULT STYLE VALUES:
	 */
	$brandClr	=	$theStyles->brandClr;
	$brandClr2	=	$theStyles->brandClr2;
	$bgcolor	=	$theStyles->siteBG;
	$headerbg	=	$theStyles->headerBG;
	$contentbg	=	$theStyles->contentBG;
	$footerbg	=	$theStyles->footerBG;

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
				'section'	=>	'prime2g_theme_colors_section',
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
				'section'	=>	'prime2g_theme_colors_section',
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
				'section'	=>	'prime2g_theme_colors_section',
				'settings'	=>	'prime2g_background_color',
			)
		)
	);


	$wp_customize->add_setting(
		'prime2g_header_background',
		array(
			'capability'	=>	'edit_theme_options',
			'default'		=>	$headerbg,
			'sanitize_callback'	=>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'prime2g_header_background',
			array(
				'label'		=>	__( 'Header Background Color', PRIME2G_TEXTDOM ),
				'section'	=>	'prime2g_theme_colors_section',
				'settings'	=>	'prime2g_header_background',
			)
		)
	);


	$wp_customize->add_setting(
		'prime2g_content_background',
		array(
			'capability'	=>	'edit_theme_options',
			'default'		=>	$contentbg,
			'sanitize_callback'	=>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'prime2g_content_background',
			array(
				'label'		=>	__( 'Content Background Color', PRIME2G_TEXTDOM ),
				'section'	=>	'prime2g_theme_colors_section',
				'settings'	=>	'prime2g_content_background',
			)
		)
	);


	$wp_customize->add_setting(
		'prime2g_footer_background',
		array(
			'capability'	=>	'edit_theme_options',
			'default'		=>	$footerbg,
			'sanitize_callback'	=>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'prime2g_footer_background',
			array(
				'label'		=>	__( 'Footer Background Color', PRIME2G_TEXTDOM ),
				'section'	=>	'prime2g_theme_colors_section',
				'settings'	=>	'prime2g_footer_background',
			)
		)
	);


}

}
