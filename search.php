<?php defined( 'ABSPATH' ) || exit;

/**
 *	SEARCH RESULTS PAGE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( ! function_exists( 'define_2gRMVSidebar' ) ) prime2g_removeSidebar();

get_header();

if ( have_posts() ) { ?>
	<div class="search_result_count">
	<?php
		$found	=	(int) $wp_query->found_posts;

		printf(
			esc_html(
				/* translators: %d: The number of search results. */
				_n(
					'We found %d result for your search.',
					'We found %d results for your search.',
					$found,
					PRIME2G_TEXTDOM
				)
			),
			$found
		);
	?>
	</div>
	<?php

	prime2g_wp_block_search_form();

	// Start the Loop
	while ( have_posts() ) {

		the_post();
		prime2g_search_loop();

	}

	// Prev/next page navigation
	prime2g_prev_next();

}
else {

	echo '<h3 style="text-align:center;margin:90px 30px;">' . __( 'No results found for your search', PRIME2G_TEXTDOM ) . '</h3>';
	prime2g_wp_block_search_form();

}

prime2g_below_posts_widgets();

get_footer();

