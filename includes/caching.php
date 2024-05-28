<?php defined( 'ABSPATH' ) || exit;
/**
 *	CACHING CONTROL
 *	NOTE: It seems WP prevents cache control header in admin
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.56
 *	Removed the business of using action hook @since 1.0.91 - it doesn't work in a hook
 */

// if ( defined( 'WP_CACHE' ) && WP_CACHE === false ) return;	# always prevents file???	// @since 1.0.70
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






/**
 *	HTACCESS CACHING
 *	@since 1.0.91
 */
if ( ! current_user_can( 'update_core' ) ) return;

if ( str_contains( $_SERVER[ 'HTTP_ACCEPT_ENCODING' ], 'br' ) ) {
#	https://httpd.apache.org/docs/2.4/mod/mod_brotli.html#precompressed
#	Serve BROTLI compressed files if they exist and the client accepts brotli
$encoding_control	=	'<IfModule mod_headers.c>
RewriteCond "%{HTTP:Accept-encoding}" "br"
RewriteCond "%{REQUEST_FILENAME}\.br" "-s"
RewriteRule "^(.*)\.(css|js|html|json)"			"$1\.$2\.$3\.$4\.br" [QSA]

#	Serve correct content types, and prevent double compression
RewriteRule "\.css\.br$" "-" [T=text/css,E=no-brotli:1]
RewriteRule "\.js\.br$"  "-" [T=text/javascript,E=no-brotli:1]
RewriteRule "\.html\.br$"  "-" [T=text/html,E=no-brotli:1]
RewriteRule "\.json\.br$"  "-" [T=text/json,E=no-brotli:1]

<FilesMatch "(\.js\.br|\.css\.br|\.html\.br|\.json\.br)$">
	#	Serve correct encoding type
	Header append Content-Encoding br

	#	Force proxies to cache brotli & non-brotli files separately
	Header append Vary Accept-Encoding
</FilesMatch>
</IfModule>';
}
else {
#	Serve GZIP compressed files if they exist and the client accepts gzip
$encoding_control	=	'<IfModule mod_headers.c>
RewriteCond "%{HTTP:Accept-encoding}" "gzip"
RewriteCond "%{REQUEST_FILENAME}\.gz" -s
RewriteRule "^(.*)\.(css|js|html|json)"		"$1\.$2\.$3\.$4\.gz" [QSA]

#	Serve correct content types, and prevent mod_deflate double gzip
RewriteRule "\.css\.gz$" "-" [T=text/css,E=no-gzip:1]
RewriteRule "\.js\.gz$"  "-" [T=text/javascript,E=no-gzip:1]
RewriteRule "\.html\.gz$"  "-" [T=text/html,E=no-gzip:1]
RewriteRule "\.json\.gz$"  "-" [T=text/json,E=no-gzip:1]

<FilesMatch "(\.js\.gz|\.css\.gz|\.html\.gz|\.json\.gz)$">
	Header append Content-Encoding gzip

	#	Force proxies to cache gzipped & non-gzipped files separately
	Header append Vary Accept-Encoding
</FilesMatch>
</IfModule>';
}


$htaccess_content	=	'

#	ToongeePrime Theme Caching
<IfModule deflate_module>
#	Enable compression for the following file types
AddOutputFilterByType		\
DEFLATE						\
application/javascript		\
text/css					\
text/html					\
text/javascript				\
text/json					\
text/plain					\
text/xml
</IfModule>

'. $encoding_control .'

<ifModule mod_headers.c>
<ifModule mod_expires.c>
	<filesMatch "\.(jpeg|jpg|png|gif|flv|pdf|swf|ico|avif|webp|mp4|mp3|avi|mov)$">
		ExpiresActive On
		ExpiresDefault "access plus 30 days"
		Header set Cache-Control "public, max-age='. MONTH_IN_SECONDS .'"
	</filesMatch>
	<filesMatch "\.(css|js|eot|ttf|ttc|otf|woff)$">
		ExpiresActive On
		ExpiresDefault "access plus 7 days"
		Header set Cache-Control "public, max-age='. WEEK_IN_SECONDS .'"
	</filesMatch>
</ifModule>
</ifModule>
#	ToongeePrime Theme Caching End

';


if ( get_theme_mod( 'prime2g_write_htaccess_chache_rules' ) ) {
	if ( ! wp_cache_get( 'htaccess_writecacherules_PRIME2G_CACHEGROUP' ) ) {
		$root	=	Prime2gFileWriter::siterootpath();
		$file	=	new Prime2gFileWriter( $root, '.htaccess' );
		$file->write( $htaccess_content );
		wp_cache_delete( 'htaccess_deletecacherules_PRIME2G_CACHEGROUP' );
		wp_cache_set( 'htaccess_writecacherules_PRIME2G_CACHEGROUP', true, '', WEEK_IN_SECONDS );
	}
}
else {
	if ( ! wp_cache_get( 'htaccess_deletecacherules_PRIME2G_CACHEGROUP' ) ) {
		$root	=	Prime2gFileWriter::siterootpath();
		$file	=	new Prime2gFileWriter( $root, '.htaccess' );
		$file->delete( $htaccess_content );
		wp_cache_delete( 'htaccess_writecacherules_PRIME2G_CACHEGROUP' );
		wp_cache_set( 'htaccess_deletecacherules_PRIME2G_CACHEGROUP', true, '', WEEK_IN_SECONDS );
	}
}

/**
@ .htaccess
<IfModule mod_expires.c>
ExpiresActive On
ExpiresByType image/jpg "access plus 1 month"
ExpiresByType image/jpeg "access plus 1 month"
ExpiresByType image/gif "access plus 1 month"
ExpiresByType image/png "access plus 1 month"
ExpiresByType image/webp "access plus 1 month"
ExpiresByType text/css "access plus 1 month"
ExpiresByType text/html "access plus 1 month"
ExpiresByType application/pdf "access plus 1 month"
ExpiresByType application/json "access plus 1 month"
ExpiresByType text/x-javascript "access plus 1 month"
ExpiresByType application/x-shockwave-flash "access plus 1 month"
ExpiresByType image/x-icon "access plus 1 year"
ExpiresDefault "access plus 7 days"
#	ExpiresDefault A1
Header append Cache-Control must-revalidate
</IfModule>
*/

