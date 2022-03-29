<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME INDEX FILE
 *
 *	Generic Template file
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( is_singular() ) {

	if ( have_posts() ) {

		$file = PRIME2G_SINGULAR . get_post_type() . '.php';

		if ( file_exists( $file ) ) {
			require $file;
		}
		else {
			require PRIME2G_SINGULAR . 'post.php';
		}

	}

}


elseif ( is_archive() || is_home() ) {

	if ( have_posts() ) {

		$file = PRIME2G_ARCHIVE . get_post_type() . '.php';

		if ( file_exists( $file ) ) {
			require $file;
		}
		else {
			require PRIME2G_ARCHIVE . 'post.php';
		}

	}
	else {
		require PRIME2G_ARCHIVE . 'empty.php';
	}

}

else {

	get_header();

	prime2g_removeSidebar();

	if ( have_posts() ) {

		// Load posts loop
		while ( have_posts() ) {

			the_post();
			the_content();

		}

	}
	else {

		echo '<h3 style="text-align:center;margin:90px 30px;">Sorry, nothing to display here!</h3>';

	}

	prime2g_below_posts_widgets();

	get_footer();

}

