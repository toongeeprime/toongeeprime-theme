<?php defined( 'ABSPATH' ) || exit;

/**
 *	RENDER SITE PARTS
 *
 *	Extract of parts/site-header.php
 *	@since ToongeePrime Theme 1.0.55
 */

global $post;

#	Excludes menus for customizer preview rendering
if ( ! function_exists( 'prime2g_render_header' ) ) {

function prime2g_render_header() {

$title_in_headr	=	( 'header' == get_theme_mod( 'prime2g_title_location' ) );
$hasHeader		=	has_custom_header();
$pid			=	get_the_ID();
$isSingular		=	is_singular();
$keepHeader		=	$isSingular ? ( $post->remove_header !== 'remove' ) : true;

$headerBackground	=	'';

if ( $hasHeader ) {

	if ( $isSingular && has_post_thumbnail() && ( '' == get_theme_mod( 'prime2g_thumb_replace_header' ) ) ) {
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

if ( ! $isSingular || $isSingular && $keepHeader ) { ?>

<header id="header" class="site_header prel" <?php echo $headerBackground; ?>>

<?php
	if ( $hasHeader ) {
		echo '<div class="shader"></div>';
	}

	echo '<div class="site_width title_wrap grid prel">';

if ( $isSingular && $post->video_url &&
( 'replace_header' === get_theme_mod( 'prime2g_video_embed_location' ) ) ) {
	echo prime2g_get_post_media_embed();
}
elseif ( has_header_video() && is_header_video_active() ) { the_custom_header_markup(); }
else { do_action( 'prime2g_page_title_hook', $title_in_headr ); }

	echo '</div>';
?>

</header>

<?php
}

}

}
