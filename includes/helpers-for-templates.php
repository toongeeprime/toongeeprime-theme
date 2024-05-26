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
 *	Get Term Image Url
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



/**
 *	@since 1.0.89
 */
function prime2g_remove_header(): bool {
$remove	=	false;

if ( is_singular() ) {
global $post;

if ( in_array( $post->remove_header, [ 'remove', 'header_image_css' ] ) ) $remove	=	true;

if ( class_exists( 'WooCommerce' ) && is_product()
	&& get_theme_mod( 'prime2g_remove_header_in_products', 0 ) ) $remove	=	true;
}

//	@since 1.0.90
if ( defined( 'PRIME2G_ALT_POST_OBJ' ) ) {
	if ( in_array( PRIME2G_ALT_POST_OBJ->remove_header, [ 'remove', 'header_image_css' ] ) ) $remove	=	true;
}

if ( function_exists( 'prime_child_remove_header' ) ) $remove	=	prime_child_remove_header(); // bool

return $remove;
}



/**
 *	@since 1.0.90
 */
function prime2g_remove_sidebar(): bool {
$remove	=	false;

if ( function_exists( 'define_2gRMVSidebar' ) ) return true;

if ( defined( 'PRIME2G_ALT_POST_OBJ' ) ) $remove	=	PRIME2G_ALT_POST_OBJ->remove_sidebar === 'remove';

if ( function_exists( 'prime_child_remove_sidebar' ) ) $remove	=	prime_child_remove_sidebar(); // bool

return $remove;
}



function prime2g_is_plain_page_template(): bool {
$plain	=	false;

if ( function_exists( 'define_2gPlainPage' ) ) return true;

if ( defined( 'PRIME2G_ALT_POST_OBJ' ) )
	$plain	=	get_post_meta( PRIME2G_ALT_POST_OBJ->ID, '_wp_page_template', true ) === 'templates/empty-page.php';

if ( function_exists( 'prime_child_is_plain_page_template' ) ) $plain	=	prime_child_is_plain_page_template(); // bool

return $plain;
}



function prime2g_remove_footer(): bool {
if ( ! prime_child_min_version( '2.4' ) ) return false;
$remove	=	false;

if ( is_singular() ) {
global $post;

$remove	=	$post->remove_footer === 'remove';
}

if ( defined( 'PRIME2G_ALT_POST_OBJ' ) ) $remove	=	PRIME2G_ALT_POST_OBJ->remove_footer === 'remove';

if ( function_exists( 'prime_child_remove_footer' ) ) $remove	=	prime_child_remove_footer(); // bool

return $remove;
}



