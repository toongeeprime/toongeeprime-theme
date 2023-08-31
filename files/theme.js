/**
 *	ToongeePrime Theme JS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */
function p2getEl( el ) { return document.querySelector( el ); }
function p2getAll( els ) { return document.querySelectorAll( els ); }

function prime2gElems( elems, clss = 'prime' ) {
elems.forEach( el=>{ event.preventDefault(); p2getEl( el ).classList.add( clss ); } );
}

function prime2g_offElems( elems, clss = 'prime' ) {
elems.forEach( el=>{ event.preventDefault(); p2getEl( el ).classList.remove( clss ); } );
}

function prime2g_toggElems( elems, clss = 'prime' ) {
elems.forEach( el=>{ event.preventDefault(); p2getEl( el ).classList.toggle( clss ); } );
}

// Element in viewport checker
function prime2g_inViewport( el ) {
let rect = el.getBoundingClientRect();
	return (
		rect.top >= 0 && rect.left >= 0 &&
		rect.bottom	<=	( window.innerHeight || document.documentElement.clientHeight ) &&
		rect.right	<=	( window.innerWidth || document.documentElement.clientWidth )
	);
}

function prime2g_inViewport_get( elmt ) {
el	=	p2getEl( elmt );
let rect	=	el.getBoundingClientRect();
	return (
		rect.top >= 0 && rect.left >= 0 &&
		rect.bottom	<=	( window.innerHeight || document.documentElement.clientHeight ) &&
		rect.right	<=	( window.innerWidth || document.documentElement.clientWidth )
	);
}

function prime2g_gotoThis( selector ) {
let elmt	=	p2getEl( selector );
	elmt.scrollIntoView( true );
}

// Remove classes on Esc key
document.addEventListener(
	'keyup', function( event ) {
	if ( event.defaultPrevented ) { return; }
	let key = event.key || event.keyCode;
	if ( key === 'Escape' || key === 'Esc' || key === 27 ) {
	let allElems = document.getElementsByClassName( 'prime' );
		while ( allElems.length > 0 ) { allElems[0].classList.remove( 'prime' ); }
	}
}
);

/**
 *	@since ToongeePrime Theme 1.0.48.10
 */
function prime2g_class_on_scroll( el, cls = 'pop', level = 200 ) {
window.addEventListener( "scroll", ()=>{
let elmt	=	p2getEl( el );
if ( elmt ) {
	if ( window.pageYOffset > level ) { elmt.classList.add( cls ); }
	else { elmt.classList.remove( cls ); }
}
}, false );
}

/**
 *	Counter
 *	@since ToongeePrime Theme 1.0.48.50
 */
function prime2g_count_to( speed = 100, clss = '.countEl' ) {
const	countEls	=	p2getAll( clss );
countEls.forEach( run =>{
const runCount	=	()=>{
	const value	=	+run.getAttribute( 'countto' );
	const data	=	+run.innerText;
	const result	=	value / speed;
	if ( data < value ) {
		run.innerText	=	Math.ceil( data + result );
		setTimeout( runCount, speed );
	}
	else {
		run.innerText	=	value;
	}
}
runCount();
} );
}

/**
 *	Counter
 *	@since ToongeePrime Theme 1.0.49
 */
function prime2g_get_sibling( get, elem, sibClass = '' ) {

	if ( get == 'previous' ) { var sibling	=	elem.previousElementSibling; }
	if ( get == 'next' ) { var sibling	=	elem.nextElementSibling; }

	// If no sibClass, return first sibling
	if ( ! sibClass ) return sibling;

	// If sibling matches sibClass, return; Else continue loop
	while ( sibling ) {
		if ( sibling.classList.contains( sibClass ) ) return sibling;

		if ( get == 'previous' ) { sibling	=	sibling.previousElementSibling; }
		if ( get == 'next' ) { sibling	=	sibling.nextElementSibling; }
	}

}

/**
 *	Detect Mobile or TouchScreen Devices
 *	@since ToongeePrime Theme 1.0.51
 */
function prime2g_isMobile() { return ( 'ontouchstart' in document.documentElement ); }

function prime2g_isTouchDevice() {
	try { document.createEvent( "TouchEvent" ); return true; }
	catch(e) { return false; }
}

function prime2g_screenIsSmaller( screenSize = 481 ) {

let windowWidth = window.screen.width < window.outerWidth ? window.screen.width : window.outerWidth;
return ( windowWidth < screenSize );

}

/**
 *	@since ToongeePrime Theme 1.0.55
 *
 **
 *	Leave name so it can easily be removed if ever JS makes it inbuilt
 */
function insertAfter( newNode, refNode ) { refNode.parentNode.insertBefore( newNode, refNode.nextSibling ); }

function prime2g_addClass( elems, clss = 'prime' ) {
elems.forEach( el=>{ p2getEl( el ).classList.add( clss ); } );
}

function prime2g_remClass( elems, clss = 'prime' ) {
elems.forEach( el=>{ p2getEl( el ).classList.remove( clss ); } );
}

function prime2g_toggClass( elems, clss = 'prime' ) {
elems.forEach( el=>{ p2getEl( el ).classList.toggle( clss ); } );
}

/**
 *	COOKIES
 *	You can delete a cookie by updating its expiration time to zero
 */
function primeSetCookie( cName, cValue, expDays ) {
	let date	=	new Date();
	date.setTime( date.getTime() + ( expDays * 24 * 60 * 60 * 1000 ) );
	const expires	=	"expires=" + date.toUTCString();
	document.cookie	=	cName + "=" + cValue + "; " + expires + "; path=/";
}

function primeHasCookie( cName ) {
	return document.cookie.split( ";" ).some( (item) => item.trim().startsWith( cName ) );
}

function primeGetCookieValue( cName ) {
let	name	=	cName + "=",
	ca	=	document.cookie.split( ";" );
for ( var i = 0; i < ca.length; i++ ) {
var c	=	ca[i].trim();
if ( ( c.indexOf( name ) ) == 0 ) {
	return c.substr( name.length );
}

}
return null;
}


