<?php defined( 'ABSPATH' ) || exit;

/**
 *	CONTENT WRAPPING SHORTCODES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.51.00
 */

#	Show contents to:
add_shortcode( 'prime_show_content_to', 'prime2g_showcontent_to' );
function prime2g_showcontent_to( $atts, $content, $tag ) {

global $current_user;

$loggedin	=	is_user_logged_in();
$content	=	do_shortcode( $content );

$atts	=	shortcode_atts(
	array(
	'users'		=>	'',
	'roles'		=>	'',
	'userids'	=>	'',
	'capability'=>	'',
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


elseif ( ! empty( $roles ) ) {
$user_roles		=	$current_user->roles;
$showtoRoles	=	explode( ',', $roles );

$rolesFound		=	(bool) array_intersect( $showtoRoles, $user_roles );

if ( $rolesFound ) return $output;
}


elseif ( ! empty( $userids ) ) {
$userID		=	$current_user->ID;
$userIDs	=	explode( ',', $userids );

$hasID		=	in_array( $userID, $userIDs );

if ( $hasID ) return $output;
}


elseif ( ! empty( $capability ) ) {
	if ( current_user_can( $capability ) ) return $output;
}


else {
	return $output;
}

}



#	Send contents to footer:
add_shortcode( 'prime_send_to_footer', 'prime2g_send_content_to_footer' );

function prime2g_send_to_footer( $contents ) {
	add_action( 'wp_footer', function() use( $contents ) { echo $contents; } );
}


function prime2g_send_content_to_footer( $atts, $content, $tag ) {

$contents	=	do_shortcode( $content );

prime2g_send_to_footer( $contents );

}

