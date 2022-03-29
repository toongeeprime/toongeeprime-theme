<?php defined( 'ABSPATH' ) || exit;

/**
 *	404 ERROR PAGE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

prime2g_removeSidebar();

get_header();


echo '<section class="nothing_found_div">';

echo '<p class="nothing_found_info">'. esc_html__( 'Maybe try a search?', 'toongeeprime-theme' ) . '</p>';

get_search_form();

echo '</section>';


prime2g_below_posts_widgets();

get_footer();

