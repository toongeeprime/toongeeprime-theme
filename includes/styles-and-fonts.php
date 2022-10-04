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
		'Arimo'		=>	'Arimo',
		'Barlow+Condensed'	=>	'Barlow Condensed',
		'Cabin'		=>	'Cabin',
		'Cantarell'	=>	'Cantarell',
		'Cantata+One'	=>	'Cantata One',
		'Cherry+Swash'	=>	'Cherry Swash',
		'Comfortaa'	=>	'Comfortaa',
		'Cormorant+Garamond'	=>	'Cormorant Garamond',
		'Dosis'		=>	'Dosis',
		'Fredoka'	=>	'Fredoka',
		'Habibi'	=>	'Habibi',
		'Inria+Serif'	=>	'Inria Serif',
		'Josefin+Sans'	=>	'Josefin Sans',
		'Jost'		=>	'Jost',
		'Lato'		=>	'Lato',
		'Lexend+Exa'	=>	'Lexend Exa',
		'Montserrat'=>	'Montserrat',
		'Nanum+Myeongjo'	=>	'Nanum Myeongjo',
		'Noto+Sans'	=>	'Noto Sans',
		'Noto+Sans+Display'	=>	'Noto Sans Display',
		'Open+Sans'	=>	'Open Sans',
		'Oswald'	=>	'Oswald',
		'Overpass'	=>	'Overpass',
		'Playfair+Display'	=>	'Playfair Display',
		'Poppins'	=>	'Poppins',
		'Quicksand'	=>	'Quicksand',
		'Red+Hat+Display'	=>	'Red Hat Display',
		'Redressed'	=>	'Redressed',
		'Roboto'	=>	'Roboto',
		'Source+Serif+4'	=>	'Source Serif 4',
		'Source+Serif+Pro'	=>	'Source Serif Pro',
		'Spartan'	=>	'Spartan',
		'Tajawal'	=>	'Tajawal',
	);

}
}

