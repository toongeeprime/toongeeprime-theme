<?php defined( 'ABSPATH' ) || exit;

/**
 *	CACHING CONTROL
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.56
 */
add_action( 'template_redirect', 'prime2g_chache_control_headers' );
if ( ! function_exists( 'prime2g_chache_control_headers' ) ) {

function prime2g_chache_control_headers() {
if ( empty( get_theme_mod( 'prime2g_activate_chache_controls' ) ) ) return;

	if ( is_admin() || current_user_can( 'edit_others_posts' ) ||
	in_array( $GLOBALS[ 'pagenow' ], [ 'wp-login.php', 'wp-register.php' ] ) ||
	false !== strpos( $_SERVER[ 'REQUEST_URI' ], '?' )
	) {
		header( 'Cache-Control: max-age=0,no-cache,no-store,must-revalidate' );
	}
	else {

$time_single	=	(int) get_theme_mod( 'prime2g_chache_time_singular' );
$seconds_single	=	(int) get_theme_mod( 'prime2g_chache_seconds_singular' );
$time_feeds		=	(int) get_theme_mod( 'prime2g_chache_time_feeds' );
$seconds_feeds	=	(int) get_theme_mod( 'prime2g_chache_seconds_feeds' );

		if ( is_feed() ) {
			header( 'Cache-Control: max-age=' . ( $time_feeds * $seconds_feeds ) );
		}
		else {
			header( 'Cache-Control: max-age=' . ( $time_single * $seconds_single ) );
		}
	}

}

}

