<?php defined( 'ABSPATH' ) || exit;
/**
 *	CLASS: PWA Scripts
 *	Contents for PWA virtual script.js file and other selective uses
 *	No <script> tags
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 *
 *	Use filter: prime2g_filter_pwa_scripts to add code to pwa script.js file @since 1.0.97
 */

class Prime2g_PWA_Scripts {

	public $scripts;
	private static $instance;
	#	Caching: @since 1.0.98
	private $same_version;

	public function __construct() {
	if ( ! isset( self::$instance ) ) {
		$this->same_version	=	prime2g_app_option( 'scripts_version' );
		$this->scripts		=	$this->js();
	}
	return self::$instance;
	}


	function js() {
	$js	=	$this->cached();

	if ( ! $this->same_version )
		prime2g_app_option( [ 'name'=>'scripts_version', 'update'=>true ] );

	return $js . apply_filters( 'prime2g_filter_pwa_scripts', '', $js );
	}


	private function cached() {
	$js	=	prime2g_app_option( 'app_scripts' );

	if ( false === $js || ! $this->same_version ) {
		$this->scripts	=	"// PWA Scripts\n";
		$this->scripts	.=	$this->onlineMonitor();
		$this->scripts	.=	apply_filters( 'prime2g_filter_cached_pwa_scripts', '', $this->scripts );
		prime2g_app_option( [ 'name'=>'app_scripts', 'update'=>true, 'value'=>$this->scripts ] );
		$js	=	prime2g_app_option( 'app_scripts' );
	}

	return $js;
	}


	static function customizer() {
	#	Gotta use jQuery
$js	=	'jQuery( document ).ready( ()=>{';

$js	.=	'
jQuery( "#customize-control-prime2g_pwapp_primaryicon" )?.append( \'<div id="p2gSS_Head" style="margin-top:40px;"><h2>'. __( '- APP SCREENSHOTS -', PRIME2G_TEXTDOM ) .'</h2></div>\' );
jQuery( "#customize-control-site_icon .attachment-media-view" )?.prepend( "<h3>'. __( 'Use a PNG/WEBP image for best results with your web app', PRIME2G_TEXTDOM ) .'.</h3>" );
';

$js	.=	'} );';

return $js;
	}


	static function checkAndReload( string $btn = '', $interval = 60000 ) {
$js	=	'';

if ( $btn ) {
	$js	.=	'p2getEl( "'. $btn .'" ).addEventListener( "click", ()=>{ window.location.reload(); } );';
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
	console.log( error );
}
}

window.addEventListener( "online", ()=>{ window.location.reload(); } );
window.setInterval( checkNetworkAndReload, '. $interval .' );
';
return $js;
	}


	static function getPageFromNetwork( string $btn = '' ) {
	$fileUrls	=	new Prime2g_PWA_File_Url_Manager;
	$offlineUrl	=	$fileUrls->get_file_url()[ 'offline' ];
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


	function onlineMonitor() {
	return	"window.addEventListener( 'online', connectionMonitor );
window.addEventListener( 'offline', connectionMonitor );

function connectionMonitor() {
const ooID	=	'#prime2g_offOnline_notif',
	ooClass		=	'.oo_notif',
	onClass		=	'.online.oo_notif',
	connClass	=	'.connected.oo_notif',
	offClass	=	'.offline.oo_notif';

if ( navigator.onLine ) {
	console.log( 'connected' );
	prime2g_addClass( [ onClass, offClass ], 'off', false );
	prime2g_remClass( [ ooID, connClass ], 'off', false );

	reachToUrl( getServerUrl() ).then( ( online )=>{
	if ( online ) {
	console.log( 'online' );
	prime2g_addClass( [ connClass, offClass ], 'off', false );
	prime2g_remClass( [ ooID, onClass ], 'off', false );
	p2gOffOONotif();
	}
	else {
	console.log( 'no internet' );
	prime2g_addClass( [ onClass, offClass ], 'off', false );
	prime2g_remClass( [ ooID, connClass ], 'off', false );
	p2gOffOONotif();
	}
	} );
}
else {
	console.log( 'offline' );
	prime2g_addClass( [ onClass, connClass ], 'off', false );
	prime2g_remClass( [ ooID, offClass ], 'off', false );
	p2gOffOONotif();
}
}

function p2gOffOONotif() {
if ( p2getEl( '#prime2g_offOnline_notif' ) ) {
	setTimeout( ()=>{ prime2g_addClass( [ '#prime2g_offOnline_notif' ], 'off', false ); }, 10000 );
}
}

function reachToUrl( url ) {
return fetch( url, { method: 'HEAD', mode: 'no-cors' } )
.then( resp => {
	return resp && ( resp.ok || resp.type === 'opaque' );
} )
.catch( err => {
	console.warn( '[conn test failure]:', err );
} );
}

function getServerUrl() { return window.location.origin; }

p2getEl( '#prime2g_offOnline_notif' ).onclick = ( event )=>{
	prime2g_addClass( [ '#prime2g_offOnline_notif' ], 'off' );
}
";
	}

}

