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

$root	=	"<style id=\"prime2g_root_css\">";
$root	.=	"
:root{";
$root	.=	$styles->the_root_css();
$root	.=	$colors->the_root_css();
$root	.=
"}
body.themeswitched_dark{";
$root	.=	$colors->the_root_dark_css();
$root	.=
"}";
$root	.=	$styles->theme_css();
$root	.=	"</style>";

return $root;

	}

}

}

