<?php defined( 'ABSPATH' ) || exit;

/**
 *	ARCHIVES' - DEFAULT TEMPLATE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

get_header();

$switchFtImageVideo	=	( get_theme_mod( 'prime2g_enable_video_features' ) && get_theme_mod( 'prime2g_replace_ftimage_with_video' ) );

$options	=	[
	'switch_img_vid' => $switchFtImageVideo
];

echo '<section id="archive_loop" class="grid prel">';

	// Load posts loop
	while ( have_posts() ) {

		the_post();

	echo prime2g_get_archive_loop_post_object( $options );

	}

echo '</section>';

	// Prev/next page navigation
	prime2g_prev_next();

get_footer();
