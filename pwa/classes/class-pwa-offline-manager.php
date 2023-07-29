<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: PWA Offline Contents Manager
 *
 *	Determine files, assets, etc. to be operational offline / with service worker
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_PWA_Offline_Manager {

	private static $instance;

	public function __construct() {

		if ( ! isset( self::$instance ) ) {
			// flush_rewrite_rules();	# for dev
			add_action( 'parse_request', array( $this, 'show_offline_output' ) );
		}

	return self::$instance;
	}


	protected function offline_page() {
		require_once PRIME2G_PWA_PATH . 'theme/offline-page.php';
	}


	protected function check_params( string $value, string $offlinePage ) {
	return (
		isset( $_GET[ 'offline' ] ) && $_GET[ 'offline' ] === $value ||
		prime2g_get_current_url() === $this->get_offline_url( $offlinePage )
	);
	}


	protected function do_output_die( $output, $type = 'json' ) {
		if ( ! headers_sent() ) {
			header( 'Content-Type: application/'. $type .'; charset=' . get_option( 'blog_charset' ) );
		}
		echo $output;
		die;
	}


	// Virtual files output
	public function show_offline_output() {

		if ( $this->check_params( 'offline', 'index' ) ) {
			$output	=	$this->offline_page();
			wp_send_json( $output );
		}

		if ( $this->check_params( 'scripts', 'script' ) ) {
			$output	=	Prime2g_PWA_Offline_Scripts::content();
			$this->do_output_die( $output, 'javascript' );
		}

		if ( $this->check_params( 'service-worker', 'sw' ) ) {
			$output	=	Prime2g_PWA_Service_Worker::content();
			$this->do_output_die( $output, 'javascript' );
		}

		$cacheFiles		=	$this->files_to_cache();
		$cacheFilesV	=	$this->files_to_cache( 'versioned' );

		// Match version requests
		foreach ( $cacheFilesV as $vkey => $vurl ) {
			if ( prime2g_get_current_url() === $vurl ) {
				foreach ( $cacheFiles as $key => $url ) {
					if ( $vkey === $key ) return $url;
				}
			}
		}

	}


	public static function startURL() {
	$startURL	=	get_home_url();

	if ( is_multisite() ) {
		switch_to_blog( 1 );
		if ( get_theme_mod( 'prime2g_route_apps_to_networkhome' ) )
			$startURL	=	network_home_url();
		restore_current_blog();
	}

	return trailingslashit( $startURL );
	}


	public function get_offline_url( $get ) {
	$startURL	=	self::startURL();

	if ( $get === 'sw' ) return $startURL . 'service-worker.js'; # must be @ the top level scope

	$url	=	$startURL . 'offline/';

		switch( $get ) {
			case 'index'	:	$end	=	'index.html'; break;
			case 'script'	:	$end	=	'scripts.js'; break;
			default	:	$end	=	''; break;
		}

	return $url . $end;
	}


	public static function files_to_cache( $get = 'array' ) {
	$filesDir	=	PRIME2G_FILE;

	$array	=	[
		'reset_css'	=>	$filesDir . "reset-and-wp.css",
		'theme_css'	=>	$filesDir . "theme.css",
		'theme_js'	=>	$filesDir . "theme.js",
		'footer_js'	=>	$filesDir . "footer.js",
	];

	if ( $get === 'array' ) return $array;
	if ( $get === 'csv' ) return implode( ', ', $array );

	$ver	=	'?ver=' . PRIME2G_VERSION;
	foreach ( $array as $key => $file ) {
		$files[]	=	$file . $ver;
	}
	$versioned	=	array_combine( array_keys( $array ), $files );

	if ( $get === 'versioned' ) return $versioned;
	if ( $get === 'csv_versioned' ) return implode( ', ', $versioned );

	}


	// Because of WP PWA?
	public function caching_routes() {
	// $homeUrl		=	self::startURL();
	// $siteroute	=	preg_quote( $homeUrl . 'offline/*' );
	$siteroute		=	$this->get_offline_url( '' );

	return [
		'offline'		=>	$siteroute,
		'images'		=>	PRIME2G_PWA_IMAGE,
		'files'			=>	PRIME2G_PWA_FILES,
		'assets'		=>	PRIME2G_PWA_THEMEASSETS,
		'child_assets'	=>	CHILD2G_PWA_THEMEASSETS,
		'pre_cache'		=>	CHILD2G_PWA_THEME_URL . 'precache/',
	];

	}

}

