<?php defined( 'ABSPATH' ) || exit;
/**
 *	PWA FUNCTIONS
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

#	for consistency in working with caches
function prime2g_pwa_cache_names(): object {
$siteName	=	str_replace( [ ' ', '\'', '.' ], '', PRIME2G_PWA_SITENAME );
$version	=	PRIME2G_PWA_VERSION;

return (object) [
	'pwa_core'	=>	$siteName . '_pwaCache' . $version,
	'dynamic'	=>	$siteName . '_dynamicCache' . $version,
	'scripts'	=>	$siteName . '_scriptsCache' . $version
];
}


#	bool as string for service worker JS
function prime2g_override_service_worker_fetch(): string {
if ( function_exists( 'prime_override_service_worker_fetch' ) ) return prime_override_service_worker_fetch();
return 'false';
}


#	@since 1.0.97
#	Appends unique value of PRIME2G_APPCACHE to options
function prime2g_app_option( $args ) {
$value	=	PRIME2G_PWA_VERSION;
$name	=	$args;
$update	=	false;
$autoload	=	'no';

is_array( $args ) ? extract( $args ) : null;

$group	=	PRIME2G_APPCACHE;

if ( $name === 'same_version' ) {
	return get_option( 'version' . $group ) === PRIME2G_PWA_VERSION;
}

if ( is_string( $args ) && str_contains( $name, 'version' ) && !$update ) {
	return get_option( $name . $group ) === PRIME2G_PWA_VERSION;
}

$option	=	get_option( $name . $group );

if ( $update ) {
	$option	=	update_option( $name . $group, $value, $autoload );
}

return $option;
}


#	CSV
function prime2g_add_service_worker_precache_files(): string {
	$depr	=	function_exists( 'child_add_to_pwa_precache' ) ? ' + ", " + "' . child_add_to_pwa_precache() . '"' : '';
return apply_filters( 'prime2g_filter_service_worker_precache_files', '', $depr );
}
#	@since 1.0.97 End

