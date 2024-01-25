<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: PWA Scripts
 *	Contents for PWA script.js file and for selective usage around the PWA
 *	No <script> tags
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

/**
 *	Create and use this Class to add code to the script.js file
 *
 *	class Prime2g_Add_PWA_Script {
 *		public static function add() { return 'string'; }
 *	}
 */


class Prime2g_PWA_Scripts {

	public $scripts;
	private static $instance;

	public function __construct() {
	if ( ! isset( self::$instance ) ) {
		$this->scripts	=	"// PWA Scripts\n";
	}

	if ( class_exists( 'Prime2g_Add_PWA_Script' ) ) {
		$this->scripts	.=	Prime2g_Add_PWA_Script::add();
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

}

