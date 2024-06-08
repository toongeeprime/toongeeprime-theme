<?php defined( 'ABSPATH' ) || exit;
/**
 *	ARCHIVES' - DEFAULT TEMPLATE
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	@since 1.0.55: Video & Columns logic
 *	@since 1.0.94: Masonry Layout for Child >= 2.4
 */
get_header();

$cols		=	get_theme_mod( 'prime2g_archive_post_columns_num' );
$masonry	=	! empty( get_theme_mod( 'prime2g_archive_masonry_layout' ) );
$masonry_class	=	$masonry ? ' masonry' : '';
$excerpt	=	$masonry ? false : true;
$switchFtImageVideo	=	( get_theme_mod( 'prime2g_enable_video_features' ) && get_theme_mod( 'prime2g_replace_ftimage_with_video' ) );

$options	=	[
	'excerpt'	=>	$excerpt,
	'switch_img_vid'	=>	$switchFtImageVideo,
	'ftimage_as_image'	=>	$masonry
];

echo '<section id="archive_loop" class="posts_loop grid '. $cols . $masonry_class .' prel">';

	#	Run posts loop
	while ( have_posts() ) {
		the_post();
		echo prime2g_get_archive_loop_post_object( $options );
	}

echo '</section>';

	#	Prev/next page navigation
	prime2g_prev_next();

get_footer();
