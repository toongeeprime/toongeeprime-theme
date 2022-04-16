<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: THEME ROOT CSS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

require PRIME2G_CLASSDIR . 'class-theme-styles.php';

/**
 * This class is in charge of color customization via the Customizer.
 */

if ( ! class_exists( 'ToongeePrime_ThemeCSS' ) ) {

class ToongeePrime_ThemeCSS extends ToongeePrime_Styles {

	/**
	 *	Return :root CSS
	 *
	 *	@static
	 */
	public static function root_css() {

$root	=	"<style id=\"prime2g_root_css\">";
$root	.=	"
:root{";
$root	.=	parent::the_root_css();
$root	.=	ToongeePrime_Colors::the_root_css();
$root	.=
"}
</style>";

	return $root;

	}

}

}

