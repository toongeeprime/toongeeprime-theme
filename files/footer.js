/**
 *	ToongeePrime Theme Footer JS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

const	theBody	=	p2getEl( 'body' );


/**
 *	Page-scrolling actions
 */
window.addEventListener( "scroll", function() {
let primetoTop	=	p2getEl( '#prime2g_toTop' ),
	popEl		=	p2getAll( '.popEl' );

	if ( window.pageYOffset > 700 ) {
		primetoTop.classList.add( 'show' );
		theBody.classList.add( 'pop' );
	}
	else {
		primetoTop.classList.remove( 'show' );
		theBody.classList.remove( 'pop' );
	}

	if ( popEl ) {
		popEl.forEach( ( pop )=>{
			if ( prime2g_inViewport( pop ) ) { pop.classList.add( 'inview' ); }
		} );
	}

}, false );



/**
 *	Close mobile menu by class "close_mobile_menu"
 */
p2getAll( '.close_mobile_menu' ).forEach( close_mMenu );
function close_mMenu(el) {
	(el).addEventListener( 'click', (el)=>{
	p2getEl( '.main_menu_wrap.prime' ).classList.remove( 'prime' );
} )
}



// Remove class to determine browser supports JavaScript
document.body.classList.remove( 'no-js' );
