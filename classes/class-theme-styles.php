<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: THEME STYLES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */


/**
 * This class sets the stage for theme styles
 */

if ( ! class_exists( 'ToongeePrime_Styles' ) ) {

class ToongeePrime_Styles {

	/**
	 *	Defaults
	 *	Public for defaults' usage in customizer and other theme files
	 */
	public $brandClr	=	'#777777';
	public $brandClr2	=	'#aaaaaa';
	public $siteBG		=	'#efefef';
	public $headerBG	=	'#030303';
	public $contentBG	=	'#ffffff';
	public $footerBG	=	'#030303';
	public $siteWidth	=	'1100px';
	public $bodyFont	=	'Open+Sans';
	public $headFont	=	'Source+Serif+4';


	/**
	 *	Get from get_theme_mod()
	 */
	public function get_mod( $toGet ) {

		switch( $toGet ) {

			case 'brand' : $mod = get_theme_mod( 'prime2g_primary_brand_color', $this->brandClr ); break;

			case 'brand2' : $mod = get_theme_mod( 'prime2g_secondary_brand_color', $this->brandClr2 ); break;

			case 'width' : $mod = get_theme_mod( 'prime2g_site_width', $this->siteWidth ); break;

			case 'background' : $mod = get_theme_mod( 'prime2g_background_color', $this->siteBG ); break;

			case 'header' : $mod = get_theme_mod( 'prime2g_header_background', $this->headerBG ); break;

			case 'content' : $mod = get_theme_mod( 'prime2g_content_background', $this->contentBG ); break;

			case 'footer' : $mod = get_theme_mod( 'prime2g_footer_background', $this->footerBG ); break;

			case 'bodyF' : $mod = get_theme_mod( 'prime2g_site_body_font', $this->bodyFont ); break;

			case 'headF' : $mod = get_theme_mod( 'prime2g_site_headings_font', $this->headFont ); break;

			case 'headerattach' : $mod = get_theme_mod( 'prime2g_header_img_attachment', 'scroll' ); break;

		}
		return $mod;

	}


	/**
	 *	Get luminance from a HEX color
	 *
	 *	@static
	 *	@return int Returns a number (0-255)
	 */
	public static function the_hex_luminance( $hex ) {

		// Remove the "#" symbol from hex value
		$hex	=	ltrim( $hex, '#' );

		// Make sure there are 6 digits for calculations
		if ( 3 === strlen( $hex ) ) {
			$hex = substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) . substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) . substr( $hex, 2, 1 ) . substr( $hex, 2, 1 );
		}

		// Get R G B
		$red	=	hexdec( substr( $hex, 0, 2 ) );
		$green	=	hexdec( substr( $hex, 2, 2 ) );
		$blue	=	hexdec( substr( $hex, 4, 2 ) );

		// Calculate the luminance
		$lum	=	( 0.2126 * $red ) + ( 0.7152 * $green ) + ( 0.0722 * $blue );
		return ( int ) round( $lum );
	}


	/**
	 *	Determine Color is Light
	 */
	public static function is_light_color( $hex ) {
		return ( 127 <= self::the_hex_luminance( $hex ) );
	}


	/**
	 *	Generate CSS :root variables
	 *
	 *	@static
	 */
	protected static function the_root_css() {

	$styles	=	new self;

	return "
	--brand-color:". $styles->get_mod( 'brand' ) .";
	--brand-color-2:". $styles->get_mod( 'brand2' ) .";
	--site-width:". $styles->get_mod( 'width' ) .";
	--body-background:". $styles->get_mod( 'background' ) .";
	--header-background:". $styles->get_mod( 'header' ) .";
	--content-background:". $styles->get_mod( 'content' ) .";
	--footer-background:". $styles->get_mod( 'footer' ) .";
	--body-font:'". str_replace( "+", " ", $styles->get_mod( 'bodyF' ) ) ."';
	--headings-font:'". str_replace( "+", " ", $styles->get_mod( 'headF' ) ) ."';
	";

	}


	/**
	 *	Generate other CSS
	 *
	 *	@static
	 */
	protected static function theme_css() {

	$styles	=	new self;

	return "
	#header{background-attachment:". $styles->get_mod( 'headerattach' ) .";
	";

	}

}

}

