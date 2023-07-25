<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: PWA Offline Contents Manager
 *
 *	Determine files, assets, etc. to be operational offline / with service worker
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_PWA_Offline_Manager {

	private static $instance;

	public function __construct() {

		if ( ! isset( self::$instance ) ) {
			// flush_rewrite_rules();	# for dev
			add_action( 'parse_request', array( $this, 'show_offline_output' ) );
		}

	return self::$instance;
	}


	protected function offline_page_maker() {
	add_action( 'wp_head', function() { echo '<title>Offline</title>'; }, 1 );

	// php based override:
	if ( function_exists( 'pwa_offline_page_maker_override' ) ) {
		pwa_offline_page_maker_override(); exit;
	}

		add_filter( 'get_the_archive_title', function() { return 'You are Offline!'; } );

		prime2g_removeSidebar();
		get_header();

		echo '<p class="centered">Please check your connection</p>';

		get_footer();

		exit;
	}


	protected function check_params( string $value, string $offlinePage ) {
	return (
		isset( $_GET[ 'offline' ] ) && $_GET[ 'offline' ] === $value ||
		prime2g_get_current_url() === $this->get_offline_url( $offlinePage )
	);
	}


	protected function do_output_die( $output, $type = 'json' ) {
		if ( ! headers_sent() ) {
			header( 'Content-Type: application/'. $type .'; charset=' . get_option( 'blog_charset' ) );
		}
		echo $output;
		die;
	}


	// Virtual files output
	public function show_offline_output() {

		if ( $this->check_params( 'offline', 'index' ) ) {
			$output	=	$this->offline_page_maker();
			wp_send_json( $output );
		}

		if ( $this->check_params( 'scripts', 'script' ) ) {
			$output	=	Prime2g_PWA_Offline_Script::content();
			$this->do_output_die( $output, 'javascript' );
		}

		if ( $this->check_params( 'service-worker', 'sw' ) ) {
			$output	=	Prime2g_PWA_Service_Worker::content();
			$this->do_output_die( $output, 'javascript' );
		}

	}


	public function get_offline_url( $get ) {
	$url	=	trailingslashit( get_home_url() ) . 'offline/';

		switch( $get ) {
			case 'index'	:	$end	=	'index.html'; break;
			case 'script'	:	$end	=	'scripts.js'; break;
			case 'sw'	:	$end	=	'service-worker.js'; break;
			default	:	$end	=	''; break;
		}

	return $url . $end;
	}


	// Because of WP PWA
	public function caching_routes() {

	$homeUrl		=	trailingslashit( get_home_url() );
	// $siteroute	=	preg_quote( $homeUrl . 'offline/*' );
	$siteroute		=	$this->get_offline_url( '' );	# assign virtual offline files/assets to this route

	return [
		'offline'		=>	$siteroute,
		'images'		=>	PRIME2G_PWA_IMAGE,
		'files'			=>	PRIME2G_PWA_FILES,
		'assets'		=>	PRIME2G_PWA_THEMEASSETS,
		'child_assets'	=>	CHILD2G_PWA_THEMEASSETS,
		'pre_cache'		=>	CHILD2G_PWA_THEME_URL . 'precache/',
	];

	}

}

