<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: PWA Extra Features
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_PWA_Features {

// SUGGESTION: Use static functions for each feature

	public static function share_this() {
	$title	=	$url	=	$text	=	'';

// To activate, create element with PWA_SHARER_BTN_ID && must have .hide class
$js	=	'const shareData = { title: "'. $title .'", url: "'. $url .'", text: "'. $text .'" };

function canBrowserShareData( data ) {
	if ( ! navigator.share || ! navigator.canShare ) { return false; }
	return navigator.canShare( data );
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


