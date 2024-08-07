<?php defined( 'ABSPATH' ) || exit;
/**
 *	CLASS: Create PWA Web Manifest & Activate App
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_Web_Manifest {

	private static $instance;
	private $same_version;	# @since 1.0.97

	public function __construct() {
	if ( ! prime2g_activate_theme_pwa() ) return;

	if ( ! isset( self::$instance ) ) {
		$this->same_version	=	prime2g_app_option( 'manifest_version' );

		$GLOBALS[ 'theme_web_app' ]	=	'Web App Active';
		$GLOBALS[ 'pwa_css_class' ]	=	'has_pwa';

		new Prime2g_PWA_File_Url_Manager;
		new Prime2g_PWA_CSS;
		new Prime2g_PWA_Service_Worker;
		// new Prime2g_Push_Notifications( $this->get_manifest()['short_name'] );
		Prime2g_PWA_Prompt::instance();

		#	Flushing rewrite rules
		add_action( 'after_switch_theme', 'flush_rewrite_rules' );
		add_action( 'customize_save_after', 'flush_rewrite_rules' );

		#	WPs own PWA plugin
		$wppwa_plugin	=	trailingslashit( WP_CONTENT_DIR ) . 'plugins/pwa/pwa.php';
		register_activation_hook( $wppwa_plugin, 'flush_rewrite_rules' );
		register_deactivation_hook( $wppwa_plugin, 'flush_rewrite_rules' );

		add_action( 'wp_head', [ $this, 'html_metadata' ], 11 );
	}

	return self::$instance;
	}


	function appID() {
		$siteID	=	is_multisite() ? get_current_blog_id() : '';
		return 'pwaID' . $siteID . 'V' . PRIME2G_PWA_VERSION;
	}


	function html_metadata() {
		$app_images	=	new Prime2g_PWA_Images;
		$manifesturl=	Prime2g_PWA_File_Url_Manager::manifest_url();
		$manifest	=	$this->get_manifest();
		$iconURL	=	$app_images->mainIcon()->src;

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

/*
<meta name="apple-touch-startup-image" content="splash.png" media="orientation: '. $manifest['orientation'] .'">
$linktags = '';
if ( isset( $manifest[ 'icons' ] ) && ! empty( $manifest[ 'icons' ] ) ) {
	$linktags .= '<link rel="apple-touch-icon" sizes="192x192" href="'. esc_url(  ) .'">' . PHP_EOL;
}
if ( isset( $manifest[ 'splash_icon' ] ) && ! empty( $manifest[ 'splash_icon' ] ) ) {
	$linktags .=  '<link rel="apple-touch-icon" sizes="512x512" href="'. esc_url(  ) .'">' . PHP_EOL;
}
*/
	}

	function get_manifest() {
	$manifest	=	prime2g_app_option( 'manifest' );

	if ( false === $manifest || ! $this->same_version ) {
		$app_images	=	new Prime2g_PWA_Images;
		$data		=	$this->manifest_data();

		$data	=	array(
			'name'			=>	PRIME2G_PWA_SITENAME,
			'short_name'	=>	$data->short_name,
			'description'	=>	html_entity_decode( $data->description ),
			'start_url'		=>	Prime2g_PWA_File_Url_Manager::startURL(),
			'lang'			=>	get_locale(),
			'id'			=>	$this->appID(),
			'scope'			=>	'/',
			'dir'			=>	is_rtl() ? 'rtl' : 'ltr',
			'display'		=>	$data->display,
			'orientation'	=>	$data->orientation,
			'theme_color'	=>	$data->theme_color,
			'background_color'	=>	$data->bg_color,
			'launch_handler'	=>	(object) [ 'client_mode' => $data->launcher ],
			'categories'	=>	explode( ',', str_replace( ' ', '', $data->categories ) ),
			'icons'			=>	[ $app_images->mainIcon() ],
			'screenshots'	=>	$app_images->screenshots()
			// 'scope_extensions'	=>	[]	// multisite?? @https://chromestatus.com/feature/5746537956114432
		);

		//	Add other available icons to icons array
		$data[ 'icons' ]	=	array_merge( $data[ 'icons' ], $app_images->site_icons() );

	prime2g_app_option( [ 'name'=>'manifest', 'update'=>true, 'value'=>$data ] );
	$manifest	=	prime2g_app_option( 'manifest' );
	}

	if ( ! $this->same_version )
		prime2g_app_option( [ 'name'=>'manifest_version', 'update'=>true ] );

	return $manifest;
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
	return (object) [
		'id'	=>	$this->appID(),
		'short_name'	=>	get_theme_mod( 'prime2g_pwapp_shortname', 'Web App' ),
		'description'	=>	get_theme_mod( 'prime2g_pwa_description' ) ?: get_bloginfo( 'description' ),
		'display'		=>	get_theme_mod( 'prime2g_pwapp_display', 'standalone' ),
		'orientation'	=>	get_theme_mod( 'prime2g_pwapp_orientation', 'portrait' ),
		'theme_color'	=>	get_theme_mod( 'prime2g_pwapp_themecolor', '#ffffff' ),
		'bg_color'		=>	get_theme_mod( 'prime2g_pwapp_backgroundcolor', '#ffffff' ),
		'launcher'		=>	get_theme_mod( 'prime2g_pwa_launch_handler', 'auto' ),	# @since 1.0.97
		'categories'	=>	get_theme_mod( 'prime2g_pwa_categories' )
	];
	}

}


/**
READ: https://web.dev/learn/pwa/detection/#detecting_related_installed_apps
https://web.dev/learn/pwa/detection/#prefer_a_related_app
{
"related_applications:" [
{
	"platform": "play",
	"url": "https://play.google.com/..."
}
],
"prefer_related_applications": true
}
*/

