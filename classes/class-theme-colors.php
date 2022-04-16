<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: THEME COLORS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

require PRIME2G_CLASSDIR . 'class-theme-styles.php';

/**
 * This class is in charge of color customization via the Customizer
 */

if ( ! class_exists( 'ToongeePrime_Colors' ) ) {

class ToongeePrime_Colors extends ToongeePrime_Styles {


	/**
	 *	Get luminance of given color and return #fff or #000 to make text readable
	 *
	 *	Invert if NOT a light color
	 */
	public function get_readable_color( $color, $light = true ) {

		if ( $light ) {
			return ( $this->is_light_color( $color ) ) ? '#101010' : '#fefefe';
		}
		else {
			return ( ! $this->is_light_color( $color ) ) ? '#fefefe' : '#101010';
		}

	}


	/**
	 *	Generate CSS :root variables
	 *
	 *	@static
	 */
	public static function the_root_css() {

		$colr		=	new self;
		$brand		=	$colr->get_mod( 'brand' );
		$brand2		=	$colr->get_mod( 'brand2' );
		$bg_color	=	$colr->get_mod( 'background' );
		$hdr_color	=	$colr->get_mod( 'header' );
		$cnt_color	=	$colr->get_mod( 'content' );
		$ftr_color	=	$colr->get_mod( 'footer' );

	return "--body-text:". $colr->get_readable_color( $bg_color ) .";
	--header-text:". $colr->get_readable_color( $hdr_color ) .";
	--content-text:". $colr->get_readable_color( $cnt_color ) .";
	--footer-text:". $colr->get_readable_color( $ftr_color ) .";
	--headline-color:". $colr->get_readable_color( $bg_color ) .";
	--button-bg:". $brand .";
	--button-text:". $colr->get_readable_color( $brand ) .";
";

	}


	/**
	 *	Set theme color classes
	 *
	 *	Used in <html> element via prime2g_theme_html_classes()
	 *	@static
	 */
	public static function theme_color_classes( array $classes = null ) {

		if ( ! $classes )
			$classes	=	array();

		$color		=	new self;
		$bgColor	=	$color->get_mod( 'background' );
		$ctColor	=	$color->get_mod( 'content' );

		$bgLum		=	parent::the_hex_luminance( $bgColor );
		$ctLum		=	parent::the_hex_luminance( $ctColor );

			if ( 127 > $bgLum ) {
				$classes[]	=	'dark-background';
			}
			elseif ( 225 <= $bgLum ) {
				$classes[]	=	'bright-background';
			}
			else {
				$classes[]	=	'light-background';
			}

			if ( 127 > $ctLum ) {
				$classes[]	=	'dark-content';
			}

		return $classes;

	}

}

}

