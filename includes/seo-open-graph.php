<?php defined( 'ABSPATH' ) || exit;
/**
 *	THEME SEO & OPEN GRAPH WORKINGS
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.81
 */

if ( ! function_exists( 'prime_seo_meta_tags_setter' ) ) {

add_action( 'wp_head', 'prime_seo_meta_tags_setter', 1 );
function prime_seo_meta_tags_setter() {

if ( is_admin() || ! ToongeePrime_Styles::mods_cache()->theme_seo ) return;

$url		=	prime2g_get_current_url();
$siteIcon	=	get_site_icon_url();
$sitename	=	get_bloginfo( 'name' );
$is_singular=	is_singular();
$type		=	'website';
$excerpt_length	=	30;

$extra_tags	=	$section = $title = $post_tags_og_array = $og_video = $tags = $p_date = $post_twitters = '';
$image		=	$siteIcon;

if ( $is_singular ) {

$title	=	$descr	=	$fName	=	$lName	=	'';
$type	=	'article';

if ( has_post_format( [ 'image', 'video' ] ) ) {
	$type	=	get_post_format();
}

global $post;

$author	=	get_user_by( 'ID', $post->post_author );
$title	=	$post->post_title;
$descr	=	wp_trim_words( get_the_excerpt( $post ), $excerpt_length, '' );
$thumb	=	get_the_post_thumbnail_url( $post );
$image	=	$thumb ?: $siteIcon;
$p_date	=	'<meta property="article:published_time" content="'. get_the_date( 'c' ) .'" />
';

$tags	.=	'<meta name="author" content="'. $author->display_name .'" />
';

$read_time	=	$post->post_type === 'post' ? '
<meta name="twitter:label2" content="Est. reading time" />
<meta name="twitter:data2" content="'. prime2g_estimated_reading_time( [ 'echo'=>false, 'plain'=>true ] ) .'" />' : '';

$post_twitters	.=	'<meta name="twitter:label1" content="Written by" />
<meta name="twitter:data1" content="'. $author->display_name .'" />'. $read_time .'
';

$postTaxs	=	get_post_taxonomies( $post );
if ( $postTaxs ) {
	if ( class_exists( 'woocommerce' ) && is_product() ) {
		$taxon	=	$postTaxs[2] ?: '';
	}
	else {
		if ( isset( $postTaxs[1] ) && $postTaxs[1] === 'post_format' ) {
			$taxon	=	$postTaxs[2] ?: '';
		}
		elseif ( $postTaxs[0] === 'post_tag' ) {
			$taxon	=	$postTaxs[1] ?: '';
		}
		else {
			$taxon	=	$postTaxs[0] ?: '';
		}
	}

	$page_terms		=	wp_get_post_terms( $post->ID, $taxon ) ?: null;
	$section		=	$page_terms ? $page_terms[0] : null;	// get the first term
}

if ( $section ) {
$tags	.=	'<meta property="article:section" content="'. $section->name .'" />
';
}

$og_video	=	$post->video_url ? '<meta property="og:video" content="'. $post->video_url .'" />
' : '';

$posttags	=	get_the_tags();
if ( $posttags ) {
foreach ( $posttags as $tag ) {
	$post_tags_array[]	=	'<meta property="article:tag" content="'. $tag->name .'" />
'; 
}

$post_tags_og_array	=	implode( '', $post_tags_array );
}

}
else {

	if ( is_archive() ) {
		$descr	=	wp_trim_words( get_the_archive_description(), $excerpt_length, '' );
		$image	=	prime2g_get_term_archive_image_url( 'large' );
		$title	=	is_author() ? __( get_the_author() . '\'s Posts', PRIME2G_TEXTDOM ) : get_the_archive_title();
	}
	else {
		$descr	=	wp_trim_words( get_bloginfo( 'description' ), $excerpt_length, '' );
		$headerImg	=	get_header_image();
		$image	=	$headerImg ?: $siteIcon;
		$title	=	$sitename;
	}

}


$tags	.=
'<meta property="og:title" content="'. $title .'" />
<meta property="og:site_name" content="'. $sitename .'" />
<meta property="og:type" content="'. $type .'" />
<meta property="og:image" content="'. $image .'" />
';

$tags	.=	$descr ? '<meta property="og:description" content="'. $descr .'" />
' : '';

$tags	.=	'<meta property="og:url" content="'. $url .'" />
<meta property="og:locale" content="'. get_locale() .'" />
';

$tags	.=	$p_date . $og_video;

#	Twitter
/**	
 *	Reviewed @since 1.0.89
 *	NOTE: Twitter falls back to og where they have similar name/property parameters
 *	=== title, description, url, image
 *	@https://developer.x.com/en/docs/twitter-for-websites/cards/guides/getting-started
 */

$tags	.=	'<meta name="twitter:card" content="summary" />
';

#	To Do's:
#	<meta property="article:author" content="https://facebook.com/author-FB-profile-url" />
#	<meta property="article:publisher" content="https://facebook.com/author-FB-page-url" />
#	<meta property="og:audio" content="'. $audio_url .'" />
#	music,video,book etc: https://ogp.me/ == <meta property="og:type" content="book" />
#	<meta name="twitter:site" content="@x_siteusername" />
#	<meta name="twitter:creator" content="@x_authorusername" />
#	<meta name="twitter:card" content="summary_large_image" /> @https://developer.x.com/en/docs/twitter-for-websites/cards/overview/summary-card-with-large-image

echo	'
<!-- Meta tags by ToongeePrime Theme -->
'. $tags . $post_twitters . $post_tags_og_array .'<!-- /Meta tags by ToongeePrime Theme -->

';
}

}


