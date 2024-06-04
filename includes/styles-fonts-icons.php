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
add_action( 'wp_head', 'prime2g_theme_root_styles', 1 );
if ( ! function_exists( 'prime2g_theme_root_styles' ) ) {
function prime2g_theme_root_styles() {
	echo ToongeePrime_ThemeCSS::root_css();
}
}


/**
 *	@since 1.0.55
 */
if ( ! function_exists( 'prime2g_theme_icons_info' ) ) {
function prime2g_theme_icons_info() {
return (object)[
	'url'		=>	'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css',
	'version'	=>	'1.11.1'
];
}
}


/**
 *	Load Theme Fonts
 */
add_action( 'wp_head', 'prime2g_load_theme_fonts' );
if ( ! function_exists( 'prime2g_load_theme_fonts' ) ) {
function prime2g_load_theme_fonts() {

if ( get_theme_mod( 'prime2g_use_theme_google_fonts', '1' ) ) {
$styles	=	ToongeePrime_Styles::mods_cache();	#	@since 1.0.57

	$bodyfont	=	$styles->bodyF;
	$headings	=	$styles->headF;
	$display	=	'&display=swap';
	$fonts_href	=	"https://fonts.googleapis.com/css?family=$bodyfont|$headings:300,400,500,600,700,800$display";
	echo "<link rel=\"preload\" href=\"$fonts_href\" fetchpriority=\"low\" as=\"style\" onload=\"this.onload=null;this.rel='stylesheet'\" />
<noscript><link rel=\"stylesheet\" href=\"$fonts_href\"></noscript>";
// "<link rel=\"preload\" href=\"font-file.woff2\" as=\"font\" type=\"font/woff2\" crossorigin>"
}

}
}


/**
 *	Get Google Fonts
 *	@since 1.0.55
 */
if ( ! function_exists( 'prime2g_get_google_fonts_remote' ) ) {
function prime2g_get_google_fonts_remote() {
$transient_name	=	'prime2g_google_fonts_sets';
$font_sets		=	get_transient( $transient_name );

if ( $font_sets ) {
	return $font_sets;
}
else {
$font_sets	=	[];
$remote		=	wp_remote_get( 'https://dev.akawey.com/fonts/google-fonts-fam-categ.json' );

if ( ! is_wp_error( $remote ) ) {
$fonts_string	=	wp_remote_retrieve_body( $remote );
$fonts_array	=	json_decode( $fonts_string );

foreach( $fonts_array as $font ) {
$family_keys[]	=	str_replace( ' ', '+', $font->family );
$family_names[]	=	$font->family;
$categories[]	=	$font->category;
}

$keys_names		=	array_combine( $family_keys, $family_names );
$keys_categs	=	array_combine( $family_keys, $categories );

$font_sets	=	[
	'family_keys'	=>	$family_keys,
	'family_names'	=>	$family_names,
	'categories'	=>	$categories,
	'keys_names'	=>	$keys_names,
	'keys_categs'	=>	$keys_categs
];

set_transient( $transient_name, $font_sets, MONTH_IN_SECONDS );
}
}

return $font_sets;
}
}


/**
 *	Theme (Google) Fonts
 *	Overhauled @since 1.0.55
 */
if ( ! function_exists( 'prime2g_theme_fonts' ) ) {
function prime2g_theme_fonts() {
	$font_sets	=	prime2g_get_google_fonts_remote();
	return $font_sets[ 'keys_names' ];
}
}


if ( ! function_exists( 'prime2g_get_gfont_category' ) ) {
function prime2g_get_gfont_category( string $font_key ) {
$font_sets	=	prime2g_get_google_fonts_remote();
$fonts		=	$font_sets[ 'keys_categs' ];

foreach( $fonts as $key => $value ) {
	if ( $font_key === $key ) return $value;
}
return '';
}
}
