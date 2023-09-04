<?php defined( 'ABSPATH' ) || exit;

/**
 *	TOUCHING WP
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	ADMIN FOOTER
 */
add_filter( 'admin_footer_text', 'prime2g_admin_footer_text' );
function prime2g_admin_footer_text() {
	_e( '<span id="prime2g_footer_credit">Site developed by <a href="https://akawey.com/" target="_blank">Akàwey Online</a> using the <a href="' . esc_url( home_url( '/' ) ) . '" target="_blank">' . esc_html( wp_get_theme() ) . '</a>.</span>', PRIME2G_TEXTDOM );
}


/**
 *	Modifies tag cloud widget arguments to display all tags in the same font size
 *	and use list format for better accessibility
 */
add_filter( 'widget_tag_cloud_args', 'prime2g_widget_tag_cloud_args' );
function prime2g_widget_tag_cloud_args( $args ) {
	$args['largest']	=	1;
	$args['smallest']	=	1;
	$args['unit']		=	'em';
	$args['format']		=	'list';

return $args;
}


/**
 *	STOP WP HEARTBEAT
 *	@since ToongeePrime Theme 1.0.49
 */
add_action( 'init', 'prime2g_stop_wp_heartbeat', 1 );
add_action( 'admin_enqueue_scripts', 'prime2g_stop_wp_heartbeat' );
if ( ! function_exists( 'prime2g_stop_wp_heartbeat' ) ) {
function prime2g_stop_wp_heartbeat() {
	if ( 'stop' === get_theme_mod( 'prime2g_stop_wp_heartbeat' ) ) {
	global $pagenow;
		if ( 'post.php' !== $pagenow && 'post-new.php' !== $pagenow ) {
			wp_deregister_script( 'heartbeat' );
			wp_register_script( 'heartbeat', false );
		}
	}
}
}


/**
 *	DISABLE WP AUTOP
 *	@since ToongeePrime Theme 1.0.51
 */
add_filter( 'the_content', 'prime2g_disable_wpautop', 0 );
function prime2g_disable_wpautop( $content ) {
global $post;
	if ( $post->disable_autop === 'disable' ) {
		remove_filter( 'the_content', 'wpautop' );
		remove_filter( 'the_excerpt', 'wpautop' );
	}
return $content;
}


