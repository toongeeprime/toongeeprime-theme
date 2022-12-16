<?php defined( 'ABSPATH' ) || exit;

/**
 *	LOAD THEME' FILES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */


/**
 *	GET 'PHP' FILES THROUGH DIRECTORIES ARRAY
 */
$directories	=	[ 'classes', 'includes', 'customizer', 'plugins', 'ajax', 'features' ];

foreach( $directories as $dir ) {

	$folder	=	PRIME2G_THEME . $dir . '/';
	$files	=	scandir( $folder );

	foreach( $files as $file ) {
	$path	=	$folder . $file;

		if ( is_file( $path ) && pathinfo( $path )[ 'extension' ] == 'php' ) require_once $path;
	}

}


/**
 *	THEME PARTS
 */
$parts	=	[ 'menus', 'sidebars', 'in-loops', 'homepage' ];
foreach( $parts as $part ) {
	require_once PRIME2G_PART . $part . '.php';
}



/**
 *	UPDATER
 */
require_once PRIME2G_THEME . 'update/updater-index.php';

