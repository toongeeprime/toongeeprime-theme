<?php defined( 'ABSPATH' ) || exit;

/**
 *	ESSENTIAL MATTERS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

add_action( 'customize_controls_enqueue_scripts', 'prime2g_customizer_pwa_enqueues' );
function prime2g_customizer_pwa_enqueues() {
    wp_enqueue_script(
		'prime2g_customizer_pwa_js',
		PRIME2G_PWA_URL . 'files/customizer.js',
		array( 'jquery', 'customize-controls' ),
		PRIME2G_VERSION,
		true
	);
}

