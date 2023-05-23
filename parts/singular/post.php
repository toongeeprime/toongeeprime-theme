<?php defined( 'ABSPATH' ) || exit;

/**
 *	SINGLE POSTS & DEFAULT SINGULAR TEMPLATE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

get_header();

	the_post();

	// Hook:
	prime2g_before_post();

	the_content();

	prime2g_link_pages();

	// Hook:
	prime2g_after_post();

get_footer();
