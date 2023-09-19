<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: PWA Files and URLs Manager
 *
 *	Determine files, assets, etc. to be operational offline / with service worker
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_PWA_File_Url_Manager {

	private static $instance;

	protected function offline_page() { require_once PRIME2G_PWA_PATH . 'theme/offline-page.php'; }


	public function __construct() {

		if ( ! isset( self::$instance ) ) {
			self::urls_cache();
			add_action( 'parse_request', array( $this, 'show_file_output' ) );
		}

	return self::$instance;
	}


	protected function check_params( string $value ) {
	$get_url	=	$this->get_file_url();

	return (
		// isset( $_GET[ PRIME2G_PWA_SLUG ] ) && $_GET[ PRIME2G_PWA_SLUG ] === $value ||
		prime2g_get_current_url() === $get_url[ $value ]
	);
	}


	protected function do_output_die( $output, $type = 'json' ) {
		if ( ! headers_sent() ) {
			header( 'Content-Type: application/'. $type .'; charset=' . get_option( 'blog_charset' ) );
		}
		if ( $type === 'json' ) {
			wp_send_json( $output );
		}
		else {
			echo $output;
		}
		die;
	}


	//	Virtual files output
	public function show_file_output() {

		if ( $this->check_params( 'manifest' ) ) {
			$manifest	=	new Prime2g_Web_Manifest();
			$output		=	$manifest->get_manifest();
			$this->do_output_die( $output );
		}

		if ( $this->check_params( 'service-worker' ) ) {
			$output	=	Prime2g_PWA_Service_Worker::content();
			$this->do_output_die( $output, 'javascript' );
		}

		if ( $this->check_params( 'scripts' ) ) {
			$output	=	Prime2g_PWA_Scripts::content();
			$this->do_output_die( $output, 'javascript' );
		}

		$get_url	=	$this->get_file_url();
		$values	=	[ 'offline', 'error', 'notcached' ];
		foreach ( $values as $value ) {
			if ( isset( $_GET[ PRIME2G_PWA_SLUG ] ) && $_GET[ PRIME2G_PWA_SLUG ] === $value ) {
				require_once $this->offline_page();
				exit;
			}

			if ( prime2g_get_current_url() === $get_url[ $value ] ) {
				echo file_get_contents( self::startURL() . '?'. PRIME2G_PWA_SLUG .'=' . $value );
				exit;
			}
		}

	}


	public static function startURL() {
		return PRIME2G_PWA_HOMEURL;
	}


	public static function manifest_url( $ext = '' ) {
		if ( $ext === 'json_file' ) return 'manifest.json';
		if ( $ext === 'file' ) return 'app.webmanifest';

		$startURL	=	self::startURL();
		if ( $ext === 'json' ) return esc_url( $startURL ) . 'manifest.json';
		return esc_url( $startURL ) . 'app.webmanifest';
	}


	public function get_file_url() {
	$homeURL	=	PRIME2G_PWA_HOMEURL;
	$addHome	=	get_theme_mod( 'prime2g_add_homepage_to_cache', 0 ) ? $homeURL : '';
	$app_dir	=	PRIME2G_PWA_VIRTUAL_DIR;
	$ver		=	isset( $_GET[ 'ver' ] ) ? '?ver=' . PRIME2G_VERSION : '';

	return [
		'home'		=>	$addHome,
		'manifest'	=>	self::manifest_url(),
		'offline'	=>	$app_dir . 'offline.html',
		'error'		=>	$app_dir . 'error.html',
		'notcached'	=>	$app_dir . 'notcached.html',
		'scripts'	=>	$app_dir . 'scripts.js' . $ver,
		'notfound'	=>	$app_dir . 'notfound.html',
		'service-worker'	=>	$homeURL . 'service-worker.js'
	];
	}


	public static function theme_files( $get = 'array' ) {
	$childDir	=	$childCss	=	$childJs	=	$childLogin	=	null;
	$childTheme	=	is_child_theme();

	$filesDir		=	PRIME2G_FILE;
	$appFile		=	PRIME2G_PWA_FILE;
	$virtual_dir	=	PRIME2G_PWA_VIRTUAL_DIR;
	if ( $childTheme ) $childDir	=	CHILD2G_FILE;

	if ( is_multisite() ) {
		switch_to_blog( 1 );
		if ( get_theme_mod( 'prime2g_route_apps_to_networkhome' ) ) {
			$filesDir	=	PRIME2G_FILE;
			if ( $childTheme ) $childDir	=	CHILD2G_FILE;
		}
		restore_current_blog();
	}

	if ( $childTheme ) {
		$childCss	=	$childDir . "child.css";
		$childJs	=	$childDir . "child.js";
		$childLogin	=	$childDir . "login.css";
	}

	// parent login.css not included

	$array	=	[
		'resetcss'	=>	$filesDir . "reset-and-wp.css",
		'themecss'	=>	$filesDir . "theme.css",
		'themejs'	=>	$filesDir . "theme.js",
		'footerjs'	=>	$filesDir . "footer.js",
		'appcss'	=>	$appFile . "app.css",
		'appjs'		=>	$appFile . "app.js",
		'scripts'	=>	$virtual_dir . "scripts.js",
		'icons'		=>	prime2g_icons_file_url(),	# == Bootstrap icons
		'childcss'	=>	$childCss,
		'childlogin'=>	$childLogin,
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
		'appcss'	=>	$appFile . "app.css" . $ver,
		'appjs'		=>	$appFile . "app.js" . $ver,
		'scripts'	=>	$virtual_dir . "scripts.js" . $ver,
		'icons'		=>	prime2g_icons_file_url() . $ver,
		'childcss'	=>	$childCss . $cVer,
		'childlogin'=>	$childLogin . $cVer,
		'childjs'	=>	$childJs . $cVer
	];

	if ( $get === 'versioned' ) return $versioned;
	if ( $get === 'csv_versioned' ) return implode( ', ', $versioned );
	}


	public static function urls_cache() {
	$cache	=	wp_cache_get( 'pwa_urls', PRIME2G_APPCACHE );

	if ( false === $cache ) {
		$appIcons	=	[];

		$icons		=	new Prime2g_PWA_Icons();
		$allicons	=	$icons->icons();
		foreach ( $allicons as $ii ) {
			$appIcons[]	=	$ii[ 'src' ];
		}

		$keys		=	[ 'appicon', 'appicons' ];
		$values		=	[ $icons->mainIcon()[ 'src' ], $appIcons ];

		$array		=	array_combine( $keys, $values );
		wp_cache_set( 'pwa_urls', $array, PRIME2G_APPCACHE, DAY_IN_SECONDS );
		$cache	=	wp_cache_get( 'pwa_urls', PRIME2G_APPCACHE );
	}

	return $cache;
	}

}

