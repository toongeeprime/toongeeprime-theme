<?php defined( 'ABSPATH' ) || exit;

/**
 *	SITE HEADER
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	Added div.title_wrap &&
 *	Support Header video @since ToongeePrime Theme 1.0.55
 */

global $post;	# 1.0.55

$title_in_headr	=	( 'header' == get_theme_mod( 'prime2g_title_location' ) );
$hasHeader		=	has_custom_header();
$menuPlace		=	get_theme_mod( 'prime2g_menu_position' );
$videoActive	=	is_header_video_active();
$pid			=	get_the_ID();
$isSingular		=	is_singular();
$keepHeader		=	$isSingular ? ( $post->remove_header !== 'remove' ) : true;

$titleOverVideo	=	get_theme_mod( 'prime2g_pagetitle_over_headervideo' );
$tov_class	=	( $titleOverVideo && ( $post->video_url || $videoActive || ! $isSingular ) ) ?
' title_over_video' : '';

$headerBackground	=	'';

if ( $hasHeader ) {

	if ( $isSingular && has_post_thumbnail() && ( '' === get_theme_mod( 'prime2g_thumb_replace_header' ) ) ) {
		$headerUrl	=	get_the_post_thumbnail_url( $pid, 'full' );
	}
	elseif ( is_category() || is_tag() || is_tax() ) {
		$headerUrl	=	prime2g_get_term_archive_image_url( 'full' );
	}
	else {
		$headerUrl	=	get_header_image();
	}

$headerBackground	=	'style="background-image:url(' . $headerUrl . ');"';
}


if ( ! wp_is_mobile() ) prime2g_site_top_menu(); # @since ToongeePrime Theme 1.0.55

prime2g_before_header();

if ( 'bottom' !== $menuPlace ) prime2g_main_menu();


if ( ! $isSingular || $isSingular && $keepHeader ) { ?>

<header id="header" class="site_header prel<?php echo $tov_class; ?>" <?php echo $headerBackground; ?>>

<?php
if ( $hasHeader ) { echo '<div class="shader"></div>'; }

echo '<div class="site_width title_wrap grid prel">';


do_action( 'prime2g_before_header_title' );	# @since ToongeePrime Theme 1.0.55


	if ( $isSingular && $post->video_url &&
	( 'replace_header' === get_theme_mod( 'prime2g_video_embed_location' ) ) ) {
		echo prime2g_get_post_media_embed();
		if ( $titleOverVideo )
			do_action( 'prime2g_page_title_hook', $title_in_headr );
	}
	elseif ( has_header_video() && $videoActive ) {
		the_custom_header_markup();
		if ( $titleOverVideo )
			do_action( 'prime2g_page_title_hook', $title_in_headr );
	}
	else { do_action( 'prime2g_page_title_hook', $title_in_headr ); }


do_action( 'prime2g_after_header_title' );	# @since ToongeePrime Theme 1.0.55


echo '</div>';
?>

</header>

<?php
}

if ( 'bottom' === $menuPlace ) prime2g_main_menu();

prime2g_sub_header();

if ( $keepHeader ) { prime2g_after_header(); }

