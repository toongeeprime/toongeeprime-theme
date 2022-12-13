<?php defined( 'ABSPATH' ) || exit;

/**
 *	DARK THEME SWITCHER
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.49.00
 */
if ( ! function_exists( 'prime2g_dark_theme_switch' ) ) {

add_action( 'wp_footer', 'prime2g_dark_theme_switch' );
function prime2g_dark_theme_switch() {

if ( 'on' === get_theme_mod( 'prime2g_dark_theme_switch' ) ) {

$switch	=	'<div id="prime2g_dt_switch">
<style scoped>
#prime2g_dt_switch{position:fixed;bottom:0;right:0;}
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
dtBody	=	p2getEl( "body" );

function prime2gDarkThemeMedia() {
let	isDarkTheme		=	window.matchMedia( "( prefers-color-scheme: dark )" ).matches,
	p2gDarkLCStore	=	window.localStorage.getItem( "prime2gDarkThemeStatus" );

	if ( "yes" === p2gDarkLCStore ) { isDarkTheme = true; }
	else if ( "no" === p2gDarkLCStore ) { isDarkTheme = false; }

return isDarkTheme;
}


// Set dark theme body class
let p2gThemeIsDark	=	window.localStorage.getItem( "prime2gDarkThemeStatus" );
if ( p2gThemeIsDark == "yes" || prime2gDarkThemeMedia() == true ) {
	dtBody.classList.add( "themeswitched_dark" );
}


let p2gDThemeOn		=	p2getEl( "#prime2g_dt_switch .switchOn" ),
	p2gDThemeOff	=	p2getEl( "#prime2g_dt_switch .switchOff" );

p2gDThemeOn.addEventListener( "click", ()=>{
	dtBody.classList.add( "themeswitched_dark" );
	window.localStorage.setItem( "prime2gDarkThemeStatus", "yes" );
} );
p2gDThemeOff.addEventListener( "click", ()=>{
	dtBody.classList.remove( "themeswitched_dark" );
	window.localStorage.setItem( "prime2gDarkThemeStatus", "no" );
} );
</script>
</div>';

echo $switch;
}

}

}

