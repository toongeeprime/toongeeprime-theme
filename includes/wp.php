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

