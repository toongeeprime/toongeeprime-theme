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
} }, 1000 );
} );


( function( $, api ) { 'use strict';
api( 'prime2g_theme_news_reel', (value)=>{
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
		nrPostType.slideDown( 180 ); nrTitle.slideDown( 180 ); nrCount.slideDown( 180 ); nrWidth.slideDown( 180 );
	}
	else {
		nrPostType.slideUp( 180 ); nrTitle.slideUp( 180 ); nrCount.slideUp( 180 ); nrWidth.slideUp( 180 );
		$( '#_customize-input-prime2g_theme_news_reel_post_type' ).val( 'non-existent' );
	}
} );
} );

api( 'prime2g_theme_news_reel_post_type', (value)=>{
value.bind( function( newval ) {
	let nrTaxonomy	=	$( '#customize-control-prime2g_theme_news_reel_taxonomy' ),
		nrTaxTerm	=	$( '#customize-control-prime2g_theme_news_reel_tax_term_id' ),
		nrCount		=	$( '#customize-control-prime2g_theme_news_reel_posts_count' ),
		nrCategory	=	$( '#customize-control-prime2g_theme_news_reel_category' );
	if ( newval === 'post' ) {
		nrTaxonomy.slideUp( 180 ); nrTaxTerm.slideUp( 180 ); nrCategory.slideDown( 180 ); nrCount.slideDown( 180 );
	}
	else if ( newval === 'page' ) {
		nrTaxonomy.slideUp( 180 ); nrTaxTerm.slideUp( 180 ); nrCategory.slideUp( 180 ); nrCount.slideDown( 180 );
	}
	else {
		nrTaxonomy.slideDown( 180 ); nrTaxTerm.slideDown( 180 ); nrCategory.slideUp( 180 ); nrCount.slideDown( 180 );
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
 *	@since 1.0.55
 */
api( 'prime2g_website_shutdown', (value)=>{
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

api( 'prime2g_shutdown_display', (value)=>{
value.bind( function( newval ) {
	let sdPageID	=	$( '#customize-control-prime2g_shutdown_page_id' );
	if ( newval ) sdPageID.slideDown( 180 ); else sdPageID.slideUp( 180 );
} );
} );

api( 'prime2g_cpt_template_parts', (value)=>{
value.bind( function( newval ) {
	let tpRich	=	$( '#customize-control-prime2g_template_parts_richedit' );
	if ( newval ) tpRich.slideDown( 180 ); else tpRich.slideUp( 180 );
} );
} );

api( 'prime2g_use_page_preloader', (value)=>{
value.bind( function( newval ) {
	let imgUrl	=	$( '#customize-control-prime2g_custom_preloader_img_url' );
	if ( newval === 'custom_url' ) imgUrl.slideDown( 180 ); else imgUrl.slideUp( 180 );
} );
} );

api( 'prime2g_use_theme_google_fonts', (value)=>{
value.bind( function( newval ) {
	let hFont	=	$( '#customize-control-prime2g_site_headings_font' ),
		bFont	=	$( '#customize-control-prime2g_site_body_font' );
	if ( newval ) { hFont.slideDown( 180 ); bFont.slideDown( 180 ); } else { hFont.slideUp( 180 ); bFont.slideUp( 180 ); }
} );
} );

api( 'prime2g_use_page_for404', (value)=>{
value.bind( function( newval ) {
	let ePageID	=	$( '#customize-control-prime2g_404error_page_id' );
	if ( newval ) { ePageID.slideDown( 180 ); } else { ePageID.slideUp( 180 ); }
} );
} );

api( 'prime2g_set_cta_menu_item', (value)=>{
value.bind( function( newval ) {
	let ctaURL	=	$( '#customize-control-prime2g_cta_menu_url' ),
		ctaText	=	$( '#customize-control-prime2g_cta_button_text' ),
		ctaTarget	=	$( '#customize-control-prime2g_cta_link_target' ),
		ctaClasses	=	$( '#customize-control-prime2g_cta_button_classes' );
	if ( newval ) { ctaURL.slideDown( 180 ); ctaText.slideDown( 180 ); ctaTarget.slideDown( 180 ); ctaClasses.slideDown( 180 ); }
	else { ctaURL.slideUp( 180 ); ctaText.slideUp( 180 ); ctaTarget.slideUp( 180 ); ctaClasses.slideUp( 180 ); }
} );
} );

/* @since 1.0.56 */
api( 'prime2g_activate_chache_controls', (value)=>{
value.bind( function( newval ) {
	let ctimeS	=	$( '#customize-control-prime2g_chache_time_singular' ),
		cunitS	=	$( '#customize-control-prime2g_chache_seconds_singular' ),
		ctimeF	=	$( '#customize-control-prime2g_chache_time_feeds' ),
		cunitF	=	$( '#customize-control-prime2g_chache_seconds_feeds' ),
		cData	=	$( '#customize-control-prime2g_allow_chache_data_clearing' ); // 1.0.58
	if ( newval ) {
		ctimeS.slideDown( 180 ); cunitS.slideDown( 180 ); ctimeF.slideDown( 180 ); cunitF.slideDown( 180 ); cData.slideDown( 180 );
	}
	else { ctimeS.slideUp( 180 ); cunitS.slideUp( 180 ); ctimeF.slideUp( 180 ); cunitF.slideUp( 180 ); cData.slideUp( 180 ); }
} );
} );

/* @since 1.0.57 */
api( 'prime2g_main_menu_type', (value)=>{
value.bind( function( newval ) {
	let tmenuSC	=	$( '#customize-control-prime2g_toggle_menu_template_part_id' ),
		mmenuSC	=	$( '#customize-control-prime2g_mega_menu_template_part_id' ),
		mmenuFW	=	$( '#customize-control-prime2g_use_fullwidth_mega_menu' ),
		mobCount	=	$( '#customize-control-prime2g_mobile_menu_template_part_id' );
	if ( newval === '' ) {
		mmenuSC.slideUp( 180 ); tmenuSC.slideUp( 180 ); mobCount.slideUp( 180 ); mmenuFW.slideUp( 180 );
	}
	if ( newval === 'togglers' ) {
		tmenuSC.slideDown( 180 ); mmenuSC.slideUp( 180 ); mobCount.slideUp( 180 ); mmenuFW.slideUp( 180 );
	}
	if ( newval === 'mega_menu' ) {
		mmenuSC.slideDown( 180 ); mobCount.slideDown( 180 ); mmenuFW.slideDown( 180 ); tmenuSC.slideUp( 180 );
	}
} );
} );

/* @since 1.0.60 */
api( 'prime2g_theme_show_stickies', (value)=>{
value.bind( function( newval ) {
	let stHead	=	$( '#customize-control-prime2g_theme_sticky_heading' ),
		stPType	=	$( '#customize-control-prime2g_theme_stickies_post_type' ),
		stCount	=	$( '#customize-control-prime2g_theme_stickies_count' );
	if ( newval !== '' ) { stHead.slideDown( 180 ); stPType.slideDown( 180 ); stCount.slideDown( 180 ); }
	else { stHead.slideUp( 180 ); stPType.slideUp( 180 ); stCount.slideUp( 180 ); }
} );
} );

/* @since 1.0.73 */
api( 'prime2g_use_custom_login_page', (value)=>{
value.bind( function( newval ) {
	let logPID	=	$( '#customize-control-prime2g_custom_login_page_id' ),
		wplSlug	=	$( '#customize-control-prime2g_wp_login_page_slug' );
	if ( newval ) { logPID.slideDown( 180 ); wplSlug.slideDown( 180 ); } else { logPID.slideUp( 180 ); wplSlug.slideUp( 180 ); }
} );
} );

/* @since 1.0.76 */
api( 'prime2g_admin_access_capability', (value)=>{
value.bind( function( newval ) {
	let cstmCap	=	$( '#customize-control-prime2g_admin_access_custom_capability' );
	if ( newval === 'custom_capability' ) { cstmCap.slideDown( 180 ); } else { cstmCap.slideUp( 180 ); }
} );
} );

wp.customize.bind( 'ready', function() {
wp.customize.previewer.bind( 'ready', function( message ){
	let cta_text	=	$( "#_customize-input-prime2g_cta_button_text" );
	cta_text.keyup( function() {
		let new_val	=	cta_text.val();
		$( '#customize-preview iframe' ).contents().find( '#prime_cta_menu .cta1' ).html( new_val );
	} );
} );
} );

} )( jQuery, wp.customize );
