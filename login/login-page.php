<?php defined( 'ABSPATH' ) || exit;
/**
 *	WP LOGIN PAGE
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	Put in dir and upgraded @since 1.0.73
 */
Prime2gLoginPage::get_instance();

#	FILTERS
add_filter( 'login_headerurl', 'prime2g_loginpage_url' );
add_filter( 'login_headertext', 'prime2g_loginpage_title' );
#	ACTIONS
add_action( 'login_enqueue_scripts', 'prime2g_login_enqueues', 15 );
add_action( 'login_head', 'prime2g_theme_styles_at_login_page' );

/**
 *	@since 1.0.73
 *	@since 1.0.74 condition added
 *		To make login page look more like theme when using custom login page
 */
if ( Prime2gLoginPage::run() ) {
	add_action( 'login_enqueue_scripts', 'prime2g_parent_enqueues_at_login', 5 );
	add_action( 'login_head', 'prime2g_load_theme_fonts' );

#	@since 1.0.98
if ( prime2g_use_extras() ) {
	add_action( 'login_head', 'prime2g_dt_headCSS' );
	add_action( 'login_footer', 'prime2g_dt_footerJS' );
}

}

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
	'. prime2g_login_page_css() .
	'</style>';
}
}

function prime2g_parent_enqueues_at_login() {
	wp_register_style( 'prime2g_css', get_theme_file_uri( '/files/theme-min.css' ), [], PRIME2G_VERSION );
    wp_enqueue_style( 'prime2g_css' );

	$icons	=	prime2g_theme_icons_info();	//	@since 1.0.98
	wp_enqueue_style( PRIME2G_ICONS_HANDLE, $icons->url, [], $icons->version );

	#	@since 1.0.75
	wp_register_script( 'prime2g_js', get_theme_file_uri( '/files/theme-min.js' ), [], PRIME2G_VERSION );
	wp_enqueue_script( 'prime2g_js' );
}

