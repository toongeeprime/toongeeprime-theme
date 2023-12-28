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
		$start		=	new self();
		$content	=	$start->share_this();

		return $content;
	}
	return self::$instance;
	}


	public static function checkAndReload( string $btn = '', $interval = 60000 ) {
$js	=	'';

if ( $btn ) {
	$js	.=	'p2getEl( "'. $btn .'" ).addEventListener( "click", () => { window.location.reload(); } );';
}

$js	.=	'
async function checkNetworkAndReload() {
try {
	const response	=	await fetch( "." );
	if ( response.status >= 200 && response.status < 500 && document.hasFocus() ) {
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
	$offlineUrl	=	$offline->get_file_url()[ 'offline' ];
	$cacheNames	=	prime2g_pwa_cache_names();

$js	=	'';

if ( $btn ) {
	$js	.=	'p2getEl( "'. $btn .'" ).addEventListener( "click", event => { tryPageDownload(); } );';
}

$js	.=	'
async function tryPageDownload() {
const PWACACHE		=	"'. $cacheNames->pwa_core .'";
const DYNACACHE		=	"'. $cacheNames->dynamic .'";

	try {
		const dyn_cache	=	await caches.open( DYNACACHE );
		const fromNetwork	=	await fetch( "." );
		await dyn_cache.put( ".", fromNetwork.clone() );
		console.log( "Network request made!" );
		window.setTimeout( ()=>{ window.location.reload() }, 1000 );
	} catch ( error ) {
		console.log( error );
		const cache	=	await caches.open( PWACACHE );
		const userOffline	=	await cache.match( "'. $offlineUrl .'" );
		return userOffline;
	}
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


	public function helpers() {
$js	=	'
// Returns ANY type of page reload
// @https://developer.mozilla.org/en-US/docs/Web/API/PerformanceNavigationTiming/type
// window is not defined in service worker.
function ifPageIsReloaded() {
	return ( window.performance.getEntriesByType( "navigation" )[0].type === "reload" ||
	window.performance.navigation && window.performance.navigation.type === 1 );
}
';
return $js;
	}


	public function abort_fetch_api() { // unused yet
	$values	=	$this->values_and_mods();

$js	=	$this->helpers() .
'const controller	=	new AbortController();
const reloaded		=	ifPageIsReloaded();
const sw_url		=	"'. $values->service_worker .'";
const serv_Worker	=	new Worker( sw_url );

/*	Do not run on form submit	*/
const forms		=	p2getAll( "form" );
if ( forms ) { forms.forEach( f => { f.addEventListener( "submit", ()=>{ serv_Worker.terminate(); } ); } ); }
';
return $js;
	}


	private function values_and_mods() {
	$fileURLs	=	new Prime2g_PWA_File_Url_Manager();
	$get_url	=	$fileURLs->get_file_url();

	$hostNames	=	defined( 'PWA_REQUEST_HOSTS' ) ? PWA_REQUEST_HOSTS : '""';

	return (object) [
		'hostNames'			=>	$hostNames,
		'service_worker'	=>	$get_url[ 'service-worker' ],
	];
	}

}


