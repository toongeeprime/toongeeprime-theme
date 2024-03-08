<?php defined( 'ABSPATH' ) || exit;

/**
 *	WP LOGIN PAGE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

$prime_custom_login_class	=	Prime2gLoginPage::get_instance();

// do_action( 'login_header', '' ); // after the body tag is opened
// do_action( 'login_init' ); // Fires when the login form is initialized
// add_action( 'login_footer', 'prime2g_custom_login_js', 15 );

#	FILTERS
add_filter( 'login_headerurl', 'prime2g_loginpage_url' );
add_filter( 'login_headertext', 'prime2g_loginpage_title' );
#	ACTIONS
add_action( 'login_enqueue_scripts', 'prime2g_login_enqueues' );
add_action( 'login_head', 'prime2g_theme_styles_at_login_page' );	#	@since 1.0.73

// change the logo link
function prime2g_loginpage_url() {  return home_url(); }

// change the alt text on the logo to site name
function prime2g_loginpage_title() { return get_option( 'blogname' ); }


#	@since 1.0.73
if ( ! function_exists( 'prime2g_theme_styles_at_login_page' ) ) {
function prime2g_theme_styles_at_login_page() {
	prime2g_theme_root_styles();
	echo '<style id="themeClassesStyles">'
	. prime_custom_theme_classes_styles() .
	'/* STYLE */
	' . prime2g_login_page_css() .
	'</style>';
}
}


if ( ! function_exists( 'prime2g_login_enqueues' ) ) {
function prime2g_login_enqueues() {
$version	=	PRIME2G_VERSION;
	wp_register_style( 'prime2g_css', get_theme_file_uri( '/files/theme.css' ), [], $version );	#	@since 1.0.73
    wp_enqueue_style( 'prime2g_css' );

	wp_enqueue_style( 'prime2g_login_css', PRIME2G_THEMEURL . '/files/login.css', [ 'prime2g_css' ], $version );
}
}





/**
 *	CUSTOM LOGIN PAGE WORKINGS
 *	@since 1.0.73
 */
// function prime2g_run_custom_login() {
// return ( ! is_user_logged_in() &&
// ! empty( get_theme_mod( 'prime2g_use_custom_login_page' ) ) && ! empty( get_theme_mod( 'prime2g_wp_login_page_slug' ) )
// );
// }


/**
 *	GET LOGIN PAGE URL
 */
// if ( ! function_exists( 'prime2g_custom_login_url' ) ) {
// function prime2g_custom_login_url( bool $default = false ) {
// if ( prime2g_run_custom_login() && $login_slug = get_theme_mod( 'prime2g_wp_login_page_slug', '' ) ) {
	// if ( ! in_array( $login_slug, prime_wp_forbidden_slugs() ) )
		// return trailingslashit( site_url( '/' . $login_slug, 'login' ) );
	// else
		// return $default ? wp_login_url() : '';
// }
// else {
	// return $default ? wp_login_url() : '';
// }
// }
// }

// define( 'PRIME_CUSTOM_LOGIN_URL', $custom_login_class->new_login_url() );
// define( 'PRIME_CUSTOM_LOGIN_URL_AND_DEFAULT', prime2g_custom_login_url(true) );


/**
 *	FILTER DEFAULT LOGIN URL
 *	@https://developer.wordpress.org/reference/hooks/login_url/
 */
// add_filter( 'login_url', 'prime2g_rewrite_login_url', 10, 3 );
function prime2g_rewrite_login_url( $login_url, $redirect, $force_reauth ) {
// $login_url	=	site_url( '/custom-login/', 'login' );
$login_url	=	PRIME_CUSTOM_LOGIN_URL;
	if ( ! empty( $redirect ) ) {
		$login_url	=	add_query_arg( 'redirect_to', urlencode( $redirect ), $login_url );
	}
	if ( $force_reauth ) {
		$login_url	=	add_query_arg( 'reauth', '1', $login_url );
	}
return $login_url;
}



/**
 *	GET LOGIN PAGE CONTENT
 */
// add_action( 'login_header', 'prime2g_login_page_content_source_page' );
if ( ! function_exists( 'prime2g_login_page_content_source_page' ) ) {
function prime2g_login_page_content_source_page() {
if ( ! Prime2gLoginPage::run() ) return;

if ( $pageID = get_theme_mod( 'prime2g_custom_login_page_id', 0 ) ) {
	if ( ! $pageID ) return;
	$pageID	=	(int) $pageID;
	$the_page	=	get_post( $pageID );
	echo apply_filters( 'the_content', $the_page->post_content );
}
}
}


/**
 *	OUTPUT WP-LOGIN.PHP
 */
// add_action( 'init', 'prime_display_wp_login_php' );
function prime_display_wp_login_php() {
if ( is_user_logged_in() || ! prime2g_run_custom_login() ) return;

if ( str_contains( prime2g_get_current_url(), 'wp-admin' ) ) {
	wp_safe_redirect( home_url( '404' ) );
}

global $pagenow;
if ( $pagenow === 'wp-login.php' ) {
$is_login	=	str_contains( prime2g_get_current_url(), 'wp-login.php' );
#	if ( str_contains( prime2g_get_current_url(), 'wp-login.php' ) ) {
$url	=	wp_get_referer() ?: prime2g_get_current_url();
$params	=	prime_url_has_params( $url );

	wp_safe_redirect( PRIME_CUSTOM_LOGIN_URL ) . ( ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '' );
die;
}


if ( str_contains( prime2g_get_current_url(), get_theme_mod( 'prime2g_wp_login_page_slug' ) ) ) {
global $error, $interim_login, $action, $user_login;
require_once ABSPATH . 'wp-login.php';
exit;
}
}



/**
 *	FILTER WP-LOGIN.PHP IN URL
 
function prime_filter_wp_login_url() {
$url	=	wp_get_referer() ?: prime2g_get_current_url();

if ( strpos( $url, 'wp-login.php' ) !== false ) {
	// if ( is_ssl() ) { $scheme = 'https'; }
	$args	=	explode( '?', $url );
	if ( isset( $args[1] ) ) {
		parse_str( $args[1], $args );
		$url	=	add_query_arg( $args, PRIME_CUSTOM_LOGIN_URL );
	}
	else {
		$url	=	PRIME_CUSTOM_LOGIN_URL;
	}
}

return esc_url( $url );
}
*/


// add_action( 'init', 'prime2g_redirect_from_wp_login' );
// function prime2g_redirect_from_wp_login() {
// if ( ! is_login() ) return;
// #	ONLY redirect attempts at wp-login.php - admin access is controlled by prime2g_admin_access_control()
// if ( prime2g_run_custom_login() && ! is_user_logged_in() && p2g_str_contains( prime2g_get_current_url(), ['wp-admin', 'wp-login.php'] ) ) {
// wp_safe_redirect( home_url( '404' ) );
// exit;
// }
// }




// if ( ! is_login() ) return;
#	ONLY redirect attempts at wp-login.php - admin access is controlled by prime2g_admin_access_control()
// if ( prime2g_run_custom_login() && ! is_user_logged_in() && p2g_str_contains( prime2g_get_current_url(), ['wp-admin', 'wp-login.php'] ) ) {
// if ( prime_url_has_params( prime2g_get_current_url() ) ) {
	// $redirect	=	prime_filter_wp_login_url();
	// wp_safe_redirect( $redirect );
// exit;
// }
// wp_safe_redirect( home_url( '404' ) );
// exit;



/**
 *	ERROR HANDLING
 */
// add_filter( 'login_errors', 'prime2g_login_error_redirector');
// function prime2g_login_error_redirector() {
// if ( isset( $_POST[ 'log' ] ) && isset( $_POST[ 'pwd' ] ) ) {
// $redirect	=	prime2g_run_custom_login() ? PRIME_CUSTOM_LOGIN_URL : prime2g_get_current_url(); // wp_login_url() will be redirected

// $redirect	.=	'?loginfail';

// if ( is_email( $_POST[ 'log' ] ) ) {
// if ( ! email_exists( $_POST[ 'log' ] ) ) {
	// $redirect	.=	'&noemail';
// }
// } else {
// if ( ! username_exists( $_POST[ 'log' ] ) ) {
	// $redirect	.=	'&nouser';
// }
// }
// wp_safe_redirect( $redirect );
// exit;
// }
// }



# REVIEW:
if ( ! function_exists( 'prime2g_get_login_notice_text' ) ) {
function prime2g_get_login_notice_text() {
if ( isset( $_GET[ 'loginfail' ] ) ) {
$email_not_exist	=	isset( $_GET[ 'noemail' ] );
$user_not_exist		=	isset( $_GET[ 'nouser' ] );

$text	=	'';

	if ( $email_not_exist ) {
		$text	.=	__( 'That "Email" does not exist on this website', PRIME2G_TEXTDOM );
	}
	if ( $user_not_exist ) {
		$text	.=	__( 'That "Username" does not exist on this website', PRIME2G_TEXTDOM );
	}
	if ( ! $email_not_exist && ! $user_not_exist ) {
		$text	.=	__( 'Please check your login details carefully and try again.', PRIME2G_TEXTDOM );
	}

return $text;
}
}
}


