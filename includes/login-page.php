<?php defined( 'ABSPATH' ) || exit;

/**
 *	WP LOGIN PAGE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */


add_action( 'login_enqueue_scripts', 'prime2g_login_enqueues', 15 );
add_action( 'login_enqueue_scripts', 'prime2g_theme_root_styles', 12 );
if ( ! function_exists( 'prime2g_login_enqueues' ) ) {

function prime2g_login_enqueues() {

	wp_enqueue_style(
		'prime2g_login_css',
		PRIME2G_THEMEURL . '/files/login.css',
		array(),
		PRIME2G_VERSION
	);

}

}


// change the logo link
function prime2g_loginpage_url() {  return home_url(); }


// change the alt text on the logo to site name
function prime2g_loginpage_title() { return get_option( 'blogname' ); }


// call on the login page
add_filter( 'login_headerurl', 'prime2g_loginpage_url' );
add_filter( 'login_headertext', 'prime2g_loginpage_title' );

