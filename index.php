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

	if ( have_posts() ) { prime2g_get_theme_template(); }

}

elseif ( is_archive() || is_home() ) {

	if ( have_posts() ) { prime2g_get_theme_template( true ); }

	else {
		if ( file_exists( CHILD2G_ARCHIVE . 'empty.php' ) ) require CHILD2G_ARCHIVE . 'empty.php';	#	@since ToongeePrime Theme 1.0.55
		else require PRIME2G_ARCHIVE . 'empty.php';
	}

}

else {

	get_header();

	prime2g_removeSidebar();

	if ( have_posts() ) {

		# Load posts loop
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
