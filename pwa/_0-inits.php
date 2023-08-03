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
 *	Constants:
 */
$version	=	defined( 'CHILD2G_VERSION' ) ? CHILD2G_VERSION . PRIME2G_VERSION : PRIME2G_VERSION;

$name	=	html_entity_decode( get_bloginfo( 'name' ) );

if ( is_multisite() ) {
switch_to_blog( 1 );
if ( get_theme_mod( 'prime2g_route_apps_to_networkhome' ) ) {

$name	=	html_entity_decode( get_bloginfo( 'name' ) );

}
restore_current_blog();
}


define( 'PRIME2G_PWA_VERSION', $version );
define( 'PRIME2G_PWA_SITENAME', $name );
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


