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
	if ( ! isset( self::$instance ) ) {
		$offline	=	new Prime2g_PWA_Offline_Manager();
		$sw_url		=	$offline->get_offline_url( 'sw' );

		echo '<script id="p2g_regServiceWorker">
		if ( typeof navigator.serviceWorker !== "undefined" ) {
			navigator.serviceWorker.register( "'. $sw_url .'" );
		}
		</script>';
	}
	return self::$instance;
	}


	/**
	 *	Foundational Service Worker: for when WP PWA is not active
	 *	Other scripts plugged in here as would be in WP PWA
	 */
	public static function content() {
	$start		=	new self;
	$sw_plugs	=	function_exists( 'p2g_child_service_worker_scripts' ) ?
					p2g_child_service_worker_scripts() : '';

	$js	=
'const SWVersion	=	"'. PRIME2G_PWA_VERSION .'";
'. $start->core() .'
'. $sw_plugs .'
';

	return $js;
	}


	public function core() {
	$offline	=	new Prime2g_PWA_Offline_Manager();
	$name		=	html_entity_decode( get_bloginfo( 'name' ) );

	if ( is_multisite() ) {
		switch_to_blog( 1 );
		if ( get_theme_mod( 'prime2g_route_apps_to_networkhome' ) )
			$name		=	html_entity_decode( get_bloginfo( 'name' ) );
		restore_current_blog();
	}

	$siteName	=	str_replace( [ ' ', '\'', '.' ], '', $name );

	$js	=
'const PWACACHE	=	"'. $siteName .'_p2gApp_cache'. PRIME2G_VERSION .'";
const userIsOfflineURL	=	"'. $offline->get_offline_url( 'index' ) .'";
const staticFiles		=	"'. $offline->files_to_cache( 'csv_versioned' ) .'";
const filesString		=	"/" + ", " + userIsOfflineURL + ", " + staticFiles;
const PRECACHE_ITEMS	=	filesString.split(", ");
const DYNAMIC_CACHE		=	[];


self.addEventListener( "install", event => {
event.waitUntil( ( async () => {
	const cache	=	await caches.open( PWACACHE );
	await cache.addAll( PRECACHE_ITEMS );
	await cache.add( new Request( userIsOfflineURL, { cache: "reload" } ) );
} )() );
self.skipWaiting();
} );


/**
 *	On App Activation
 */
self.addEventListener( "activate", event => {

async function enableNavPreload() {
	if ( "navigationPreload" in self.registration ) {
		await self.registration.navigationPreload.enable();
	}
}
event.waitUntil( enableNavPreload() );


async function deleteOldCaches() {
// Get ALL caches by their names
const cacheNames	=	await caches.keys();
await Promise.all( cacheNames.map( name => {
	if ( name !== PWACACHE ) {
		return caches.delete( name );
	}
} ) );
}
event.waitUntil( deleteOldCaches() );

self.clients.claim();
} );


/**
 *	FETCH HANDLER
 */
self.addEventListener( "fetch", event => {

async function networkOrOfflinePage() {
	try {
		// Try preloaded
		const preResponse	=	await event.preloadResponse;
		if ( preResponse ) return preResponse;

		const networkResponse	=	await fetch( event.request );
		return networkResponse;
	} catch ( error ) {
		console.log( "Network Fetch failed; returning offline page instead.", error );

		const cache	=	await caches.open( PWACACHE );
		const userOffline	=	await cache.match( userIsOfflineURL );
		return userOffline;
	}
}
if ( event.request.mode === "navigate" ) {
	event.respondWith( networkOrOfflinePage() );
	return;
}

event.respondWith(
( async () => {
const cache	=	await caches.open( PWACACHE );

// Check cache response
const cachedResponse	=	await cache.match( event.request );
if ( cachedResponse !== undefined ) return cachedResponse;

// Or, if preloaded response
const pre_response	=	await event.preloadResponse;
if ( pre_response ) return pre_response;

// Network?
const netResponse	=	await fetch( event.request );
if ( netResponse ) return netResponse;

// Else, offline page
const userOffline	=	await cache.match( userIsOfflineURL );
return userOffline;
} )()
);

} );
';

	return $js;
	}

}


/*
Read more @:
https://learn.microsoft.com/en-us/microsoft-edge/progressive-web-apps-chromium/how-to/service-workers#other-capabilities

window.addEventListener("online",  function(){
    console.log("You are online!");
});
window.addEventListener("offline", function(){
    console.log("Oh no, you lost your network connection.");
});
*/
