<?php defined( 'ABSPATH' ) || exit;

/**
 *	ARCHIVES' - DEFAULT TEMPLATE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	Added Video & Columns logic @since ToongeePrime Theme 1.0.55
 */

get_header();

$cols	=	get_theme_mod( 'prime2g_archive_post_columns_num' );
$switchFtImageVideo	=	( get_theme_mod( 'prime2g_enable_video_features' ) && get_theme_mod( 'prime2g_replace_ftimage_with_video' ) );

$options	=	[
	'switch_img_vid' => $switchFtImageVideo
];

echo '<section id="archive_loop" class="posts_loop grid '. $cols .' prel">';

	# Load posts loop
	while ( have_posts() ) {

		the_post();

	echo prime2g_get_archive_loop_post_object( $options );

	}

echo '</section>';

	# Prev/next page navigation
	prime2g_prev_next();

get_footer();
