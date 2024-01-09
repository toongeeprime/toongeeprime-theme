<?php defined( 'ABSPATH' ) || exit;

/**
 *	PWA FUNCTIONS:
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

#	for consistency in working with caches
function prime2g_pwa_cache_names() : object {
$siteName	=	str_replace( [ ' ', '\'', '.' ], '', PRIME2G_PWA_SITENAME );
$version	=	PRIME2G_PWA_VERSION;

return (object) [
	'pwa_core'	=>	$siteName . '_pwaCache' . $version,
	'dynamic'	=>	$siteName . '_dynamicCache' . $version,
	'scripts'	=>	$siteName . '_scriptsCache' . $version
];
}



#	bool as string must be returned for service worker JS use
function prime2g_override_service_worker_fetch() : string {
if ( function_exists( 'prime_override_service_worker_fetch' ) ) return prime_override_service_worker_fetch();
return 'false';
}

