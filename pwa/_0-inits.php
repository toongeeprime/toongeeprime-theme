<?php defined( 'ABSPATH' ) || exit;

/**
 *	PWA INITIAL MATTERS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

add_action( 'after_setup_theme', 'prime2g_appicons_image_sizes', 1000 );
function prime2g_appicons_image_sizes() {
   add_image_size( 'pwa-small-icon', 192, 192 );
   add_image_size( 'pwa-big-icon', 512, 512 );
}


/**
 *	Constants
 */
$version	=	defined( 'CHILD2G_VERSION' ) ? CHILD2G_VERSION . PRIME2G_VERSION : PRIME2G_VERSION;
define( 'PRIME2G_PWA_VERSION', $version );
define( 'PRIME2G_PWA_BTNID', 'pwa_install' );
define( 'PRIME2G_PWA_PATH', PRIME2G_THEME .'pwa/' );
define( 'PRIME2G_PWA_URL', PRIME2G_THEMEURL .'pwa/' );
define( 'PRIME2G_PWA_IMAGE', PRIME2G_PWA_URL .'images/' );

// Cache Strategies
define( 'PWA_CACHEFIRST', 'CacheFirst' );
define( 'PWA_CACHEONLY', 'CacheOnly' );
define( 'PWA_NETWORKFIRST', 'NetworkFirst' );
define( 'PWA_NETWORKONLY', 'NetworkOnly' );
define( 'PWA_STALE_REVAL', 'StaleWhileRevalidate' );


// @ Child Theme
define( 'CHILD2G_PWA_THEME_URL', trailingslashit( get_stylesheet_directory_uri() ) . 'pwa-theme/' );
define( 'CHILD2G_PWA_THEME_DIR', trailingslashit( get_stylesheet_directory() ) . 'pwa-theme/' );
define( 'CHILD2G_PWA_THEMEASSETS', CHILD2G_PWA_THEME_URL . 'assets/' );
define( 'CHILD2G_PWA_OFFLINEPAGE_URL', CHILD2G_PWA_THEME_URL . 'offline.html' );
define( 'CHILD2G_PWA_OFFLINEPAGE_FILE', CHILD2G_PWA_THEME_DIR . 'offline.html' );

