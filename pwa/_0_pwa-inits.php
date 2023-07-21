<?php defined( 'ABSPATH' ) || exit;

/**
 *	PWA INITIAL MATTERS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

add_action( 'after_setup_theme', 'prime2g_appicons_image_sizes', 1000 );
function prime2g_appicons_image_sizes() {
   add_theme_support( 'post-thumbnails' );
   add_image_size( 'pwa-small-icon', 192, 192 );
   add_image_size( 'pwa-big-icon', 512, 512 );
}



/**
 *	PWA Related Constants
 */
$version	=	defined( 'CHILD2G_VERSION' ) ? CHILD2G_VERSION . PRIME2G_VERSION : PRIME2G_VERSION;
define( 'PRIME2G_PWA_VERSION', $version );
define( 'PRIME2G_PWA_BTNID', 'pwa_install' );
define( 'PRIME2G_PWA_URL', PRIME2G_THEMEURL .'pwa/' );
define( 'PRIME2G_PWA_IMAGE', PRIME2G_PWA_URL .'images/' );




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

