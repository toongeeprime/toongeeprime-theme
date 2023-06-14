<?php defined( 'ABSPATH' ) || exit;

/**
 *	GET TAXONOMY IMAGE URL
 *
 *	@since ToongeePrime Theme 1.0.45
 */

if ( ! function_exists( 'prime2g_taxonomies_with_archive_image' ) ) {
function prime2g_taxonomies_with_archive_image() {
	return [ 'post_tag', 'category' ];
}
}


/**
 *	Get Term Image Url: in archive page
 *	Use in archive page templates to reduce querying by this much
 */
if ( ! function_exists( 'prime2g_get_term_archive_image_url' ) ) {
function prime2g_get_term_archive_image_url( $size = 'large' ) {
/**
 *	For Category
	$categ	=	get_category( get_query_var( 'cat' ) );
	$termID	=	$categ->cat_ID;
 */
if ( ! prime2g_use_extras() ) {
	return get_header_image();
}

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
 *	Get Term Image Url: in a template
 */
if ( ! function_exists( 'prime2g_get_term_image_url' ) ) {
function prime2g_get_term_image_url( $termID, $size = 'large' ) {
if ( ! prime2g_use_extras() ) {
	return get_header_image();
}

	$image_id	=	get_term_meta( $termID, 'thumbnail_id', true );
	$imageUrl	=	wp_get_attachment_image_url( $image_id, $size );
	if ( $imageUrl )
		return $imageUrl;
	else
		return get_header_image();
}
}

