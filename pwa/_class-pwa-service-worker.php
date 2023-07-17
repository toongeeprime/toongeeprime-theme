<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: Register PWA Service Worker
 *	if WP PWA plugin isn't active
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */


#	In Progress
#	Inactive but is registering Service Worker
#	@ https://docs.pwabuilder.com/#/home/sw-intro


class Prime2g_PWA_Service_Worker {

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

	public function __construct() {
		if ( ! class_exists( 'WP_Service_Workers' ) ) {
			add_action( 'wp_footer', array( $this, 'register_service_worker' ), 10, 0 );
		}
	}


	public function register_service_worker() {
	echo '<script id="p2g_regServiceWorker">
	if ( typeof navigator.serviceWorker !== "undefined" ) {
		navigator.serviceWorker.register( "'. PRIME2G_PWA_URL .'service-worker.js" );
	}
	</script>';
	}


}


// Prime2g_PWA_Service_Worker::instance();

