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

function prime2g_theme_mod_social_and_contacts( $incAddress = true ) {
/**
 *	@since ToongeePrime Theme 1.0.55
 */
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
$tiktok		=	get_theme_mod( 'prime2g_tiktok_url' );
$telegram	=	get_theme_mod( 'prime2g_telegram_url' );

$attrs	=	' target="_blank" rel="noopener noreferrer nofollow" title=';

$contacts	=	'<div class="socials_contacts">';
$contacts	.=	'<div class="links">';

if ( $facebook )
	$contacts .= '<span class="sci fb"><a href="'. $facebook .'"'. $attrs .'"' . __( $siteName . ' on Facebook', PRIME2G_TEXTDOM ) . '"><i class="bi bi-facebook"></i></a></span>';
if ( $instagram )
	$contacts .= '<span class="sci ig"><a href="'. $instagram .'"'. $attrs .'"' . __( $siteName . ' on Instagram', PRIME2G_TEXTDOM ) . '"><i class="bi bi-instagram"></i></a></span>';
if ( $twitter )
	$contacts .= '<span class="sci tw"><a href="'. $twitter .'"'. $attrs .'"' . __( $siteName . ' on Twitter', PRIME2G_TEXTDOM ) . '"><i class="bi bi-twitter"></i></a></span>';
if ( $youTube )
	$contacts .= '<span class="sci yt"><a href="'. $youTube .'"'. $attrs .'"' . __( $siteName . ' on YouTube', PRIME2G_TEXTDOM ) . '"><i class="bi bi-youtube"></i></a></span>';
if ( $linkedIn )
	$contacts .= '<span class="sci li"><a href="'. $linkedIn .'"'. $attrs .'"' . __( $siteName . ' on LinkedIn', PRIME2G_TEXTDOM ) . '"><i class="bi bi-linkedin"></i></a></span>';
if ( $tiktok )
	$contacts .= '<span class="sci tt"><a href="'. $tiktok .'"'. $attrs .'"' . __( $siteName . ' on TikTok', PRIME2G_TEXTDOM ) . '"><i class="bi bi-tiktok"></i></a></span>';
if ( $telegram )
	$contacts .= '<span class="sci tg"><a href="'. $telegram .'"'. $attrs .'"' . __( $siteName . ' on Telegram', PRIME2G_TEXTDOM ) . '"><i class="bi bi-telegram"></i></a></span>';
if ( $email )
	$contacts .= '<span class="sci em"><a href="mailto:'. $email .'" title="' . __( 'Send us a mail', PRIME2G_TEXTDOM ) . '"><i class="bi bi-envelope"></i></a></span>';
if ( $whatsapp ) {
	$whatsapp	=	'https://wa.me/' . $whatsapp . '?text=Hello,%20I%20want%20to%20chat%20with%20' . $siteName;
	$contacts .= '<span class="sci wa"><a href="'. $whatsapp .'"'. $attrs .'"' . __( 'Chat with us on WhatsApp', PRIME2G_TEXTDOM ) . '"><i class="bi bi-whatsapp"></i></a></span>';
}
if ( $phone )
	$contacts .= '<span class="sci ph"><a href="tel:+'. $phone .'" title="' . __( 'Call us', PRIME2G_TEXTDOM ) . '"><i class="bi bi-telephone"></i></a></span>';

$contacts	.=	'</div>';

if ( $address && $incAddress )
	$contacts .= '<span class="address" title="' . __( 'Our Address', PRIME2G_TEXTDOM ) . '"><i class="bi bi-building"></i><span class="contactAddress">' . __( $address, PRIME2G_TEXTDOM ) . '</span></span>';

$contacts	.=	'</div>';

return $contacts;
}

}



/**
 *	Site's Footer Credit
 */
if ( ! function_exists( 'prime2g_theme_mod_footer_credit' ) ) {

function prime2g_theme_mod_footer_credit() {

$footerCred	=	'';

if ( get_theme_mod( 'prime2g_theme_add_footer_credits', '1' ) ) {
	$footerCred	.=	prime2g_theme_footer_credit();
}

$footerCred	.=	'<p id="akaweyCredit" style="font-size:70%;text-align:center;padding-bottom:var(--min-pad);margin:0;">Designed and developed by <a href="https://akawey.com/" title="Visit Akàwey Online Enterprises" target="_blank" rel="noopener">Akàwey Online Enterprises</a>.</p>';

return $footerCred;
}

}


/**
 *	Split from prime2g_theme_mod_footer_credit() for Customizer control & shortcode
 *	@since ToongeePrime Theme 1.0.55
 */
if ( ! function_exists( 'prime2g_theme_footer_credit' ) ) {

function prime2g_theme_footer_credit() {

$power	=	get_theme_mod( 'prime2g_footer_credit_power', 'Powered by' );
$name	=	get_theme_mod( 'prime2g_footer_credit_name', 'ToongeePrime Theme' );
$url	=	get_theme_mod( 'prime2g_footer_credit_url', 'https://akawey.com/' );
$append	=	get_theme_mod( 'prime2g_footer_credit_append', '' ); # @since ToongeePrime Theme 1.0.48.50

$attrs	=	' target="_blank" rel="noopener noreferrer nofollow"';
$cRight	=	'<span id="copyright_date"> &copy; ' . date( 'Y' ) . '.</span> ';

$footerCred	=	'<div class="site_footer_credits">';

	if ( $name ) {
		if( $url && $name ) {
			$footerCred	.=	'<span title="Site Credits"><span class="power">' . $power . '</span> <a href="' . $url . '"' . $attrs . '>' . $name . '</a> '. $cRight .'</span>';
		}
		elseif ( $name ) {
			$footerCred	.=	'<span title="Site Credits"><span class="power">' . $power . '</span> ' . $name . $cRight .'</span>';
		}
		else {
			$footerCred	.=	'<span title="Site Credits"><span class="power">' . $power . '</span>' . $cRight .'</span>';
		}
	}
	else {
		$footerCred	.=	'<span id="powered_by_credit" title="Site Credits">Powered by <a href="https://akawey.com/" title="ToongeePrime of Akàwey Online Enterprises" target="_blank" rel="noopener">ToongeePrime Theme</a>.' . $cRight . '</span>';
	}

	$footerCred	.=	'<span id="appended_credit" title="Site Credits">';
	if ( '' !== $append ) { $footerCred	.=	$append; }
	$footerCred	.=	'</span>';

$footerCred	.=	'</div>';

return $footerCred;
}

}



/**
 *	Shop Page's Title
 */
if ( ! function_exists( 'prime2g_theme_mod_shop_title' ) ) {

function prime2g_theme_mod_shop_title( $pre = '<h1 class="page-title">', $post = '</h1>' ) {
$shopTitle	=	get_theme_mod( 'prime2g_shop_page_title' );

	if ( $shopTitle ) {
		$title	=	$pre . __( $shopTitle, PRIME2G_TEXTDOM ) . $post;
	}
	else {
		$title	=	$pre . __( 'Products', PRIME2G_TEXTDOM ) . $post;
	}

return $title;
}

}

