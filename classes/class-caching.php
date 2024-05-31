<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: CACHING
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.91
 */

class Prime2gCaching {
public	$cachename_write_htacess	=	'htaccess_writecacherules_PRIME2G_CACHEGROUP',
		$cachename_delete_htacess	=	'htaccess_deletecacherules_PRIME2G_CACHEGROUP';


function __construct() {
	add_action( 'admin_init', [ $this, 'write_htaccess_content' ], 0 );
	add_action( 'switch_theme', [ $this, 'erase_caching' ], 0 );
	$this->write_htaccess_content();
}


static function htaccess_content() {
if ( str_contains( $_SERVER[ 'HTTP_ACCEPT_ENCODING' ], 'br' ) ) {	#	condition may not be relevant as only admins can affect this
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
	<filesMatch "\.(css|js|eot|ttf|ttc|otf|woff|woff2)$">
		ExpiresActive On
		ExpiresDefault "access plus 7 days"
		Header set Cache-Control "public, max-age='. WEEK_IN_SECONDS .'"
	</filesMatch>
</ifModule>
</ifModule>
#	ToongeePrime Theme Caching End

';

return $htaccess_content;
}


private function htaccess_writer( $action = '' ) {
$root	=	Prime2gFileWriter::siterootpath();
$file	=	new Prime2gFileWriter( $root, '.htaccess' );

$action === 'delete' ? $file->delete( self::htaccess_content() ) : $file->write( self::htaccess_content() );
}


function erase_caching() {
if ( defined( 'PRIME2G_TEXTDOM' ) && ! wp_cache_get( $this->cachename_write_htacess ) ) {
	$this->htaccess_writer( 'delete' );
	wp_cache_delete( $this->cachename_write_htacess );
	wp_cache_delete( $this->cachename_delete_htacess );
}
}


function write_htaccess_content() {
if ( ! current_user_can( 'update_core' ) ) return;

if ( get_theme_mod( 'prime2g_write_htaccess_chache_rules' ) ) {
	if ( ! wp_cache_get( $this->cachename_write_htacess ) ) {
		$this->htaccess_writer();
		wp_cache_delete( $this->cachename_delete_htacess );
		wp_cache_set( $this->cachename_write_htacess, true, '', WEEK_IN_SECONDS );
	}
}
else {
	if ( ! wp_cache_get( $this->cachename_delete_htacess ) ) {
		$this->htaccess_writer( 'delete' );
		wp_cache_delete( $this->cachename_write_htacess );
		wp_cache_set( $this->cachename_delete_htacess, true, '', WEEK_IN_SECONDS );
	}
}
}


}

