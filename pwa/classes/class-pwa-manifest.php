<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: Create PWA Web Manifest
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_Web_Manifest {

	private static $instance;

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance	=	new self();
		}
		return self::$instance;
	}

	public function __construct( $iconID = 0 ) {

	if ( ! isset( self::$instance ) ) {

		new Prime2g_PWA_Offline_Manager();

		// Flush rewrite rules accordingly:
		// Consider flushing on version updates also*****
		add_action( 'after_switch_theme', array( $this, 'on_activation' ) );
		add_action( 'customize_save_after', array( $this, 'on_activation' ) );

		$wppwa_plugin	=	trailingslashit( WP_CONTENT_DIR ) . 'plugins/pwa/pwa.php';
		register_activation_hook( $wppwa_plugin, 'on_activation' );
		register_deactivation_hook( $wppwa_plugin, 'on_activation' );


		if ( ! class_exists( 'WP_Service_Workers' ) ) {
			new Prime2g_PWA_Service_Worker();
			add_action( 'init', array( $this, 'rewrite_rule' ) );
			add_action( 'parse_request', function() use( $iconID ) {
				$this->show_manifest( $iconID );
			}, 10, 1 );
			// add_action( 'wp_head', array( $this, 'pwa_html_head' ), 15, 0 );
			add_action( 'wp_head', function() use( $iconID ) {
				$this->pwa_html_head( $iconID );
			}, 11, 1 );
		}
	}

	return self::$instance;
	}


	public function on_activation() { $this->rewrite_rule(); flush_rewrite_rules(); }


	public function pwa_html_head( $iconID = 0 ) {
		$getIcons	=	Prime2g_PWA_Icons::instance();
		$startURL	=	Prime2g_PWA_Offline_Manager::startURL();
		$getIcons->html_metadata( $iconID );	# register icons <link>
		echo '<link rel="manifest" href="' . esc_url( $startURL ) . 'pwapp/manifest.json" />' . PHP_EOL;
	}


	public function rewrite_rule() {
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
	$data	=	[
		'id'	=>	$this->appID(),
		'short_name'	=>	get_theme_mod( 'prime2g_pwapp_shortname', 'Web App' ),
		'description'	=>	get_bloginfo( 'description' ),
		'display'		=>	get_theme_mod( 'prime2g_pwapp_display', 'standalone' ),
		'orientation'	=>	get_theme_mod( 'prime2g_pwapp_orientation', 'portrait' ),
		'theme_color'	=>	get_theme_mod( 'prime2g_pwapp_themecolor', '#ffffff' ),
		'bg_color'		=>	get_theme_mod( 'prime2g_pwapp_backgroundcolor', '#ffffff' ),
	];

	if ( is_multisite() ) {
	switch_to_blog( 1 );
	if ( get_theme_mod( 'prime2g_route_apps_to_networkhome' ) ) {

		$data	=	[
			'id'	=>	$this->appID(),
			'short_name'	=>	get_theme_mod( 'prime2g_pwapp_shortname', 'Web App' ),
			'description'	=>	get_bloginfo( 'description' ),
			'display'		=>	get_theme_mod( 'prime2g_pwapp_display', 'standalone' ),
			'orientation'	=>	get_theme_mod( 'prime2g_pwapp_orientation', 'portrait' ),
			'theme_color'	=>	get_theme_mod( 'prime2g_pwapp_themecolor', '#ffffff' ),
			'bg_color'		=>	get_theme_mod( 'prime2g_pwapp_backgroundcolor', '#ffffff' ),
		];

	}
	restore_current_blog();
	}

	return $data;
	}

}
