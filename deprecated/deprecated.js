/**
 *	ToongeePrime Theme JS Deprecated code
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.57
 */
// Poor function naming
function prime2gElems( elems, clss = 'prime' ) {
elems.forEach( el=>{ event.preventDefault(); p2getEl( el ).classList.add( clss ); } );
}

function prime2g_offElems( elems, clss = 'prime' ) {
elems.forEach( el=>{ event.preventDefault(); p2getEl( el ).classList.remove( clss ); } );
}

function prime2g_toggElems( elems, clss = 'prime' ) {
elems.forEach( el=>{ event.preventDefault(); p2getEl( el ).classList.toggle( clss ); } );
}

function prime2g_inViewport_get( elmt ) {
el	=	typeof elmt === 'object' ? elmt : p2getEl( elmt );
let rect	=	el.getBoundingClientRect();
	return (
		rect.top >= 0 && rect.left >= 0 &&
		rect.bottom	<=	( window.innerHeight || document.documentElement.clientHeight ) &&
		rect.right	<=	( window.innerWidth || document.documentElement.clientWidth )
	);
}

