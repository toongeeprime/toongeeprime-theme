/**
 *	ToongeePrime Customizer JS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */


( function( $ ) {


	wp.customize( 'prime2g_content_background', function( value ) {
		value.bind( function( newval ) {
			$( '#contentWrap' ).css( 'background-color', newval );
		} );
	} );


	wp.customize( 'prime2g_posts_home_title', function( value ) {
		value.bind( function( newval ) {
			$( 'h1.entry-title' ).html( newval );
		} );
	} );


} )( jQuery );

