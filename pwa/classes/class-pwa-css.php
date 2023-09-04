<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: PWA Conditional CSS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_PWA_CSS {

	private static $instance;

	public function __construct() {
	if ( ! isset( self::$instance ) ) {
	add_action( 'wp_head', function() {
	$start	=	new self();

$css	=	'<style id="pwa_condCSS">';
$css	.=	$start->sharerCSS();
$css	.=	'</style>';

echo $css;
	} );
	}

	return self::$instance;
	}


	public function sharerCSS() {
		return '@media (display-mode:browser) { #'. PWA_SHARER_BTN_ID .'{display:none;} }';
	}

}
