<?php defined( 'ABSPATH' ) || exit;
/**
 *	CLASS: PWA Conditional CSS
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_PWA_CSS {

	public	$styles;
	private static $instance;
	#	Caching: @since 1.0.98
	private $same_version;

	public function __construct() {
	if ( ! isset( self::$instance ) ) {
		$this->same_version	=	prime2g_app_option( 'styles_version' );
		$this->styles		=	$this->css();

	add_action( 'wp_head', function() {
	$start	=	new self();
	echo '<style id="prime_AppCSS">'. $start->styles .'</style>';
	}, 100 );
	}

	return self::$instance;
	}


	function css() {
	$css	=	$this->cached();

	if ( ! $this->same_version )
		prime2g_app_option( [ 'name'=>'styles_version', 'update'=>true ] );

	return $css . apply_filters( 'prime2g_filter_pwa_styles', '', $css );
	}


	private function cached() {
	$css	=	prime2g_app_option( 'app_styles' );

	if ( false === $css || ! $this->same_version ) {
		$this->styles	=	$this->app();
		$this->styles	.=	apply_filters( 'prime2g_filter_cached_pwa_styles', '', $this->styles );
		prime2g_app_option( [ 'name'=>'app_styles', 'update'=>true, 'value'=>$this->styles ] );
		$css	=	prime2g_app_option( 'app_styles' );
	}

	return $css;
	}


	function app() {
	return '#prime2g_offOnline_notif.off{transform:translateY(120%);}
#prime2g_offOnline_notif{position:fixed;left:0;right:0;bottom:0;transition:0.2s;
background:var(--content-text);color:var(--content-background);line-height:1;}
.oo_notif.off{display:none;}
@media(display-mode:browser){#prime2g_offOnline_notif,.app-mode{display:none!important;}}
@media all and (display-mode:standalone),(display-mode:fullscreen),(display-mode:minimal-ui){
.browser-mode{display:none!important;}
.unselectable{user-select:none;}
}';
	}

/**
https://web.dev/learn/pwa/app-design/
setting user-system fonts
selector {
font-family: -apple-system, BlinkMacSystemFont,
"Segoe UI", system-ui, Roboto, Oxygen-Sans, Ubuntu, Cantarell,
"Helvetica Neue", sans-serif;
}
OTHER MEDIA QUERIES: prefers-colors-scheme, honoring prefers-reduced-motion
Disable Pull to refresh
body { overscroll-behavior-y: contain; }
*/

}
