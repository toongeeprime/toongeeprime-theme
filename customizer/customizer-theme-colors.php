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
	$theStyles	=	$theStyles->defaults();


	/**
	 *	DEFAULT STYLE VALUES:
	 */
	$brandClr	=	$theStyles->brandcolor;
	$brandClr2	=	$theStyles->brandcolor2;
	$bgcolor	=	$theStyles->bgcolor;
	$headerbg	=	$theStyles->headerbg;
	$contentbg	=	$theStyles->contentbg;
	$buttonbg	=	$theStyles->buttonbg;
	$footerbg	=	$theStyles->footerbg;

	/**
	 *	COLOURS
	 */
if ( ! defined( 'CHILD_BRANDCOLOR' ) ) {
	$wp_customize->add_setting( 'prime2g_primary_brand_color',
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
}


if ( ! defined( 'CHILD_BRANDCOLOR2' ) ) {
	$wp_customize->add_setting( 'prime2g_secondary_brand_color',
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
}


if ( ! defined( 'CHILD_SITEBG' ) ) {
	$wp_customize->add_setting( 'prime2g_background_color',
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
}


if ( ! defined( 'CHILD_HEADERBG' ) ) {
	$wp_customize->add_setting( 'prime2g_header_background',
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
}


if ( ! defined( 'CHILD_CONTENTBG' ) ) {
	$wp_customize->add_setting( 'prime2g_content_background',
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
}


if ( ! defined( 'CHILD_BUTTONBG' ) ) {
	$wp_customize->add_setting( 'prime2g_button_background',
		array(
			'capability'	=>	'edit_theme_options',
			'default'		=>	$buttonbg,
			'sanitize_callback'	=>	'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'prime2g_button_background',
			array(
				'label'		=>	__( 'Buttons Background Color', PRIME2G_TEXTDOM ),
				'section'	=>	'prime2g_theme_colors_section',
				'settings'	=>	'prime2g_button_background',
			)
		)
	);
}


if ( ! defined( 'CHILD_FOOTERBG' ) ) {
	$wp_customize->add_setting( 'prime2g_footer_background',
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

}
