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
			if ( is_admin() ) return;
			add_action( 'wp_footer', array( $this, 'register_service_worker' ) );
		}
	return self::$instance;
	}


	public function register_service_worker() {
	if ( ! isset( self::$instance ) ) {
		$offline	=	new Prime2g_PWA_File_Url_Manager();
		$sw_url		=	$offline->get_file_url()[ 'service-worker' ];

		echo '<script id="p2g_regServiceWorker">
		if ( typeof navigator.serviceWorker !== "undefined" ) {
			navigator.serviceWorker.register( "'. esc_url( $sw_url ) .'" );
		}
		</script>';
	}
	return self::$instance;
	}


	/**
	 *	Core Service Worker
	 *	Scripts plugged in
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


	public function get_caching() {
	$strategy	=	get_theme_mod( 'prime2g_pwa_cache_strategy', PWA_CACHEFIRST );
	$addToCache	=	get_theme_mod( 'prime2g_add_request_to_pwa_cache', 'false' ); # String

	if ( is_multisite() ) {
		switch_to_blog( 1 );
		if ( get_theme_mod( 'prime2g_route_apps_to_networkhome' ) ) {
			$strategy	=	get_theme_mod( 'prime2g_pwa_cache_strategy', PWA_CACHEFIRST );
			$addToCache	=	get_theme_mod( 'prime2g_add_request_to_pwa_cache', 'false' );
		}
		restore_current_blog();
	}

	return [ 'strategy' => $strategy, 'addToCache' => $addToCache ];
	}


	public function core() {
	$fileURLs	=	new Prime2g_PWA_File_Url_Manager();
	$get_url	=	$fileURLs->get_file_url();
	$icons		=	new Prime2g_PWA_Icons();
	$caching	=	$this->get_caching();
	$strategy	=	$caching[ 'strategy' ];
	$addRequestToCache	=	$caching[ 'addToCache' ];
	$addFileUrls	=	function_exists( 'child_add_to_pwa_precache' ) ?
						' + ", " + "' . child_add_to_pwa_precache() . '"' : null; # CSV
	$siteName	=	str_replace( [ ' ', '\'', '.' ], '', PRIME2G_PWA_SITENAME );

	$js	=
'const PWACACHE		=	"'. $siteName .'_preCache" + SWVersion;
const logoURL		=	"'. prime2g_siteLogo( false, true ) .'";
const iconURL		=	"'. $icons->mainIcon()[ 'src' ] .'";
const themeFiles	=	"'. $fileURLs->theme_files( 'csv_versioned' ) .'";
const homeStartURL	=	"'. $get_url[ 'home' ] .'";
const userIsOfflineURL	=	"'. $get_url[ 'offline' ] .'";
const errorPageURL		=	"'. $get_url[ 'error' ] .'";
const notCachedPageURL	=	"'. $get_url[ 'notcached' ] .'";
const filesString		=	logoURL + ", " + iconURL + ", " + themeFiles +
", " + homeStartURL + ", " + userIsOfflineURL + ", " + errorPageURL + ", " + notCachedPageURL'. $addFileUrls .';
const PRECACHE_ITEMS	=	filesString.split(", ");
const addRequestToCache	=	'. $addRequestToCache .';
const strategy			=	"'. $strategy .'";
const DYNAMIC_CACHE		=	"'. $siteName .'_dynamicCache" + SWVersion;

/**
 *	HELPERS
 */
function addCachePermit() {
	return ( addRequestToCache && strategy !== "'. PWA_NETWORKONLY .'" );
}


self.addEventListener( "install", event => {
event.waitUntil( ( async () => {
	const cache	=	await caches.open( PWACACHE );
	await cache.addAll( PRECACHE_ITEMS );
	// await cache.add( new Request( userIsOfflineURL, { cache: "reload" } ) );
} )() );
self.skipWaiting();
} );



self.addEventListener( "activate", event => {
async function deleteOldCaches() {
const cacheNames	=	await caches.keys();
await Promise.all( cacheNames.map( name => {
	if ( name !== PWACACHE && name !== DYNAMIC_CACHE ) {
		return caches.delete( name );
	}
} ) );
}
event.waitUntil( deleteOldCaches() );

self.clients.claim();
} );



self.addEventListener( "fetch", event => {

async function networkFetcher( returnOffline = false ) {
	try {
		const cache	=	await caches.open( PWACACHE );

		const fromNetwork	=	await fetch( event.request );
		if ( addCachePermit() ) {
			await cache.put( event.request, fromNetwork.clone() );
		}
		if ( fromNetwork ) return fromNetwork;
	} catch ( error ) {
		console.log( error );
		const cache	=	await caches.open( PWACACHE );
		if ( returnOffline ) {
			const userOffline	=	await cache.match( userIsOfflineURL );
			return userOffline;
		}
	}
}


if ( strategy === "'. PWA_NETWORKONLY .'" ) {
if ( event.request.mode === "navigate" ) {
	event.respondWith( networkFetcher( true ) );
}
return;
}


/**
 *	Network first strategy applies from here... Intercepted by cache based strategies
 */
event.respondWith(
( async () => {

if ( strategy === "'. PWA_CACHEFIRST .'" ||
	strategy === "'. PWA_CACHEONLY .'" ||
	strategy === "'. PWA_STALE_REVAL .'"
	) {
	const cachedResponse	=	await caches.match( event.request );
	if ( cachedResponse && strategy !== "'. PWA_STALE_REVAL .'" ) {
		return cachedResponse;
	}
}

if ( strategy === "'. PWA_CACHEONLY .'" ) {
	const cache		=	await caches.open( PWACACHE );
	const notCached	=	await cache.match( notCachedPageURL );
	return notCached;
}

try {
	const cache	=	await caches.open( PWACACHE );

	const fromNetwork	=	await fetch( event.request );
	if ( addCachePermit() ) {
		await cache.put( event.request, fromNetwork.clone() );
	}

	if ( strategy === "'. PWA_STALE_REVAL .'" ) {
		if ( cachedResponse ) return cachedResponse;
	}
	if ( fromNetwork ) return fromNetwork;

} catch ( error ) {
	// Retain for Network first:
	const cachedResponse	=	await caches.match( event.request );
	if ( cachedResponse ) return cachedResponse;

	const cache			=	await caches.open( PWACACHE );
	const userOffline	=	await cache.match( userIsOfflineURL );
	return userOffline;
}

} )()
);

} );
';

	return $js;
	}

}



/*
Read more @
https://learn.microsoft.com/en-us/microsoft-edge/progressive-web-apps-chromium/how-to/service-workers#other-capabilities
https://learn.microsoft.com/en-us/microsoft-edge/progressive-web-apps-chromium/how-to/service-workers#push-messages
*/

