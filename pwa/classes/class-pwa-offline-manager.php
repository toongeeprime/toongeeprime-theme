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

	protected function offline_page() { require_once PRIME2G_PWA_PATH . 'theme/offline-page.php'; }


	public function __construct() {

		if ( ! isset( self::$instance ) ) {
			add_action( 'parse_request', array( $this, 'show_offline_output' ) );
		}

	return self::$instance;
	}


	protected function check_params( string $value ) {
	$offlineUrls	=	$this->get_offline_url();

	return (
		isset( $_GET[ 'offline' ] ) && $_GET[ 'offline' ] === $value ||
		prime2g_get_current_url() === $offlineUrls[ $value ]
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

		if ( $this->check_params( 'service-worker' ) ) {
			$output	=	Prime2g_PWA_Service_Worker::content();
			$this->do_output_die( $output, 'javascript' );
		}

		if ( $this->check_params( 'scripts' ) ) {
			$output	=	Prime2g_PWA_Offline_Scripts::content();
			$this->do_output_die( $output, 'javascript' );
		}

		$offlineUrls	=	$this->get_offline_url();
		$values	=	[ 'index', 'error', 'notcached' ];
		foreach ( $values as $value ) {
			if ( isset( $_GET[ 'offline' ] ) && $_GET[ 'offline' ] === $value ) {
				require_once $this->offline_page();	# Make params readable
				exit;
			}

			if ( prime2g_get_current_url() === $offlineUrls[ $value ] ) {
				echo file_get_contents( self::startURL() . '?offline=' . $value );
				exit;
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


	public static function manifest_url() {
		$startURL	=	self::startURL();
		return esc_url( $startURL ) . 'pwapp/manifest.json';
	}


	public function get_offline_url() {
	$startURL	=	self::startURL();
	$manifest	=	self::manifest_url();
	$offline	=	$startURL . 'offline/';

	return [
		'home'		=>	$startURL,
		'manifest'	=>	$manifest,
		'index'		=>	$offline . 'index.html',
		'error'		=>	$offline . 'error.html',
		'notcached'	=>	$offline . 'notcached.html',
		'scripts'	=>	$offline . 'scripts.js',
		'notfound'	=>	$offline . 'notfound.html',
		'service-worker'	=>	$startURL . 'service-worker.js'
	];
	}


	public static function theme_files( $get = 'array' ) {
	$filesDir	=	PRIME2G_FILE;
	$childDir	=	$childCss	=	$childJs	=	null;

	if ( is_child_theme() ) {
		$childDir	=	CHILD2G_FILE;
		$childCss	=	$childDir . "child.css";
		$childJs	=	$childDir . "child.js";
	}

	$array	=	[
		'resetcss'	=>	$filesDir . "reset-and-wp.css",
		'themecss'	=>	$filesDir . "theme.css",
		'themejs'	=>	$filesDir . "theme.js",
		'footerjs'	=>	$filesDir . "footer.js",
		'icons'		=>	prime2g_icons_file_url(),
		'childcss'	=>	$childCss,
		'childjs'	=>	$childJs
	];

	if ( $get === 'array' ) return $array;
	if ( $get === 'csv' ) return implode( ', ', $array );


	$ver	=	'?ver=' . PRIME2G_VERSION;
	$cVer	=	$childDir ? '?ver=' . CHILD2G_VERSION : '';

	$versioned	=	[
		'resetcss'	=>	$filesDir . "reset-and-wp.css" . $ver,
		'themecss'	=>	$filesDir . "theme.css" . $ver,
		'themejs'	=>	$filesDir . "theme.js" . $ver,
		'footerjs'	=>	$filesDir . "footer.js" . $ver,
		'icons'		=>	prime2g_icons_file_url() . $ver,
		'childcss'	=>	$childCss . $cVer,
		'childjs'	=>	$childJs . $cVer
	];

	if ( $get === 'versioned' ) return $versioned;
	if ( $get === 'csv_versioned' ) return implode( ', ', $versioned );
	}


	// Because of WP PWA??
	public function caching_routes() {
	// $homeUrl		=	self::startURL();
	// $siteroute	=	preg_quote( $homeUrl . 'offline/*' );
	$siteroute		=	$this->get_offline_url( '' );

	return [
		'offline'		=>	$siteroute,
		'images'		=>	PRIME2G_PWA_IMAGE,
		'files'			=>	PRIME2G_PWA_FILE,
		// 'assets'		=>	PRIME2G_PWA_THEMEASSETS,
		// 'child_assets'	=>	CHILD2G_PWA_THEMEASSETS,
		'pre_cache'		=>	CHILD2G_PWA_THEME_URL . 'precache/',
	];

	}

}
