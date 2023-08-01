<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: Create PWA Web Manifest
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_Web_Manifest {

	private static $instance;

	public function __construct( $iconID = 0 ) {

	if ( ! isset( self::$instance ) ) {

		new Prime2g_PWA_Offline_Manager();

		// Flushing rewrite rules:
		add_action( 'after_switch_theme', 'flush_rewrite_rules' );
		add_action( 'customize_save_after', 'flush_rewrite_rules' );

		$wppwa_plugin	=	trailingslashit( WP_CONTENT_DIR ) . 'plugins/pwa/pwa.php';
		register_activation_hook( $wppwa_plugin, 'flush_rewrite_rules' );
		register_deactivation_hook( $wppwa_plugin, 'flush_rewrite_rules' );


		if ( ! class_exists( 'WP_Service_Workers' ) ) {
			new Prime2g_PWA_Service_Worker();
			add_action( 'init', [ $this, 'manifest_rule' ] );
			add_action( 'parse_request', function() use( $iconID ) {
				$this->show_manifest( $iconID );
			}, 10, 1 );
			add_action( 'wp_head', function() use( $iconID ) {
				$this->pwa_html_head( $iconID );
			}, 11, 1 );
			add_action( 'upgrader_process_complete', [ $this, 'after_upgrades' ], 10, 2 );
		}
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


	public function pwa_html_head( $iconID = 0 ) {
		$getIcons	=	Prime2g_PWA_Icons::instance();
		$manifest	=	Prime2g_PWA_Offline_Manager::manifest_url();
		$getIcons->html_metadata( $iconID );
		echo '<link rel="manifest" href="'. $manifest . '">' . PHP_EOL;
	}


	public function manifest_rule() {
		global $wp;
		add_rewrite_rule( 'pwapp/\bmanifest.json\b', 'index.php?pwapp=manifest', 'top' );

		$wp->add_query_var( 'pwapp' );
	}


	public function appID() {
		$siteID	=	is_multisite() ? get_current_blog_id() : '';
		return 'p2gPWA_ID' . $siteID . 'V' . PRIME2G_PWA_VERSION;
	}


	public function show_manifest( $iconID ) {
		if ( empty( $GLOBALS[ 'wp' ]->query_vars[ 'pwapp' ] ) ) { return; }

		$manifest	=	$this->get_manifest( $iconID );
		wp_send_json( $manifest );
	}


	public function get_manifest( $iconID ) {
		$siteName	=	html_entity_decode( get_bloginfo( 'name' ) );
		$getIcons	=	Prime2g_PWA_Icons::instance();
		$data		=	$this->manifest_data();

		$startURL	=	Prime2g_PWA_Offline_Manager::startURL();

		$data	=	array(
			'name'			=>	$siteName,
			'short_name'	=>	$data[ 'short_name' ],
			'description'	=>	$data[ 'description' ],
			'start_url'		=>	$startURL,
			'lang'			=>	get_locale(),
			'id'			=>	$data[ 'id' ],
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
		$additionalIcons	=	$getIcons->icons( $iconID );
		$data[ 'icons' ]	=	array_merge( $data[ 'icons' ], $additionalIcons );

	return $data;
	}


	private function manifest_data() {

	if ( is_multisite() ) {
	$data	=	$this->get_manifest_data();

		switch_to_blog( 1 );
		if ( get_theme_mod( 'prime2g_route_apps_to_networkhome' ) ) {
			$data	=	$this->get_manifest_data();
		}
		restore_current_blog();
	}
	else {
		$data	=	$this->get_manifest_data();
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
