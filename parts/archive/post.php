<?php defined( 'ABSPATH' ) || exit;

/**
 *	ARCHIVES' - DEFAULT TEMPLATE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

get_header();

echo '<section id="archive_loop" class="grid prel">';

	// Load posts loop
	while ( have_posts() ) {

		the_post();

		prime2g_archive_loop();

	}

echo '</section>';

	// Prev/next page navigation
	prime2g_prev_next();

get_footer();
