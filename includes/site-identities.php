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
function prime2g_title_or_logo( $before = '<div class="page_title prel title_tagline_logo site_width">', $after = '</div>' )
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

	// Add optional html tags
	// Opening
	$show	=	$before;

	if ( has_custom_logo() ) {

		$show	.=	prime2g_siteLogo();

	}
	else {

		$show	.=	'<h1>'. $title .'</h1>';
		$show	.=	'<p id="site_description">'. get_bloginfo( 'description' ) .'</p>';

	}

	// Include closing html tags
	$show	.=	$after;

return $show;
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
function prime2g_get_placeholder_url() {
	return PRIME2G_THEMEURL. 'images/placeholder.gif';
}



/**
 *	Theme logo
 *
 *	Determine Dark theme logo or default custom logo
 */
function prime2g_siteLogo() {
$siteName	=	get_bloginfo( 'name' );

	if (
		in_array( 'dark-background', ToongeePrime_Colors::theme_color_classes() )
		&& get_theme_mod( 'prime2g_dark_theme_logo' )
	) {
		$src = prime2g_get_dark_logo_url();
	}
	else {
		$src = prime2g_get_custom_logo_url();
	}

	$img	=	'<img src="' . $src . '" alt class="custom-logo" title="' . $siteName . '" />';

	// Link logo to homepage from all other pages
	if ( ! is_front_page() ) {
		$logo	=	'<a class="logo_link" href="'. esc_url( home_url() ) .'">';
		$logo	.=	$img;
		$logo	.=	'</a>';
	}
	else {
		$logo	=	$img;
	}

return $logo;

}


