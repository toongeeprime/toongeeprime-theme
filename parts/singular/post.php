<?php defined( 'ABSPATH' ) || exit;

/**
 *	SINGULAR POSTS & DEFAULT TEMPLATE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( get_post_meta( get_the_ID(), 'remove_sidebar', true ) == 'remove' ) prime2g_removeSidebar();

get_header();

		the_post();

		// Hook:
		prime2g_before_post();

		the_content();

		// Hook:
		prime2g_after_post();

get_footer();
