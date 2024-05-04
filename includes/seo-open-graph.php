<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME SEO & OPEN GRAPH WORKINGS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.81
 */

if ( ! function_exists( 'prime_seo_meta_tags_setter' ) ) {

add_action( 'wp_head', 'prime_seo_meta_tags_setter', 1 );
function prime_seo_meta_tags_setter() {

if ( ! ToongeePrime_Styles::mods_cache()->theme_seo ) return;

$url		=	prime2g_get_current_url();
$siteIcon	=	get_site_icon_url();

$sitename	=	get_bloginfo( 'name' );
$type		=	'website';
$excerpt_length	=	30;
$extra_tags	=	$section = $title = $post_tags_og_array = $video_url = '';
$image		=	$siteIcon;


if ( is_singular() ) {

$title	=	$descr	=	$fName	=	$lName	=	'';
$type	=	'article';

if ( has_post_format( [ 'image', 'video' ] ) ) {
	$type	=	get_post_format();
}

global $post;

$title	=	$post->post_title;
$descr	=	wp_trim_words( get_the_excerpt( $post ), $excerpt_length, '' );
$thumb	=	get_the_post_thumbnail_url( $post );
$image	=	$thumb ?: $siteIcon;


$postTaxs	=	get_post_taxonomies( $post );
if ( $postTaxs ) {
	if ( class_exists( 'woocommerce' ) && is_product() ) {
		$taxon	=	$postTaxs[2];
	}
	else {
		if ( $postTaxs[1] === 'post_format' ) {
			$taxon	=	$postTaxs[2];
		}
		elseif ( $postTaxs[0] === 'post_tag' ) {
			$taxon	=	$postTaxs[1];
		}
		else {
			$taxon	=	$postTaxs[0];
		}
	}

	$section		=	wp_get_post_terms( $post->ID, $taxon )[0];	// gets the first term
}


if ( $section ) {
$author		=	get_user_by( 'ID', $post->post_author );
$extra_tags	=	'<meta property="article:author" content="'. $author->display_name .'" />
<meta property="article:section" content="'. $section->name .'" />';
}

$video_url	=	$post->video_url ? '<meta property="og:video" content="'. $post->video_url .'" />' : '';

#	<meta property="og:audio" content="'. $audio_url .'" />
#	music,video,book etc: https://ogp.me/ == <meta property="og:type" content="book" />

$posttags	=	get_the_tags();
if ( $posttags ) {
foreach ( $posttags as $tag ) {
	$post_tags_array[]	=	'<meta property="article:tag" content="'. $tag->name .'" />'; 
}

$post_tags_og_array	=	implode( '', $post_tags_array );
}

}
else {

	if ( is_archive() ) {

		$descr	=	wp_trim_words( get_the_archive_description(), $excerpt_length, '' );
		$image	=	prime2g_get_term_archive_image_url( 'full' );
		$title	=	get_the_archive_title();

	}
	else {

		$descr	=	wp_trim_words( get_bloginfo( 'description' ), $excerpt_length, '' );
		$headerImg	=	get_header_image();
		$image	=	$headerImg ? $headerImg : $siteIcon;
		$title	=	$sitename;

	}

}


$tags	=
'<meta property="og:title" content="'. $title .'" />
<meta property="og:site_name" content="'. $sitename .'" />
<meta property="og:type" content="'. $type .'" />
<meta property="og:image" content="'. $image .'" />';

$tags	.=	$descr ? '<meta property="og:description" content="'. $descr .'" />' : '';

$tags	.=	'
<meta property="og:url" content="'. $url .'" />
<meta property="og:locale" content="'. get_locale() .'" />';

$tags	.=	$extra_tags . $video_url;

#	Twitter

$tags	.=
// '<meta name="twitter:text:title" content="'. $title .'" />
// '<meta name="twitter:text:card" content="'. $aReallyCoolImage .'" />
'<meta name="twitter:title" content="'. $title .'" />
<meta name="twitter:url" content="'. $url .'" />
<meta name="twitter:image" content="'. $image .'" />
<meta name="twitter:card" content="summary" />';

$tags	.=	$descr ? '<meta property="twitter:description" content="'. $descr .'" />' : '';

echo	'<!-- Meta tags by ToongeePrime Theme -->' . $tags . $post_tags_og_array . '<!-- /Meta tags by ToongeePrime Theme -->';
}


}


