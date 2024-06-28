<?php defined( 'ABSPATH' ) || exit;
/**
 *	RUN THEME
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	File renamed from files-loader.php @since 1.0.60
 */

require_once 'constants.php';
require_once 'website-shutdown.php';
require_once 'private-site.php';	// @since 1.0.90

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
 *	@since 1.0.91
 */
new Prime2gCaching;


/**
 *	@since 1.0.60
 */
require_once 'performance.php';


/**
 *	THEME PARTS
 */
$parts	=	[ 'adjust-templates', 'menus', 'sidebars', 'in-loops', 'homepage' ];
foreach( $parts as $part ) { require_once PRIME2G_PART . $part . '.php'; }


/**
 *	UPON THEME ACTIVATE
 */
add_action( 'after_switch_theme', 'prime2g_theme_activated' );
function prime2g_theme_activated() {
	prime2g_register_custom_post_types();
	flush_rewrite_rules();
}


/**
 *	UPON THEME DEACTIVATE
 *	@since 1.0.91
 */
add_action( 'switch_theme', 'prime2g_theme_switched_away', 1, 2 );
function prime2g_theme_switched_away( $new_name, $new_theme ) {
flush_rewrite_rules();

#	Ensure theme's .htaccess rules are cleared
if ( ! $new_theme->parent() && get_template() !== 'toongeeprime-theme' ||
$new_theme->parent()->template !== 'toongeeprime-theme' ) {
$content	=	Prime2gCaching::htaccess_content();
$htaccess	=	Prime2gFileWriter::siterootpath( '.htaccess' );
$init_content	=	file_get_contents( $htaccess );
$new_content	=	str_replace( $content,  '', $init_content );
$f	=	fopen( $htaccess, "w+" );	# empty file before update
fwrite( $f, $new_content );
fclose( $f );
}

}


