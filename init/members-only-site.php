<?php defined( 'ABSPATH' ) || exit;
/**
 *	MEMBERS-ONLY WEBSITE STATE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.90
 */

add_action( 'template_redirect', 'prime2g_members_only_website_state', 7 );
function prime2g_members_only_website_state() {
if ( ! prime2g_constant_is_true( 'PRIME2G_MEMBERSONLY_SITE', false ) ) return;	// checking on single-sites
if ( empty( get_theme_mod( 'prime2g_site_is_members_only' ) ) ) return;

//	This feature must favour website shutdown
$shutDown	=	! empty( get_theme_mod( 'prime2g_website_shutdown' ) );

//	Return conditions
$logged_in	=	is_user_logged_in();
if ( is_admin() || $logged_in || $shutDown ||
	in_array( $GLOBALS[ 'pagenow' ], [ 'wp-login.php', 'wp-register.php' ] )
) return;

/**
 *	PUBLIC PAGE
 *	Homepage should show public content @ page prepared
 *	Set this selected page as Static homepage also for expected output
 *	because WP will load the static homepage object STILL
 */
if ( ! $logged_in ) {

$page_id	=	get_theme_mod( 'prime2g_membersonly_page_id' );

$pageID	=	(int) $page_id;

if ( ! $pageID ) {
	echo function_exists( 'prime2g_members_only_public_page' ) ? prime2g_members_only_public_page() :
	'<h1>'. __( 'Private', PRIME2G_TEXTDOM ) .'</h1>';
}
else {
$page	=	new WP_Query( [ 'post_type' => 'page', 'p' => $pageID ] );
if ( $page->have_posts() ) {

define( 'PRIME2G_ALT_POST_OBJ', $page->posts[0] );

get_header();

while ( $page->have_posts() ) {
$page->the_post();

	prime2g_before_post();

	the_content();

	prime2g_after_post();
break;
}

get_footer();
}
}

exit;
}

}

