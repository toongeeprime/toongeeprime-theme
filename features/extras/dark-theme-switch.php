<?php defined( 'ABSPATH' ) || exit;

/**
 *	DARK THEME SWITCHER
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.49.00
 */
if ( ! function_exists( 'prime2g_dark_theme_switch' ) ) {

add_action( 'wp_body_open', 'prime2g_dark_theme_switch', 9 );
add_action( 'wp_footer', 'prime2g_dark_theme_set_logos' );

function prime2g_dark_theme_switch() {

if ( '' !== get_theme_mod( 'prime2g_dark_theme_switch' ) ) {
$domain	=	prime2g_get_site_domain();
$domain	=	str_replace( '.', '', $domain );
$nOnce	=	wp_create_nonce();

$switch	=	'<div id="prime2g_dt_switch"><div id="darkthemeAjaxResponse"></div>
<style scoped>
#prime2g_dt_switch{position:fixed;bottom:0;right:0;z-index:+99999;}
#prime2g_dt_switch .bi::before{place-items:center;width:30px;height:30px;border-radius:30px;margin:1rem;
background:var(--content-text);color:var(--content-background);display:grid;border:1px solid;}
.themeswitched_dark #prime2g_dt_switch .bi::before{color:var(--content-text);background:var(--content-background);}
#prime2g_dt_switch .on,.themeswitched_dark #prime2g_dt_switch .bi{display:none;}
.themeswitched_dark #prime2g_dt_switch .bi.on{display:grid;}
</style>

<div>
<i class="bi bi-brightness-high on switchOff" title="' . __( 'Light Theme', PRIME2G_TEXTDOM ) . '"></i>
<i class="bi bi-moon switchOn" title="' . __( 'Dark Theme', PRIME2G_TEXTDOM ) . '"></i>
</div>

<script id="prime2g_darkTheme_js">
let dtBody		=	p2getEl( "body" ),
	dTAjxResp	=	p2getEl( "#darkthemeAjaxResponse" ),
	locDLogoUrl	=	"' . $domain . '" + "_DTLogoUrl",
	locDTState	=	"' . $domain . '" + "_DarkTheme";

function prime2gDarkThemeMedia() {
let	isDarkTheme		=	window.matchMedia( "( prefers-color-scheme: dark )" ).matches,
	p2gDarkLCStore	=	window.localStorage.getItem( locDTState );

	if ( "yes" === p2gDarkLCStore ) { isDarkTheme = true; }
	else if ( "no" === p2gDarkLCStore ) { isDarkTheme = false; }
return isDarkTheme;
}


// Set dark theme body class
let p2gThemeIsDark	=	window.localStorage.getItem( locDTState );
if ( p2gThemeIsDark == "yes" || prime2gDarkThemeMedia() === true ) {
	dtBody.classList.add( "themeswitched_dark" );
}


function prime2g_setDTlogos( ajxLogoUrl ) {
	p2getAll( "img.custom-logo" ).forEach( logo=>{ logo.src	=	ajxLogoUrl; } );
	window.localStorage.setItem( locDLogoUrl, ajxLogoUrl );
}

let p2gDThemeOn		=	p2getEl( "#prime2g_dt_switch .switchOn" ),
	p2gDThemeOff	=	p2getEl( "#prime2g_dt_switch .switchOff" );

p2gDThemeOn.addEventListener( "click", ()=>{
	dtBody.classList.add( "themeswitched_dark" );
	window.localStorage.setItem( locDTState, "yes" );
	prime2g_runDarkThemeAjax();
} );

p2gDThemeOff.addEventListener( "click", ()=>{
	dtBody.classList.remove( "themeswitched_dark" );
	window.localStorage.setItem( locDTState, "no" );
	prime2g_runDarkThemeAjax();
} );


// AJAX:
function prime2g_runDarkThemeAjax() {

formData	=	{
	action: "prime2g_doing_ajax_nopriv",
	"prime_do_ajax": "get_logo",
	"use_dark_logo": window.localStorage.getItem( locDTState ),
	"prime_ajaxnonce" : "' . $nOnce . '"
};
ajaxSuccess	=	function( response ) { prime2g_setDTlogos( response ); }
ajaxError	=	function( response ) {
	dTAjxResp.innerHTML = "Server Response Error!<br>Cannot get logo url.";
}

prime2g_run_ajax( formData, ajaxSuccess, ajaxError );
}

</script>
</div>';

echo $switch;
}

}



function prime2g_dark_theme_set_logos() { ?>
<script id="prime2g_dt_logos_setter">
// Set Custom Logo URLs:
p2getAll( "img.custom-logo" ).forEach( logo=>{ logo.src	=	window.localStorage.getItem( locDLogoUrl ); } );
</script>
<?php
}


}
