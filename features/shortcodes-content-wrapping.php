<?php defined( 'ABSPATH' ) || exit;
/**
 *	CONTENT WRAPPING SHORTCODES
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.51
 */

add_shortcode( 'prime_show_content_to', 'prime2g_showcontent_to' );
function prime2g_showcontent_to( $atts, $content, $tag ) {
$current_user	=	wp_get_current_user();
$loggedin	=	is_user_logged_in();
$content	=	do_shortcode( $content );

$atts	=	shortcode_atts(
	array(
	'users'		=>	'',
	'roles'		=>	'',
	'userids'	=>	'',
	'capability'=>	'',
	'device'	=>	''	#	@since 1.0.55
	), $atts
);
extract( $atts );

$output	=	'<div class="prime-showto-div">' . $content . '</div>';

if ( ! empty( $users ) ) {
	if ( $users === 'logged in' ) {
		if ( $loggedin ) return $output;
	}
	if ( $users === 'logged out' ) {
		if ( ! $loggedin ) return $output;
	}
}

elseif ( ! empty( $device ) ) {
$isMobile	=	wp_is_mobile();
$devices	=	prime2g_devices_array();

if ( in_array( $device, $devices->mobiles ) && $isMobile ) return $output;
if ( in_array( $device, $devices->desktops ) && ! $isMobile ) return $output;
}

elseif ( ! empty( $roles ) ) {
$user_roles	=	$current_user->roles;
$showtoRoles=	explode( ',', $roles );
$hasRoles	=	false;

foreach ( $showtoRoles as $role ) {
	if ( in_array( $role, $user_roles ) ) {
		$hasRoles	=	true; break;
	}
}
if ( $hasRoles ) return $output;
}

elseif ( ! empty( $userids ) ) {
$userID	=	$current_user->ID;
$userIDs=	explode( ',', $userids );
$hasID	=	in_array( $userID, $userIDs );

if ( $hasID ) return $output;
}

elseif ( ! empty( $capability ) ) {
$allcaps	=	$current_user->allcaps;
$showtoCaps	=	explode( ',', $capability );
$hasCapabs	=	false;

foreach ( $showtoCaps as $cap ) {
	if ( array_key_exists( $cap, $allcaps ) ) {	#	capabilities are array keys
		$hasCapabs	=	true; break;
	}
}

if ( $hasCapabs ) return $output;
}

else {
	return $output;
}
}


