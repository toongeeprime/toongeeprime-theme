<?php defined( 'ABSPATH' ) || exit;

/**
 *	RUN WITH WP PWA
 *
 *	@package WordPress, WP PWA core
 *	@since ToongeePrime Theme 1.0.55
 */

if ( class_exists( 'WP_Service_Workers' ) ) {

require_once PWA_PLUGIN_DIR . '/integrations/interface-wp-service-worker-integration.php';
require_once PWA_PLUGIN_DIR . '/integrations/class-wp-service-worker-base-integration.php';
require_once PWA_PLUGIN_DIR . '/integrations/functions.php';


$path	=	PRIME2G_PWA_PATH . 'wp-pwa/';

// require_once $path . 'wp-pwa-theme.php';
require_once $path . 'wp-pwa-offline.php';
require_once $path . 'wp-pwa.php';



// Applicable Theme App Classes
$offline	=	new Prime2g_PWA_Offline_Manager();

$cachingRoutes	=	$offline->caching_routes();

$components	=	[];


add_action( 'after_setup_theme', function() {
// add_theme_support( 'service_worker', true );
add_theme_support( 'service_worker', array(
	'prime2g-offline'	=>	'Prime2g_PWA_Offline_Integration'
) );
} );


pwa_register_service_worker_integrations( new WP_Service_Worker_Scripts(
	$cachingRoutes['images'],
	$cachingRoutes['offline'],
	$components
) );

}

