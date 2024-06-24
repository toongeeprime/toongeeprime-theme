<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: BUILD THEME STYLES
 *	Sets up theme styles
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */
if ( ! class_exists( 'ToongeePrime_Styles' ) ) {

class ToongeePrime_Styles {

	/**
	 *	Properties
	 *	Public for defaults' usage in customizer and other theme files
	 */
	public	$siteWidth	=	'1100px',
			$headFont	=	'Oxygen',
			$bodyFont	=	'Open+Sans',
			$headingsAltFont	=	'Geneva, Verdana, sans-serif', # 1.0.55
			$bodyAltFont	=	'Arial, Helvetica, sans-serif',
			$titlesF_Weight	=	'500',
			$arch_ftImgHeight=	'17';


	/**
	 *	Defaults subject to Child Overrides
	 */
	public function defaults() {
	$brandcolor	=	defined( 'CHILD_BRANDCOLOR' ) ? CHILD_BRANDCOLOR : '#777777';
	$brandcolor2=	defined( 'CHILD_BRANDCOLOR2' ) ? CHILD_BRANDCOLOR2 : '#aaaaaa';
	$bgcolor	=	defined( 'CHILD_SITEBG' ) ? CHILD_SITEBG : '#efefef';
	$headerbg	=	defined( 'CHILD_HEADERBG' ) ? CHILD_HEADERBG : '#030303';
	$contentbg	=	defined( 'CHILD_CONTENTBG' ) ? CHILD_CONTENTBG : '#ffffff';
	$buttonbg	=	defined( 'CHILD_BUTTONBG' ) ? CHILD_BUTTONBG : '#777777';
	$footerbg	=	defined( 'CHILD_FOOTERBG' ) ? CHILD_FOOTERBG : '#030303';
	$sidebarbg	=	defined( 'CHILD_SIDEBARBG' ) ? CHILD_SIDEBARBG : '#ffffff';	#	@since 1.0.93

	return (object) [
		'brandcolor'	=>	$brandcolor,
		'brandcolor2'	=>	$brandcolor2,
		'bgcolor'	=>	$bgcolor,
		'headerbg'	=>	$headerbg,
		'contentbg'	=>	$contentbg,
		'buttonbg'	=>	$buttonbg,
		'footerbg'	=>	$footerbg,
		'sidebarbg'	=>	$sidebarbg
	];
	}

	/**
	 *	Get from get_theme_mod()
	 */
	public function get_mod( string $get ) {
	$by_net_home	=	prime2g_design_by_network_home();
	if ( $by_net_home ) switch_to_blog( 1 );
	$defaults	=	$this->defaults();

		switch( $get ) {
			case 'brand' : $mod = defined( 'CHILD_BRANDCOLOR' ) ? CHILD_BRANDCOLOR : get_theme_mod( 'prime2g_primary_brand_color', $defaults->brandcolor ); break;
			case 'brand2' : $mod = defined( 'CHILD_BRANDCOLOR2' ) ? CHILD_BRANDCOLOR2 : get_theme_mod( 'prime2g_secondary_brand_color', $defaults->brandcolor2 ); break;
			case 'background' : $mod = defined( 'CHILD_SITEBG' ) ? CHILD_SITEBG : get_theme_mod( 'prime2g_background_color', $defaults->bgcolor ); break;
			case 'header' : $mod = defined( 'CHILD_HEADERBG' ) ? CHILD_HEADERBG : get_theme_mod( 'prime2g_header_background', $defaults->headerbg ); break;
			case 'content' : $mod = defined( 'CHILD_CONTENTBG' ) ? CHILD_CONTENTBG : get_theme_mod( 'prime2g_content_background', $defaults->contentbg ); break;
			case 'footer' : $mod = defined( 'CHILD_FOOTERBG' ) ? CHILD_FOOTERBG : get_theme_mod( 'prime2g_footer_background', $defaults->footerbg ); break;
			case 'buttonbg' : $mod = defined( 'CHILD_BUTTONBG' ) ? CHILD_BUTTONBG : get_theme_mod( 'prime2g_button_background', $defaults->buttonbg ); break;
			case 'width' : $mod = get_theme_mod( 'prime2g_site_width', $this->siteWidth ); break;
			case 'h_height' : $mod = get_theme_mod( 'prime2g_theme_header_height', '' ); break;		# '' === default for backwards compat
			case 'use_gFonts' : $mod = get_theme_mod( 'prime2g_use_theme_google_fonts', '1' ); break;
			case 'bodyF' : $mod = get_theme_mod( 'prime2g_site_body_font', $this->bodyFont ); break;
			case 'b_AltFont' : $mod = get_theme_mod( 'prime2g_body_fallback_fonts', $this->bodyAltFont ); break;
			case 'headF' : $mod = get_theme_mod( 'prime2g_site_headings_font', $this->headFont ); break;
			case 'h_AltFont' : $mod = get_theme_mod( 'prime2g_headings_fallback_fonts', $this->headingsAltFont ); break;
			case 'headerattach' : $mod = get_theme_mod( 'prime2g_header_img_attachment', 'scroll' ); break;
			case 'headerimgsize' : $mod = get_theme_mod( 'prime2g_header_background_size', 'cover' ); break;
			case 'darktheme' : $mod = get_theme_mod( 'prime2g_dark_theme_switch' ); break;
			# @since 1.0.55
			case 'post_titleSize' : $mod = get_theme_mod( 'prime2g_post_title_font_size', '2.5' ); break;
			case 'arch_titleSize' : $mod = get_theme_mod( 'prime2g_archive_title_font_size', '3' ); break;
			case 'titlesWeight' : $mod = get_theme_mod( 'prime2g_page_titles_font_weight', $this->titlesF_Weight ); break;
			case 'bodyFontSize' : $mod = get_theme_mod( 'prime2g_body_text_font_size', '15' ); break;
			case 'ftImgHeight' : $mod = get_theme_mod( 'prime2g_loop_post_image_height', $this->arch_ftImgHeight ); break;
			case 'menu_place' : $mod = get_theme_mod( 'prime2g_menu_position' ); break;
			case 'titleOnHeader' : $mod = get_theme_mod( 'prime2g_pagetitle_over_headervideo' ); break;
			# @since 1.0.57
			case 'style_extras' : $mod = get_theme_mod( 'prime2g_site_style_extras' ); break;
			case 'title_place' : $mod = get_theme_mod( 'prime2g_title_location' ); break;
			case 'sidebar_place' : $mod = get_theme_mod( 'prime2g_sidebar_position' ); break;
			case 'video_place' : $mod = get_theme_mod( 'prime2g_video_embed_location' ); break;
			case 'menu_type' : $mod = get_theme_mod( 'prime2g_main_menu_type' ); break;
			case 'logo_with_menu' : $mod = get_theme_mod( 'prime2g_logo_with_menu' ); break;
			case 'top_menu' : $mod = get_theme_mod( 'prime2g_use_site_top_menu' ); break;
			case 'm_menu_width' : $mod = get_theme_mod( 'prime2g_mega_menu_width' ); break; # @since 1.0.78
			case 'theme_seo' : $mod = get_theme_mod( 'prime2g_use_theme_seo', 1 ); break; # @since 1.0.81
			case 'sticky_menu' : $mod = get_theme_mod( 'prime2g_use_sticky_menu', 0 ); break; # @since 1.0.83
			case 'mob_submenu_open' : $mod = get_theme_mod( 'prime2g_mobile_submenu_collapsing', 'click' ); break; # @since 1.0.86
			case 'autoplay_header_vid' : $mod = get_theme_mod( 'prime2g_autoplay_header_video', '' ); break; # @since 1.0.87
			case 'search_in_cf' : $mod = get_theme_mod( 'prime2g_search_in_custom_fields', '' ); break; # @since 1.0.88
			case 'header_vid_places' : $mod = get_theme_mod( 'prime2g_video_header_placements', '' ); break; # @since 1.0.88
			case 'sidebarbg' : $mod = defined( 'CHILD_SIDEBARBG' ) ? CHILD_SIDEBARBG : get_theme_mod( 'prime2g_sidebar_background', $defaults->sidebarbg ); break; # @since 1.0.93
			case 'sticky_sb_tog' : $mod = get_theme_mod( 'prime2g_sticky_sidebar_toggler', '' ); break; # @since 1.0.95
		}

	if ( $by_net_home ) restore_current_blog();

	return $mod;
	}

	/**
	 *	Get luminance from a HEX color
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
	 */
	public static function is_light_color( $hex ) { return ( 127 <= self::the_hex_luminance( $hex ) ); }

	/**
	 *	Generate CSS :root variables
	 */
	protected function the_root_css() {
	$cache	=	self::mods_cache();

	if ( $cache->use_gFonts ) {
		$hFont		=	$cache->headF;
		$headGFont	=	str_replace( "+", " ", $hFont );
		$headGFont	=	$headGFont . '\', \'' . prime2g_get_gfont_category( $hFont );

		$bFont		=	$cache->bodyF;
		$bodyGFont	=	str_replace( "+", " ", $bFont );
		$bodyGFont	=	$bodyGFont . '\', \'' . prime2g_get_gfont_category( $bFont );
	} else {
		$headGFont	=	$cache->h_AltFont;
		$bodyGFont	=	$cache->b_AltFont;
	}

	return "
	--brand-color:". $cache->brand .";
	--brand-color-2:". $cache->brand2 .";
	--site-width:". $cache->width .";
	--body-background:". $cache->background .";
	--header-background:". $cache->header .";
	--content-background:". $cache->content .";
	--sidebar-background:". $cache->sidebarbg .";
	--footer-background:". $cache->footer .";
	--body-font:'{$bodyGFont}';
	--headings-font:'{$headGFont}';
	--post-titlesize:". $cache->post_titleSize ."rem;
	--arch-titlesize:". $cache->arch_titleSize ."rem;
	--transparent-light1:#ffffffcc;
	--transparent-light2:#ffffffaa;
	--transparent-light3:#ffffff55;
	--transparent-dark1:#000000cc;
	--transparent-dark2:#000000aa;
	--transparent-dark3:#00000055;
	";
	}

	/**
	 *	Generate other CSS
	 */
	protected function theme_css() {
	$cache	=	self::mods_cache();

	$bodyFS	=	$cache->bodyFontSize .'px';
	$bgSize	=	$cache->headerimgsize;
	$t_weight	=	$cache->titlesWeight;
	$bgSize		=	'' === $bgSize ? 'cover' : $bgSize;
	$menuPlace	=	$cache->menu_place;

	$hHeight	=	$cache->h_height;
	$hHeight	=	'' === $hHeight ? '' : $hHeight .'vh';

	$titleOnHeader	=	$cache->titleOnHeader ? '.title_over_video ' : '';

	$videoActive	=	( has_header_video() && is_header_video_active() ) ?
	".site_width.title_wrap{max-width:none;width:100%;height:100%;}" : '';
	$videoFeatures	=	prime2g_video_features_active();
	$headerVidCSS	=	$videoFeatures ?
	"#header iframe{height:{$hHeight};}{$videoActive}#header.grid{display:grid;}
	#wp-custom-header{position:relative;height:{$hHeight};}
	#wp-custom-header-video{width:auto;height:{$hHeight};}" : '';
	$headerVidCSSB	=	$videoFeatures ?
	".video_header #header,.video_as_header #header{min-height:{$hHeight};}
	#wp-custom-header-video{width:100%;height:auto;}" : '';

	$fImgHeight	=	$cache->ftImgHeight .'em';
	$fImgCSS	=	'.posts_loop .thumbnail,.posts_loop .video iframe{height:'. $fImgHeight .';}
	.mejs-container,.mejs-mediaelement video.wp-video-shortcode{height:'. $fImgHeight .'!important;}';
	$fImgCSS	=	( ! is_singular() ) ? $fImgCSS : '';

	$css	=	"
#header{background-attachment:". $cache->headerattach .";background-size:{$bgSize};min-height:{$hHeight};}
h1.page-title{font-weight:{$t_weight};}
.singular .entry-title{font-size:var(--post-titlesize);}
body:not(.singular) .entry-title{font-size:var(--arch-titlesize);}
body{font-size:{$bodyFS};}
.mainsidebar{background-color:var(--sidebar-background);color:var(--sidebar-text);}
.mainsidebar a{color:var(--sidebar-text);}
{$fImgCSS}
{$headerVidCSS}

@media(min-width:821px){";
$css	.=	in_array( $menuPlace, [ 'fixed', 'menu_on_header' ] ) ? "#container{top:46px;}
#main_nav{position:fixed;top:0;left:0;right:0;}.admin-bar #main_nav{top:32px;}" : "";
$css	.=	$menuPlace === 'menu_on_header' ? "#main_nav{background:transparent;}
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

	/**
	 *	Theme Mods Cached
	 *	Since $this->get_mod() computes site/network values, reduce repeats
	 *	@since 1.0.57
	 */
	public static function mods_cache() {
		if ( is_customize_preview() ) return self::mods_object();

		if ( $modsCache = wp_cache_get( 'theme_style_mods', PRIME2G_CACHEGROUP ) ) { return $modsCache; }
		else {
			wp_cache_set( 'theme_style_mods', self::mods_object(), PRIME2G_CACHEGROUP, HOUR_IN_SECONDS + 11 );
			return wp_cache_get( 'theme_style_mods', PRIME2G_CACHEGROUP );
		}
	}

	protected static function mods_object() {
	$mods	=	new self;
	return (object) [
		'brand'		=>	$mods->get_mod( 'brand' ),
		'brand2'	=>	$mods->get_mod( 'brand2' ),
		'background'=>	$mods->get_mod( 'background' ),
		'header'	=>	$mods->get_mod( 'header' ),
		'content'	=>	$mods->get_mod( 'content' ),
		'footer'	=>	$mods->get_mod( 'footer' ),
		'buttonbg'	=>	$mods->get_mod( 'buttonbg' ),
		'width'		=>	$mods->get_mod( 'width' ),
		'h_height'	=>	$mods->get_mod( 'h_height' ),
		'use_gFonts'=>	$mods->get_mod( 'use_gFonts' ),
		'bodyF'		=>	$mods->get_mod( 'bodyF' ),
		'b_AltFont'	=>	$mods->get_mod( 'b_AltFont' ),
		'headF'		=>	$mods->get_mod( 'headF' ),
		'h_AltFont'	=>	$mods->get_mod( 'h_AltFont' ),
		'headerattach'	=>	$mods->get_mod( 'headerattach' ),
		'headerimgsize'	=>	$mods->get_mod( 'headerimgsize' ),
		'dt_switch'		=>	$mods->get_mod( 'darktheme' ),
		'post_titleSize'=>	$mods->get_mod( 'post_titleSize' ),
		'arch_titleSize'=>	$mods->get_mod( 'arch_titleSize' ),
		'titlesWeight'	=>	$mods->get_mod( 'titlesWeight' ),
		'bodyFontSize'	=>	$mods->get_mod( 'bodyFontSize' ),
		'ftImgHeight'	=>	$mods->get_mod( 'ftImgHeight' ),
		'menu_place'	=>	$mods->get_mod( 'menu_place' ),
		'titleOnHeader'	=>	$mods->get_mod( 'titleOnHeader' ),
		'style_extras'	=>	$mods->get_mod( 'style_extras' ),
		'title_place'	=>	$mods->get_mod( 'title_place' ),
		'sidebar_place'	=>	$mods->get_mod( 'sidebar_place' ),
		'video_place'	=>	$mods->get_mod( 'video_place' ),
		'menu_type'		=>	$mods->get_mod( 'menu_type' ),
		'logo_with_menu'=>	$mods->get_mod( 'logo_with_menu' ),
		'top_menu'		=>	$mods->get_mod( 'top_menu' ),
		'megamenu_width'=>	$mods->get_mod( 'm_menu_width' ),
		'theme_seo'		=>	$mods->get_mod( 'theme_seo' ),
		'sticky_menu'	=>	$mods->get_mod( 'sticky_menu' ),
		'mob_submenu_open'	=>	$mods->get_mod( 'mob_submenu_open' ),
		'autoplay_header_vid'	=>	$mods->get_mod( 'autoplay_header_vid' ),	// @since 1.0.87
		'search_in_cf'		=>	$mods->get_mod( 'search_in_cf' ),	// @since 1.0.88
		'header_vid_places'	=>	$mods->get_mod( 'header_vid_places' ),
		'sidebarbg'		=>	$mods->get_mod( 'sidebarbg' ),	// @since 1.0.93
		'sticky_sb_tog'	=>	$mods->get_mod( 'sticky_sb_tog' )	// @since 1.0.95
	];
	}

}

}

