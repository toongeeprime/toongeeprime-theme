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
let primetoTop	=	document.querySelector( '#prime2g_toTop' );

	if( window.pageYOffset > 700 ) {
		primetoTop.classList.add( 'show' );
	}
	else {
		primetoTop.classList.remove( 'show' );
	}

}, false );



// Remove class to determine browser supports JavaScript
document.body.classList.remove( 'no-js' );
