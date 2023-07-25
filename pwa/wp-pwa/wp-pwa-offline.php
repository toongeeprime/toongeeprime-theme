<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: Hook WP PWA for when Offline
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 *
 *	See other integrations
 */


#	Essence Not Found nor Understood, doesn't seem to be hooked/called up anywhere

class Prime2g_PWA_Offline_Integration extends WP_Service_Worker_Base_Integration {

	public function define_scope() { return WP_Service_Workers::SCOPE_FRONT; }

	public function get_priority() { return 100; }

	public function register( WP_Service_Worker_Scripts $scripts ) {

	$offline	=	new Prime2g_PWA_Offline_Manager();
	$cachingRoute	=	$offline->caching_routes()['site_route'] . 'index.html';

	$scripts->caching_routes()->register(
		preg_quote( $cachingRoute ),
		array(
			'strategy'	=>	WP_Service_Worker_Caching_Routes::STRATEGY_CACHE_FIRST,
			'cacheName'	=>	'prime-offline-page',
			'expiration'=>	array(
				'maxAgeSeconds'	=>	WEEK_IN_SECONDS,
				'maxEntries'	=>	30,
			),
		),
	);

	}

}

