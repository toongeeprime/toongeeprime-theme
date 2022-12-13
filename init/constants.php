<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME CONSTANTS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.49.00
 */

define( 'PRIME2G_TEXTDOM', 'toongeeprime-theme' );
define( 'PRIME2G_VERSION', wp_get_theme( PRIME2G_TEXTDOM )->get( 'Version' ) );
define( 'PRIME2G_THEMEURL', get_template_directory_uri() . '/' );
define( 'PRIME2G_THEME', get_template_directory() . '/' );
define( 'PRIME2G_CLASSDIR', PRIME2G_THEME . 'classes/' );
define( 'PRIME2G_PART', PRIME2G_THEME . 'parts/' );
define( 'PRIME2G_SINGULAR', PRIME2G_PART . 'singular/' );
define( 'PRIME2G_ARCHIVE', PRIME2G_PART . 'archive/' );
define( 'PRIME2G_IMAGE', PRIME2G_THEMEURL . '/images/' );
define( 'PRIME2G_THEMENAME', wp_get_theme()->get( 'Name' ) );

