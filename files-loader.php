<?php defined( 'ABSPATH' ) || exit;

/**
 *	INCLUDE / REQUIRE THEME' FILES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */
require_once PRIME2G_THEME . 'features/features-index.php';
require_once PRIME2G_THEME . 'classes/classes-index.php';


/**
 *	THEME PARTS
 */
require_once PRIME2G_PARTS . 'in-loops.php';
require_once PRIME2G_PARTS . 'sidebars.php';
require_once PRIME2G_PARTS . 'menus.php';
require_once PRIME2G_PARTS . 'homepage.php';


/**
 *	UPDATER
 */
require_once PRIME2G_THEME . 'update/updater-index.php';


/**
 *	THEME DIRECTORIES' PATHS
 */
$incFolder	=	PRIME2G_THEME . 'includes/';
$ctmFolder	=	PRIME2G_THEME . 'customizer/';


/**
 *	GET ALL FILES IN DIRECTORY
 */
$incFiles	=	scandir( $incFolder );
$ctmFiles	=	scandir( $ctmFolder );


/**
 *	REQUIRE PHP FILES
 */
// INCLUDES
foreach( $incFiles as $incs ) {
$incPath	=	$incFolder . $incs;

	if ( pathinfo( $incPath )[ 'extension' ] == 'php' ) require_once $incPath;
}


// CUSTOMIZER
foreach( $ctmFiles as $ctms ) {
$ctmPath	=	$ctmFolder . $ctms;

	if ( pathinfo( $ctmPath )[ 'extension' ] == 'php' ) require_once $ctmPath;
}

