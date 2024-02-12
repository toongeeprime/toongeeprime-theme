<?php defined( 'ABSPATH' ) || exit;

/**
 *	CACHING CONTROL
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.56
 */

add_action( 'template_redirect', 'prime2g_cache_control_headers' );
if ( ! function_exists( 'prime2g_cache_control_headers' ) ) {
function prime2g_cache_control_headers() {
if ( empty( get_theme_mod( 'prime2g_activate_chache_controls' ) ) ) return;

/* @since ToongeePrime Theme 1.0.58 */
if ( is_multisite() ) {
switch_to_blog( 1 );
if ( get_theme_mod( 'prime2g_route_caching_to_networkhome' ) ) {
	$allow_clearing	=	! empty( get_theme_mod( 'prime2g_allow_chache_data_clearing' ) );
}
restore_current_blog();
} else {
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


if ( defined( 'WP_CACHE' ) && WP_CACHE === false ) return;	// @since 1.0.70

global $post;

	if (
	is_admin() || current_user_can( 'edit_others_posts' ) || false !== strpos( $_SERVER[ 'REQUEST_URI' ], '?' ) ||
	in_array( $GLOBALS[ 'pagenow' ], [ 'wp-login.php', 'wp-register.php' ] ) ||
	isset( $post ) && $post->prevent_caching === 'prevent'
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

	if ( is_feed() ) {
		header( 'Cache-Control: max-age=' . ( $time_feeds * $seconds_feeds ) );
	}
	else {
		header( 'Cache-Control: max-age=' . ( $time_single * $seconds_single ) );
	}
	}

}
}


/**
@.htaccess caching
#   CACHE CONTROL = REVALIDATE
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresDefault A1
    Header append Cache-Control must-revalidate
</IfModule>

<IfModule deflate_module>
# Enable compression for the following file types.
AddOutputFilterByType		\
DEFLATE						\
application/javascript		\
text/css					\
text/html					\
text/javascript				\
text/plain					\
text/xml
</IfModule>

## EXPIRES CACHING ##
<IfModule mod_expires.c>
ExpiresActive On
ExpiresByType image/jpg "access plus 1 month"
ExpiresByType image/jpeg "access plus 1 month"
ExpiresByType image/gif "access plus 1 month"
ExpiresByType image/png "access plus 1 month"
ExpiresByType text/css "access plus 1 month"
ExpiresByType application/pdf "access plus 1 month"
ExpiresByType application/json "access plus 1 month"
ExpiresByType text/x-javascript "access plus 1 month"
ExpiresByType application/x-shockwave-flash "access plus 1 month"
ExpiresByType image/x-icon "access plus 1 year"
ExpiresDefault "access plus 7 days"
</IfModule>
## EXPIRES CACHING ##

*/

