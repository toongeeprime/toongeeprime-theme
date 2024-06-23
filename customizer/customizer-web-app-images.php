<?php defined( 'ABSPATH' ) || exit;
/**
 *	PWA Images
 *	DRY: @ prime2g_customizer_theme_pwa()
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.97
 */

if ( ! function_exists( 'prime2g_customizer_theme_pwa_images' ) ) {
function prime2g_customizer_theme_pwa_images( $wp_customize ) {

$postMsg_text	=	[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ];

	$wp_customize->add_setting( 'prime2g_pwapp_primaryicon', $postMsg_text );
	$wp_customize->add_control( new WP_Customize_Cropped_Image_Control(
	$wp_customize, 'prime2g_pwapp_primaryicon', array(
		'label'		=>	__( 'Main App Icon (PNG)', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_pwapp_primaryicon',
		'section'	=>	'prime2g_theme_pwa_images_section',
		'width'		=>	144,
		'height'	=>	144
	) ) );

	$wp_customize->add_setting( 'prime2g_pwa_screenshot_1', $postMsg_text );
	$wp_customize->add_control( new WP_Customize_Cropped_Image_Control(
	$wp_customize, 'prime2g_pwa_screenshot_1', array(
		'label'		=>	__( 'Screenshot 1', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_pwa_screenshot_1',
		'section'	=>	'prime2g_theme_pwa_images_section',
		'width'		=>	720,
		'height'	=>	1280,
		'flex_width'=>	true,
		'flex_height'=>	true
	) ) );

	$wp_customize->add_setting( 'prime2g_pwa_screenshot_descr_1', $postMsg_text );
	$wp_customize->add_control( 'prime2g_pwa_screenshot_descr_1', [
	'label'		=>	__( 'Screenshot 1 Description', PRIME2G_TEXTDOM ),
	'settings'	=>	'prime2g_pwa_screenshot_descr_1',
	'section'	=>	'prime2g_theme_pwa_images_section',
	'input_attrs'	=>	array(
		'placeholder'	=>	'Something cool about this screenshot',
		'maxlength'	=>	70
	) ] );

	$wp_customize->add_setting( 'prime2g_pwa_screenshot_2', $postMsg_text );
	$wp_customize->add_control( new WP_Customize_Cropped_Image_Control(
	$wp_customize, 'prime2g_pwa_screenshot_2', [
		'label'		=>	__( 'Screenshot 2', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_pwa_screenshot_2',
		'section'	=>	'prime2g_theme_pwa_images_section',
		'width'		=>	720,
		'height'	=>	1280,
		'flex_width'=>	true,
		'flex_height'=>	true
	] ) );

	$wp_customize->add_setting( 'prime2g_pwa_screenshot_descr_2', $postMsg_text );
	$wp_customize->add_control( 'prime2g_pwa_screenshot_descr_2', [
	'label'		=>	__( 'Screenshot 2 Description', PRIME2G_TEXTDOM ),
	'settings'	=>	'prime2g_pwa_screenshot_descr_2',
	'section'	=>	'prime2g_theme_pwa_images_section',
	'input_attrs'	=>	array(
		'placeholder'	=>	'Something cool about this screenshot',
		'maxlength'	=>	70
	) ] );

	$wp_customize->add_setting( 'prime2g_pwa_screenshot_3', $postMsg_text );
	$wp_customize->add_control( new WP_Customize_Cropped_Image_Control(
	$wp_customize, 'prime2g_pwa_screenshot_3', [
		'label'		=>	__( 'Screenshot 3', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_pwa_screenshot_3',
		'section'	=>	'prime2g_theme_pwa_images_section',
		'width'		=>	720,
		'height'	=>	1280,
		'flex_width'=>	true,
		'flex_height'=>	true
	] ) );

	$wp_customize->add_setting( 'prime2g_pwa_screenshot_descr_3', $postMsg_text );
	$wp_customize->add_control( 'prime2g_pwa_screenshot_descr_3', [
	'label'		=>	__( 'Screenshot 3 Description', PRIME2G_TEXTDOM ),
	'settings'	=>	'prime2g_pwa_screenshot_descr_3',
	'section'	=>	'prime2g_theme_pwa_images_section',
	'input_attrs'	=>	array(
		'placeholder'	=>	'Something cool about this screenshot',
		'maxlength'	=>	70
	) ] );

	$wp_customize->add_setting( 'prime2g_pwa_screenshot_narrow', $postMsg_text );
	$wp_customize->add_control( new WP_Customize_Cropped_Image_Control(
	$wp_customize, 'prime2g_pwa_screenshot_narrow', [
		'label'		=>	__( 'Narrow Screenshot', PRIME2G_TEXTDOM ),
		'description'=>	__( '<strong>*FOR NARROW SCREENS!</strong>', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_pwa_screenshot_narrow',
		'section'	=>	'prime2g_theme_pwa_images_section',
		'width'		=>	720,
		'height'	=>	1280,
		'flex_width'=>	true,
		'flex_height'=>	true
	] ) );

	$wp_customize->add_setting( 'prime2g_pwa_screenshot_descr_narrow', $postMsg_text );
	$wp_customize->add_control( 'prime2g_pwa_screenshot_descr_narrow', [
	'label'		=>	__( 'Narrow Screenshot Description', PRIME2G_TEXTDOM ),
	'settings'	=>	'prime2g_pwa_screenshot_descr_narrow',
	'section'	=>	'prime2g_theme_pwa_images_section',
	'input_attrs'	=>	array(
		'placeholder'	=>	'Something cool about this narrow screenshot',
		'maxlength'	=>	70
	) ] );

	$wp_customize->add_setting( 'prime2g_pwa_screenshot_wide', $postMsg_text );
	$wp_customize->add_control( new WP_Customize_Cropped_Image_Control(
	$wp_customize, 'prime2g_pwa_screenshot_wide', [
		'label'		=>	__( 'Wide Screenshot', PRIME2G_TEXTDOM ),
		'description'=>	__( '<strong>*RECOMMENDED FOR DESKTOPS.</strong>', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_pwa_screenshot_wide',
		'section'	=>	'prime2g_theme_pwa_images_section',
		'width'		=>	1280,
		'height'	=>	720,
		'flex_width'=>	true,
		'flex_height'=>	true
	] ) );

	$wp_customize->add_setting( 'prime2g_pwa_screenshot_descr_wide', $postMsg_text );
	$wp_customize->add_control( 'prime2g_pwa_screenshot_descr_wide', [
	'label'		=>	__( 'Wide Screenshot Description', PRIME2G_TEXTDOM ),
	'settings'	=>	'prime2g_pwa_screenshot_descr_wide',
	'section'	=>	'prime2g_theme_pwa_images_section',
	'input_attrs'	=>	array(
		'placeholder'	=>	'Something cool about this wide screenshot',
		'maxlength'	=>	70
	) ] );

}
}

