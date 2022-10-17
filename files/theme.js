/**
 *	ToongeePrime Theme JS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */
function p2getEl( el ) { return document.querySelector( el ); }
function p2getAll( els ) { return document.querySelectorAll( els ); }

function prime2gElems( elems, clss = 'prime' ) {
elems.forEach( clssAdd );
	function clssAdd( el ) {
		event.preventDefault();
		let ell = p2getEl( el );
		ell.classList.add( clss );
	}
}

function prime2g_offElems( elems, clss = 'prime' ) {
elems.forEach( clRemove );
	function clRemove( el ) {
		event.preventDefault();
		let ell = p2getEl( el );
		ell.classList.remove( clss );
	}
}

function prime2g_toggElems( elems, clss = 'prime' ) {
elems.forEach( elTogg );
	function elTogg( el ) {
		event.preventDefault();
		let ell = p2getEl( el );
		ell.classList.toggle( clss );
	}
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


function prime2g_gotoThis( selector ) {
let elmt = p2getEl( selector );
	elmt.scrollIntoView( true );
}


// Remove classes on Esc key
document.addEventListener(
	'keyup', function( event ) {
	if ( event.defaultPrevented ) { return; }

	let key = event.key || event.keyCode;
	if ( key === 'Escape' || key === 'Esc' || key === 27 ) {
	let allElems = document.getElementsByClassName( 'prime' );
		while ( allElems.length > 0 ) {
			allElems[0].classList.remove( 'prime' );
		}
	}
}
);

