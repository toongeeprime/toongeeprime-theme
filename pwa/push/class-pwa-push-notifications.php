<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: PWA Push Notifications
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_Push_Notifications {

	private static $instance;

	public function __construct() {
	if ( ! isset( self::$instance ) ) {}

	return self::$instance;
	}


}


