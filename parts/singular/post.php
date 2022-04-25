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

		wp_link_pages(
			array(
				'before'	=>	'<div id="page_parts" class="page_parts clear"><p>Parts:',
				'after'		=>	'</p></div>',
				'link_before'	=>	' Part ',
				// 'separator'		=>	'>> ',
			)
		);

		// Hook:
		prime2g_after_post();

get_footer();
