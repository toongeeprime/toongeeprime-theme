<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: PWA Offline Scripts
 *	Here to plug into either Theme's service worker or that of WP PWA
 *	codes are NOT wrapped in <script> tags
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_PWA_Scripts {

	public static function content() {}


	public static function checkAndReload( string $btn = '', $interval = 60000 ) {
$js	=	'';

if ( $btn ) {
	$js	.=	'document.querySelector( "'. $btn .'" ).addEventListener( "click", () => {
window.location.reload();
} );';
}

$js	.=	'
async function checkNetworkAndReload() {
try {
	const response	=	await fetch( "." );
	if ( response.status >= 200 && response.status < 500 ) {
		window.location.reload();
		return;
	}
} catch ( error ) {
	// Nothing much to do
	console.log( error );
}
}

window.addEventListener( "online", () => { window.location.reload(); } );
window.setInterval( checkNetworkAndReload, '. $interval .' );
';
return $js;
	}


	public static function getPageFromNetwork( string $btn = '' ) {
	$offline	=	new Prime2g_PWA_File_Url_Manager();
	$offlineRul	=	$offline->get_file_url()[ 'index' ];

$js	=	'';

if ( $btn ) {
	$js	.=	'document.querySelector( "'. $btn .'" ).addEventListener( "click", ()=>{
		event.respondWith( networkFetcher() );
	}
);';
}

$js	.=	'
async function networkFetcher() {
	try {
		const dyn_cache	=	await caches.open( DYNAMIC_CACHE );

		const fromNetwork	=	await fetch( "." );
		await dyn_cache.put( ".", fromNetwork.clone() );
		if ( fromNetwork ) return fromNetwork;
	} catch ( error ) {
		console.log( error );
		const cache	=	await caches.open( PWACACHE );
		const userOffline	=	await cache.match( '. $offlineRul .' );
		return userOffline;
	}

window.setTimeout( ()=>{ window.location.reload() }, 1000 );
}
';
return $js;
	}

}


/*
window.addEventListener("offline", function(){
    console.log("Oh no, you lost your network connection.");
});
*/
