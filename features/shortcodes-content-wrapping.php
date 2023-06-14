<?php defined( 'ABSPATH' ) || exit;

/**
 *	CONTENT WRAPPING SHORTCODES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.51
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
	if ( user_can( $current_user, $capability ) ) return $output;
}


else {
	return $output;
}

}


/**
 *	ADD IN-POST CONTENT TO THEME PARTS
 *	@since ToongeePrime Theme 1.0.55
 */
add_shortcode( 'prime_add_to_theme', 'prime2g_add_content_to_theme' );
function prime2g_add_content_to_theme( $atts, $content, $tag ) {

$atts	=	shortcode_atts( array( 'place' => 'after post', 'priority' => '10' ), $atts );
extract( $atts );

$output	=	do_shortcode( $content );

#	Add by theme/WP hooks
#	Tested hooks:
$hook	=	$place;
if ( $place == 'after post' ) $hook	=	'prime2g_after_post';
if ( $place == 'base' ) $hook	=	'prime2g_site_base_strip';
if ( $place == 'footer' ) $hook	=	'wp_footer';

add_action( $hook, function() use( $output ) { echo $output; }, (int) $priority );
}

