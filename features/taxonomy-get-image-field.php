<?php defined( 'ABSPATH' ) || exit;

/**
 *	GET TAXONOMY IMAGE URL
 *
 *	@since ToongeePrime Theme 1.0.45.00
 */

if ( ! function_exists( 'prime2g_taxonomies_with_archive_image' ) ) {
function prime2g_taxonomies_with_archive_image() {
		return [ 'post_tag', 'category' ];
	}
}


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
	$termID	=	get_queried_object_id();
	$image_id	=	get_term_meta( $termID, 'thumbnail_id', true );
	return wp_get_attachment_image_url( $image_id, $size );
}
}


/**
 *	Get Term Image Url: in a template
 */
if ( ! function_exists( 'prime2g_get_term_image_url' ) ) {
function prime2g_get_term_image_url( $termID, $size = 'large' ) {
	$image_id	=	get_term_meta( $termID, 'thumbnail_id', true );
	return wp_get_attachment_image_url( $image_id, $size );
}
}

