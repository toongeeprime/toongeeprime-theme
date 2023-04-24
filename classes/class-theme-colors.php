<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: THEME COLORS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

require_once PRIME2G_CLASSDIR . 'class-theme-styles.php';

if ( ! class_exists( 'ToongeePrime_Colors' ) ) {

class ToongeePrime_Colors extends ToongeePrime_Styles {


	/**
	 *	Get luminance of given color and return hex to make text readable
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
	 */
	protected function the_root_css() {

		$brand		=	$this->get_mod( 'brand' );
		$brand2		=	$this->get_mod( 'brand2' );
		$bg_color	=	$this->get_mod( 'background' );
		$hdr_color	=	$this->get_mod( 'header' );
		$cnt_color	=	$this->get_mod( 'content' );
		$ftr_color	=	$this->get_mod( 'footer' );

	return "--body-text:". $this->get_readable_color( $bg_color ) .";
	--header-text:". $this->get_readable_color( $hdr_color ) .";
	--content-text:". $this->get_readable_color( $cnt_color ) .";
	--footer-text:". $this->get_readable_color( $ftr_color ) .";
	--headline-color:". $this->get_readable_color( $bg_color ) .";
	--button-bg:". $brand .";
	--button-text:". $this->get_readable_color( $brand ) .";
";

	}

	/**
	 *	Generate Dark Theme CSS :root variables
	 *	@since ToongeePrime Theme 1.0.49.00
	 */
	protected function the_root_dark_css() {

		$bg_color	=	$this->get_mod( 'background' );
		$cnt_color	=	$this->get_mod( 'content' );
		$dTheme		=	$this->get_mod( 'darktheme' );

	$dBody	=	'';
	if ( 'on_dbody' === $dTheme ) {
		$dBody	=	"--body-text:#efefef;
	--body-background:#030303;
	--header-text:#efefef;
	--header-background:#000;
	--footer-text:#efefef;
	--footer-background:#000;
";
	}
	return "--content-text:". $this->get_mod( 'content' ) .";
	--content-background:". $this->get_readable_color( $cnt_color ) .";
	--body-text:". $this->get_mod( 'background' ) .";
	--body-background:". $this->get_readable_color( $bg_color ) .";
	$dBody
";

	}


	/**
	 *	Set theme color classes
	 *
	 *	Used in <html> element via prime2g_theme_html_classes()
	 *	@static
	 */
	public static function theme_color_classes() {

		$classes	=	[];

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

			if ( ( 127 > $bgLum ) && ( 127 > $ctLum ) ) {
				$classes[]	=	'dark-theme';
			}

		return $classes;

	}

}

}

