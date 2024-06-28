<?php defined( 'ABSPATH' ) || exit;
/**
 *	CLASS: Register PWA Service Worker
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_PWA_Service_Worker {

	private static $instance;
	public $same_version;	# @since 1.0.97

	public function __construct() {
		if ( ! isset( self::$instance ) ) {
			if ( is_admin() ) return;
			$this->same_version	=	prime2g_app_option( 'worker_version' );
			add_action( 'wp_footer', [ $this, 'register_service_worker' ] );
		}
	return self::$instance;
	}


	function register_service_worker() {
		$urls	=	new Prime2g_PWA_File_Url_Manager;

		echo '<script id="p2g_regServiceWorker" async>
		if ( typeof navigator.serviceWorker !== "undefined" ) {
			navigator.serviceWorker.register( "'. esc_url( $urls->get_file_url()[ 'service-worker' ] ) .'" );
		}
		</script>';
	}


	/**
	 *	Service Worker Content
	 */
	static function content() {
	$start	=	new self;
	$core	=	$start->cached_content();

	if ( ! $start->same_version )
		prime2g_app_option( [ 'name'=>'worker_version', 'update'=>true ] );

	return $core . apply_filters( 'prime2g_filter_pwa_service_worker', '', $core );
	}

	private function cached_content() {
	$core	=	prime2g_app_option( 'service_worker' );

	if ( false === $core || ! $this->same_version ) {
		prime2g_app_option( [ 'name'=>'service_worker', 'update'=>true, 'value'=>$this->core() ] );
		$core	=	prime2g_app_option( 'service_worker' );
	}

	return $core;
	#	return $this->core();	# debugging
	}


	function get_caching() {
	$mods	=	$this->mods();

	if ( is_multisite() ) {
		switch_to_blog( 1 );
		if ( get_theme_mod( 'prime2g_route_apps_to_networkhome' ) ) {
			$mods	=	$this->mods();
		}
		restore_current_blog();
	}

	return (object) [ 'strategy' => $mods->strategy, 'addHome' => $mods->addHome,
	'addToCache' => $mods->addToCache, 'navPreload' => $mods->navPreload, 'login_slug' => $mods->login_slug,
	'excludePaths' => $mods->excludePaths, 'endPoints' => $mods->endPoints ];
	}


	private function mods() {
	$custom_login_page	=	Prime2gLoginPage::get_instance()->get_login_page();
	$excludes	=	get_theme_mod( 'prime2g_pwapp_cache_exclude_paths' );
	$endpoints	=	get_theme_mod( 'prime2g_pwapp_endpoints_to_request' );

	return (object) [
		'login_slug'=>	$custom_login_page ? $custom_login_page->post_name : 'login',	# 1.0.97
		'strategy'	=>	get_theme_mod( 'prime2g_pwa_cache_strategy', PWA_NETWORKFIRST ),
		'addHome'	=>	get_theme_mod( 'prime2g_add_homepage_to_cache', '0' ),
		'addToCache'=>	get_theme_mod( 'prime2g_add_request_to_pwa_cache', 'true' ),	# String
		'navPreload'=>	get_theme_mod( 'prime2g_use_navigation_preload' ) ? 'true' : 'false',
		'excludePaths'	=>	apply_filters( 'prime2g_filter_pwa_sw_cache_exclude_paths', '', $excludes ),
		'endPoints'	=>	apply_filters( 'prime2g_filter_pwa_sw_endpoints_to_request', '', $endpoints )
	];
	}


	private function core() {
	$fileURLs	=	new Prime2g_PWA_File_Url_Manager;
	$get_url	=	$fileURLs->get_file_url();
	$images		=	new Prime2g_PWA_Images;
	$caching	=	$this->get_caching();
	$addHome	=	$caching->addHome ?: '0';
	$excludePaths=	$caching->excludePaths ?: 'avoidemptyplaceholder';
	$endPoints	=	$caching->endPoints ?: 'avoidemptyplaceholder';
	$cacheNames	=	prime2g_pwa_cache_names();
	$addFileUrls=	prime2g_add_service_worker_precache_files();

	$js	=
'const PWACACHE		=	"'. $cacheNames->pwa_core .'";
const SCRIPTSCACHE	=	"'. $cacheNames->scripts .'";
const DYNACACHE		=	"'. $cacheNames->dynamic .'";
const logoURL		=	"'. prime2g_siteLogo( false, true ) .'";
const iconURL		=	"'. $images->mainIcon()->src .'";
const themeFiles	=	"'. $fileURLs->theme_files( 'csv_versioned' ) .'";
const homeStartURL	=	0 === '. $addHome .' ? "" : "'. $get_url[ 'home' ] .'" + ", ";
const userIsOfflineURL	=	"'. $get_url[ 'offline' ] .'";
const errorPageURL		=	"'. $get_url[ 'error' ] .'";
const notCachedPageURL	=	"'. $get_url[ 'notcached' ] .'";
const filesString		=	homeStartURL + logoURL + ", " + iconURL + ", " + themeFiles +
", " + userIsOfflineURL + ", " + errorPageURL + ", " + notCachedPageURL'. $addFileUrls .';
const PRECACHE_ITEMS	=	filesString.split(", ");
const addRequestToCache	=	'. $caching->addToCache .';
const strategy			=	"'. $caching->strategy .'";
const navPreload		=	'. $caching->navPreload .';


/**		HELPERS		**/
function addCachePermit() {
	return ( addRequestToCache && strategy !== "'. PWA_NETWORKONLY .'" );
}

function sw_donotcache_items( event ) {
const urlObj	=	new URL( event.request.url );
const urlPath	=	urlObj.pathname;
const excl_paths=	"wp-admin, '. $caching->login_slug .', wp-login.php, '. $excludePaths .'";
const exclPaths	=	excl_paths.split(", ");
const pathsNum	=	exclPaths.length;

var doNot	=	false;

for ( u = 0; u < pathsNum; u++ ) {
	if ( urlPath.startsWith( "/" + exclPaths[u] ) ) { doNot = true; break; }
}

return doNot;
}

function requestFromNetworkOnly( event ) {
const urlStr	=	event.request.url;
const excl_ends	=	"'. $caching->login_slug .'/, wp-admin, wp-login.php, admin-ajax.php, '. $endPoints .'";
const exclEnds	=	excl_ends.split(", ");
const urlNum	=	exclEnds.length;

var toNet	=	false;

for ( u = 0; u < urlNum; u++ ) {
	if ( urlStr.includes( exclEnds[u] ) ) { toNet = true; break; }
}

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

async function navPreload_on() {
if ( navPreload && self.registration.navigationPreload ) {
	await self.registration.navigationPreload.enable();
}
}

const promises	=	[ deleteOldCaches(), navPreload_on() ];
event.waitUntil( Promise.allSettled( promises ) );
self.clients.claim();
} );


/**
 *	FETCHING
 */
self.addEventListener( "fetch", event => {

doNotCache	=	sw_donotcache_items( event );

async function networkFetcher( returnCache ) {
	try {
		const cache1	=	await caches.open( PWACACHE );
		const fromNetwork	=	await fetch( event.request );
		if ( addCachePermit() && ! doNotCache ) {
			await cache1.put( event.request, fromNetwork.clone() );
		}

		if ( navPreload ) {
			const preloaded	=	await event.preloadResponse;
			if ( preloaded ) return preloaded;
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

	return $js . '

//	Extending Service Worker

' . apply_filters( 'prime2g_filter_service_worker', '', $js );	# @since 1.0.97
	}

}




/*
Use filter for:
Background Sync, Periodic Background Sync, etc.

Read more@
https://learn.microsoft.com/en-us/microsoft-edge/progressive-web-apps-chromium/how-to/service-workers#other-capabilities
https://learn.microsoft.com/en-us/microsoft-edge/progressive-web-apps-chromium/how-to/service-workers#push-messages
const host_names	=	"'.$values->hostNames.'";
const hostNames		=	host_names.split(", ");
hostNames.forEach( xclh => { if ( reloaded && urlObj.hostname === xclh ) { serv_Worker.terminate(); } } );
*/

# await cache1.add( new Request( userIsOfflineURL, { cache:"reload" } ) );


