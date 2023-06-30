<?php defined( 'ABSPATH' ) || exit;

/**
 *	Template Name: Empty Page (No Theme Widgets)
 *	Template Post Type: post, page
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */
prime2g_removeSidebar();
prime2g_remove_title();
prime2g_is_plain_page();


get_header();

	the_post();

	# Hook: includes page CSS
	prime2g_before_post();

	the_content();

	prime2g_link_pages();

	# Hook: includes page JS
	prime2g_after_post();

get_footer();
