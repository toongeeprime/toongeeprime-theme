<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME'S STYLES AND FONTS
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



/**
 *	Preload the Theme Fonts
 */
add_action( 'wp_head', 'prime2g_preload_webfonts' );
if ( ! function_exists( 'prime2g_preload_webfonts' ) ) {

function prime2g_preload_webfonts() {

	$theStyles	=	new ToongeePrime_Styles();

	$bodyfont	=	get_theme_mod( 'prime2g_site_body_font', $theStyles->bodyFont );
	$headings	=	get_theme_mod( 'prime2g_site_headings_font', $theStyles->headFont );
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
		'Cantarell'	=>	__( 'Cantarell', 'toongeeprime-theme' ),
		'Cantata+One'	=>	__( 'Cantata One', 'toongeeprime-theme' ),
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
		'Source+Serif+Pro'	=>	__( 'Source Serif Pro', 'toongeeprime-theme' ),
		'Spartan'	=>	__( 'Spartan', 'toongeeprime-theme' ),
		'Tajawal'	=>	__( 'Tajawal', 'toongeeprime-theme' ),
	);

}
}

