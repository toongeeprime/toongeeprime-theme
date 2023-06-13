/**
 *	ToongeePrime Customizer JS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.50
 */
jQuery( document ).ready( function( $ ) {
/* if ( 'undefined' === typeof wp || ! wp.customize || ! wp.customize.selectiveRefresh ) return; */
let imgHeight	=	Math.ceil( $( '.custom-logo' ).height() );
$( '.custom-logo' ).css( { 'width': 'auto', 'height': imgHeight } );

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

	/* @since ToongeePrime Theme 1.0.55 */
	wp.customize( 'prime2g_header_img_attachment', function( value ) {
		value.bind( function( newval ) { $( '#header.site_header' ).css( 'background-attachment', newval ); } );
	} );
	wp.customize( 'prime2g_header_background_size', function( value ) {
		value.bind( function( newval ) { $( '#header.site_header' ).css( 'background-size', newval ); } );
	} );
	wp.customize( 'prime2g_theme_header_height', function( value ) {
		value.bind( function( newval ) { $( '#header.site_header' ).css( 'min-height', newval+'vh' ); } );
	} );
	wp.customize( 'prime2g_post_title_font_size', function( value ) {
		value.bind( function( newval ) { $( '.singular .entry-title' ).css( 'font-size', newval+'rem' ); } );
	} );
	wp.customize( 'prime2g_archive_title_font_size', function( value ) {
		value.bind( function( newval ) { $( 'body:not(.singular) .entry-title' ).css( 'font-size', newval+'rem' ); } );
	} );
	wp.customize( 'prime2g_body_text_font_size', function( value ) {
		value.bind( function( newval ) { $( 'body' ).css( 'font-size', newval+'px' ); } );
	} );
	wp.customize( 'prime2g_page_titles_font_weight', function( value ) {
		value.bind( function( newval ) { $( 'h1.page-title' ).css( 'font-weight', newval ); } );
	} );
	wp.customize( 'prime2g_loop_post_image_height', function( value ) {
		value.bind( function( newval ) {
			$( '.posts_loop .thumbnail' ).css( 'height', newval+'em' );
			$( '#archive_loop .video iframe' ).css( 'height', newval+'em' );
		} );
	} );
	wp.customize( 'prime2g_theme_logo_height', function( value ) {
		value.bind( function( newval ) { $( '.custom-logo' ).css( 'height', newval+'px' ); } );
	} );
} );

