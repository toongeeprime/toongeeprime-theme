<?php defined( 'ABSPATH' ) || exit;

/**
 *	HELPER FUNCTIONS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	Use prime2g_removeSidebar() to remove the sidebar from a template
 *	Sidebar is added throughout the theme via footer.php by prime2g_sidebar()
 */
function prime2g_removeSidebar() {
	function define_2gRMVSidebar(){}
}



/**
 *	nonce verifier
 *	@since ToongeePrime Theme 1.0.46.00
 */
function prime2g_verify_nonce( $nonceField = 'prime_ajaxnonce' ) {
	if ( ! isset( $_REQUEST[ $nonceField ] ) || ! wp_verify_nonce( $_POST[ $nonceField ] ) ) {
		wp_die( 'Security Fail!' );
	}
}



/**
 *	If current user is post author
 *	@since ToongeePrime Theme 1.0.45.00
 */
function prime2g_is_post_author( $post, $userID = null ) {
	return ( $userID ) ? $post->post_author == $userID :
	$post->post_author == get_current_user_id();
}



/**
 *	Use prime2g_remove_title() to remove the title from a template
 */
function prime2g_remove_title() {
	function define_2gRMVTitle(){}
}


/**
 *	Use prime2g_is_plain_page() to declare a template as being plain
 *	Thus, can be used to remove select features, widgets, etc.
 */
function prime2g_is_plain_page() {
	function define_2gPlainPage(){}
}



/**
 *	Include or exclude post types
 */
if ( ! function_exists( 'prime2g_include_post_types' ) ) {
	function prime2g_include_post_types( array $addTo = [ 'post', 'page' ] ) {
		return $addTo;
	}
}

if ( ! function_exists( 'prime2g_exclude_post_types' ) ) {
	function prime2g_exclude_post_types( array $pTypes = [ 'page' ] ) {
		return ( ! in_array( get_post_type(), $pTypes ) );
	}
}




/**
 *	Get Country via 2 Char Code
 *	More @ http://country.io/data/
 *	@since ToongeePrime Theme 1.0.47.00
 */
function prime2g_get_country_by_code( $code ) {
	// $countries	=	json_decode( file_get_contents( "http://country.io/names.json" ), true );
	$countries	=	json_decode( file_get_contents( "https://dev.akawey.com/cdn/countrynames.json" ), true );
	return $countries[ $code ];
}



/**
 *	If To Use Theme Extras
 *	@since ToongeePrime Theme 1.0.48.00
 */
function prime2g_use_extras() {
	return ( defined( 'PRIME2G_EXTRAS' ) && PRIME2G_EXTRAS === true );
}



/**
 *	Get Site' Domain name...
 *	@since ToongeePrime Theme 1.0.49.00
 */
function prime2g_get_site_domain() {
$url	=	get_bloginfo( 'url' );
$url	=	parse_url( $url );
$url	=	preg_replace( '/^www\./', '', $url['host'] );
return $url;
}



