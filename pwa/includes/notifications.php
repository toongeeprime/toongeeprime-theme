<?php defined( 'ABSPATH' ) || exit;
/**
 *	NOTIFICATIONS
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

if ( ! function_exists( 'prime2g_pwa_online_offline_notif' ) ) {

#	Hook set here for easy re-placement
add_action( 'wp_footer', 'prime2g_pwa_online_offline_notif' );

function prime2g_pwa_online_offline_notif() {
if ( prime2g_activate_theme_pwa() ) {

echo	'<div id="prime2g_offOnline_notif" class="centered off pointer">
<p class="offline oo_notif off"><i class="bi bi-reception-0"></i> '. __( "You're Offline", PRIME2G_TEXTDOM ) .'</p>
<p class="connected oo_notif off"><i class="bi bi-reception-2"></i> '. __( 'You are Connected', PRIME2G_TEXTDOM ) .'</p>
<p class="online oo_notif off"><i class="bi bi-reception-4"></i> '. __( "You're back Online", PRIME2G_TEXTDOM ) .'</p>
</div>';

}
}

}

