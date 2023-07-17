<?php defined( 'ABSPATH' ) || exit;

/**
 *	PWA ACTIVATOR
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

if ( prime2g_add_theme_pwa() ) {

if ( function_exists( 'prime2g_child_pwa_activator' ) ) {
	#	For Overriding in Child theme:
	prime2g_child_pwa_activator();
}
else {
	prime2g_pwa_activator();
}

}




function prime2g_pwa_activator() {

if ( get_theme_mod( 'prime2g_use_theme_pwa' ) ) {

// Use with WP PWA plugin if active
if ( class_exists( 'WP_Service_Workers' ) ) {

Prime2g_Hook_WP_PWA::instance();

}
else {

$GLOBALS[ 'pwapp' ]	=	Prime2g_Web_Manifest::instance();

}

}

}

