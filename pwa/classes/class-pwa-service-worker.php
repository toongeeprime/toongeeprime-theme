<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: Register PWA Service Worker
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_PWA_Service_Worker {

	private static $instance;

	public function __construct() {
		if ( ! isset( self::$instance ) ) {
		add_action( 'wp_footer', array( $this, 'register_service_worker' ) );
		}
	return self::$instance;
	}


	public function register_service_worker() {
	$offline	=	new Prime2g_PWA_Offline_Manager();
	$sw_url		=	$offline->get_offline_url( 'sw' );

	echo '<script id="p2g_regServiceWorker">
	if ( typeof navigator.serviceWorker !== "undefined" ) {
		navigator.serviceWorker.register( "'. $sw_url .'" );
	}
	</script>';
	}


	/**
	 *	Foundational Service Worker: for when WP PWA is not active
	 *	Other scripts plugged in here as would be in WP PWA
	 */
	public static function content() {
	$scripts	=	new Prime2g_PWA_Offline_Scripts;
	$sw_plugs	=	( function_exists( 'p2g_child_service_worker_scripts' ) ) ?
					p2g_child_service_worker_scripts() : '';

	$js	=
'const SWVersion	=	"'. PRIME2G_PWA_VERSION .'";
'. $scripts->caching() .'

self.addEventListener( "fetch", event => {
event.respondWith( async () => {
const cache	=	await caches.open( PWACACHE );

// match the request to our cache
const cachedResponse	=	await cache.match( event.request );

// check if we got a valid cache response, Otherwise, go to network
if ( cachedResponse !== undefined ) { return cachedResponse; }
else { return fetch( event.request ); };
} );
} );

// Claim control
self.addEventListener( "activate", event => { event.waitUntil( clients.claim() ); } );
'. $sw_plugs .'
';

	return $js;
	}

}

