/**
 *	ToongeePrime Theme Footer JS
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

const	theBody = p2getEl( 'body' ), primetoTop = p2getEl( '#prime2g_toTop' );

/* On Page-scroll */
window.addEventListener( "scroll", ()=>{
window.pageYOffset > 300 ? theBody.classList.add( 'pop' ) : theBody.classList.remove( 'pop' );
window.pageYOffset > 700 ? primetoTop.classList.add( 'show' ) : primetoTop.classList.remove( 'show' );
p2getAll( '.popEl' )?.forEach( pop=>{ prime2g_inViewport( pop ) ? pop.classList.add( 'inview' ) : null; } );
}, false );

/* Close mobile menu by class "close_mobile_menu" */
p2getAll( '.close_mobile_menu' )?.forEach( el=>{
	el.addEventListener( 'click', ()=>{ p2getEl( '.main_menu_wrap.prime' ).classList.remove( 'prime' ); } )
} );

//	Indicate browser supports JavaScript
document.body.classList.remove( 'no-js' );
document.body.classList.add( 'js' );
