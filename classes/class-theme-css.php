<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: THEME ROOT CSS
 *	Outputting to the Theme
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */
require_once PRIME2G_CLASSDIR . 'class-theme-colors.php';

if ( ! class_exists( 'ToongeePrime_ThemeCSS' ) ) {

class ToongeePrime_ThemeCSS extends ToongeePrime_Colors {
	/**
	 *	Return :root CSS
	 *
	 *	@static
	 */
	public static function root_css() {

	$styles	=	new ToongeePrime_Styles();
	$colors	=	new ToongeePrime_Colors();

$css	=	"<style id=\"prime2g_root_css\">";
$css	.=	"
:root{";
$css	.=	$styles->the_root_css();
$css	.=	$colors->the_root_css().
"}
body.themeswitched_dark{";
$css	.=	$colors->the_root_dark_css().
"}";
$css	.=	$styles->theme_css();
$css	.=	"</style>";

return $css;

	}

}

}

