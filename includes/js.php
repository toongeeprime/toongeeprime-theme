<?php defined( 'ABSPATH' ) || exit;

/**
 *	CONDITIONAL THEME JS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

add_action( 'wp_footer', 'prime2g_conditional_js', 990 );
function prime2g_conditional_js() {
$singular	=	is_singular();
$jsSingular	=	$singular ? 'true' : 'false';

$js	=	'<script async defer id="prime2g_conditional_js">
const	singular	=	'. $jsSingular .';
';

if ( prime2g_video_features_active() ) {
$js	.=
'let sCodeDivs	=	p2getAll( ".wp-video-shortcode" ),
	sCodeVids	=	p2getAll( "video.wp-video-shortcode" ),
	wpVids	=	p2getAll( ".wp-video" );
if ( sCodeVids ) {
sCodeVids.forEach( vid => { vid.setAttribute( "width", "100%" ); vid.style.width = "100%"; } );
}
if ( sCodeDivs ) { sCodeDivs.forEach( div => { div.style.width = "auto"; } ); }
if ( wpVids ) { wpVids.forEach( wpv => { wpv.style.width = "auto"; } ); }
';
}

if ( $singular && 'replace_header' === get_theme_mod( 'prime2g_video_embed_location' ) ) {
if ( has_header_video() && is_header_video_active() ) {
$js	.=	'var ww_timer	=	setTimeout( function ww_video() {
if ( wp.customHeader.handlers.youtube.player == null ) {
	ww_timer	=	setTimeout( ww_video, 1000 );
} else {
	if ( typeof wp.customHeader.handlers.youtube.player.unMute === "function" ) {
		wp.customHeader.handlers.youtube.player.unMute();
		wp.customHeader.handlers.youtube.player.stopVideo();
	} else {
		ww_timer	=	setTimeout( ww_video, 1000 );
	}
} }, 1000 );
';
}
}
/*
let ytHeader	=	p2getEl( "#wp-custom-header" );
ytHeader.classList.add( "unclicked" );
ytHeader.onclick	=	()=>{ ytHeader.classList.remove( "unclicked" ); };
*/
$js	.=	'</script>';

echo $js;
}



prime2g_conditional_customizer_js();
function prime2g_conditional_customizer_js() {
$scriptName	=	basename( $_SERVER[ 'PHP_SELF' ] );
if ( $scriptName === 'customize.php' ) {
if ( prime2g_design_by_network_home() && get_current_blog_id() !== 1 ) {

$js	=	'<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" id="jQueryTmp"></script>
<script id="prime2g_conditional_customizer_js">
jQuery( document ).ready( function() {';

$js	.=	'
setTimeout( ()=>{
let p2gPane	=	jQuery( "#sub-accordion-panel-prime2g_customizer_panel .customize-info" );
p2gPane.append( \'<div style="background:#fff;padding:25px 15px 15px;text-align:center;"><h3>'. __( 'MAIN SITE DESIGNS ARE FROM THE NETWORK HOME', PRIME2G_TEXTDOM ) .'</h3></div>\' );
}, 5000
);
';

$js	.=	'} );
</script>';
echo $js;

}
}
}




/**
 *	@since 1.0.73
 *
 *	Password Toggler
 */
if ( ! function_exists( 'prime2g_view_password_toggler' ) ) {
function prime2g_view_password_toggler() {
echo Prime2gJSBits::dom_create_and_insert();

$js	=	'<script id="primeLoginJS">
let loginForm	=	p2getEl( "#custom_login_page_form" ),
	userName	=	p2getEl( "#user_login" ),
	passWd		=	p2getEl( "#user_pass" );

userName.setAttribute( "required", true );
passWd.setAttribute( "required", true );

// Password view toggle
let formHasPW	=	p2getAll( ".form_has_pw_field form" );
if ( formHasPW ) {
pwFormNum	=	formHasPW.length;
for ( fpw = 0; fpw < pwFormNum; fpw++ ) {
	parnt	=	formHasPW[ fpw ].querySelector(".login-password");
	if ( ! parnt ) {
		parnt	=	formHasPW[ fpw ].querySelector(".fld-set.password");
	}
	pwInput	=	parnt.childNodes[1];
	p2g_createNewItem( "span", "pwtogg"+fpw, "pwTogg p-abso", parnt, pwInput );
	pwTogglr	=	\'<span tabindex="1" onclick="p2gtoggpwd( this );"><i class="bi bi-eye"></i><i class="bi bi-eye-slash"></i></span>\';
	p2g_addContentToEl( "#pwtogg"+fpw, "", pwTogglr );
}
function p2gtoggpwd( elmt ) {
	thisParent	=	elmt.parentNode;
	thisParent.classList.toggle( "visible" );
	pInputType	=	thisParent.parentNode.querySelector( "input" );
	if ( pInputType.type === "password" ) {
		pInputType.type = "text";
	} else {
		pInputType.type = "password";
	}
}
}
</script>';
return $js;
}
}



/**
 *	CUSTOM FIELDS
 */
add_action( 'admin_footer', 'prime2g_metabox_javascript' );
function prime2g_metabox_javascript() {
global $pagenow, $typenow;
if ( in_array( $pagenow, [ 'post-new.php', 'post.php' ] ) ) { ?>
<script id="prime2g_metaboxesJS">
let p2gBoxIDs	=	[
'#prime2g_prime_fields1', '#prime2g_postdata_box', '#prime2g_settings_fields', '#prime2g_extras_fields', '#prime2g_media_cfields'
];
p2gBoxIDs.forEach( pb => {
box	=	p2getEl( pb );
if ( box ) { box.classList.add( 'prime2g_postbox' ); }
} );
</script>
<?php
}
}

/*	@since 1.0.73 End	*/


