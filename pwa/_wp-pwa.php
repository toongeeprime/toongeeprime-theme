<?php defined( 'ABSPATH' ) || exit;

/**
 *	WORKING WITH WP PWA Core
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_Hook_WP_PWA {

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
		$start			=	Prime2g_Web_Manifest::instance();
		$primeManifest	=	$start->get_manifest( $iconID );

		add_filter( 'web_app_manifest', function( $manifest ) use( $primeManifest ) {
			$manifest[ 'name' ]	=	$primeManifest[ 'name' ];
			$manifest[ 'short_name' ]	=	$primeManifest[ 'short_name' ];
			$manifest[ 'id' ]	=	$primeManifest[ 'id' ];
			$manifest[ 'description' ]	=	$primeManifest[ 'description' ];
			$manifest[ 'display' ]	=	$primeManifest[ 'display' ];
			$manifest[ 'orientation' ]	=	$primeManifest[ 'orientation' ];
			$manifest[ 'theme_color' ]	=	$primeManifest[ 'theme_color' ];
			$manifest[ 'background_color' ]	=	$primeManifest[ 'background_color' ];
		return $manifest;
		} );

		$this->icons( $primeManifest );
	}

	private function icons( $primeManifest ) {
		add_filter( 'web_app_manifest', static function( $manifest ) use( $primeManifest ) {
			$manifest[ 'icons' ]	=	$primeManifest[ 'icons' ];
			return $manifest;
		} );
	}

}

