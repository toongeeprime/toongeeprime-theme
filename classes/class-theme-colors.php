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
	protected function text_colors() {
	$cache	=	self::mods_cache();
	$brand		=	$cache->brand;
	$brand2		=	$cache->brand2;
	$bg_color	=	$cache->background;
	$hdr_color	=	$cache->header;
	$cnt_color	=	$cache->content;
	$ftr_color	=	$cache->footer;
	$buttonbg	=	$cache->buttonbg;
	$sbarText	=	$cache->sidebarbg;	//	@since 1.0.93
	$btnText	=	defined( 'CHILD_BUTTONTEXT' ) ? CHILD_BUTTONTEXT : $this->get_readable_color( $buttonbg );

	return "--body-text:". $this->get_readable_color( $bg_color ) .";
	--header-text:". $this->get_readable_color( $hdr_color ) .";
	--content-text:". $this->get_readable_color( $cnt_color ) .";
	--footer-text:". $this->get_readable_color( $ftr_color ) .";
	--headline-color:". $this->get_readable_color( $bg_color ) .";
	--button-bg:". $buttonbg .";
	--button-text:". $btnText .";
	--sidebar-text:". $this->get_readable_color( $sbarText ) .";
";
	}

	/**
	 *	Generate Dark Theme CSS :root variables
	 *	@since ToongeePrime Theme 1.0.49
	 */
	protected function the_root_dark_css() {
	$cache	=	self::mods_cache();
	$bg_color	=	$cache->background;
	$cnt_color	=	$cache->content;
	$sidebarbg	=	$cache->sidebarbg;

	$dBody	=	'';
	if ( 'on_dbody' === $cache->dt_switch ) {
		$dBody	=	"--body-text:#efefef;
	--body-background:#030303;
	--header-text:#efefef;
	--header-background:#000;
	--footer-text:#efefef;
	--footer-background:#000;
	--sidebar-background:#090909;
	--sidebar-text:#efefef;
	--transparent-light1:#000000cc;
	--transparent-light2:#000000aa;
	--transparent-light3:#00000055;
	--transparent-dark1:#ffffffcc;
	--transparent-dark2:#ffffffaa;
	--transparent-dark3:#ffffff55;
";
	}
	return "--content-text:". $cache->content .";
	--content-background:". $this->get_readable_color( $cnt_color ) .";
	--body-text:". $cache->background .";
	--body-background:". $this->get_readable_color( $bg_color ) .";
	$dBody
";
	}

	/**
	 *	Set theme color classes
	 *	Used in <html> element via prime2g_theme_html_classes()
	 */
	public static function theme_color_classes() {
	$classes	=	[];
	$cache		=	self::mods_cache();
	$bgColor	=	$cache->background;
	$ctColor	=	$cache->content;
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

