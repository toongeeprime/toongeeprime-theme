<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: PWA Scripts
 *	Plug into Theme's Web App
 *	codes ARE NOT wrapped in <script> tags
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_PWA_Scripts {

	private static $instance;

	public static function content() {
	if ( ! isset( self::$instance ) ) {
		$start	=	new self();
		$sharer	=	$start->share_this();

		return $sharer;
	}
	return self::$instance;
	}


	public static function checkAndReload( string $btn = '', $interval = 60000 ) {
$js	=	'';

if ( $btn ) {
	$js	.=	'p2getEl( "'. $btn .'" ).addEventListener( "click", () => {
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
	$offlineUrll	=	$offline->get_file_url()[ 'offline' ];

$js	=	'';

if ( $btn ) {
	$js	.=	'p2getEl( "'. $btn .'" ).addEventListener( "click", ()=>{
		event.respondWith( networkFetcher() );
	} );';
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
		const userOffline	=	await cache.match( '. $offlineUrll .' );
		return userOffline;
	}

window.setTimeout( ()=>{ window.location.reload() }, 1000 );
}
';
return $js;
	}


	public function share_this() {
	$title	=	$url	=	$text	=	'';

$js	=	'const shareData = { title: "'. $title .'", url: "'. $url .'", text: "'. $text .'" };

function canBrowserShareData( data ) {
	if ( ! navigator.share || ! navigator.canShare ) { return false; }
	return navigator.canShare( data ); // determines if data is shareable
}

const sharerBTN	=	p2getEl( "#'. PWA_SHARER_BTN_ID .'" );
if ( sharerBTN && canBrowserShareData( shareData ) ) {
sharerBTN.classList.remove( "hide" );
sharerBTN.addEventListener( "click", async ()=>{
	try { await navigator.share( shareData ); }
	catch (err) { console.error( `URL could not be shared: ${err}` ); }
} );

}';
return $js;
	}

}

