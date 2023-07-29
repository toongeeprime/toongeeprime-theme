<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: PWA Offline Script
 *	Here to plug into either Theme's service worker or that of WP PWA
 *	codes are NOT wrapped in <script> tags
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_PWA_Offline_Scripts {

// Study: https://web.dev/learn/pwa/caching/#updating-and-deleting-assets updating & deleting

	public static function content() {}


	public static function checkAndReload( string $btn = '', $interval = 60000 ) {
$js	=	'';

if ( $btn ) {
	$js	.=	'document.querySelector( "'. $btn .'" ).addEventListener( "click", () => {
window.location.reload();
} );';
}

$js	.=	'
// Listen to changes in network & reload == *When device is offline
window.addEventListener( "online", () => { window.location.reload(); } );

// Check if server is responding & reload == *Device is online, server failed
async function checkNetworkAndReload() {
try {
	const response	=	await fetch( "." );
	// Verify response from the server
	if ( response.status >= 200 && response.status < 500 ) {
		window.location.reload();
		return;
	}
} catch {
	// Unable to connect to the server, ignore
}
window.setTimeout( checkNetworkAndReload, "'. $interval .'" );
}

checkNetworkAndReload();
';
return $js;
	}

}

