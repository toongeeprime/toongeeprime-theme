<?php defined( 'ABSPATH' ) || exit;

/**
 *	CONDITIONS FOR ADDING STYLES TO THEME'S MAIN STYLESHEET
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */
/**
 *	Print Root CSS Styles
 */
add_action( 'wp_head', 'prime2g_theme_root_styles', 3 );
if ( ! function_exists( 'prime2g_theme_root_styles' ) ) {

function prime2g_theme_root_styles() {

	echo ToongeePrime_ThemeCSS::root_css();

}

}


/*
add_action( 'wp_enqueue_scripts', 'prime2g_add_theme_css_enqueues' );
function prime2g_add_theme_css_enqueues() {
	wp_add_inline_style(
		'prime2g_css',
		prime2g_theme_style_conditions()
	);
}

function prime2g_theme_style_conditions() {

	// CSS:
	return "
	body{
		display:block;
	}
	";

}
*/


/**
 *	Preload the Theme Fonts
 */
add_action( 'wp_head', 'prime2g_preload_webfonts' );
if ( ! function_exists( 'prime2g_preload_webfonts' ) ) {

function prime2g_preload_webfonts() {
	$bodyfont	=	get_theme_mod( 'prime2g_site_body_font' );
	$headings	=	get_theme_mod( 'prime2g_site_headings_font' );
	echo "<link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=$bodyfont|$headings\">";
}

}



/**
 *	Theme (Google) Fonts
 */
if ( ! function_exists( 'prime2g_theme_fonts' ) ) {
function prime2g_theme_fonts() {

return array(
		'Arimo'	=>	__( 'Arimo', 'toongeeprime-theme' ),
		'Barlow+Condensed'	=>	__( 'Barlow Condensed', 'toongeeprime-theme' ),
		'Cabin'	=>	__( 'Cabin', 'toongeeprime-theme' ),
		'Cherry+Swash'	=>	__( 'Cherry Swash', 'toongeeprime-theme' ),
		'Comfortaa'	=>	__( 'Comfortaa', 'toongeeprime-theme' ),
		'Cormorant+Garamond'	=>	__( 'Cormorant Garamond', 'toongeeprime-theme' ),
		'Dosis'	=>	__( 'Dosis', 'toongeeprime-theme' ),
		'Fredoka'	=>	__( 'Fredoka', 'toongeeprime-theme' ),
		'Habibi'	=>	__( 'Habibi', 'toongeeprime-theme' ),
		'Inria+Serif'	=>	__( 'Inria Serif', 'toongeeprime-theme' ),
		'Josefin+Sans'	=>	__( 'Josefin Sans', 'toongeeprime-theme' ),
		'Jost'	=>	__( 'Jost', 'toongeeprime-theme' ),
		'Lato'		=>	__( 'Lato', 'toongeeprime-theme' ),
		'Lexend+Exa'	=>	__( 'Lexend Exa', 'toongeeprime-theme' ),
		'Montserrat'=>	__( 'Montserrat', 'toongeeprime-theme' ),
		'Nanum+Myeongjo'	=>	__( 'Nanum Myeongjo', 'toongeeprime-theme' ),
		'Noto+Sans'	=>	__( 'Noto Sans', 'toongeeprime-theme' ),
		'Noto+Sans+Display'	=>	__( 'Noto Sans Display', 'toongeeprime-theme' ),
		'Open+Sans'	=>	__( 'Open Sans', 'toongeeprime-theme' ),
		'Oswald'	=>	__( 'Oswald', 'toongeeprime-theme' ),
		'Overpass'	=>	__( 'Overpass', 'toongeeprime-theme' ),
		'Playfair+Display'	=>	__( 'Playfair Display', 'toongeeprime-theme' ),
		'Poppins'	=>	__( 'Poppins', 'toongeeprime-theme' ),
		'Quicksand'	=>	__( 'Quicksand', 'toongeeprime-theme' ),
		'Red+Hat+Display'	=>	__( 'Red Hat Display', 'toongeeprime-theme' ),
		'Redressed'	=>	__( 'Redressed', 'toongeeprime-theme' ),
		'Roboto'	=>	__( 'Roboto', 'toongeeprime-theme' ),
		'Source+Serif+4'	=>	__( 'Source Serif 4', 'toongeeprime-theme' ),
		'Spartan'	=>	__( 'Spartan', 'toongeeprime-theme' ),
		'Tajawal'	=>	__( 'Tajawal', 'toongeeprime-theme' ),
	);

}
}


