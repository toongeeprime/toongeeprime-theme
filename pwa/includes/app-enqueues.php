<?php defined( 'ABSPATH' ) || exit;
/**
 *	APP ENQUEUES & PERFORMANCE
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 *	prime2g_optimize_theme_files logic @since 1.0.97
 */

add_action( 'wp_enqueue_scripts', 'prime2g_enqueue_pwa_files' );
function prime2g_enqueue_pwa_files() {
if ( prime2g_activate_theme_pwa() && empty( get_theme_mod( 'prime2g_optimize_theme_files' ) ) ) {

wp_register_script(
	'prime2g_pwa_js', PRIME2G_PWA_URL .'files/app.js', [ 'prime2g_js' ], PRIME2G_VERSION, [ 'in_footer' => true, 'strategy' => 'async' ]
);

wp_enqueue_script( 'prime2g_pwa_js' );

wp_enqueue_script(
	'prime2g_pwa_scripts', PRIME2G_PWA_VIRTUAL_URL .'scripts.js', [ 'prime2g_pwa_js' ], PRIME2G_VERSION, [ 'in_footer' => true, 'strategy' => 'async' ]
);

}
}


add_action( 'customize_controls_enqueue_scripts', 'prime2g_customizer_pwa_enqueues' );
function prime2g_customizer_pwa_enqueues() {
if ( prime2g_add_theme_pwa() ) {
wp_enqueue_script(
	'prime2g_customizer_pwa_js',
	PRIME2G_PWA_VIRTUAL_URL . 'customizer-v-js.js',
	[ 'jquery', 'customize-controls' ],
	PRIME2G_VERSION,
	true
);
}
}


if ( ! empty( get_theme_mod( 'prime2g_optimize_theme_files' ) ) ) {

add_action( 'wp_footer', function() {
echo '<script id="prime2g_pwa_js">'. file_get_contents( PRIME2G_PWA_URL .'files/app.js' ) .'</script>';
echo '<script id="prime2g_pwa_scripts">'. file_get_contents( PRIME2G_PWA_VIRTUAL_URL .'scripts.js' ) .'</script>';
}, 50 );

}

