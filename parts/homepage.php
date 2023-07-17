<?php defined( 'ABSPATH' ) || exit;

/**
 *	HOMEPAGE PARTS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	HEADLINES
 */
add_action( 'prime2g_after_header', 'prime2g_home_headlines', 12 );

if ( ! function_exists( 'prime2g_headlines_loop' ) ) {
	function prime2g_headlines_loop() {
		return prime2g_archive_loop( true, 'medium', 20, false, false );
	}
}



if ( ! function_exists( 'prime2g_home_headlines' ) ) {
function prime2g_home_headlines() {
if ( ! is_home() ) return;

if ( 'show' == get_theme_mod( 'prime2g_theme_show_headlines' ) ) {
	$cid	=	get_theme_mod( 'prime2g_headlines_category' );
	$cat	=	get_category( $cid );
	if ( $cat ) {
	$slug	=	$cat->slug;

	echo '<section class="home_headlines">';

		echo '<h1 class="headlines_heading">' . $cat->name . '</h1>';

		echo '<div class="grid display prel">';

			echo '<div class="left sides grid prel">';
				prime2g_get_posts_query(
					'post', 2, 1, 'date', 'category', 'IN', $slug, 'prime2g_headlines_loop'
				);
			echo '</div>';

			echo '<div class="mid grid prel">';
			echo '<div class="mainheadline">';
				prime2g_get_posts_query(
					'post', 1, 0, 'date', 'category', 'IN', $slug, 'prime2g_archive_loop'
				);
			echo '</div>';
			do_action( 'prime2g_after_home_main_headline' );	# @since ToongeePrime Theme 1.0.55
			echo '</div>';

			echo '<div class="right sides grid prel">';
				prime2g_get_posts_query(
					'post', 2, 3, 'date', 'category', 'IN', $slug, 'prime2g_headlines_loop'
				);
			echo '</div>';

		echo '</div>';

		do_action( 'prime2g_after_home_headlines' );	# @since ToongeePrime Theme 1.0.55

	echo '</section>';
	}
	else {
		echo '<h2>Select Category</h2>';
	}

}

}
}

