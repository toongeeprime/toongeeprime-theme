<?php defined( 'ABSPATH' ) || exit;

/**
 *	RUN THEME
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	File renamed from files-loader.php @since 1.0.60
 */

require_once 'constants.php';

require_once 'website-shutdown.php';

/* @since 1.0.55 */
require_once 'smtp.php';


/**
 *	GET PHP FILES THROUGH DIRECTORIES ARRAY
 */
$directories	=	[ 'classes', 'includes', 'customizer', 'plugins', 'ajax', 'features', 'login', 'pwa', 'deprecated' ];
foreach( $directories as $dir ) {

	$folder	=	PRIME2G_THEME . $dir . '/';
	$files	=	scandir( $folder );
	foreach( $files as $file ) {
	$path	=	$folder . $file;
	if ( is_file( $path ) && pathinfo( $path )[ 'extension' ] === 'php' ) require_once $path;
	}
}


/* ENQUEUE FILES */
require_once 'enqueues.php';


/**
 *	PERFORMANCE
 *	@since 1.0.60
 */
require_once 'performance.php';


/**
 *	THEME PARTS
 */
$parts	=	[ 'adjust-templates', 'menus', 'sidebars', 'in-loops', 'homepage' ];
foreach( $parts as $part ) { require_once PRIME2G_PART . $part . '.php'; }


/**
 *	FLUSH REWRITE RULES
 */
add_action( 'after_switch_theme', 'prime_init_rewrite_flush' );
function prime_init_rewrite_flush() {
prime2g_register_custom_post_types();
	flush_rewrite_rules();
}
