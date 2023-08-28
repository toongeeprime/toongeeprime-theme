<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: THEME STYLES
 *	Sets the stage for theme styles
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
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
	public $bodyAltFont	=	'Arial, Helvetica, sans-serif'; # 1.0.55
	public $headFont	=	'Oxygen';
	public $headingsAltFont	=	'Geneva, Verdana, sans-serif'; # 1.0.55
	public $titlesF_Weight	=	'500'; # 1.0.55
	public $arch_ftImgHeight=	'17'; # 1.0.55

	/**
	 *	Get from get_theme_mod()
	 */
	public function get_mod( $toGet ) {
	$by_net_home	=	prime2g_design_by_network_home();
	if ( $by_net_home ) { switch_to_blog( 1 ); }

		switch( $toGet ) {
			case 'brand' : $mod = get_theme_mod( 'prime2g_primary_brand_color', $this->brandClr ); break;
			case 'brand2' : $mod = get_theme_mod( 'prime2g_secondary_brand_color', $this->brandClr2 ); break;
			case 'width' : $mod = get_theme_mod( 'prime2g_site_width', $this->siteWidth ); break;
			case 'background' : $mod = get_theme_mod( 'prime2g_background_color', $this->siteBG ); break;
			case 'header' : $mod = get_theme_mod( 'prime2g_header_background', $this->headerBG ); break;
			case 'h_height' : $mod = get_theme_mod( 'prime2g_theme_header_height' ); break;		# No default for backwards compat
			case 'content' : $mod = get_theme_mod( 'prime2g_content_background', $this->contentBG ); break;
			case 'footer' : $mod = get_theme_mod( 'prime2g_footer_background', $this->footerBG ); break;
			case 'use_gFonts' : $mod = get_theme_mod( 'prime2g_use_theme_google_fonts', '1' ); break;
			case 'bodyF' : $mod = get_theme_mod( 'prime2g_site_body_font', $this->bodyFont ); break;
			case 'b_AltFont' : $mod = get_theme_mod( 'prime2g_body_fallback_fonts', $this->bodyAltFont ); break;
			case 'headF' : $mod = get_theme_mod( 'prime2g_site_headings_font', $this->headFont ); break;
			case 'h_AltFont' : $mod = get_theme_mod( 'prime2g_headings_fallback_fonts', $this->headingsAltFont ); break;
			case 'headerattach' : $mod = get_theme_mod( 'prime2g_header_img_attachment', 'scroll' ); break;
			case 'headerimgsize' : $mod = get_theme_mod( 'prime2g_header_background_size', 'cover' ); break;
			case 'darktheme' : $mod = get_theme_mod( 'prime2g_dark_theme_switch' ); break;
			case 'post_titleSize' : $mod = get_theme_mod( 'prime2g_post_title_font_size', '2.5' ); break; # 1.0.55
			case 'arch_titleSize' : $mod = get_theme_mod( 'prime2g_archive_title_font_size', '3' ); break; # 1.0.55
			case 'titlesWeight' : $mod = get_theme_mod( 'prime2g_page_titles_font_weight', $this->titlesF_Weight ); break; # 1.0.55
			case 'bodyFontSize' : $mod = get_theme_mod( 'prime2g_body_text_font_size', '15' ); break; # 1.0.55
			case 'ftImgHeight' : $mod = get_theme_mod( 'prime2g_loop_post_image_height', $this->arch_ftImgHeight ); break; # 1.0.55
			case 'menu_place' : $mod = get_theme_mod( 'prime2g_menu_position' ); break; # 1.0.55
			case 'titleOnHeader' : $mod = get_theme_mod( 'prime2g_pagetitle_over_headervideo' ); break; # 1.0.55
		}

	if ( $by_net_home ) { restore_current_blog(); }

	return $mod;
	}

	/**
	 *	Get luminance from a HEX color
	 *
	 *	@static
	 *	@return int Returns a number (0-255)
	 */
	public static function the_hex_luminance( $hex ) {
		# Remove the "#" in hex value
		$hex	=	ltrim( $hex, '#' );

		# Make sure there are 6 digits for calculations
		if ( 3 === strlen( $hex ) ) {
			$hex = substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) . substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) . substr( $hex, 2, 1 ) . substr( $hex, 2, 1 );
		}

		# Get R G B
		$red	=	hexdec( substr( $hex, 0, 2 ) );
		$green	=	hexdec( substr( $hex, 2, 2 ) );
		$blue	=	hexdec( substr( $hex, 4, 2 ) );

		# Calculate the luminance
		$lum	=	( 0.2126 * $red ) + ( 0.7152 * $green ) + ( 0.0722 * $blue );
		return ( int ) round( $lum );
	}

	/**
	 *	Determine Color is Light
	 *
	 *	@static
	 */
	public static function is_light_color( $hex ) {
	return ( 127 <= self::the_hex_luminance( $hex ) );
	}

	/**
	 *	Generate CSS :root variables
	 */
	protected function the_root_css() {
	$useGFonts	=	$this->get_mod( 'use_gFonts' );
	$bodyGFont	=	$useGFonts ? str_replace( "+", " ", $this->get_mod( 'bodyF' ) ) : '';
	$headGFont	=	$useGFonts ? str_replace( "+", " ", $this->get_mod( 'headF' ) ) : '';

	return "
	--brand-color:". $this->get_mod( 'brand' ) .";
	--brand-color-2:". $this->get_mod( 'brand2' ) .";
	--site-width:". $this->get_mod( 'width' ) .";
	--body-background:". $this->get_mod( 'background' ) .";
	--header-background:". $this->get_mod( 'header' ) .";
	--content-background:". $this->get_mod( 'content' ) .";
	--footer-background:". $this->get_mod( 'footer' ) .";
	--body-font:'{$bodyGFont}', ". $this->get_mod( 'b_AltFont' ) .";
	--headings-font:'{$headGFont}', ". $this->get_mod( 'h_AltFont' ) .";
	--post-titlesize:". $this->get_mod( 'post_titleSize' ) ."rem;
	--arch-titlesize:". $this->get_mod( 'arch_titleSize' ) ."rem;
	";
	}

	/**
	 *	Generate other CSS
	 */
	protected function theme_css() {
	$bodyFS	=	$this->get_mod( 'bodyFontSize' ) .'px';
	$bgSize	=	$this->get_mod( 'headerimgsize' );
	$t_weight	=	$this->get_mod( 'titlesWeight' );
	$bgSize		=	( '' == $bgSize ) ? 'cover' : $bgSize;
	$menuPlace	=	$this->get_mod( 'menu_place' );

	$hHeight	=	$this->get_mod( 'h_height' );
	$hHeight	=	( '' == $hHeight ) ? '' : $hHeight .'vh';

	$titleOnHeader	=	$this->get_mod( 'titleOnHeader' ) ? '.title_over_video ' : '';

	$videoActive	=	( has_header_video() && is_header_video_active() ) ?
	".site_width.title_wrap{max-width:none;width:100%;height:100%;}
	.title_over_video .page_title{position:absolute;}" : '';
	$videoFeatures	=	prime2g_video_features_active();
	$headerVidCSS	=	$videoFeatures ?
	"#header iframe{height:{$hHeight};}{$videoActive}#header.grid{display:grid;}
	.video_header #header,.video_as_header #header{padding:0;overflow:hidden;display:block;}
	#wp-custom-header{position:relative;height:{$hHeight};}
	#wp-custom-header-video{width:auto;height:{$hHeight};}" : '';
	$headerVidCSSB	=	$videoFeatures ?
	".video_header #header,.video_as_header #header{min-height:{$hHeight};}
	#wp-custom-header-video{width:100%;height:auto;}" : '';

	$fImgHeight	=	$this->get_mod( 'ftImgHeight' ) .'em';
	$fImgCSS	=	'.posts_loop .thumbnail,.posts_loop .video iframe{height:'. $fImgHeight .';}
	.mejs-container{height:'. $fImgHeight .'!important;}';
	$fImgCSS	=	( ! is_singular() ) ? $fImgCSS : '';

	$css	=	"
#header{background-attachment:". $this->get_mod( 'headerattach' ) .";background-size:{$bgSize};min-height:{$hHeight};}
h1.page-title{font-weight:{$t_weight};}
.singular .entry-title{font-size:var(--post-titlesize);}
body:not(.singular) .entry-title{font-size:var(--arch-titlesize);}
body{font-size:{$bodyFS};}
{$fImgCSS}
{$headerVidCSS}

@media(min-width:821px){";
$css	.=	in_array( $menuPlace, [ 'fixed', 'menu_on_header' ] ) ? "#container{top:46px;}
#main_nav{position:fixed;top:0;left:0;right:0;}.admin-bar #main_nav{top:32px;}" : "";
$css	.=	( $menuPlace === 'menu_on_header' ) ? "#main_nav{background:transparent;}
.pop #main_nav{background:var(--content-background);}#container{top:0;}":"";
$css	.=	$headerVidCSSB;
$css	.=	"}

@media(max-width:820px){
.singular .entry-title{font-size:calc(var(--post-titlesize)*0.85);}
body:not(.singular) .entry-title{font-size:calc(var(--arch-titlesize)*0.85);}";

$css	.=	$fImgCSS ? ".posts_loop .thumbnail,.posts_loop .video iframe{height:calc({$fImgHeight} * .8);}" : "";
$css	.=	"}

@media(max-width:601px){
.singular .entry-title{font-size:calc(var(--post-titlesize)*0.7);}
body:not(.singular) .entry-title{font-size:calc(var(--arch-titlesize)*0.7);}
}
";
return $css;
	}

}

}

