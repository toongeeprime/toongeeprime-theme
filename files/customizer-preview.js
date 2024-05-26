/**
 *	ToongeePrime Customizer JS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.50
 */
jQuery( document ).ready( ( $ )=>{
/* if ( 'undefined' === typeof wp || ! wp.customize || ! wp.customize.selectiveRefresh ) return; */
let imgHeight	=	Math.ceil( $( '.custom-logo' ).height() );
$( '.custom-logo' ).css( { 'width': 'auto', 'height': imgHeight } );

	wp.customize( 'prime2g_header_background', ( value )=>{
		value.bind( ( newval )=>{ $( '#header' ).css( 'background-color', newval ); } );
	} );
	wp.customize( 'prime2g_background_color', ( value )=>{
		value.bind( ( newval )=>{ $( 'body' ).css( 'background-color', newval ); } );
	} );
	wp.customize( 'prime2g_content_background', ( value )=>{
		value.bind( ( newval )=>{ $( '#content' ).css( 'background-color', newval ); } );
	} );
	wp.customize( 'prime2g_footer_background', ( value )=>{
		value.bind( ( newval )=>{ $( '#footerWrap' ).css( 'background-color', newval ); } );
	} );

	wp.customize( 'prime2g_front_page_title', ( value )=>{
		value.bind( ( newval )=>{ $( '#header h1.entry-title' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_posts_home_title', ( value )=>{
		value.bind( ( newval )=>{ $( '#header h1.entry-title' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_posts_home_description', ( value )=>{
		value.bind( ( newval )=>{ $( '.archive-description p' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_theme_sticky_heading', ( value )=>{
		value.bind( ( newval )=>{ $( 'h1.sticky_heading' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_footer_credit_power', ( value )=>{
		value.bind( ( newval )=>{ $( '.site_footer_credits .power' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_footer_credit_name', ( value )=>{
		value.bind( ( newval )=>{ $( '.site_footer_credits a' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_footer_credit_url', ( value )=>{
		value.bind( ( newval )=>{ $( '.site_footer_credits a' ).attr( 'href', newval ) ; } );
	} );
	wp.customize( 'prime2g_footer_credit_append', ( value )=>{
		value.bind( ( newval )=>{ $( '#appended_credit' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_shop_page_title', ( value )=>{
		value.bind( ( newval )=>{ $( '#header h1.entry-title' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_shop_page_description', ( value )=>{
		value.bind( ( newval )=>{ $( '.archive-description p' ).html( newval ); } );
	} );
	wp.customize( 'prime2g_contact_address', ( value )=>{
		value.bind( ( newval )=>{ $( '#footerWrap .socials_contacts .address' ).html( '<i class="bi bi-building"></i>'+newval ); } );
	} );

	/* @since ToongeePrime Theme 1.0.55 */
	wp.customize( 'prime2g_header_img_attachment', ( value )=>{
		value.bind( ( newval )=>{ $( '#header.site_header' ).css( 'background-attachment', newval ); } );
	} );
	wp.customize( 'prime2g_header_background_size', ( value )=>{
		value.bind( ( newval )=>{ $( '#header.site_header' ).css( 'background-size', newval ); } );
	} );
	wp.customize( 'prime2g_theme_header_height', ( value )=>{
		value.bind( ( newval )=>{ $( '#header.site_header' ).css( 'min-height', newval+'vh' ); } );
	} );
	wp.customize( 'prime2g_post_title_font_size', ( value )=>{
		value.bind( ( newval )=>{ $( '.singular .entry-title' ).css( 'font-size', newval+'rem' ); } );
	} );
	wp.customize( 'prime2g_archive_title_font_size', ( value )=>{
		value.bind( ( newval )=>{ $( 'body:not(.singular) .entry-title' ).css( 'font-size', newval+'rem' ); } );
	} );
	wp.customize( 'prime2g_body_text_font_size', ( value )=>{
		value.bind( ( newval )=>{ $( 'body' ).css( 'font-size', newval+'px' ); } );
	} );
	wp.customize( 'prime2g_page_titles_font_weight', ( value )=>{
		value.bind( ( newval )=>{ $( 'h1.page-title' ).css( 'font-weight', newval ); } );
	} );
	wp.customize( 'prime2g_loop_post_image_height', ( value )=>{
		value.bind( ( newval )=>{
			$( '.posts_loop .thumbnail' ).css( 'height', newval+'em' );
			$( '#archive_loop .video iframe' ).css( 'height', newval+'em' );
		} );
	} );
	wp.customize( 'prime2g_theme_logo_height', ( value )=>{
		value.bind( ( newval )=>{ $( '.custom-logo' ).css( 'height', newval+'px' ); } );
	} );
} );

