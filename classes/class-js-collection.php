<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: JS
 *	A bunch of JS + elements for selecive use
 *	Depends on enqueued prime2g_js (theme.js)
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.70
 */

class Prime2gJSBits {

	/**
	 *	Elements to work with Class' code
	 */
	static function elements( string $get ) {
	$footerhook	=	is_admin() ? 'admin_footer' : 'wp_footer';

	$css	=	'<style id="'. $get .'CSS">'. self::elements_css( $get ) .'</style>';

	if ( $get === 'copied_to_clip' ) {
		add_action( $footerhook, function() use( $css ) {
			echo $css . '<div id="jsBit_copiedtoclip">'. __( 'Copied to Clipboard', PRIME2G_TEXTDOM ) .'</div>';
		} );
	}
	}


	static function elements_css( string $get ) {
	//	$get value must match elements() method
	if ( $get === 'copied_to_clip' ) {
	return '#jsBit_copiedtoclip{position:fixed;bottom:5px;right:10px;transform:translateY(120%);transition:0.3s;z-index:99999;font-size:110%;font-weight:600;letter-spacing:1px;background:#f7f7f7;color:#000;padding:5px 10px;margin:0;line-height:1;border-radius:5px;box-shadow:0 3px 7px rgba(0,0,0,0.3);}
	.prime#jsBit_copiedtoclip{transform:translate(0);}
	.highlight{background:blue;color:#fff;}';
	}

	}


	/**
	 *	JS CODES
	 */
	static function copy_to_clipboard( bool $run = false, bool $tags = true ) {
	if ( defined( 'P2GJSBIT_CTCLIPB' ) ) return;	//	Prevent multiple instances
	define( 'P2GJSBIT_CTCLIPB', true );

	self::elements( 'copied_to_clip' );
	$footerhook	=	is_admin() ? 'admin_footer' : 'wp_footer';

$js	=	$tags ? '<script id="p2bit_c2clipboard">' : '';

$js	.=	self::set_class() . self::class_by_timeout();
$js	.=	$run ? 'p2gCopyToClipBoard( null )' : '';
$js	.=	'
function p2gCopyToClipBoard( elmt = null ) {
if ( null === elmt ) {
	let	copyEls	=	p2getAll( ".p2gClipCopyThis" )
	if ( copyEls ) {
		copyEls.forEach( cp => {
		cp.setAttribute( "onclick", "p2gDoCopyToClipBoard(this);" );
		cp.setAttribute( "title", "Click to copy" );
	} ) };
}
else {
var cp	=	typeof elmt === "object" ? elmt : p2getEl( elmt );
p2gDoCopyToClipBoard( cp );
}
}

function p2gDoCopyToClipBoard( copyFrom ) {
function doC2CUX() {
	p2gClassByTimeout( [ copyFrom, "#jsBit_copiedtoclip" ], 0, [ "highlight", "prime" ] );
	p2gClassByTimeout( [ copyFrom, "#jsBit_copiedtoclip" ], 5000, [ "highlight", "prime" ], "remove" );
}

try {
if ( copyFrom.tagName.toLowerCase() === "input" ) {	/* review textarea and button */
	copyFrom.select();
	if ( document.execCommand( "copy" ) ) { doC2CUX(); }
	else { console.log( "Failed to copy text!" ); }
}
else {
	var range	=	document.createRange();
	window.getSelection().removeAllRanges();	/* clear current selection */
	range.selectNodeContents( copyFrom );
	var selectedString	=	range.toString();

	if ( selectedString ) {
		navigator.clipboard.writeText( selectedString );
		doC2CUX();
		// console.log( selectedString );
	}
	else { console.log( "Failed to copy text!" ); }
}
}
catch (error) { console.error( error.message ); }
}
';

$js	.=	$tags ? '</script>' : '';

	add_action( $footerhook, function() use( $js ) { echo $js; }, 12 );
}


	static function class_by_timeout() {
	if ( defined( 'P2GJSBIT_SCBTO' ) ) return;
	define( 'P2GJSBIT_SCBTO', true );
	return 'function p2gClassByTimeout( elmts, interval, classes = "prime", toDo = "add" ) {
		setTimeout( ()=>{ p2gSetClass( elmts, toDo, classes ); }, interval );
	}';
	}


	static function set_class() {
	if ( defined( 'P2GJSBIT_SETC' ) ) return;
	define( 'P2GJSBIT_SETC', true );

	return 'function p2gSetClass( elmts, toDo = "add", classes = "prime" ) {
	if ( Array.isArray( elmts ) ) {
		count	=	elmts.length;
		for ( e = 0; e < count; e++ ) {
			var theEl	=	typeof elmts[e] === "object" ? elmts[e] : p2getEl( elmts[e] );
			var theClass=	Array.isArray( classes ) ? classes[e] : classes;
			toDo === "add" ? theEl.classList.add( theClass ) : theEl.classList.remove( theClass );
		}
	} else {
		var theEl	=	typeof elmts === "object" ? elmts : p2getEl( elmts );
		var theClass=	Array.isArray( classes ) ? classes[0] : classes;
		toDo === "add" ? theEl.classList.add( theClass ) : theEl.classList.remove( theClass );
	}
	}';
	}


	// @since 1.0.73
	static function dom_create_and_insert( bool $tags = true, bool $hook = false ) {
	if ( defined( 'P2GJSBIT_DC_I' ) ) return;
	define( 'P2GJSBIT_DC_I', true );

	$headhook	=	is_admin() ? 'admin_head' : 'wp_head';

	$js	=	$tags ? '<script id="p2bit_creatingEls">' : '';
	$js	.=	'// Create New DOM Element
function p2g_createNewItem( elType, newID, newClass, parentEl, putBeforeEl ) {

	if ( typeof parentEl === "object" ) { parentElmt	=	parentEl; }
	else { parentElmt	=	document.querySelector( parentEl ); }

	if ( typeof putBeforeEl === "object" ) { iBefore	=	putBeforeEl; }
	else { iBefore		=	parentElmt.querySelector( putBeforeEl ); }

	let newEl		=	document.createElement( elType );
		newEl.id	=	newID,
		newEl.className	=	newClass,
		parentElmt.insertBefore( newEl, iBefore );
}

// Add content to Elements
function p2g_addContentToEl( theEl, theTxt, theHtml, ifNoText = "Empty!" ) {
let theElmt	=	document.querySelector( theEl );
	if ( theElmt !== null ) {
	let txtContent	=	document.createTextNode( theTxt ),
		noTxt		=	document.createTextNode( ifNoText );

		if ( theTxt ) { theElmt.appendChild( txtContent ); }
		else if ( theHtml ) { theElmt.innerHTML = theHtml; }
		else {
			theElmt.innerHTML = ifNoText; // html
		}
	}
	else {
		notifBox.innerHTML = "Your Requested Element, "+theEl+", Doesn\'t Exist.<br>No contents can be inserted therefore. <em>Sorry!</em>";
		notifBox.style.display = "block";
	}
}';
$js	.=	$tags ? '</script>' : '';

	if ( $hook ) {
		add_action( $headhook, function() use( $js ) { echo $js; }, 12 );
	} else {
		return $js;
	}

	}

}



