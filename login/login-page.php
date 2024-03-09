<?php defined( 'ABSPATH' ) || exit;
/**
 *	WP LOGIN PAGE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	Placed in dir and upgraded @since 1.0.73
 */

// add_action( 'login_init' ); // Fires when the login form is initialized
// add_action( 'login_footer', '', 15 );

$prime_custom_login_class	=	Prime2gLoginPage::get_instance();

#	FILTERS
add_filter( 'login_headerurl', 'prime2g_loginpage_url' );
add_filter( 'login_headertext', 'prime2g_loginpage_title' );
#	ACTIONS
add_action( 'login_enqueue_scripts', 'prime2g_login_enqueues' );
add_action( 'login_enqueue_scripts', 'prime2g_enqueue_parent_css_login', 5 );	#	@since 1.0.73
add_action( 'login_head', 'prime2g_theme_styles_at_login_page' );	#	@since 1.0.73
add_action( 'login_head', 'prime2g_load_theme_fonts' );	#	@since 1.0.73

#	change the logo link
function prime2g_loginpage_url() {  return home_url(); }

#	change the alt text on the logo to site name
function prime2g_loginpage_title() { return get_option( 'blogname' ); }

if ( ! function_exists( 'prime2g_login_enqueues' ) ) {
function prime2g_login_enqueues() {
	wp_enqueue_style( 'prime2g_login_css', PRIME2G_THEMEURL . '/files/login.css', [ 'prime2g_css' ], PRIME2G_VERSION );
}
}

#	@since 1.0.73
if ( ! function_exists( 'prime2g_theme_styles_at_login_page' ) ) {
function prime2g_theme_styles_at_login_page() {
	prime2g_theme_root_styles();
	echo '<style id="themeLoginCss">'
	. prime_custom_theme_classes_styles() .
	'/* STYLE */
	' . prime2g_login_page_css() .
	'</style>';
}
}

function prime2g_enqueue_parent_css_login() {
	wp_register_style( 'prime2g_css', get_theme_file_uri( '/files/theme.css' ), [], PRIME2G_VERSION );
    wp_enqueue_style( 'prime2g_css' );
}
