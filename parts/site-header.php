<?php defined( 'ABSPATH' ) || exit;

/**
 *	SITE HEADER
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	Added div.title_wrap & Support Header video @since 1.0.55
 */

global $post;	# @since 1.0.55
$styles	=	ToongeePrime_Styles::mods_cache();	# 1.0.57

$isSingular		=	is_singular();
$title_in_headr	=	( 'header' === $styles->title_place );
$hasHeader		=	has_custom_header();
$menuPlace		=	$styles->menu_place;
$videoActive	=	is_header_video_active();
$keepHeader		=	false === prime2g_remove_header();
$titleOverVideo	=	$styles->titleOnHeader;
$tov_class		=	$titleOverVideo && ( $post && $post->video_url || $videoActive || ! $isSingular ) ?
' title_over_video' : '';


$headerUrl	=	$hasHeader ? prime2g_get_header_image_url( $hasHeader ) : '';	# 1.0.70
$headerBackground	=	$headerUrl ? ' style="background-image:url(' . $headerUrl . ');"' : '';


if ( ! wp_is_mobile() ) {
	prime2g_site_top_menu();	# 1.0.55
	if ( $styles->sticky_menu && $styles->menu_place !== 'fixed' && empty( $styles->menu_type ) )
		prime2g_main_menu( 'sticky_nav', 'sticky_menu_items' );	# 1.0.83
}

prime2g_before_header();

if ( 'bottom' !== $menuPlace ) prime2g_main_menu();


if ( $keepHeader ) {
do_action( 'prime2g_header_top' );	# 1.0.95 ?>
<header id="header" class="site_header prel<?php echo $tov_class; ?>"<?php echo $headerBackground; ?>>

<?php
if ( $hasHeader ) { echo '<div class="shader"></div>'; }

echo '<div class="site_width title_wrap prel grid w100pc">';

do_action( 'prime2g_before_header_title' );	# 1.0.55

	if ( $isSingular && $post->video_url &&
	'replace_header' === get_theme_mod( 'prime2g_video_embed_location' ) ) {
		echo prime2g_get_post_media_embed();
		if ( $titleOverVideo )
			do_action( 'prime2g_page_title_hook', $title_in_headr );
	}
	else if ( $videoActive ) {
		the_custom_header_markup();
		if ( $titleOverVideo )
			do_action( 'prime2g_page_title_hook', $title_in_headr );
	}
	else { do_action( 'prime2g_page_title_hook', $title_in_headr ); }

do_action( 'prime2g_after_header_title' );	# 1.0.55

echo '</div>';
?>

</header>
<?php
do_action( 'prime2g_header_bottom' );	# 1.0.95
}

if ( 'bottom' === $menuPlace ) prime2g_main_menu();

prime2g_sub_header();

if ( $keepHeader ) prime2g_after_header();

