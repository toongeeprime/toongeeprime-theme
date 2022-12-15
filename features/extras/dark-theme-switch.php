<?php defined( 'ABSPATH' ) || exit;

/**
 *	DARK THEME SWITCHER
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.49.00
 */
if ( ! function_exists( 'prime2g_dark_theme_switch' ) ) {

add_action( 'wp_body_open', 'prime2g_dark_theme_switch', 9 );
function prime2g_dark_theme_switch() {

if ( '' !== get_theme_mod( 'prime2g_dark_theme_switch' ) ) {
$domain	=	prime2g_get_site_domain();
$domain	=	str_replace( '.', '', $domain );

$switch	=	'<div id="prime2g_dt_switch">
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

<script>
let dtBody	=	p2getEl( "body" ),
	dtState	=	"' . $domain . '" + "_DarkTheme";

function prime2gDarkThemeMedia() {
let	isDarkTheme		=	window.matchMedia( "( prefers-color-scheme: dark )" ).matches,
	p2gDarkLCStore	=	window.localStorage.getItem( dtState );

	if ( "yes" === p2gDarkLCStore ) { isDarkTheme = true; }
	else if ( "no" === p2gDarkLCStore ) { isDarkTheme = false; }

return isDarkTheme;
}


// Set dark theme body class
let p2gThemeIsDark	=	window.localStorage.getItem( dtState );
if ( p2gThemeIsDark == "yes" || prime2gDarkThemeMedia() === true ) {
	dtBody.classList.add( "themeswitched_dark" );
}


let p2gDThemeOn		=	p2getEl( "#prime2g_dt_switch .switchOn" ),
	p2gDThemeOff	=	p2getEl( "#prime2g_dt_switch .switchOff" );

p2gDThemeOn.addEventListener( "click", ()=>{
	dtBody.classList.add( "themeswitched_dark" );
	window.localStorage.setItem( dtState, "yes" );
} );

p2gDThemeOff.addEventListener( "click", ()=>{
	dtBody.classList.remove( "themeswitched_dark" );
	window.localStorage.setItem( dtState, "no" );
} );
</script>
</div>';

echo $switch;
}

}

}

