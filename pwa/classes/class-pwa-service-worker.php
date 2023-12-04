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

	$js	= $start->core() . $sw_plugs;

	return $js;
	}


	public function get_caching() {
	$strategy	=	get_theme_mod( 'prime2g_pwa_cache_strategy', PWA_NETWORKFIRST );
	$addHome	=	get_theme_mod( 'prime2g_add_homepage_to_cache', '0' );
	$addToCache	=	get_theme_mod( 'prime2g_add_request_to_pwa_cache', 'false' );	# String

	if ( is_multisite() ) {
		switch_to_blog( 1 );
		if ( get_theme_mod( 'prime2g_route_apps_to_networkhome' ) ) {
			$strategy	=	get_theme_mod( 'prime2g_pwa_cache_strategy', PWA_NETWORKFIRST );
			$addHome	=	get_theme_mod( 'prime2g_add_homepage_to_cache', '0' );
			$addToCache	=	get_theme_mod( 'prime2g_add_request_to_pwa_cache', 'false' );
		}
		restore_current_blog();
	}

	return [ 'strategy' => $strategy, 'addHome' => $addHome, 'addToCache' => $addToCache ];
	}


	public function core() {
	$fileURLs	=	new Prime2g_PWA_File_Url_Manager();
	$get_url	=	$fileURLs->get_file_url();
	$icons		=	new Prime2g_PWA_Icons();
	$caching	=	$this->get_caching();
	$strategy	=	$caching[ 'strategy' ];
	$addHome	=	$caching[ 'addHome' ] ?: '""';
	$addRequestToCache	=	$caching[ 'addToCache' ];
	$cacheNames	=	prime2g_pwa_cache_names();
	$addFileUrls	=	function_exists( 'child_add_to_pwa_precache' ) ?
						' + ", " + "' . child_add_to_pwa_precache() . '"' : null;	# CSV

	$js	=
'const PWACACHE		=	"'. $cacheNames->pwa_core .'";
const SCRIPTSCACHE	=	"'. $cacheNames->scripts .'";
const DYNACACHE		=	"'. $cacheNames->dynamic .'";
const logoURL		=	"'. prime2g_siteLogo( false, true ) .'";
const iconURL		=	"'. $icons->mainIcon()[ 'src' ] .'";
const themeFiles	=	"'. $fileURLs->theme_files( 'csv_versioned' ) .'";
const addHome		=	'. $addHome .';
const homeStartURL	=	"";
if ( 0 != addHome ) {
	const homeStartURL	=	"'. $get_url[ 'home' ] .'" + ", ";
}
const userIsOfflineURL	=	"'. $get_url[ 'offline' ] .'";
const errorPageURL		=	"'. $get_url[ 'error' ] .'";
const notCachedPageURL	=	"'. $get_url[ 'notcached' ] .'";
const filesString		=	homeStartURL + logoURL + ", " + iconURL + ", " + themeFiles +
", " + userIsOfflineURL + ", " + errorPageURL + ", " + notCachedPageURL'. $addFileUrls .';
const PRECACHE_ITEMS	=	filesString.split(", ");
const addRequestToCache	=	'. $addRequestToCache .';
const strategy			=	"'. $strategy .'";

/**
 *	HELPERS
 */
function addCachePermit() {
	return ( addRequestToCache && strategy !== "'. PWA_NETWORKONLY .'" );
}

function stopServiceWorkerByRequest( event ) {
const urlObj	=	new URL( event.request.url );
const urlStr	=	event.request.url;
const exclPaths	=	[ "/wp-admin/", "/login/", "/wp-login.php" ]; // Consider control to add other paths
const exclEnds	=	[ "/login/", "/wp-login.php", "admin-ajax.php", "/api/users/auth/google" ]; // Consider control too

/**
 *	Do not run in these paths
 */
exclPaths.forEach( xcl => { if ( urlObj.pathname.startsWith( xcl ) ) { return; } } );

/**
 *	Check if the request ends with any of these - respond with a network fetch
 */
exclEnds.forEach( xcl => { if ( urlStr.endsWith( xcl ) ) { event.respondWith( fetch( event.request ) ); return; } } );
}



/**
 *	On Install
 */
self.addEventListener( "install", event => {
event.waitUntil( ( async () => {
	const cache	=	await caches.open( PWACACHE );
	await cache.addAll( PRECACHE_ITEMS );
	// await cache.add( new Request( userIsOfflineURL, { cache: "reload" } ) );
} )() );
self.skipWaiting();
} );


/**
 *	On Activate
 */
self.addEventListener( "activate", event => {
async function deleteOldCaches() {
const cacheNames	=	await caches.keys();
await Promise.all( cacheNames.map( name => {
	if ( name !== PWACACHE && name !== SCRIPTSCACHE && name !== DYNACACHE ) {
		return caches.delete( name );
	}
} ) );
}
event.waitUntil( deleteOldCaches() );
self.clients.claim();
} );


/**
 *	FETCHING
 */
self.addEventListener( "fetch", event => {

stopServiceWorkerByRequest( event );

async function networkFetcher( returnCache ) {
	try {
		const cache	=	await caches.open( PWACACHE );
		const fromNetwork	=	await fetch( event.request );
		if ( addCachePermit() ) { await cache.put( event.request, fromNetwork.clone() ); }
		if ( fromNetwork ) return fromNetwork;
	} catch ( error ) {
		console.log( error );
		if ( returnCache ) {
			stopServiceWorkerByRequest( event );
			const cachedResponse	=	await caches.match( event.request );
			if ( cachedResponse ) return cachedResponse;
		}

		const cache	=	await caches.open( PWACACHE );
		const userOffline	=	await cache.match( userIsOfflineURL );
		return userOffline;
	}
}

async function cacheFetcher() {
	try {
	stopServiceWorkerByRequest( event );
	const cachedResponse	=	await caches.match( event.request );
		if ( ! cachedResponse && strategy === "'. PWA_CACHEONLY .'" ) {
			const cache		=	await caches.open( PWACACHE );
			const notCached	=	await cache.match( notCachedPageURL );
			return notCached;
		}
		if ( strategy === "'. PWA_STALE_REVAL .'" ) {
			return cachedResponse || networkFetcher( true );	// from cache or go back to network for revalidation
		}
	return cachedResponse || networkFetcher( false );
	}
	catch ( error ) {
		console.log( error );
	}
}



/**
 *	RETURN RESPONSE
 */
if ( strategy === "'. PWA_NETWORKONLY .'" ) {
	if ( event.request.mode === "navigate" ) { event.respondWith( networkFetcher( false ) ); } // do not return cache
return;
}

else if ( strategy === "'. PWA_NETWORKFIRST .'" ) {
	if ( event.request.mode === "navigate" ) { event.respondWith( networkFetcher( true ) ); } // return cache
return;
}

else {
	if ( event.request.mode === "navigate" ) { event.respondWith( cacheFetcher() ); return; }
}

} );
';

	return $js;
	}

}


/*
Read more@
	https://learn.microsoft.com/en-us/microsoft-edge/progressive-web-apps-chromium/how-to/service-workers#other-capabilities
	https://learn.microsoft.com/en-us/microsoft-edge/progressive-web-apps-chromium/how-to/service-workers#push-messages
*/
