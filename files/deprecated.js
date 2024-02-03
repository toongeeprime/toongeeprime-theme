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

