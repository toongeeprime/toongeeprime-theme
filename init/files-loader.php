<?php defined( 'ABSPATH' ) || exit;

/**
 *	LOAD THEME' FILES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	Contents moved to this file being new @since ToongeePrime Theme 1.0.49
 */

require_once 'website-shutdown.php';

/**
 *	GET 'PHP' FILES THROUGH DIRECTORIES ARRAY
 */
$directories	=	[ 'classes', 'includes', 'customizer', 'plugins', 'ajax', 'features', 'pwa' ];

foreach( $directories as $dir ) {

	$folder	=	PRIME2G_THEME . $dir . '/';
	$files	=	scandir( $folder );

	foreach( $files as $file ) {
	$path	=	$folder . $file;

		if ( is_file( $path ) && pathinfo( $path )[ 'extension' ] === 'php' ) require_once $path;
	}

}


/**
 *	THEME PARTS
 */
$parts	=	[ 'adjust-templates', 'menus', 'sidebars', 'in-loops', 'homepage' ];
foreach( $parts as $part ) {
	require_once PRIME2G_PART . $part . '.php';
}



/**
 *	UPDATER
 */
require_once PRIME2G_THEME . 'update/updater-index.php';

