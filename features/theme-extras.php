<?php defined( 'ABSPATH' ) || exit;
/**
 *	CONNECT EXTRA FEATURES
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.49
 */

if ( prime2g_use_extras() ) {
$folder	=	__DIR__ . '/extras/';
$files	=	scandir( $folder );

foreach( $files as $file ) {
	$path	=	$folder . $file;
	if ( is_file( $path ) && pathinfo( $path )[ 'extension' ] === 'php' ) require_once $path;
}

prime2g_dark_theme_switch();
new Prime2g_TaxonomyImageField;
}

