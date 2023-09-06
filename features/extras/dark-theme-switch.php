<?php defined( 'ABSPATH' ) || exit;

/**
 *	DARK THEME SWITCHER
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.49
 */
add_action( 'wp_footer', 'prime2g_dark_theme_switch' );
add_action( 'wp_footer', 'prime2g_dark_theme_set_logos', 99 );

if ( ! function_exists( 'prime2g_dark_theme_switch' ) ) {

function prime2g_dark_theme_switch() {

$by_net_home	=	prime2g_design_by_network_home();
if ( $by_net_home ) { switch_to_blog( 1 ); }

$theme_switch	=	get_theme_mod( 'prime2g_dark_theme_switch' );

if ( in_array( $theme_switch, [ 'on', 'on_dbody' ] ) ) {

$domain	=	prime2g_get_site_domain();
$domain	=	str_replace( '.', '', $domain );

$switch	=	'<div id="prime2g_dt_switch">
<style id="dThemeSwitchCss">
#prime2g_dt_switch{position:fixed;bottom:0;right:0;z-index:+99999;}
#prime2g_dt_switch .bi::before{place-items:center;width:30px;height:30px;border-radius:30px;margin:1rem;
background:var(--content-text);color:var(--content-background);display:grid;border:1px solid;}
.themeswitched_dark #prime2g_dt_switch .bi::before{color:var(--content-text);background:var(--content-background);}
#prime2g_dt_switch .on,.themeswitched_dark #prime2g_dt_switch .bi{display:none;}
.themeswitched_dark #prime2g_dt_switch .bi.on{display:grid;}

@media (display-mode: browser){
body.has_pwa:not(.prompt_hidden) #prime2g_dt_switch{bottom:75px;}
}
</style>

<div>
<i class="bi bi-brightness-high on switchOff" title="' . __( 'Light Theme', PRIME2G_TEXTDOM ) . '"></i>
<i class="bi bi-moon switchOn" title="' . __( 'Dark Theme', PRIME2G_TEXTDOM ) . '"></i>
</div>

<script id="prime2g_darkTheme_js">
let dtBody		=	p2getEl( "body" ),
	llogoUrl	=	"'. prime2g_get_custom_logo_url() .'",
	darklogoUrl	=	"'. prime2g_siteLogo( true, true ) .'",
	locDLogoUrl	=	"' . $domain . '" + "_DTLogoUrl",
	locDTState	=	"' . $domain . '" + "_DarkTheme";

dlogoUrl	=	darklogoUrl ? darklogoUrl : llogoUrl;

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


function prime2g_setDTlogos( useLogoUrl ) {
	p2getAll( "img.custom-logo" ).forEach( logo=>{ logo.src	=	useLogoUrl; } );
	window.localStorage.setItem( locDLogoUrl, useLogoUrl );
}

let p2gDThemeOn		=	p2getEl( "#prime2g_dt_switch .switchOn" ),
	p2gDThemeOff	=	p2getEl( "#prime2g_dt_switch .switchOff" );

p2gDThemeOn.addEventListener( "click", ()=>{
	dtBody.classList.add( "themeswitched_dark" );
	window.localStorage.setItem( locDTState, "yes" );
	prime2g_setDTlogos( dlogoUrl );
} );

p2gDThemeOff.addEventListener( "click", ()=>{
	dtBody.classList.remove( "themeswitched_dark" );
	window.localStorage.setItem( locDTState, "no" );
	prime2g_setDTlogos( llogoUrl );
} );
</script>
</div>';

echo $switch;
}

if ( $by_net_home ) { restore_current_blog(); }

}

}



if ( ! function_exists( 'prime2g_dark_theme_set_logos' ) ) {
function prime2g_dark_theme_set_logos() {

$by_net_home	=	prime2g_design_by_network_home();
if ( $by_net_home ) { switch_to_blog( 1 ); }

$theme_switch	=	get_theme_mod( 'prime2g_dark_theme_switch' );

if ( in_array( $theme_switch, [ 'on', 'on_dbody' ] ) ) { ?>

<script id="prime2g_dt_logos_setter">
//	Set Custom Logo URL on page load
p2getAll( "img.custom-logo" ).forEach( logo=>{
	if ( p2gThemeIsDark === "yes" || prime2gDarkThemeMedia() === true )
		logo.src	=	dlogoUrl;
	else
		logo.src	=	llogoUrl;
} );
</script>

<?php
}

if ( $by_net_home ) { restore_current_blog(); }
}
}

