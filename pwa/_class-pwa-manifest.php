<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: Create PWA Web Manifest
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_Web_Manifest {
	/**
	 *	Instantiate
	 */
	private static $instance;

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance	=	new self();
		}
		return self::$instance;
	}

	public function __construct( $iconID = 0 ) {

	if ( ! isset( self::$instance ) ) {
		// Flush rewrite rules accordingly
		add_action( 'after_switch_theme', array( $this, 'on_activation' ) );

		add_action( 'init', array( $this, 'rewrite_rule' ) );
		add_action( 'wp_head', array( $this, 'manifest_head_link' ), 15, 0 );
		add_action( 'parse_request', function() use( $iconID ) {
			$this->show_manifest( $iconID );
		}, 10, 1 );
	}

	}


	public function on_activation() {
		$this->add_rewrite_rule();
		flush_rewrite_rules();
	}


	public function manifest_head_link() {
		echo '<link rel="manifest" href="' . esc_url( home_url() ) . '/pwapp/manifest" />' . PHP_EOL;
	}


	public function rewrite_rule() {
		add_rewrite_rule( 'pwapp/\bmanifest\b', 'index.php?pwapp=manifest', 'top' );

		global $wp;
		$wp->add_query_var( 'pwapp' );
	}


	public function appID() { return 'p2g_pwa_sID' . get_current_blog_id() . 'V' . PRIME2G_PWA_VERSION; }


	public function show_manifest( $iconID ) {
		if ( empty( $GLOBALS[ 'wp' ]->query_vars[ 'pwapp' ] ) ) { return; }

		$manifest	=	$this->get_manifest( $iconID );
		wp_send_json( $manifest );
	}

	public function get_manifest( $iconID ) {
		$siteName	=	esc_js( get_bloginfo( 'name' ) );
		$getIcons	=	Prime2g_PWA_Icons::instance();
		$startURL	=	get_theme_mod( 'prime2g_route_starturl_to_networkhome' ) ? network_home_url() : get_home_url();

		$data	=	array(
			'name'			=>	$siteName,
			'short_name'	=>	$this->get_shortname(),
			'description'	=>	get_bloginfo( 'description' ),
			'start_url'		=>	$startURL,
			'lang'			=>	get_locale(),
			'id'			=>	$this->appID(),
			'scope'			=>	'/',
			'dir'			=>	'ltr',
			'display'		=>	$this->get_display(),
			'orientation'	=>	$this->get_orientation(),

			'theme_color'	=>	$this->get_themecolor(),
			'background_color'	=>	$this->get_bgcolor(),

			'icons'			=>	[ $getIcons->defaultIcon() ],

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

