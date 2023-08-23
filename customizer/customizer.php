<?php defined( 'ABSPATH' ) || exit;

/**
 *	Theme's Customizer
 *
 *	@link https://developer.wordpress.org/themes/customize-api/
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 * Register Theme Customizer Functions
 */
add_action( 'customize_register', 'prime2g_register_customizer_panel' );
add_action( 'customize_register', 'prime2g_customizer_sections' );
add_action( 'customize_register', 'prime2g_customizer_site_settings' );
add_action( 'customize_register', 'prime2g_customizer_theme_options' );
add_action( 'customize_register', 'prime2g_customizer_theme_colors' );
add_action( 'customize_register', 'prime2g_customizer_theme_fonts' );
add_action( 'customize_register', 'prime2g_customizer_theme_menus' );
add_action( 'customize_register', 'prime2g_customizer_front_page' );
add_action( 'customize_register', 'prime2g_customizer_singular_entries' );
add_action( 'customize_register', 'prime2g_customizer_home_and_archives' );
add_action( 'customize_register', 'prime2g_customizer_socialmedia_and_contacts' );
add_action( 'customize_register', 'prime2g_customizer_media_features' );
add_action( 'customize_register', 'prime2g_customizer_theme_extras' );
add_action( 'customize_register', 'prime2g_customizer_wp_header_image' );
add_action( 'customize_register', 'prime2g_customizer_misc_wp_settings' );
add_action( 'customize_register', 'prime2g_customizer_theme_pwa' );
add_action( 'customize_register', 'prime2g_customizer_smtp' );

if ( class_exists( 'woocommerce' ) ) {
	add_action( 'customize_register', 'prime2g_customizer_woocommerce_edits' );
}


/**
 *	Editing Customizer Defaults
 */
add_action( 'customize_register', 'prime2g_edit_customizer_wp_defaults' );
if ( ! function_exists( 'prime2g_edit_customizer_wp_defaults' ) ) {

function prime2g_edit_customizer_wp_defaults( $wp_customize ) {
	$wp_customize->remove_section( 'colors' );
	$wp_customize->get_control( 'display_header_text' )->label	=	__( 'Display Site Title &amp; Tagline - if no Logo', PRIME2G_TEXTDOM );
}

}


/**
 *	THEME'S MAIN CUSTOMIZER PANEL
 *
 *	Let ALL ToongeePrime Theme sections fall under this panel
 */
function prime2g_register_customizer_panel( $wp_customize ) {
$description	=	'<p>Customize ' . PRIME2G_THEMENAME . ' Options</p>';

	$wp_customize->add_panel(
		'prime2g_customizer_panel',
		array(
			'title'			=>	__( PRIME2G_THEMENAME, PRIME2G_TEXTDOM ),
			'description'	=>	__( $description, PRIME2G_TEXTDOM ),
			'priority'		=>	50,
		)
	);

}
