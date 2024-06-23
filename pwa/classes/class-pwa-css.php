<?php defined( 'ABSPATH' ) || exit;
/**
 *	CLASS: PWA Conditional CSS
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_PWA_CSS {

	public	$styles;
	private static $instance;

	public function __construct() {
	if ( ! isset( self::$instance ) ) {
	add_action( 'wp_head', function() {
		$start	=	new self();
		$this->styles	=	$start->app();
		$this->styles	.=	$start->sharerCSS();
		$this->styles	.=	apply_filters( 'prime2g_filter_pwa_styles', '', $this->styles );

		echo '<style id="prime_AppCSS">'. $this->styles .'</style>';
	}, 99 );
	}

	return self::$instance;
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
/*
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


	function sharerCSS() {
		return '
@media (display-mode:browser) { #'. PWA_SHARER_BTN_ID .'{display:none;} }';
	}

}
