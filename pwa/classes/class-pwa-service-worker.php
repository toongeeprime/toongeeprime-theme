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
	 *	Core Service Worker (Scripts plugged in)
	 */
	public static function content() {
	$start		=	new self;
	$sw_plugs	=	function_exists( 'p2g_child_service_worker_scripts' ) ? p2g_child_service_worker_scripts() : '';

	$js	=	$start->core() . $sw_plugs;

	return $js;
	}


	public function get_caching() {
	$strategy	=	get_theme_mod( 'prime2g_pwa_cache_strategy', PWA_NETWORKFIRST );
	$addHome	=	get_theme_mod( 'prime2g_add_homepage_to_cache', '0' );
	$addToCache	=	get_theme_mod( 'prime2g_add_request_to_pwa_cache', 'false' );	# String
	$excludePaths	=	defined( 'PWA_EXCLUDE_PATHS' ) ? PWA_EXCLUDE_PATHS : get_theme_mod( 'prime2g_pwapp_cache_exclude_paths' );
	$endPoints	=	defined( 'PWA_REQUEST_ENDPOINTS' ) ? PWA_REQUEST_ENDPOINTS : get_theme_mod( 'prime2g_pwapp_endpoints_to_request' );

	if ( is_multisite() ) {
		switch_to_blog( 1 );
		if ( get_theme_mod( 'prime2g_route_apps_to_networkhome' ) ) {
			$strategy	=	get_theme_mod( 'prime2g_pwa_cache_strategy', PWA_NETWORKFIRST );
			$addHome	=	get_theme_mod( 'prime2g_add_homepage_to_cache', '0' );
			$addToCache	=	get_theme_mod( 'prime2g_add_request_to_pwa_cache', 'false' );
			$excludePaths	=	defined( 'PWA_EXCLUDE_PATHS' ) ? PWA_EXCLUDE_PATHS : get_theme_mod( 'prime2g_pwapp_cache_exclude_paths' );
			$endPoints	=	defined( 'PWA_REQUEST_ENDPOINTS' ) ? PWA_REQUEST_ENDPOINTS : get_theme_mod( 'prime2g_pwapp_endpoints_to_request' );
		}
		restore_current_blog();
	}

	return [ 'strategy' => $strategy, 'addHome' => $addHome, 'addToCache' => $addToCache,
	'excludePaths' => $excludePaths, 'endPoints' => $endPoints ];
	}


	public function core() {
	$fileURLs	=	new Prime2g_PWA_File_Url_Manager();
	$get_url	=	$fileURLs->get_file_url();
	$scripts	=	new Prime2g_PWA_Scripts();
	$icons		=	new Prime2g_PWA_Icons();
	$caching	=	$this->get_caching();
	$strategy	=	$caching[ 'strategy' ];
	$addHome	=	$caching[ 'addHome' ] ?: '""';
	$excludePaths	=	$caching[ 'excludePaths' ] ?: null;
	$endPoints	=	$caching[ 'endPoints' ] ?: null;
	$addRequestToCache	=	$caching[ 'addToCache' ];
	$cacheNames	=	prime2g_pwa_cache_names();
	$addFileUrls	=	function_exists( 'child_add_to_pwa_precache' ) ? ' + ", " + "' . child_add_to_pwa_precache() . '"' : null;	# CSV
	$overrideSW_fetch	=	function_exists( 'prime2g_override_service_worker_fetch' ) ? prime2g_override_service_worker_fetch() : 'false';

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


/**		HELPERS		**/
function addCachePermit() {
	return ( addRequestToCache && strategy !== "'. PWA_NETWORKONLY .'" );
}

function sw_donotcache_items( event ) {
const urlObj	=	new URL( event.request.url );
const urlPath	=	urlObj.pathname;
const excl_paths=	"wp-admin, login, wp-login.php, '. $excludePaths .'";
const exclPaths	=	excl_paths.split(", ");
const pathNum	=	exclPaths.length;

var doNot	=	false;

for ( u = 0; u < pathNum; u++ ) {
	startPath	=	"/" + exclPaths[u];
	if ( urlPath.startsWith( startPath ) ) { doNot = true; break; }
}

return doNot;
}

function requestFromNetworkOnly( event ) {
const urlStr	=	event.request.url;
const excl_ends		=	"login/, wp-login.php, admin-ajax.php, '. $endPoints .'";
const exclEnds	=	excl_ends.split(", ");
const urlNum	=	exclEnds.length;

var toNet	=	false;

for ( u = 0; u < urlNum; u++ ) { if ( urlStr.indexOf( exclEnds[u] ) > -1 ) { toNet = true; break; } }

return toNet;
}
/**		HELPERS END		**/



/**
 *	On Install
 */
self.addEventListener( "install", event => {
event.waitUntil(
( async ()=>{
	const cache1	=	await caches.open( PWACACHE );
	await cache1.addAll( PRECACHE_ITEMS );
	// await cache1.add( new Request( userIsOfflineURL, { cache:"reload" } ) );
self.skipWaiting();
} )()
);
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

if ( true === '. $overrideSW_fetch .' ) return;

var doNotCache	=	sw_donotcache_items( event );

async function networkFetcher( returnCache ) {
	try {
		const cache1	=	await caches.open( PWACACHE );
		const fromNetwork	=	await fetch( event.request );
		if ( addCachePermit() && ! doNotCache ) {
			await cache1.put( event.request, fromNetwork.clone() );
		}
		if ( fromNetwork ) return fromNetwork;
	} catch ( error ) {
		console.log( error );

		if ( returnCache ) {
			const cachedResponse	=	await caches.match( event.request );
			if ( cachedResponse ) return cachedResponse;
		}

		const cache1	=	await caches.open( PWACACHE );
		const userOffline	=	await cache1.match( userIsOfflineURL );
		return userOffline;
	}
}

async function cacheFetcher() {
	try {
	if ( ! doNotCache ) {
		const cachedResponse	=	await caches.match( event.request );
		if ( ! cachedResponse && strategy === "'. PWA_CACHEONLY .'" ) {
			const cache1	=	await caches.open( PWACACHE );
			const notCached	=	await cache1.match( notCachedPageURL );
			return notCached;
		}
		if ( strategy === "'. PWA_STALE_REVAL .'" ) {
			return cachedResponse || networkFetcher( true );	// from cache or go back to network for revalidation
		}
	return cachedResponse || networkFetcher( false );	// cache-first
	}
	return networkFetcher( false );
	}
	catch ( error ) {
		console.log( error );
	}
}



/**
 *	RETURN RESPONSE
 */
if ( event.request.mode === "navigate" ) {

if ( requestFromNetworkOnly( event ) ) {
	return event.respondWith( fetch( event.request ) );
}

else if ( strategy === "'. PWA_NETWORKONLY .'" ) {
	return event.respondWith( networkFetcher( false ) );	// do not return cached
}

else if ( strategy === "'. PWA_NETWORKFIRST .'" ) {
	return event.respondWith( networkFetcher( true ) );
}

else { return event.respondWith( cacheFetcher() ); }

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
const host_names	=	"'. $values->hostNames .'";
const hostNames		=	host_names.split(", ");
hostNames.forEach( xclh => { if ( reloaded && urlObj.hostname === xclh ) { serv_Worker.terminate(); } } );
*/

