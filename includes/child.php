<?php defined( 'ABSPATH' ) || exit;

/**
 *	CHILD THEME RELATED FUNCTIONS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.35
 */

/**
 *	CONSTANTS
 */
$uri	=	trailingslashit( get_stylesheet_directory_uri() );
define( 'CHILD2G_URI', $uri );
define( 'CHILD2G_PART', get_stylesheet_directory() . '/parts/' );
define( 'CHILD2G_SINGULAR', CHILD2G_PART . 'singular/' );
define( 'CHILD2G_ARCHIVE', CHILD2G_PART . 'archive/' );
define( 'CHILD2G_IMAGE', $uri . 'images/' );
define( 'CHILD2G_FILE', $uri . 'files/' );



function child2g_placeholder_url( $return = false ) {
	if ( $return )
		return CHILD2G_URI . 'images/placeholder.gif';
	else
		echo CHILD2G_URI . 'images/placeholder.gif';
}


function child2g_has_placeholder() {
	return file_exists( get_stylesheet_directory() . '/images/placeholder.gif' );
}

