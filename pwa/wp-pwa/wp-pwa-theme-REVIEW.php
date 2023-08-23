<?php defined( 'ABSPATH' ) || exit;

/**
 *	WORKING WITH WP PWA Core
 *
 *	@package WordPress, WP PWA core
 *	@since ToongeePrime Theme 1.0.55
 *
 **
 *	See WP_Service_Workers __construct
 *
 *	Adds this to $scripts:: cache assets in assets directories specified within
 *	forked: WP_Service_Worker_Theme_Asset_Caching_Component
 *	according to source, for offline caching
 */

###					UNTESTED
###					CONVERT TO INTEGRATION... See WP PWA integrations folder

class Prime2g_WP_PWA_Theme_Assets__RENAME {

	const CACHE_NAME	=	'prime-theme-assets';

	public function serve( WP_Service_Worker_Scripts $scripts ) {
		if ( is_admin() ) { return; }

		$theme_dir_uri_patterns	=	[
			preg_quote( trailingslashit( PRIME2G_PWA_FILES ), '/' ),
			preg_quote( trailingslashit( PRIME2G_PWA_THEMEASSETS ), '/' ),
		];

		// if child theme has own PWA theme dir
		if ( is_dir( CHILD2G_PWA_THEMEASSETS ) ) {
			$theme_dir_uri_patterns[]	=	preg_quote( CHILD2G_PWA_THEMEASSETS, '/' );
		}

		$config	=	array(
			'route'			=>	'^(' . implode( '|', $theme_dir_uri_patterns ) . ').*', # All files in dirs
			'strategy'		=>	WP_Service_Worker_Caching_Routes::STRATEGY_NETWORK_FIRST,
			'cache_name'	=>	self::CACHE_NAME,
			'expiration'	=>	array(
				'max_entries'	=>	34,
			),
		);

		
		$config	=	apply_filters( 'wp_service_worker_theme_asset_caching', $config );

		if ( ! is_array( $config ) || ! isset( $config['route'], $config['strategy'] ) ) {
			return;
		}

		$route	=	$config['route'];
		unset( $config['route'] );

		$strategy	=	$config['strategy'];
		unset( $config['strategy'] );

		$scripts->caching_routes()->register( $route, $strategy, $config );
	}

	public function get_priority() { return 15; }

}

