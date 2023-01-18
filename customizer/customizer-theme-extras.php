<?php defined( 'ABSPATH' ) || exit;

/**
 *	Extra Theme Features for Customizer
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.48.00
 */

if ( ! function_exists( 'prime2g_customizer_theme_extras' ) ) {

function prime2g_customizer_theme_extras( $wp_customize ) {

	/**
	 *	PAGE PRELOADER
	 */
	$wp_customize->add_setting( 'prime2g_use_page_preloader', array( 'type' => 'theme_mod', ) );
	$wp_customize->add_control(
		'prime2g_use_page_preloader',
		array(
			'label'		=>	__( 'Page Preloader', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_use_page_preloader',
			'section'	=>	'prime2g_theme_extras_section',
			'choices'	=>	array(
				''		=>	__( 'Preloader Off', PRIME2G_TEXTDOM ),
				'on'	=>	__( 'Preloader On', PRIME2G_TEXTDOM ),
				'use_logo'	=>	__( 'Preloader On: Use Site Logo', PRIME2G_TEXTDOM ),
				'use_icon'	=>	__( 'Preloader On: Use Site Icon', PRIME2G_TEXTDOM ),
			),
		)
	);


	/**
	 *	DARK THEME SWITCH
	 *	@since ToongeePrime Theme 1.0.49.00
	 */
	$wp_customize->add_setting( 'prime2g_dark_theme_switch', array( 'type' => 'theme_mod', ) );
	$wp_customize->add_control(
		'prime2g_dark_theme_switch',
		array(
			'label'		=>	__( 'Dark Theme Switch', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_dark_theme_switch',
			'section'	=>	'prime2g_theme_extras_section',
			'choices'	=>	array(
				''		=>	__( 'Off', PRIME2G_TEXTDOM ),
				'on'	=>	__( 'Activate Switch', PRIME2G_TEXTDOM ),
				'on_dbody'	=>	__( 'Activate - Ensure Dark Body', PRIME2G_TEXTDOM ),
			),
		)
	);


	/**
	 *	ADD "TEMPLATE PARTS" CUSTOM POST TYPE
	 *	@since ToongeePrime Theme 1.0.50.00
	 */
	$wp_customize->add_setting(
		'prime2g_cpt_template_parts',
		array(
			'type'		=>	'theme_mod',
			'transport'		=>	'postMessage', # no refresh
		)
	);
	$wp_customize->add_control(
		'prime2g_cpt_template_parts',
		array(
			'label'		=>	__( 'Add Template Parts to Theme', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_cpt_template_parts',
			'section'	=>	'prime2g_theme_extras_section',
		)
	);


}

}

