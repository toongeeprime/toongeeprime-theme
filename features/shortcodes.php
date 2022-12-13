<?php defined( 'ABSPATH' ) || exit;

/**
 *	MINI THEME FEATURES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.49.00
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
 *	Get a Template Part
 */
add_shortcode( 'prime2g_add_template_part', 'prime2g_add_template_part_shortcode' );
function prime2g_add_template_part_shortcode( $atts ) {
$atts	=	shortcode_atts( array( 'slug'	=>	'hello', 'section'	=>	'header' ), $atts );
extract( $atts );

$part	=	prime2g_add_template_part( $slug, $section, false );

if ( ! $part ) {
	return __( 'Requested Template Part Does Not Exist', PRIME2G_TEXTDOM );
}

return $part;

}


