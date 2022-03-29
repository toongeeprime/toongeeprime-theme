<?php defined( 'ABSPATH' ) || exit;

/**
 *	ARCHIVES' - DEFAULT TEMPLATE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

get_header();

	// Load posts loop
	while ( have_posts() ) {

		the_post();

		prime2g_archive_loop();

	}

	// Prev/next page navigation
	prime2g_prev_next();

get_footer();
