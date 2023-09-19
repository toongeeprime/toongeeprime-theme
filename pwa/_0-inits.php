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

$homeURL	=	get_home_url();
$name		=	get_bloginfo( 'name' );

if ( is_multisite() ) {
switch_to_blog( 1 );
if ( get_theme_mod( 'prime2g_route_apps_to_networkhome' ) ) {

$homeURL	=	network_home_url();
$name		=	get_bloginfo( 'name' );

}
restore_current_blog();
}


define( 'PRIME2G_PWA_VERSION', $version );
define( 'PRIME2G_PWA_SITENAME', html_entity_decode( $name ) );
define( 'PRIME2G_PWA_HOMEURL', trailingslashit( $homeURL ) );
define( 'PRIME2G_PWA_SLUG', 'app' );
define( 'PRIME2G_PWA_BTNID', 'pwa_install' );
define( 'PRIME2G_PWA_PATH', PRIME2G_THEME .'pwa/' );
define( 'PRIME2G_PWA_URL', PRIME2G_THEMEURL .'pwa/' );
define( 'PRIME2G_PWA_IMAGE', PRIME2G_PWA_URL .'images/' );
define( 'PRIME2G_PWA_FILE', PRIME2G_PWA_URL .'files/' );
#	Via site's home address NOT theme's pwa dir
define( 'PRIME2G_PWA_VIRTUAL_DIR', PRIME2G_PWA_HOMEURL . PRIME2G_PWA_SLUG . '/' );

define( 'PRIME2G_APPCACHE', 'prime2g_pwa_app_cache' );

#	Cache Strategies
define( 'PWA_CACHEFIRST', 'CacheFirst' );
define( 'PWA_CACHEONLY', 'CacheOnly' );
define( 'PWA_NETWORKFIRST', 'NetworkFirst' );
define( 'PWA_NETWORKONLY', 'NetworkOnly' );
define( 'PWA_STALE_REVAL', 'StaleWhileRevalidate' );

if ( ! defined( 'PWA_SHARER_BTN_ID' ) ) {
	define( 'PWA_SHARER_BTN_ID', 'sharerBTN' );
}

