<?php defined( 'ABSPATH' ) || exit;
/**
 *	CACHING CONTROL
 *	NOTE: It seems WP prevents cache control header in admin
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.56
 */

// Removed the business of using action hook @1.0.91 - it doesn't work in a hook
// But had to return it @1.0.97 due to headers already sent issues... REVIEW

add_action( 'template_redirect', 'prime2g_caching' );
function prime2g_caching() {
/*	START CACHING:	*/
// if ( defined( 'WP_CACHE' ) && WP_CACHE === false ) return;	# always blocks file???	# @since 1.0.70
if ( empty( get_theme_mod( 'prime2g_activate_chache_controls' ) ) ) return;

/* @since 1.0.58 */
if ( is_multisite() ) {
switch_to_blog( 1 );
if ( get_theme_mod( 'prime2g_route_caching_to_networkhome' ) ) {
	$allow_clearing	=	! empty( get_theme_mod( 'prime2g_allow_chache_data_clearing' ) );
}
restore_current_blog();
}
else {
	$allow_clearing	=	! empty( get_theme_mod( 'prime2g_allow_chache_data_clearing' ) );
}

if ( isset( $_GET[ 'clear-data' ] ) && $allow_clearing ) {

$clear_data	=	$_GET[ 'clear-data' ];

if ( $clear_data === 'cache' ) header( 'Clear-Site-Data: "cache"' );
if ( $clear_data === 'cookies' ) header( 'Clear-Site-Data: "cookies"' );
if ( $clear_data === 'storage' ) header( 'Clear-Site-Data: "storage"' );
if ( $clear_data === 'all' ) header( 'Clear-Site-Data: "*"' );
if ( $clear_data === 'logout' ) header( 'Clear-Site-Data: "cache", "cookies", "storage", "executionContexts"' );

return;
}
/* @since 1.0.58 End */


global $post;

if (
is_admin() || current_user_can( 'edit_others_posts' ) || false !== strpos( $_SERVER[ 'REQUEST_URI' ], '?' ) ||
in_array( $GLOBALS[ 'pagenow' ], [ 'wp-login.php', 'wp-register.php' ] ) ||
isset( $post ) && $post->prevent_caching === '1'
) {
	header( 'Cache-Control: max-age=0,no-cache,no-store,must-revalidate' );
}
else {

$time_single	=	(int) get_theme_mod( 'prime2g_chache_time_singular' );
$seconds_single	=	(int) get_theme_mod( 'prime2g_chache_seconds_singular', DAY_IN_SECONDS );
$time_feeds		=	(int) get_theme_mod( 'prime2g_chache_time_feeds' );
$seconds_feeds	=	(int) get_theme_mod( 'prime2g_chache_seconds_feeds', DAY_IN_SECONDS );

if ( is_multisite() ) {
switch_to_blog( 1 );
if ( get_theme_mod( 'prime2g_route_caching_to_networkhome' ) ) {
	$time_single	=	(int) get_theme_mod( 'prime2g_chache_time_singular' );
	$seconds_single	=	(int) get_theme_mod( 'prime2g_chache_seconds_singular' );
	$time_feeds		=	(int) get_theme_mod( 'prime2g_chache_time_feeds' );
	$seconds_feeds	=	(int) get_theme_mod( 'prime2g_chache_seconds_feeds' );
}
restore_current_blog();
}

$cache_age	=	$time_single * $seconds_single;
$feeds_age	=	$time_feeds * $seconds_feeds;

	if ( is_feed() ) {
		header( 'Cache-Control: max-age=' . ( $feeds_age ) );
	}
	else {
		header( 'Cache-Control: max-age=' . ( $cache_age ) );
	}
}

}


