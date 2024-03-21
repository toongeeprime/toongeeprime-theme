<?php defined( 'ABSPATH' ) || exit;

/**
 *	DO THINGS FOR TEMPLATES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.70
 */

function prime2g_get_header_image_url( bool $hasHeader = false, $size = 'large' ) {

$headerUrl	=	$hasHeader ?: has_custom_header();

if ( $hasHeader ) {
	if ( is_singular() && has_post_thumbnail() && ( '' === get_theme_mod( 'prime2g_thumb_replace_header', '' ) ) ) {
		$headerUrl	=	get_the_post_thumbnail_url( get_the_ID(), $size );
	}
	elseif ( is_category() || is_tag() || is_tax() ) {
		$headerUrl	=	prime2g_get_term_archive_image_url( $size );
	}
	else {
		$headerUrl	=	get_header_image();
	}
}
return $headerUrl;
}



/***		Moved here @since 1.0.77	***/
/**
 *	Get Term Image Url: in archive page
 */
if ( ! function_exists( 'prime2g_get_term_archive_image_url' ) ) {
function prime2g_get_term_archive_image_url( $size = 'large' ) {
/**
 *	For Category
	$categ	=	get_category( get_query_var( 'cat' ) );
	$termID	=	$categ->cat_ID;
 */
if ( ! prime2g_use_extras() )
	return get_header_image();

	$termID		=	get_queried_object_id();
	$image_id	=	get_term_meta( $termID, 'thumbnail_id', true );
	$imageUrl	=	wp_get_attachment_image_url( $image_id, $size );
	if ( $imageUrl )
		return $imageUrl;
	else
		return get_header_image();
}
}

/**
 *	Get Term Image Url: in a loop
 */
if ( ! function_exists( 'prime2g_get_term_image_url' ) ) {
function prime2g_get_term_image_url( $termID, $size = 'large' ) {
if ( ! prime2g_use_extras() )
	return get_header_image();

	$image_id	=	get_term_meta( $termID, 'thumbnail_id', true );
	$imageUrl	=	wp_get_attachment_image_url( $image_id, $size );
	if ( $imageUrl )
		return $imageUrl;
	else
		return get_header_image();
}
}
