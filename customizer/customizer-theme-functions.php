<?php defined( 'ABSPATH' ) || exit;

/**
 *	Customizer Functions for Theme use
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */


/**
 * Social Media and Contacts
 */
if ( ! function_exists( 'prime2g_theme_mod_social_and_contacts' ) ) {

function prime2g_theme_mod_social_and_contacts() {

$siteName	=	esc_html( get_bloginfo( 'name' ) );
$facebook	=	get_theme_mod( 'prime2g_facebook_url' );
$instagram	=	get_theme_mod( 'prime2g_instagram_url' );
$twitter	=	get_theme_mod( 'prime2g_twitter_url' );
$email		=	get_theme_mod( 'prime2g_contact_email' );
$address	=	get_theme_mod( 'prime2g_contact_address' );
$phone		=	get_theme_mod( 'prime2g_contact_phone' );
$whatsapp	=	get_theme_mod( 'prime2g_whatsapp_number' );
$youTube	=	get_theme_mod( 'prime2g_youtube_url' );
$linkedIn	=	get_theme_mod( 'prime2g_linkedin_url' );

$attrs	=	' target="_blank" rel="noopener noreferrer nofollow" title=';

$contacts	=	'<div class="socials_contacts">';
$contacts	.=	'<div class="links">';

if ( $facebook )
	$contacts .= '<span class="sci fb"><a href="'. $facebook .'"'. $attrs .'"' . __( $siteName . ' on Facebook', 'toongeeprime-theme' ) . '"><span class="dashicons dashicons-facebook"></span></a></span>';
if ( $instagram )
	$contacts .= '<span class="sci ig"><a href="'. $instagram .'"'. $attrs .'"' . __( $siteName . ' on Instagram', 'toongeeprime-theme' ) . '"><span class="dashicons dashicons-instagram"></span></a></span>';
if ( $twitter )
	$contacts .= '<span class="sci tw"><a href="'. $twitter .'"'. $attrs .'"' . __( $siteName . ' on Twitter', 'toongeeprime-theme' ) . '"><span class="dashicons dashicons-twitter"></span></a></span>';
if ( $youTube )
	$contacts .= '<span class="sci yt"><a href="'. $youTube .'"'. $attrs .'"' . __( $siteName . ' on YouTube', 'toongeeprime-theme' ) . '"><span class="dashicons dashicons-youtube"></span></a></span>';
if ( $linkedIn )
	$contacts .= '<span class="sci li"><a href="'. $linkedIn .'"'. $attrs .'"' . __( $siteName . ' on LinkedIn', 'toongeeprime-theme' ) . '"><span class="dashicons dashicons-linkedin"></span></a></span>';
if ( $whatsapp ) {
	$whatsapp	=	'https://wa.me/' . $whatsapp . '?text=Hello,%20I%20want%20to%20chat%20with%20' . $siteName;
	$contacts .= '<span class="sci wa"><a href="'. $whatsapp .'"'. $attrs .'"' . __( 'Chat with us on WhatsApp', 'toongeeprime-theme' ) . '"><span class="dashicons dashicons-whatsapp"></span></a></span>';
}
if ( $email )
	$contacts .= '<span class="sci em"><a href=mailto:"'. $email .'" title="' . __( 'Send us a mail', 'toongeeprime-theme' ) . '"><span class="dashicons dashicons-email"></span></a></span>';
if ( $phone )
	$contacts .= '<span class="sci ph"><a href=tel:"'. $phone .'" title="' . __( 'Call us', 'toongeeprime-theme' ) . '"><span class="dashicons dashicons-phone"></span></a></span>';

$contacts	.=	'</div>';

if ( $address )
	$contacts .= '<span class="address" title="' . __( 'Our Address', 'toongeeprime-theme' ) . '"><span class="dashicons dashicons-building"></span>' . __( $address, 'toongeeprime-theme' ) . '</span>';

$contacts	.=	'</div>';

return $contacts;
}

}



/**
 *	Site's Footer Credit
 */
if ( ! function_exists( 'prime2g_theme_mod_footer_credit' ) ) {

function prime2g_theme_mod_footer_credit() {
$power	=	get_theme_mod( 'prime2g_footer_credit_power' );
$name	=	get_theme_mod( 'prime2g_footer_credit_name' );
$url	=	get_theme_mod( 'prime2g_footer_credit_url' );
$attrs	=	' target="_blank" rel="noopener noreferrer nofollow"';
$cRight	=	' &copy; '. date( 'Y' );

$footerCred	=	'<div class="site_footer_credits">';

	if ( $power ) {
		if( $url && $name ) {
			$footerCred	.=	'<span title="Site Credits">' . $power . ' <a href="' . $url . '"' . $attrs . '>' . $name . '</a> '. $cRight .' </span>';
		}
		elseif ( $name ) {
			$footerCred	.=	'<span title="Site Credits">' . $power . ' ' . $name . $cRight .' </span>';
		}
		else {
			$footerCred	.=	'<span title="Site Credits">' . $power . $cRight .' </span>';
		}
	}
	else {
		$footerCred	.=	'<span id="powered_by_credit" title="Site Credits">Powered by <a href="https://akawey.com/" title="ToongeePrime of Akàwey Online Enterprises" target="_blank" rel="noopener">ToongeePrime Theme</a>.' . $cRight . '</span>';
	}

$footerCred	.=	'</div>';
$footerCred	.=	'<p id="akaweyCredit" style="font-size:70%;text-align:center;padding-bottom:var(--min-pad);">Designed and developed by <a href="https://akawey.com/" title="Visit Akàwey Online Enterprises" target="_blank" rel="noopener">Akàwey Online Enterprises</a>.</p>';

return $footerCred;
}

}



/**
 *	Shop Page's Title
 */
if ( ! function_exists( 'prime2g_theme_mod_shop_title' ) ) {

function prime2g_theme_mod_shop_title( $pre = '<h1 class="page-title">', $post = '</h1>' ) {
$shopTitle	=	get_theme_mod( 'prime2g_shop_page_title' );

	if( $shopTitle ) {
		$title	=	$pre . __( $shopTitle, 'toongeeprime-theme' ) . $post;
	}
	else {
		$title	=	$pre . __( 'Products', 'toongeeprime-theme' ) . $post;
	}

return $title;
}

}


