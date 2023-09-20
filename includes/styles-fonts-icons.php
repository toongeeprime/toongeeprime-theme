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
 *	@since ToongeePrime Theme 1.0.55
 */
if ( ! function_exists( 'prime2g_icons_file_url' ) ) {
function prime2g_icons_file_url() {
	return 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css';
}
}


/**
 *	Load Theme Fonts
 */
add_action( 'wp_footer', 'prime2g_load_fonts_and_icons' );
if ( ! function_exists( 'prime2g_load_fonts_and_icons' ) ) {

function prime2g_load_fonts_and_icons() {

if ( get_theme_mod( 'prime2g_use_theme_google_fonts', '1' ) ) {
	$theStyles	=	new ToongeePrime_Styles();

	$bodyfont	=	get_theme_mod( 'prime2g_site_body_font', $theStyles->bodyFont );
	$headings	=	get_theme_mod( 'prime2g_site_headings_font', $theStyles->headFont );
	echo "<link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=$bodyfont|$headings:300,400,500,600,700,800&display=swap\">";
}
	# echo '<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">';
	wp_enqueue_style( 'bootstrap-icons', prime2g_icons_file_url(), [], PRIME2G_VERSION );

}

}



/**
 *	Theme (Google) Fonts
 */
if ( ! function_exists( 'prime2g_theme_fonts' ) ) {
function prime2g_theme_fonts() {

return array(
	'Abril+Fatface'	=>	'Abril Fatface',
	'Alegreya+Sans'	=>	'Alegreya Sans',
	'Amita'		=>	'Amita',
	'Architects+Daughter'		=>	'Architects Daughter',
	'Archivo+Narrow'		=>	'Archivo Narrow',
	'Arimo'		=>	'Arimo',
	'Barlow'	=>	'Barlow',
	'Barlow+Condensed'	=>	'Barlow Condensed',
	'Barriecito'=>	'Barriecito',
	'Bebas+Neue'=>	'Bebas Neue',
	'Bellefair'	=>	'Bellefair',
	'Bitter'	=>	'Bitter',
	'Bonbon'	=>	'Bonbon',
	'Cabin'		=>	'Cabin',
	'Cantarell'	=>	'Cantarell',
	'Cantata+One'	=>	'Cantata One',
	'Cardo'	=>	'Cardo',
	'Carter+One'=>	'Carter One',
	'Caveat'	=>	'Caveat',
	'Charm'		=>	'Charm',
	'Cherry+Swash'	=>	'Cherry Swash',
	'Comfortaa'	=>	'Comfortaa',
	'Comforter+Brush'	=>	'Comforter Brush',
	'Coming+Soon'	=>	'Coming Soon',
	'Cormorant+Garamond'	=>	'Cormorant Garamond',
	'Cormorant+Infant'	=>	'Cormorant Infant',
	'Crimson+Text'	=>	'Crimson Text',
	'Dancing+Script'	=>	'Dancing Script',
	'Delius'	=>	'Delius',
	'DM+Sans'	=>	'DM Sans',
	'Dosis'		=>	'Dosis',
	'Fahkwang'	=>	'Fahkwang',
	'Fredoka'	=>	'Fredoka',
	'Fuzzy+Bubbles'	=>	'Fuzzy Bubbles',
	'Habibi'	=>	'Habibi',
	'Heebo'	=>	'Heebo',
	'Inconsolata'	=>	'Inconsolata',
	'Inria+Serif'	=>	'Inria Serif',
	'Inspiration'	=>	'Inspiration',
	'Inter'		=>	'Inter',
	'Josefin+Sans'	=>	'Josefin Sans',
	'Jost'		=>	'Jost',
	'Just+Another+Hand'	=>	'Just Another Hand',
	'Karla'		=>	'Karla',
	'Khula'		=>	'Khula',
	'Krub'		=>	'Krub',
	'Kumbh+Sans'=>	'Kumbh Sans',
	'Lato'		=>	'Lato',
	'Lexend+Exa'=>	'Lexend Exa',
	'Lora'		=>	'Lora',
	'Luckiest+Guy'	=>	'Luckiest Guy',
	'Lustria'	=>	'Lustria',
	'Mada'		=>	'Mada',
	'Marcellus'	=>	'Marcellus',
	'Merriweather'	=>	'Merriweather',
	'Montserrat'=>	'Montserrat',
	'Mulish'	=>	'Mulish',
	'Nanum+Myeongjo'	=>	'Nanum Myeongjo',
	'Noto+Sans'	=>	'Noto Sans',
	'Noto+Sans+Display'	=>	'Noto Sans Display',
	'Noto+Sans+Mono'	=>	'Noto Sans Mono',
	'Nunito'	=>	'Nunito',
	'Nunito+Sans'	=>	'Nunito Sans',
	'Open+Sans'	=>	'Open Sans',
	'Orbitron'	=>	'Orbitron',
	'Oswald'	=>	'Oswald',
	'Overpass'	=>	'Overpass',
	'Oxygen'	=>	'Oxygen',
	'Playfair+Display'	=>	'Playfair Display',
	'Poppins'	=>	'Poppins',
	'Poiret+One'=>	'Poiret One',
	'PT+Mono'	=>	'PT Mono',
	'PT+Sans'	=>	'PT Sans',
	'Quicksand'	=>	'Quicksand',
	'Quintessential'	=>	'Quintessential',
	'Qwigley'	=>	'Qwigley',
	'Raleway'	=>	'Raleway',
	'Red+Hat+Display'	=>	'Red Hat Display',
	'Redressed'	=>	'Redressed',
	'Reenie+Beanie'	=>	'Reenie Beanie',
	'Roboto'	=>	'Roboto',
	'Roboto+Mono'	=>	'Roboto Mono',
	'Rochester'	=>	'Rochester',
	'Rubik+Dirt'=>	'Rubik Dirt',
	'Rubik+Maze'=>	'Rubik Maze',
	'Sofia'		=>	'Sofia',
	'Source+Code+Pro'	=>	'Source Code Pro',
	'Source+Sans+Pro'	=>	'Source Sans Pro',
	'Source+Serif+4'	=>	'Source Serif 4',
	'Source+Serif+Pro'	=>	'Source Serif Pro',
	'Spartan'	=>	'Spartan',
	'Syne'		=>	'Syne',
	'Tajawal'	=>	'Tajawal',
	'Trirong'	=>	'Trirong',
	'Ubuntu'	=>	'Ubuntu',
	'Unna'	=>	'Unna',
	'Work+Sans'	=>	'Work Sans',
	'Yeseva+One'=>	'Yeseva One',
	'Zen+Dots'	=>	'Zen Dots',
	'Zilla+Slab'	=>	'Zilla Slab',
);

}
}
