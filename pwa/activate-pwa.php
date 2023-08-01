<?php defined( 'ABSPATH' ) || exit;

/**
 *	PWA ACTIVATOR
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */


if ( prime2g_add_theme_pwa() ) {

if ( function_exists( 'prime2g_child_pwa_activator' ) ) {
	#	For Overriding in Child theme:
	prime2g_child_pwa_activator();
}
else {
	prime2g_pwa_activator();
}

}




function prime2g_pwa_activator() {

if ( get_theme_mod( 'prime2g_use_theme_pwa' ) ) {

// Use with WP PWA plugin if active... For later review
if ( class_exists( 'WP_Service_Workers' ) ) {

// Prime2g_Hook_WP_PWA::instance();
$GLOBALS[ 'pwapp' ]	=	new Prime2g_Web_Manifest();

}
else {

$GLOBALS[ 'pwapp' ]	=	new Prime2g_Web_Manifest();

}

}

}




/*
add_action( 'admin_notices', function() {
if ( ! current_user_can( 'activate_plugins' ) ) return;

if ( prime2g_add_theme_pwa() ) {

$install	=	'plugin-install.php?s=core%2520PWA%2520Plugin%2520Contributors&tab=search&type=term';
$pluginsUrl	=	admin_url( 'plugins.php' );
$getPluginUrl	=	admin_url( $install );

if ( is_multisite() ) {
	$network	=	'network/';
	switch_to_blog( 1 );
	// $pluginsUrl		=	admin_url( $network . 'plugins.php' );	# let admin determine activation scope
	$getPluginUrl	=	admin_url( $network . $install );
	restore_current_blog();
}


if ( prime2g_plugin_exists( 'pwa/pwa.php' ) ) {

if ( ! is_plugin_active( 'pwa/pwa.php' ) ) { ?>
<div class="notice notice-warning">
<p>
<?php _e( 'Please activate the core WP PWA plugin at the Plugins page. 
<a href="'. $pluginsUrl .'">Click here to activate now</a>.', PRIME2G_TEXTDOM ); ?>
</p>
</div>
<?php
}

}
else { ?>
<div class="notice notice-warning">
<p>
<?php _e( 'We recommend the core WP PWA plugin for optimal Web App functionalities. 
<a href="'. $getPluginUrl .'">Click here to install now</a>.', PRIME2G_TEXTDOM ); ?>
</p>
</div>
<?php
}
}

} );
*/
