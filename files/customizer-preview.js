/**
 *	ToongeePrime Customizer JS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.50.00
 */
jQuery( document ).ready( function( $ ) {

/*if ( 'undefined' === typeof wp || ! wp.customize || ! wp.customize.selectiveRefresh ) return;*/


	wp.customize( 'prime2g_header_background', function( value ) {
		value.bind( function( newval ) { $( '#header' ).css( 'background-color', newval ); } );
	} );
	wp.customize( 'prime2g_background_color', function( value ) {
		value.bind( function( newval ) { $( 'body' ).css( 'background-color', newval ); } );
	} );
	wp.customize( 'prime2g_content_background', function( value ) {
		value.bind( function( newval ) { $( '#content' ).css( 'background-color', newval ); } );
	} );
	wp.customize( 'prime2g_footer_background', function( value ) {
		value.bind( function( newval ) { $( '#footerWrap' ).css( 'background-color', newval ); } );
	} );

	wp.customize( 'prime2g_front_page_title', function( value ) {
		value.bind( function( newval ) { $( '#header h1.entry-title' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_posts_home_title', function( value ) {
		value.bind( function( newval ) { $( '#header h1.entry-title' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_posts_home_description', function( value ) {
		value.bind( function( newval ) { $( '.archive-description p' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_theme_sticky_heading', function( value ) {
		value.bind( function( newval ) { $( 'h1.sticky_heading' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_footer_credit_power', function( value ) {
		value.bind( function( newval ) { $( '.site_footer_credits .power' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_footer_credit_name', function( value ) {
		value.bind( function( newval ) { $( '.site_footer_credits a' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_footer_credit_url', function( value ) {
		value.bind( function( newval ) { $( '.site_footer_credits a' ).attr( 'href', newval ) ; } );
	} );
	wp.customize( 'prime2g_footer_credit_append', function( value ) {
		value.bind( function( newval ) { $( '#appended_credit' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_shop_page_title', function( value ) {
		value.bind( function( newval ) { $( '#header h1.entry-title' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_shop_page_description', function( value ) {
		value.bind( function( newval ) { $( '.archive-description p' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_contact_address', function( value ) {
		value.bind( function( newval ) { $( '#footerWrap .socials_contacts .address' ).html( '<i class="bi bi-building"></i>'+newval ); } );
	} );

} );
