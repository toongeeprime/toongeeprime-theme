<?php defined( 'ABSPATH' ) || exit;

/*
#	Seems to increase initial server response time ?? TEST AGAIN
if ( ! is_admin() && ! ini_get( 'zlib.output_compression' ) ) {
#	Compress HTML webpage
if ( ! isset( $_SERVER[ 'HTTP_ACCEPT_ENCODING' ] ) ) { ob_start(); }
elseif ( strpos( ' ' . $_SERVER[ 'HTTP_ACCEPT_ENCODING' ], 'x-gzip' ) === false ) {
	if ( strpos( ' ' . $_SERVER[ 'HTTP_ACCEPT_ENCODING' ], 'gzip' ) === false ) { ob_start(); }
	elseif ( ! ob_start( "ob_gzhandler" ) ) { ob_start(); }
}
elseif ( ! ob_start( "ob_gzhandler" ) ) { ob_start(); }
}
*/


/**
 *	START THEME
 *	@package WordPress
 *	File created @since ToongeePrime Theme 1.0.49
 */
require_once 'run.php';


