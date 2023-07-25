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
		// Flush rewrite rules accordingly:
		// Consider flushing on version updates also
		add_action( 'after_switch_theme', array( $this, 'on_activation' ) );

		$wppwa_plugin	=	trailingslashit( WP_CONTENT_DIR ) . 'plugins/pwa/pwa.php';
		register_activation_hook( $wppwa_plugin, 'on_activation' );
		register_deactivation_hook( $wppwa_plugin, 'on_activation' );

		new Prime2g_PWA_Offline_Manager();

		if ( ! class_exists( 'WP_Service_Workers' ) ) {
			new Prime2g_PWA_Service_Worker();
			add_action( 'init', array( $this, 'rewrite_rule' ) );
			add_action( 'wp_head', array( $this, 'pwa_html_head' ), 15, 0 );
			add_action( 'parse_request', function() use( $iconID ) {
				$this->show_manifest( $iconID );
			}, 10, 1 );
		}
	}

	}


	public function on_activation() { $this->rewrite_rule(); flush_rewrite_rules(); }


	public function pwa_html_head() {
		$getIcons	=	Prime2g_PWA_Icons::instance();
		$getIcons->html_head();	# register icons <link>
		echo '<link rel="manifest" href="' . esc_url( home_url() ) . '/pwapp/manifest" />' . PHP_EOL;
	}


	public function rewrite_rule() {
		global $wp;
		add_rewrite_rule( 'pwapp/\bmanifest\b', 'index.php?pwapp=manifest', 'top' );

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

		$startURL	=	get_home_url();

		if ( is_multisite() ) {
		switch_to_blog( 1 );

		if ( get_theme_mod( 'prime2g_route_starturl_to_networkhome' ) )
			$startURL	=	network_home_url();

		restore_current_blog();
		}

		$data	=	array(
			'name'			=>	$siteName,
			'short_name'	=>	$this->get_shortname(),
			'description'	=>	get_bloginfo( 'description' ),
			'start_url'		=>	$startURL,
			'lang'			=>	get_locale(),
			'id'			=>	$this->appID(),
			'scope'			=>	'/',
			'dir'			=>	is_rtl() ? 'rtl' : 'ltr',
			'display'		=>	$this->get_display(),
			'orientation'	=>	$this->get_orientation(),

			'theme_color'	=>	$this->get_themecolor(),
			'background_color'	=>	$this->get_bgcolor(),

			'icons'			=>	[ $getIcons->mainIcon() ],

			// 'screenshots'	=>	[]
		);

		$additionalIcons	=	$getIcons->icons( $iconID );
		$data[ 'icons' ]	=	array_merge( $data[ 'icons' ], $additionalIcons );

	return $data;
	}

	private function get_shortname() { return get_theme_mod( 'prime2g_pwapp_shortname', 'Web App' ); }

	private function get_display() { return get_theme_mod( 'prime2g_pwapp_display', 'standalone' ); }

	private function get_orientation() { return get_theme_mod( 'prime2g_pwapp_orientation', 'portrait' ); }

	private function get_themecolor() { return get_theme_mod( 'prime2g_pwapp_themecolor', '#ffffff' ); }

	private function get_bgcolor() { return get_theme_mod( 'prime2g_pwapp_backgroundcolor', '#ffffff' ); }
}

