/**
 *	ToongeePrime Theme Footer JS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	Page-scrolling actions
 */
window.addEventListener( "scroll", function() {
let primetoTop	=	document.querySelector( '#prime2g_toTop' ),
	theBody		=	document.querySelector( 'body' );

	if( window.pageYOffset > 700 ) {
		primetoTop.classList.add( 'show' );
		theBody.classList.add( 'pop' );
	}
	else {
		primetoTop.classList.remove( 'show' );
		theBody.classList.remove( 'pop' );
	}

}, false );



/**
 *	Close mobile menu by class "close_mobile_menu"
 */
document.querySelectorAll( '.close_mobile_menu' ).forEach( close_mMenu );
function close_mMenu(el) {
	(el).addEventListener( 'click', (el)=>{
	document.querySelector( '.main_menu_wrap.prime' ).classList.remove( 'prime' );
} )
}



// Remove class to determine browser supports JavaScript
document.body.classList.remove( 'no-js' );
