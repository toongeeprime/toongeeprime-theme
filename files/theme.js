/**
 *	ToongeePrime Theme JS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */
function primeElems( elems, clss = 'prime' ) {
elems.forEach( activeAdd );
	function activeAdd( el ) {
		let ell = document.querySelector( el );
		ell.classList.add( clss );
	}
}

function prime_offElems( elems, clss = 'prime' ) {
elems.forEach( clRemove );
	function clRemove( el ) {
		let ell = document.querySelector( el );
		ell.classList.remove( clss );
	}
}

function prime_toggElems( elems, clss = 'prime' ) {
elems.forEach( elTogg );
	function elTogg( el ) {
		let ell = document.querySelector( el );
		ell.classList.toggle( clss );
	}
}


// Element in viewport checker
function prime_inViewport( el ) {
let rect = el.getBoundingClientRect();
	return (
		rect.top >= 0 && rect.left >= 0 &&
		rect.bottom	<=	( window.innerHeight || document.documentElement.clientHeight ) &&
		rect.right	<=	( window.innerWidth || document.documentElement.clientWidth )
	);
}


function prime_gotoThis( selector ) {
let elmt = document.querySelector( selector );
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

