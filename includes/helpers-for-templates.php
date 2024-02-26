<?php defined( 'ABSPATH' ) || exit;

/**
 *	DO THINGS FOR TEMPLATES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.70
 */

function prime2g_get_header_image_url( bool $hasHeader = false ) {

$headerUrl	=	$hasHeader ?: has_custom_header();

if ( $hasHeader ) {
	if ( is_singular() && has_post_thumbnail() && ( '' === get_theme_mod( 'prime2g_thumb_replace_header', '' ) ) ) {
		$headerUrl	=	get_the_post_thumbnail_url( get_the_ID(), 'full' );
	}
	elseif ( is_category() || is_tag() || is_tax() ) {
		$headerUrl	=	prime2g_get_term_archive_image_url( 'full' );
	}
	else {
		$headerUrl	=	get_header_image();
	}
}

return $headerUrl;
}

