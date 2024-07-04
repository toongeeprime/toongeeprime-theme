<?php defined( 'ABSPATH' ) || exit;
/**
 *	THEME PWA
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */
if ( ! prime2g_add_theme_pwa() ) return;

/**
 *	REQUIRE 'PHP' FILES VIA DIRECTORIES ARRAY
 */
$directories	=	[ 'classes', 'includes', 'push' ];

foreach( $directories as $dir ) {
	$folder	=	PRIME2G_PWA_PATH . $dir .'/';
	$files	=	scandir( $folder );
	foreach( $files as $file ) {
	$path	=	$folder . $file;
		if ( is_file( $path ) && pathinfo( $path )[ 'extension' ] === 'php' ) require_once $path;
	}
}


/*	ACTIVATE	*/
if ( prime2g_activate_theme_pwa() ) {

if ( function_exists( 'prime2g_child_pwa_activator' ) )
	prime2g_child_pwa_activator();
else
	new Prime2g_Web_Manifest;

}



/*
// Use with WP PWA plugin. **For later review
if ( class_exists( 'WP_Service_Workers' ) ) {
Prime2g_Hook_WP_PWA::instance();
}
else {}
*/


