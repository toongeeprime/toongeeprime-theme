<?php defined( 'ABSPATH' ) || exit;
/**
 *	Template Name: Content ONLY
 *	Template Post Type: post, page, landing_page
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.96
 */

define( 'PRIME2G_NOHEADER', true );
define( 'PRIME2G_NOSIDEBAR', true );
define( 'PRIME2G_NOWIDGETS', true );
define( 'PRIME2G_NOFOOTER', true );

get_header();

	the_post();

	# Hook: includes page CSS
	prime2g_before_post();

	the_content();

	prime2g_link_pages();

	# Hook: includes page JS
	prime2g_after_post();

get_footer();
