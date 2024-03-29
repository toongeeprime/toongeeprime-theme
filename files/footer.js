/**
 *	ToongeePrime Theme Footer JS
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/* Vars */
const	theBody	=	p2getEl( 'body' );

/* On Page-scroll */
window.addEventListener( "scroll", ()=>{
let primetoTop	=	p2getEl( '#prime2g_toTop' ),
popEl	=	p2getAll( '.popEl' );

if ( window.pageYOffset > 500 ) { theBody.classList.add( 'pop' ); }
else { theBody.classList.remove( 'pop' ); }
if ( window.pageYOffset > 800 ) { primetoTop.classList.add( 'show' ); }
else { primetoTop.classList.remove( 'show' ); }
if ( popEl ) { popEl.forEach( ( pop )=>{ if ( prime2g_inViewport( pop ) ) { pop.classList.add( 'inview' ); } } ); }
}, false );

/* Close mobile menu by class "close_mobile_menu" */
p2getAll( '.close_mobile_menu' ).forEach( el=>{
	el.addEventListener( 'click', ()=>{ p2getEl( '.main_menu_wrap.prime' ).classList.remove( 'prime' ); } )
} );

// Indicate browser supports JavaScript
document.body.classList.remove( 'no-js' );
document.body.classList.add( 'js' );



