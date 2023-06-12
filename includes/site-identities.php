<?php defined( 'ABSPATH' ) || exit;

/**
 *	ELEMENTS TO IDENTIFY A SITE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	The Site Title or Logo display
 */
if ( ! function_exists( 'prime2g_title_or_logo' ) ) {
function prime2g_title_or_logo( $before = '<div class="page_title prel title_tagline_logo site_width">', $after = '</div>', $darklogo = false )
{
	if ( ! display_header_text() ) return;

$name		=	get_bloginfo( 'name' );
$siteName	=	'<span title="' . $name . '">' . $name . '</span>';

if ( is_front_page() ) {
	$title	=	$siteName;
}
else {
	$title	=	'<a href="'. get_home_url() .'">'. $siteName .'</a>';
}

	# Add optional html tags
	# Opening
	$show	=	$before;

	if ( has_custom_logo() ) { $show	.=	prime2g_siteLogo( $darklogo ); }
	else {
		$show	.=	'<h1>'. $title .'</h1>';
		$show	.=	'<p id="site_description">'. get_bloginfo( 'description' ) .'</p>';
	}

	# Include closing html tags
	$show	.=	$after;

return $show;
}
}



/**
 *	Dark and Default theme logo URLs
 */
function prime2g_get_custom_logo_url() {
	return esc_url( wp_get_attachment_url( get_theme_mod( 'custom_logo' ) ) );
}

function prime2g_get_dark_logo_url() {
	return esc_url( wp_get_attachment_url( get_theme_mod( 'prime2g_dark_theme_logo' ) ) );
}



/**
 *	Theme's Placeholder Image
 */
function prime2g_get_placeholder_url() { return PRIME2G_THEMEURL. 'images/placeholder.gif'; }



/**
 *	Theme' logo
 *
 *	Determine Dark theme logo or default custom logo
 *
 *	@ 1.0.49 : added $darklogo
 *	@ 1.0.49.05 : added $getSrc
 *	@ 1.0.55 : calc and set attrs height & width
 */
function prime2g_siteLogo( $darklogo = false, $getSrc = false ) {

	if ( $darklogo ) {
		$iid	=	get_theme_mod( 'prime2g_dark_theme_logo' );
		if ( $iid ) {
			$src	=	prime2g_get_dark_logo_url();
		}
		else {
			$src	=	prime2g_get_custom_logo_url();
			$iid	=	get_theme_mod( 'custom_logo' );
		}
	}
	else {
		$iid	=	get_theme_mod( 'prime2g_dark_theme_logo' );
		if ( $iid && in_array( 'dark-background', ToongeePrime_Colors::theme_color_classes() ) ) {
			$src	=	prime2g_get_dark_logo_url();
		}
		else {
			$src	=	prime2g_get_custom_logo_url();
			$iid	=	get_theme_mod( 'custom_logo' );
		}
	}

if ( $getSrc ) return $src;

	$siteName	=	get_bloginfo( 'name' );
	$logoHeight	=	get_theme_mod( 'prime2g_theme_logo_height', '100' );	# @ Theme 1.0.55
	$imgsrcs	=	wp_get_attachment_image_src( $iid, 'full' );
	$width	=	$height	=	'50';
	if ( $imgsrcs ) {
		$width		=	(int) $imgsrcs[1];
		$height		=	(int) $imgsrcs[2];
		$width		=	( $width / $height ) * (int) $logoHeight;
		$width		=	ceil( $width );
	}

	$img	=	'<img src="' . $src . '" alt class="custom-logo" title="' . $siteName . '" width="'. $width .'px" height="'. $logoHeight .'px" />';

	#	Link logo to homepage from all other pages
	if ( ! is_front_page() ) {
		$logo	=	'<a class="logo_link" href="'. esc_url( home_url() ) .'">' . $img . '</a>';
	}
	else {
		$logo	=	$img;
	}

return $logo;
}

