<?php defined( 'ABSPATH' ) || exit;

if ( ! isset( $_SERVER[ 'HTTP_ACCEPT_ENCODING' ] ) ) { ob_start(); }
elseif ( strpos( ' ' . $_SERVER[ 'HTTP_ACCEPT_ENCODING' ], 'x-gzip' ) == false ) {
	if ( strpos( ' ' . $_SERVER[ 'HTTP_ACCEPT_ENCODING' ], 'gzip' ) == false ) { ob_start(); }
    elseif ( ! ob_start( "ob_gzhandler" ) ) { ob_start(); }
}
elseif ( ! ob_start( "ob_gzhandler" ) ) { ob_start(); }

/**
 *	START THEME
 *
 *	@package WordPress
 *	File created @since ToongeePrime Theme 1.0.49
 */

/**
 *	@since ToongeePrime Theme 1.0.55
 */
require_once 'smtp.php';

/**
 *	THEME CONSTANTS
 */
require_once 'constants.php';

/**
 *	LOAD THEME FILES
 */
require_once 'files-loader.php';

/**
 *	ENQUEUE FILES
 */
require_once 'enqueues.php';
