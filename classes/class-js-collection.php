<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: JS
 *	A bunch of JS + elements for selecive use
 *	Depends on enqueued prime2g_js (theme.js)
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.70
 */

if ( ! class_exists( 'Prime2gJSBits' ) ) {

class Prime2gJSBits {

	/**
	 *	Elements to work with Class' code
	 */
	public static function elements( string $get ) {
	$footerhook	=	is_admin() ? 'admin_footer' : 'wp_footer';

	$css	=	'<style id="'. $get .'CSS">'. self::elements_css( $get ) .'</style>';

	if ( $get === 'copied_to_clip' ) {
		add_action( $footerhook, function() use( $css ) {
			echo $css . '<div id="jsBit_copiedtoclip">'. __( 'Copied to Clipboard', PRIME2G_TEXTDOM ) .'</div>';
		} );
	}
	}


	public static function elements_css( string $get ) {
	//	$get must match elements() method args
	if ( $get === 'copied_to_clip' ) {
	return '#jsBit_copiedtoclip{position:fixed;bottom:5px;right:10px;transform:translateY(120%);transition:0.3s;z-index:99999;font-size:110%;font-weight:600;letter-spacing:1px;background:#f7f7f7;color:#000;padding:5px 10px;margin:0;line-height:1;border-radius:5px;box-shadow:0 3px 7px rgba(0,0,0,0.3);}
	.prime#jsBit_copiedtoclip{transform:translate(0);}
	.highlight{background:var(--content-text);color:var(--content-background);}';
	}

	}


	/**
	 *	JS CODES
	 */
	public static function copy_to_clipboard( bool $tags = true ) {
	if ( defined( 'P2GJSBIT_CTCLIPB' ) ) return;	//	Prevent multiple instances
	define( 'P2GJSBIT_CTCLIPB', true );

	self::elements( 'copied_to_clip' );
	$footerhook	=	is_admin() ? 'admin_footer' : 'wp_footer';

$js	=	$tags ? '<script id="p2bit_c2clipboard">' : '';

$js	.=	self::set_class() . self::class_by_timeout();
$js	.=	'
function p2gCopyToClipBoard( elmt ) {
var copyFrom	=	( typeof elmt === "object" ) ? elmt : p2getEl( elmt );
copyFrom.addEventListener( "click", ()=>{
event.preventDefault();
try {
	var range	=	document.createRange();
	window.getSelection().removeAllRanges();	/* clear current selection */
	range.selectNodeContents( copyFrom );
	var selectedString	=	range.toString();

	if ( selectedString ) {
		navigator.clipboard.writeText( selectedString );
		p2gClassByTimeout( [ copyFrom, "#jsBit_copiedtoclip" ], 0, [ "highlight", "prime" ] );
		p2gClassByTimeout( [ copyFrom, "#jsBit_copiedtoclip" ], 5000, [ "highlight", "prime" ], "remove" );
		console.log( selectedString );
	}
	else { console.log( "Failed to copy text!" ); }
}
catch (error) { console.error( error.message ); }
} );
}';

$js	.=	$tags ? '</script>' : '';

	add_action( $footerhook, function() use( $js ) { echo $js; }, 12 );
}


	public static function class_by_timeout() {
	if ( defined( 'P2GJSBIT_SCBTO' ) ) return;
	define( 'P2GJSBIT_SCBTO', true );
	return 'function p2gClassByTimeout( elmts, interval, classes = "prime", toDo = "add" ) {
		setTimeout( ()=>{ p2gSetClass( elmts, toDo, classes ); }, interval );
	}';
	}


	public static function set_class() {
	if ( defined( 'P2GJSBIT_SETC' ) ) return;
	define( 'P2GJSBIT_SETC', true );

	return 'function p2gSetClass( elmts, toDo = "add", classes = "prime" ) {
	if ( Array.isArray( elmts ) ) {
		count	=	elmts.length;
		for ( e = 0; e < count; e++ ) {
			var theEl	=	typeof elmts[e] === "object" ? elmts[e] : p2getEl( elmts[e] );
			var theClass=	Array.isArray( classes ) ? classes[e] : classes;
			if ( toDo === "add" ) theEl.classList.add( theClass );
			if ( toDo === "remove" ) theEl.classList.remove( theClass );
		}
	} else {
		var theEl	=	typeof elmts === "object" ? elmts : p2getEl( elmts );
		var theClass=	Array.isArray( classes ) ? classes[0] : classes;
		if ( toDo === "add" ) theEl.classList.add( theClass );
		if ( toDo === "remove" ) theEl.classList.remove( theClass );
	}
	}';
	}

}

}

