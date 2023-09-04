/**
 *	ToongeePrime Customizer JS
 *
 *	https://developer.wordpress.org/themes/customize-api/the-customizer-javascript-api
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.50
 */

/**
 *	@since ToongeePrime Theme 1.0.55
 */
jQuery( document ).ready( function() {

setTimeout( ()=>{
let useGFonts	=	jQuery( '#_customize-input-prime2g_use_theme_google_fonts' );

if ( useGFonts && useGFonts.is( ":checked" ) ) {
	jQuery( '#customize-control-prime2g_site_headings_font' ).css( 'display', 'block' );
	jQuery( '#customize-control-prime2g_site_body_font' ).css( 'display', 'block' );
}
}, 1000 );

} );

( function( $, api ) {
	'use strict';

api( 'prime2g_theme_news_reel', function( value ) {
value.bind( function( newval ) {
	let nrPostType	=	$( '#customize-control-prime2g_theme_news_reel_post_type' ),
		nrTitle		=	$( '#customize-control-prime2g_theme_news_reel_title' ),
		nrCategory	=	$( '#customize-control-prime2g_theme_news_reel_category' ),
		nrTaxonomy	=	$( '#customize-control-prime2g_theme_news_reel_taxonomy' ),
		nrTaxTerm	=	$( '#customize-control-prime2g_theme_news_reel_tax_term_id' ),
		nrCount		=	$( '#customize-control-prime2g_theme_news_reel_posts_count' ),
		nrWidth		=	$( '#customize-control-prime2g_news_reel_width' );

	nrTaxonomy.slideUp( 180 ); nrTaxTerm.slideUp( 180 ); nrCategory.slideUp( 180 );

	if ( newval ) {
		nrPostType.slideDown( 180 ); nrTitle.slideDown( 180 );
		nrCount.slideDown( 180 ); nrWidth.slideDown( 180 );
	}
	else {
		nrPostType.slideUp( 180 ); nrTitle.slideUp( 180 );
		nrCount.slideUp( 180 ); nrWidth.slideUp( 180 );
		$( '#_customize-input-prime2g_theme_news_reel_post_type' ).val( 'non-existent' );
	}
} );
} );

api( 'prime2g_theme_news_reel_post_type', function( value ) {
value.bind( function( newval ) {
	let nrTaxonomy	=	$( '#customize-control-prime2g_theme_news_reel_taxonomy' ),
		nrTaxTerm	=	$( '#customize-control-prime2g_theme_news_reel_tax_term_id' ),
		nrCount		=	$( '#customize-control-prime2g_theme_news_reel_posts_count' ),
		nrCategory	=	$( '#customize-control-prime2g_theme_news_reel_category' );

	if ( newval == 'post' ) {
		nrTaxonomy.slideUp( 180 ); nrTaxTerm.slideUp( 180 );
		nrCategory.slideDown( 180 ); nrCount.slideDown( 180 );
	}
	else if ( newval == 'page' ) {
		nrTaxonomy.slideUp( 180 ); nrTaxTerm.slideUp( 180 );
		nrCategory.slideUp( 180 ); nrCount.slideDown( 180 );
	}
	else {
		nrTaxonomy.slideDown( 180 ); nrTaxTerm.slideDown( 180 );
		nrCategory.slideUp( 180 ); nrCount.slideDown( 180 );
	}
} );
} );

wp.customize.bind( 'ready', function() {
wp.customize.previewer.bind( 'ready', function( message ) {
	let nrTitleInput	=	$( "#_customize-input-prime2g_theme_news_reel_title" );
	nrTitleInput.keyup( function() {
		let new_val	=	nrTitleInput.val();
		$( '#customize-preview iframe' ).contents().find( '#newsreelHeading' ).html( new_val );
	} );
} );
} );

/**
 *	@since ToongeePrime Theme 1.0.55
 */
api( 'prime2g_website_shutdown', function( value ) {
value.bind( function( newval ) {
	let sdDisplay	=	$( '#customize-control-prime2g_shutdown_display' ),
		sddSelect	=	$( '#_customize-input-prime2g_shutdown_display' ),
		sdPageID	=	$( '#customize-control-prime2g_shutdown_page_id' );

	if ( newval ) {
		sdDisplay.slideDown( 180 );
		if ( sddSelect.val() ) sdPageID.slideDown( 180 ); else sdPageID.slideUp( 180 );
	}
	else { sdDisplay.slideUp( 180 ); sdPageID.slideUp( 180 ); }
} );
} );

api( 'prime2g_shutdown_display', function( value ) {
value.bind( function( newval ) {
	let sdPageID	=	$( '#customize-control-prime2g_shutdown_page_id' );
	if ( newval ) sdPageID.slideDown( 180 ); else sdPageID.slideUp( 180 );
} );
} );

api( 'prime2g_cpt_template_parts', function( value ) {
value.bind( function( newval ) {
	let tpRich	=	$( '#customize-control-prime2g_template_parts_richedit' );
	if ( newval ) tpRich.slideDown( 180 ); else tpRich.slideUp( 180 );
} );
} );

api( 'prime2g_use_page_preloader', function( value ) {
value.bind( function( newval ) {
	let imgUrl	=	$( '#customize-control-prime2g_custom_preloader_img_url' );
	if ( newval === 'custom_url' ) imgUrl.slideDown( 180 ); else imgUrl.slideUp( 180 );
} );
} );
/*
api( 'prime2g_login_page_slug', function( value ) {
value.bind( function( newval ) {
	let slug	=	$( '#_customize-input-prime2g_login_page_slug' );
	slug.keyup( function() { slug.val( $( this ).val().replace( /\d+|\s/g, '' ).toLowerCase() ); } );
} );
} );
*/
api( 'prime2g_use_theme_google_fonts', function( value ) {
value.bind( function( newval ) {
	let hFont	=	$( '#customize-control-prime2g_site_headings_font' ),
		bFont	=	$( '#customize-control-prime2g_site_body_font' );

	if ( newval ) { hFont.slideDown( 180 ); bFont.slideDown( 180 ); }
	else { hFont.slideUp( 180 ); bFont.slideUp( 180 ); }
} );
} );

api( 'prime2g_set_cta_menu_item', function( value ) {
value.bind( function( newval ) {
	let ctaURL	=	$( '#customize-control-prime2g_cta_menu_url' ),
		ctaText	=	$( '#customize-control-prime2g_cta_button_text' ),
		ctaTarget	=	$( '#customize-control-prime2g_cta_link_target' ),
		ctaClasses	=	$( '#customize-control-prime2g_cta_button_classes' );

	if ( newval ) { ctaURL.slideDown( 180 ); ctaText.slideDown( 180 ); ctaTarget.slideDown( 180 ); ctaClasses.slideDown( 180 ); }
	else { ctaURL.slideUp( 180 ); ctaText.slideUp( 180 ); ctaTarget.slideUp( 180 ); ctaClasses.slideUp( 180 ); }
} );
} );

wp.customize.bind( 'ready', function() {
wp.customize.previewer.bind( 'ready', function( message ) {
	let cta_text	=	$( "#_customize-input-prime2g_cta_button_text" );
	cta_text.keyup( function() {
		let new_val	=	cta_text.val();
		$( '#customize-preview iframe' ).contents().find( '#prime_cta_menu .cta1' ).html( new_val );
	} );
} );
} );

} )( jQuery, wp.customize );
