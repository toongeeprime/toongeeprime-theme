<?php defined( 'ABSPATH' ) || exit;
/**
 *	CLASS: CUSTOM LOGIN PAGE
 *	Forked: https://github.com/wp-plugins/wps-hide-login/blob/master/wps-hide-login.php
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.73
 *
 *	***			Class called @ login-page.php
 */

if ( ! class_exists( 'Prime2gLoginPage' ) ) {
class Prime2gLoginPage {

	private $wp_login_php;
	private static $instance;

	private function use_trailing_slashes() { return ( '/' === substr( get_option( 'permalink_structure' ), -1, 1 ) ); }

	private function user_trailingslashit( $string ) {
		return $this->use_trailing_slashes() ? trailingslashit( $string ) : untrailingslashit( $string );
	}


	function new_login_slug() {
		// To Do: network logic
		$slug	=	get_theme_mod( 'prime2g_wp_login_page_slug', 'login' );
		if ( ! in_array( $slug, prime_wp_forbidden_slugs() ) ) {
			return $slug;
		}
	return 'login';
	}


	function new_login_url( $scheme = null ) {
		if ( get_option( 'permalink_structure' ) ) { // site is using pretty permalinks
			return $this->user_trailingslashit( home_url( '/', $scheme ) . $this->new_login_slug() );
		}
		else {
			return home_url( '/', $scheme ) . '?' . $this->new_login_slug();
		}
	}


	static function run() {
	return ( ! empty( get_theme_mod( 'prime2g_use_custom_login_page' ) )
		&& ! empty( get_theme_mod( 'prime2g_wp_login_page_slug' ) ) );
	}

	/**
	 *	Return an instance of class
	 *	@return object: A single instance of class
	 */
	static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance	=	new self;
		}
	return self::$instance;
	}


	public function __construct() {
	if ( ! self::run() ) return;

		add_filter( 'site_url', array( $this, 'site_url' ), 10, 4 );
		add_filter( 'network_site_url', array( $this, 'network_site_url' ), 10, 3 );
		add_filter( 'wp_redirect', array( $this, 'wp_redirect' ), 10, 2 );

		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ), 2 );
		add_action( 'wp_loaded', array( $this, 'wp_loaded' ) );

		add_action( 'login_header', [ $this, 'login_page_content' ] );
		add_action( 'login_footer', [ $this, 'login_footer' ], 100 );	# @since 1.0.75

		add_filter( 'login_url', [ $this, 'login_url' ], 10, 3 );
		add_filter( 'retrieve_password_message', [ $this, 'password_reset_message' ], 20, 2 );

		remove_action( 'template_redirect', 'wp_redirect_admin_locations', 1000 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
	}


	function plugins_loaded() {
		global $pagenow;

		if ( ! is_multisite()
			&& ( strpos( $_SERVER['REQUEST_URI'], 'wp-signup' )  !== false
				|| strpos( $_SERVER['REQUEST_URI'], 'wp-activate' ) )  !== false ) {
			wp_die( __( 'This feature is not enabled.', PRIME2G_TEXTDOM ) );
		}

		$request	=	parse_url( $_SERVER['REQUEST_URI'] );

		if ( ( strpos( $_SERVER['REQUEST_URI'], 'wp-login.php' ) !== false
			|| untrailingslashit( $request['path'] ) === site_url( 'wp-login', 'relative' ) )
			&& ! is_admin() ) {

			$this->wp_login_php	=	true;

			$_SERVER['REQUEST_URI']	=	$this->user_trailingslashit( '/' . str_repeat( '-/', 10 ) );

		$pagenow	=	'index.php';
		}
		elseif ( untrailingslashit( $request['path'] ) === home_url( $this->new_login_slug(), 'relative' )
			|| ( ! get_option( 'permalink_structure' )
				&& isset( $_GET[$this->new_login_slug()] )
				&& empty( $_GET[$this->new_login_slug()] ) )
				) {
		$pagenow	=	'wp-login.php';
		}
	}


	function wp_loaded() {
	global $pagenow;

		if ( ( ! is_user_logged_in() && ( is_admin() && ! defined( 'DOING_AJAX' ) ) )
		|| $pagenow === 'wp-login.php' && ! wp_get_referer()
		) {
			status_header(404);
			nocache_headers();
			include_once get_404_template();
		exit;
		}

		$request	=	parse_url( $_SERVER['REQUEST_URI'] );

		if ( $pagenow === 'wp-login.php' && get_option( 'permalink_structure' )
		&& $request['path'] !== $this->user_trailingslashit( $request['path'] ) ) {

			wp_safe_redirect( $this->user_trailingslashit( $this->new_login_url() )
				. ( ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '' ) );
		die;
		}
		elseif ( $this->wp_login_php ) {

			if ( ( $referer = wp_get_referer() )
				&& strpos( $referer, 'wp-activate.php' ) !== false
				&& ( $referer = parse_url( $referer ) )
				&& ! empty( $referer['query'] ) ) {

				parse_str( $referer['query'], $referer );

				if ( ! empty( $referer['key'] )
					&& ( $result = wpmu_activate_signup( $referer['key'] ) )
					&& is_wp_error( $result )
					&& ( $result->get_error_code() === 'already_active'
						|| $result->get_error_code() === 'blog_taken' ) ) {

					wp_safe_redirect( $this->new_login_url()
						. ( ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '' ) );
				die;
				}
			}

		$this->wp_template_loader();
		}
		elseif ( prime_strip_url_end( prime2g_get_current_url() ) === $this->new_login_slug() ) {
			global $error, $interim_login, $action, $user_login;
			@require_once ABSPATH . 'wp-login.php';
		die;
		}
	}


	private function wp_template_loader() {
		global $pagenow;
		$pagenow	=	'index.php';

		if ( ! defined( 'WP_USE_THEMES' ) ) { define( 'WP_USE_THEMES', true ); }
		wp();

		if ( $_SERVER['REQUEST_URI'] === $this->user_trailingslashit( str_repeat( '-/', 10 ) ) ) {
			$_SERVER['REQUEST_URI'] = $this->user_trailingslashit( '/wp-login-php/' );
		}

		require_once( ABSPATH . WPINC . '/template-loader.php' );
	die;
	}


	function get_login_page() {
		if ( $pageID = get_theme_mod( 'prime2g_custom_login_page_id', 0 ) ) {
			if ( !$pageID ) return null;
			return get_post( (int) $pageID );
		}
	}


	function login_page_content() {
		if ( $the_page = $this->get_login_page() )
			echo apply_filters( 'the_content', $the_page->post_content );
	}


	#	@since 1.0.75
	function login_footer() {
		if ( $the_page = $this->get_login_page() ) {
			if ( $the_page->prime_page_js )
				echo '<script id="prime2g_pageJS">'. $the_page->prime_page_js .'</script>';
		}
	}


	function login_url( $login_url, $redirect, $force_reauth ) { return $this->filter_wp_login_php( $login_url ); }

	function site_url( $url, $path, $scheme, $blog_id ) { return $this->filter_wp_login_php( $url, $scheme ); }

	function network_site_url( $url, $path, $scheme ) { return $this->filter_wp_login_php( $url, $scheme ); }

	function wp_redirect( $location, $status ) { return $this->filter_wp_login_php( $location ); }


	function filter_wp_login_php( $url, $scheme = null ) {
		if ( strpos( $url, 'wp-login.php' ) !== false ) {

			if ( is_ssl() ) { $scheme = 'https'; }

			$args	=	explode( '?', $url );

			if ( isset( $args[1] ) ) {
				parse_str( $args[1], $args );
				$url	=	add_query_arg( $args, $this->new_login_url( $scheme ) );
			}
			else {
				$url	=	$this->new_login_url( $scheme );
			}
		}
	return $url;
	}


	function password_reset_message( $message, $key ) {
	if ( strpos( $_POST['user_login'], '@' ) ) {
		$user_data	=	get_user_by( 'email', trim( $_POST['user_login'] ) );
	}
	else {
		$login		=	trim( $_POST['user_login'] );
		$user_data	=	get_user_by( 'login', $login );
	}

	$user_login	=	$user_data->user_login;
	$reset_link	=	network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' );
	$reset_link	=	$this->filter_wp_login_php( $reset_link );
	#	network_site_url()

	$msg = __( 'A password reset for the following account has been requested at ' ) . get_bloginfo( 'name' ) . '...' . "\r\n\r\n";
	$msg .= sprintf( __( 'Username: %s' ), $user_login ) . "\r\n\r\n";
	$msg .= __( 'If this message was sent in error, please ignore this email.' ) . "\r\n\r\n";
	$msg .= __( 'To reset your password, visit the following link:' );
	$msg .= ' ' . $reset_link . "\r\n";

	return $msg;
	}

}
}



