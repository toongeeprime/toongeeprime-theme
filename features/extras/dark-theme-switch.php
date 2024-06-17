<?php defined( 'ABSPATH' ) || exit;

/**
 *	DARK THEME SWITCHER
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.49/edited @1.0.96
 */

if ( ! function_exists( 'prime2g_dark_theme_switch' ) ) {

function prime2g_dark_theme_switch() {

if ( in_array( ToongeePrime_Styles::mods_cache()->dt_switch, [ 'on', 'on_dbody' ] ) ) {
//	CSS
add_action( 'wp_head', function() {
echo	'<style id="dThemeSwitchCSS">
#prime2g_dt_switch{position:fixed;bottom:0;right:0;z-index:+99999;}
#prime2g_dt_switch .bi::before{place-items:center;width:30px;height:30px;border-radius:30px;margin:1rem;
background:var(--content-text);color:var(--content-background);display:grid;border:1px solid;}
.themeswitched_dark #prime2g_dt_switch .bi::before{color:var(--content-text);background:var(--content-background);}
#prime2g_dt_switch .on,.themeswitched_dark #prime2g_dt_switch .bi{display:none;}
.themeswitched_dark #prime2g_dt_switch .bi.on{display:grid;}

@media (display-mode: browser){
body.has_pwa:not(.prompt_hidden) #prime2g_dt_switch{bottom:75px;}
}
</style>';
} );


//	JS
add_action( 'wp_footer', function() {
$id		=	( is_multisite() && ! prime2g_constant_is_true( 'PRIME2G_EXTRAS_BY_NETWORK_HOME' )
 && get_current_blog_id() !== 1 ) ? get_current_blog_id() : '';

$domain	=	prime2g_get_site_domain();
$domain	=	str_replace( '.', '', $domain ) . $id;

$switch	=	'<div id="prime2g_dt_switch">
<div class="elmt">
<i class="bi bi-brightness-high on switchOff" title="' . __( 'Light Theme', PRIME2G_TEXTDOM ) . '"></i>
<i class="bi bi-moon switchOn" title="' . __( 'Dark Theme', PRIME2G_TEXTDOM ) . '"></i>
</div>

<script async id="prime2g_darkTheme_JS">
let dtBody		=	p2getEl( "body" ),
	llogoUrl	=	"'. prime2g_get_custom_logo_url() .'",
	darklogoUrl	=	"'. prime2g_siteLogo( true, true ) .'",
	locDLogoUrl	=	"' . $domain . '" + "_DTLogoUrl",
	locDTState	=	"' . $domain . '" + "_DarkTheme";

dlogoUrl	=	darklogoUrl || llogoUrl;

function prime2gDarkThemeMedia() {
let	p2gDarkLCStore	=	window.localStorage.getItem( locDTState );

	isDarkTheme		=	window.matchMedia( "( prefers-color-scheme: dark )" ).matches;
	if ( "yes" === p2gDarkLCStore ) isDarkTheme = true;
	else if ( "no" === p2gDarkLCStore ) isDarkTheme = false;
return isDarkTheme;
}


//	Set dark theme body class
let p2gThemeIsDark	=	window.localStorage.getItem( locDTState );
if ( p2gThemeIsDark === "yes" || prime2gDarkThemeMedia() ) {
	dtBody.classList.add( "themeswitched_dark" );
}


function prime2g_setDTlogos( useLogoUrl ) {
	p2getAll( "img.custom-logo" ).forEach( logo=>{ logo.src	=	useLogoUrl; } );
	window.localStorage.setItem( locDLogoUrl, useLogoUrl );
}

p2getEl( "#prime2g_dt_switch .switchOn" ).addEventListener( "click", ()=>{
	dtBody.classList.add( "themeswitched_dark" );
	window.localStorage.setItem( locDTState, "yes" );
	prime2g_setDTlogos( dlogoUrl );
} );

p2getEl( "#prime2g_dt_switch .switchOff" ).addEventListener( "click", ()=>{
	dtBody.classList.remove( "themeswitched_dark" );
	window.localStorage.setItem( locDTState, "no" );	// do not removeItem... value has control isDarkTheme
	prime2g_setDTlogos( llogoUrl );
} );

//	Set Custom Logo URL on page load
p2getAll( "img.custom-logo" ).forEach( logo=>{
	if ( p2gThemeIsDark === "yes" || prime2gDarkThemeMedia() )
		logo.src	=	dlogoUrl;
	else
		logo.src	=	llogoUrl;
} );
</script>
</div>';

echo $switch;
} );
}

}
prime2g_dark_theme_switch();

}

