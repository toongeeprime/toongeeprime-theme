<?php defined( 'ABSPATH' ) || exit;

/**
 *	ARCHIVES' - EMPTY TEMPLATE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( ! function_exists( 'define_2gRMVSidebar' ) ) prime2g_removeSidebar();

get_header();


	echo '<div style="text-align:center;margin:90px 30px;">';
	echo '<h3>Sorry, nothing to display here!</h3>';

	if ( current_user_can( 'edit_posts' ) ) {
		echo '<p><a href="'. esc_url( admin_url( 'post-new.php' ) ) .'" title="'. __( 'Add a new Post', 'toongeeprime-theme' ) .'">'. __( 'Why not add a new Post, here', 'toongeeprime-theme' ) .'</a>?</p>';
	}

	echo '</div>';


get_footer();

