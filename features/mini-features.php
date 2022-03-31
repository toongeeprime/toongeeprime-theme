<?php defined( 'ABSPATH' ) || exit;

/**
 *	MINI THEME FEATURES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */



/**
 *	Scroll back to the top of the page
 */
add_action( 'wp_footer', 'prime2g_toTop' );
if ( ! function_exists( 'prime2g_toTop' ) ) {
function prime2g_toTop() { ?>
	<div id="prime2g_toTop">
		<p onclick="prime_gotoThis( 'body' );" title="Back to the Top">
			<span class="dashicons dashicons-arrow-up-alt"></span>
		</p>
	</div>
<?php
}
}

