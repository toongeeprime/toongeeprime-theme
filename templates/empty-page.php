<?php defined( 'ABSPATH' ) || exit;

/**
 *	Template Name: No In-Content Widgets
 *	Template Post Type: post, page
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

define( 'PRIME2G_NOWIDGETS', true );	// @since 1.0.96

get_header();

	the_post();

	# Hook: includes page CSS
	prime2g_before_post();

	the_content();

	prime2g_link_pages();

	# Hook: includes page JS
	prime2g_after_post();

get_footer();

