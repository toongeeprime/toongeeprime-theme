<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: Create PWA Web Manifest & Activate App
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_Web_Manifest {

	private static $instance;

	public function __construct() {

	if ( ! isset( self::$instance ) ) {

		$GLOBALS[ 'theme_web_app' ]	=	'Web App Active';
		$GLOBALS[ 'pwa_css_class' ]	=	'has_pwa';

		Prime2g_PWA_Prompt::instance();

		new Prime2g_PWA_CSS();

		new Prime2g_PWA_File_Url_Manager();

		new Prime2g_PWA_Service_Worker();

		// Flushing rewrite rules
		add_action( 'after_switch_theme', 'flush_rewrite_rules' );
		add_action( 'customize_save_after', 'flush_rewrite_rules' );

		$wppwa_plugin	=	trailingslashit( WP_CONTENT_DIR ) . 'plugins/pwa/pwa.php';
		register_activation_hook( $wppwa_plugin, 'flush_rewrite_rules' );
		register_deactivation_hook( $wppwa_plugin, 'flush_rewrite_rules' );

		add_action( 'wp_head', function() { $this->html_metadata(); }, 11, 1 );

		add_action( 'upgrader_process_complete', [ $this, 'after_upgrades' ], 10, 2 );
	}

	return self::$instance;
	}


	public function after_upgrades( $upgrader_object, $options ) {
	if ( $options['type'] === 'theme' ) {
		foreach( $options['themes'] as $theme ) {
			if ( $theme === PRIME2G_TEXTDOM ) { flush_rewrite_rules(); return; }
		}
	}
	}


	public function appID() {
		$siteID	=	is_multisite() ? get_current_blog_id() : '';
		return 'pwaID' . $siteID . 'V' . PRIME2G_PWA_VERSION;
	}


	public function html_metadata() {
		$getIcons		=	Prime2g_PWA_Icons::instance();
		$manifesturl	=	Prime2g_PWA_File_Url_Manager::manifest_url();
		$manifest		=	$this->get_manifest();
		$iconURL		=	$getIcons->mainIcon()[ 'src' ];

echo '
<link rel="manifest" href="'. $manifesturl . '">
<meta name="web-application" content="toongeeprime-theme-web-app" />
<meta name="theme-color" content="'. esc_attr( $manifest['theme_color'] ) .'">
<meta name="apple-mobile-web-app-title" content="'. esc_attr( $manifest['name'] ) .'">
<meta name="application-name" content="'. esc_attr( $manifest['name'] ) .'">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<link rel="apple-touch-icon" sizes="144x144" href="'. esc_url( $iconURL ) .'" />
<meta name="apple-mobile-web-app-status-bar-style" content="default">'  # "black-translucent", "black" or "white"
. PHP_EOL;

// <meta name="apple-touch-startup-image" content="splash.png" media="orientation: '. $manifest['orientation'] .'">
// $linktags = '';
// if ( isset( $manifest[ 'icons' ] ) && ! empty( $manifest[ 'icons' ] ) ) {
	// $linktags .= '<link rel="apple-touch-icon" sizes="192x192" href="'. esc_url(  ) .'">' . PHP_EOL;
// }

// if ( isset( $manifest[ 'splash_icon' ] ) && ! empty( $manifest[ 'splash_icon' ] ) ) {
	// $linktags .=  '<link rel="apple-touch-icon" sizes="512x512" href="'. esc_url(  ) .'">' . PHP_EOL;
// }
	}


	public function manifest_rule() {
		global $wp;
		$file	=	Prime2g_PWA_File_Url_Manager::manifest_url( 'file' );
		add_rewrite_rule( 'pwapp/\bmanifest.json\b', 'index.php?pwapp=manifest', 'top' );
		// add_rewrite_rule( '/\b'. $file .'\b', 'index.php?pwapp=manifest', 'top' );
		$wp->add_query_var( 'pwapp' );
	}


	public function show_manifest() {
		if ( empty( $GLOBALS[ 'wp' ]->query_vars[ 'pwapp' ] ) ) { return; }
		$manifest	=	$this->get_manifest();
		wp_send_json( $manifest );
	}


	public function get_manifest() {
		$getIcons	=	Prime2g_PWA_Icons::instance();
		$data		=	$this->manifest_data();

		$startURL	=	Prime2g_PWA_File_Url_Manager::startURL();

		$data	=	array(
			'name'			=>	PRIME2G_PWA_SITENAME,
			'short_name'	=>	$data[ 'short_name' ],
			'description'	=>	$data[ 'description' ],
			'start_url'		=>	$startURL,
			'lang'			=>	get_locale(),
			'id'			=>	$this->appID(),
			'scope'			=>	'/',
			'dir'			=>	is_rtl() ? 'rtl' : 'ltr',
			'display'		=>	$data[ 'display' ],
			'orientation'	=>	$data[ 'orientation' ],

			'theme_color'	=>	$data[ 'theme_color' ],
			'background_color'	=>	$data[ 'bg_color' ],

			'icons'			=>	[ $getIcons->mainIcon() ],
			// 'screenshots'	=>	[]
		);

		// Add other available icons to icons array
		$additionalIcons	=	$getIcons->icons();
		$data[ 'icons' ]	=	array_merge( $data[ 'icons' ], $additionalIcons );

	return $data;
	}


	private function manifest_data() {
	$data	=	$this->get_manifest_data();

	if ( is_multisite() ) {
		switch_to_blog( 1 );
		if ( get_theme_mod( 'prime2g_route_apps_to_networkhome' ) ) {
			$data	=	$this->get_manifest_data();
		}
		restore_current_blog();
	}

	return $data;
	}


	private function get_manifest_data() {
	return [
		'id'	=>	$this->appID(),
		'short_name'	=>	get_theme_mod( 'prime2g_pwapp_shortname', 'Web App' ),
		'description'	=>	get_bloginfo( 'description' ),
		'display'		=>	get_theme_mod( 'prime2g_pwapp_display', 'standalone' ),
		'orientation'	=>	get_theme_mod( 'prime2g_pwapp_orientation', 'portrait' ),
		'theme_color'	=>	get_theme_mod( 'prime2g_pwapp_themecolor', '#ffffff' ),
		'bg_color'		=>	get_theme_mod( 'prime2g_pwapp_backgroundcolor', '#ffffff' ),
	];
	}

}

