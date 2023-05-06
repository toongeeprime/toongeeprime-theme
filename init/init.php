<?php defined( 'ABSPATH' ) || exit;

if ( substr_count( $_SERVER[ "HTTP_ACCEPT_ENCODING" ], "gzip" ) ) ob_start ( "ob_gzhandler" );
else ob_start();


/**
 *	START THEME
 *
 *	@package WordPress
 *	File created @since ToongeePrime Theme 1.0.49
 */

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
