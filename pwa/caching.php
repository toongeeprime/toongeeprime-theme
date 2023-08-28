<?php

/**
 *	CACHING CONTROL
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

add_action( 'plugins_loaded', 'prime2g_essential_chaching_control' );
if ( ! function_exists( 'prime2g_essential_chaching_control' ) ) {

function prime2g_essential_chaching_control( $wp ) {

	if ( is_admin() || is_user_logged_in() ||
	in_array( $GLOBALS[ 'pagenow' ], [ 'wp-login.php', 'wp-register.php' ] ) ||
	false !== strpos( $_SERVER[ 'REQUEST_URI' ], '?' )
	) {
		header( 'Cache-Control: max-age=0,no-cache,no-store,must-revalidate' );
	}
	else {
		if ( is_feed() ) {
			header( 'Cache-Control: max-age=' . ( 1 * DAY_IN_SECONDS ) );
		}
		else {
			header( 'Cache-Control: max-age=' . ( 1 * WEEK_IN_SECONDS ) );
		}
	}

}

}
