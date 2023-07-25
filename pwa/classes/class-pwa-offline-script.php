<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: PWA Offline Script
 *	Here to plug into either Theme's service worker or that of WP PWA
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */


// Study: https://web.dev/learn/pwa/caching/#updating-and-deleting-assets updating & deleting

class Prime2g_PWA_Offline_Scripts {

	public function caching() {
	$offline	=	new Prime2g_PWA_Offline_Manager();
	$name		=	get_bloginfo( 'name' );
	$siteName	=	str_replace( [ ' ', '\'', '.' ], '', $name );

	$js	=
'const PWACACHE	=	"'. $siteName .'_p2gApp_cache";
const offlineFallbackPage	=	"'. $offline->get_offline_url( 'index' ) .'";
const PRECACHE_ASSETS	=	[ "/", offlineFallbackPage ];

self.addEventListener( "install", event => {
event.waitUntil( ( async () => {
	const cache	=	await caches.open( PWACACHE );
	return cache.addAll( PRECACHE_ASSETS );
} )() );
} );
';

	return $js;
	}

}


