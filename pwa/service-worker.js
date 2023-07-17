/**
 *	BASIC PWA Service Worker
 *	Forked @ https://github.com/pwa-builder/PWABuilder/blob/main/docs/assets/code-examples/example-sw.js
 *	This is the service worker with the combined offline experience (Offline page + Offline copy of pages)
 *
 *	Study: https://developer.mozilla.org/en-US/docs/Web/Progressive_web_apps/Guides/Offline_and_background_operation
 *
 *	Use/fork to improve this Service Worker: https://github.com/docluv/add-to-homescreen/blob/master/demos/sw.js
 */

const SWVersion	=	0.001;

const PWACACHE	=	'myh_pwa_cache';

const offlineFallbackPage	=	"pages/offline.html";

// Add whichever assets you want to precache here:
const PRECACHE_ASSETS	=	[ 'files/', 'images/', offlineFallbackPage ];

// Listener for the install event - precaches assets list on service worker install
self.addEventListener( 'install', event => {
event.waitUntil( ( async () => {
	const cache	=	await caches.open( PWACACHE );
	cache.addAll( PRECACHE_ASSETS );
// console.log( PRECACHE_ASSETS );
// caches.open(pb_cache)
// .then((cache) => {
// return cache.addAll(PRECACHE_ASSETS)
// .then(() => {
// return self.skipWaiting();
// })
// });

} )());
} );

self.addEventListener( 'activate', event => { event.waitUntil( clients.claim() ); } );

/*
self.addEventListener( 'fetch', event => {
event.respondWith( async () => {
const cache	=	await caches.open( PWACACHE );

// match the request to our cache
const cachedResponse	=	await cache.match( event.request );

// check if we got a valid response
if ( cachedResponse !== undefined ) { return cachedResponse;	// Cache hit, return the resource
}
else { return fetch( event.request );	// Otherwise, go to the network
};
} );
} );
*/

self.addEventListener( 'fetch', ( event ) => {
if ( event.request.mode === 'navigate' ) {
	event.respondWith( ( async () => {
	try {
		const preloadResp	=	await event.preloadResponse;
		if ( preloadResp ) { return preloadResp; }
		const networkResp	=	await fetch( event.request );
		return networkResp;
	}
	catch (error) {
		const cache	=	await caches.open( PWACACHE );
		const cachedResp	=	await cache.match( offlineFallbackPage );
		return cachedResp;
	}
	} )());
}
});



/*
Updating and deleting assets #
You can update assets using cache.put(request, response) and delete assets with delete(request).

Avoid device detection #
You should directly test for feature support instead of making support assumptions based on the User-Agent string.
*/


