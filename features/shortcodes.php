<?php defined( 'ABSPATH' ) || exit;

/**
 *	SHORTCODES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.49
 */

/**
 *	Show Contacts & Social Media Icons set in Theme's Customizer
 */
add_shortcode( 'prime2g_social_and_contacts', 'prime2g_social_and_contacts_shortcode' );
function prime2g_social_and_contacts_shortcode( $atts ) {
$atts	=	shortcode_atts( array( 'showaddress'	=>	'' ), $atts );
extract( $atts );

$address	=	false;
if ( $showaddress == 'yes' ) {
	$address	=	true;
}

return prime2g_theme_mod_social_and_contacts( $address );
}


/**
 *	Insert a Template Part
 *	@since ToongeePrime Theme 1.0.50
 */
add_shortcode( 'prime_insert_template_part', 'prime2g_insert_template_part_shortcode' );
function prime2g_insert_template_part_shortcode( $atts ) {
$atts	=	shortcode_atts( array( 'id'	=>	'1' ), $atts );
extract( $atts );

$part	=	prime2g_insert_template_part( $id, false );

if ( ! $part ) {
	return __( 'Invalid Template Part', PRIME2G_TEXTDOM );
}

return $part;

}


/**
 *	@since ToongeePrime Theme 1.0.55
 *	Considered for Template Parts
 */
add_shortcode( 'prime_site_logo', 'prime2g_sitelogo_shortcode' );
function prime2g_sitelogo_shortcode( $atts ) {
$atts	=	shortcode_atts( array( 'dark_logo' => '', 'source' => '' ), $atts );
extract( $atts );

$darkLogo	=	( $dark_logo == 'yes' ) ? true : false;
$src	=	( $source == 'yes' ) ? true : false;

return prime2g_siteLogo( $darkLogo, $src );
}


/**
 *	@since ToongeePrime Theme 1.0.55
 */
add_shortcode( 'prime_site_title_and_description', 'prime2g_title_and_description_shortcode' );
function prime2g_title_and_description_shortcode( $atts ) {
$atts	=	shortcode_atts( array( 'description' => 'yes', 'class' => '' ), $atts );
extract( $atts );

$desc	=	( $description == 'yes' ) ? true : false;
$name	=	get_bloginfo( 'name' );

$title	=	"<div class=\"page_title prel site_width {$class}\">";
$title	.=	"<h1><span title=\"{$name}\">{$name}</span></h1>";
$title	.=	$desc ? '<p id="site_description">'. get_bloginfo( 'description' ) .'</p>' : '';
$title	.=	"</div>";

return $title;
}


/**
 *	@since ToongeePrime Theme 1.0.55
 */
add_shortcode( 'prime_site_footer_credits', 'prime2g_theme_footer_credit' );


/**
 *	In-post Redirection
 *	@since ToongeePrime Theme 1.0.51
 */
add_shortcode( 'prime_redirect_to', 'prime2g_redirect_shortcode' );
function prime2g_redirect_shortcode( $atts ) {
$home		=	get_home_url();
$loggedin	=	is_user_logged_in();

$atts	=	shortcode_atts( array( 'url' => $home, 'users' => '' ), $atts );
extract( $atts );

// Leave echo, not return:
if ( $users == 'logged out' ) {
	if ( ! $loggedin ) {
		echo '<script id="prime_redirect_shortcode">window.location = "'. $url .'";</script>';
	}
}

if ( $users == 'logged in' ) {
	if ( $loggedin ) {
		echo '<script id="prime_redirect_shortcode">window.location = "'. $url .'";</script>';
	}
}

if ( $users == '' ) {
	echo '<script id="prime_redirect_shortcode">window.location = "'. $url .'";</script>';
}

}

