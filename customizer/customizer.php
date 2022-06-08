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
add_action( 'customize_register', 'prime2g_customizer_theme_options' );
add_action( 'customize_register', 'prime2g_customizer_theme_styles' );
add_action( 'customize_register', 'prime2g_customizer_theme_archives' );
add_action( 'customize_register', 'prime2g_customizer_socialmedia_and_contacts' );

if ( class_exists( 'woocommerce' ) ) {
	add_action( 'customize_register', 'prime2g_customizer_woocommerce_edits' );
}


/**
 *	Editing Customizer Defaults
 */
add_action( 'customize_register', 'prime2g_edit_customizer_defaults' );
if ( ! function_exists( 'prime2g_edit_customizer_defaults' ) ) {

function prime2g_edit_customizer_defaults( $wp_customize ) {
	$wp_customize->remove_section( 'colors' );
	$wp_customize->get_control( 'display_header_text' )->label = __( 'Display Site Title &amp; Tagline - if no Logo', 'toongeeprime-theme' );
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
			'title'			=>	__( PRIME2G_THEMENAME, 'toongeeprime-theme' ),
			'description'	=>	__( $description, 'toongeeprime-theme' ),
			'priority'		=>	50,
		)
	);

}

