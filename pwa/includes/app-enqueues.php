<?php defined( 'ABSPATH' ) || exit;

/**
 *	FILE ENQUEUES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

add_action( 'wp_enqueue_scripts', 'prime2g_enqueue_pwa_files' );
function prime2g_enqueue_pwa_files() {
if ( prime2g_add_theme_pwa() ) {
$version	=	PRIME2G_VERSION;

	wp_enqueue_style(
		'prime2g_pwa_css',
		PRIME2G_PWA_URL . 'files/app.css',
		array( 'prime2g_css' ),
		$version
	);

	wp_register_script(
		'prime2g_pwa_js',
		PRIME2G_PWA_URL . 'files/app.js',
		array( 'prime2g_js' ),
		$version,
		true
	);

	wp_enqueue_script( 'prime2g_pwa_js' );

	wp_enqueue_script(
		'prime2g_pwa_scripts',
		PRIME2G_PWA_VIRTUAL_DIR . 'scripts.js',
		[ 'prime2g_pwa_js' ],
		$version,
		true
	);

}
}



add_action( 'customize_controls_enqueue_scripts', 'prime2g_customizer_pwa_enqueues' );
function prime2g_customizer_pwa_enqueues() {
if ( prime2g_add_theme_pwa() ) {

    wp_enqueue_script(
		'prime2g_customizer_pwa_js',
		PRIME2G_PWA_URL . 'files/customizer.js',
		[ 'jquery', 'customize-controls' ],
		PRIME2G_VERSION,
		true
	);

}
}

