<?php defined( 'ABSPATH' ) || exit;

/**
 *	HELPER FUNCTIONS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	Use prime2g_removeSidebar() to remove sidebar areas from a template
 */
function prime2g_removeSidebar() {
	if ( ! function_exists( 'define_2gRMVSidebar' ) ) { function define_2gRMVSidebar(){} }
}



/**
 *	nonce verifier
 *	@since ToongeePrime Theme 1.0.46
 */
function prime2g_verify_nonce( $actionName = 'prime_ajaxnonce' ) {
	if ( ! isset( $_REQUEST[ '_prime-nonce' ] ) || ! wp_verify_nonce( $_POST[ '_prime-nonce' ], $actionName ) ) {
		$msg	=	__( 'Failed security verification!', PRIME2G_TEXTDOM ); wp_die( $msg );
	}
}



/**
 *	If current user is post author
 *	@since ToongeePrime Theme 1.0.45
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
 *	Use prime2g_is_plain_page() to declare a template as being plain.
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
 *	@since ToongeePrime Theme 1.0.47
 */
function prime2g_get_country_by_code( $code ) {
	// $countries	=	json_decode( file_get_contents( "http://country.io/names.json" ), true );
	$countries	=	json_decode( file_get_contents( "https://dev.akawey.com/cdn/countrynames.json" ), true );
	return $countries[ $code ];
}



/**
 *	Use Theme Extras?
 *	@since ToongeePrime Theme 1.0.48
 */
function prime2g_use_extras() {
	return ( defined( 'PRIME2G_EXTRAS' ) && PRIME2G_EXTRAS === true );
}


/**
 *	Use PWA?
 *	@since ToongeePrime Theme 1.0.55
 */
function prime2g_add_theme_pwa() {
	return ( defined( 'PRIME2G_ADD_PWA' ) && PRIME2G_ADD_PWA === true );
}


/**
 *	Control Design from Network home on multisite installs?
 *	@since ToongeePrime Theme 1.0.55
 */
function prime2g_design_by_network_home() {
	if ( ! is_multisite() ) return false;
	return ( defined( 'PRIME2G_DESIGN_BY_NETWORK_HOME' ) && PRIME2G_DESIGN_BY_NETWORK_HOME === true );
}



/**
 *	Get Site' Domain name
 *	@since ToongeePrime Theme 1.0.49
 */
function prime2g_get_site_domain() {
$url	=	get_bloginfo( 'url' );
$url	=	parse_url( $url );
$url	=	preg_replace( '/^www\./', '', $url['host'] );
return $url;
}



/**
 *	@since ToongeePrime Theme Theme 1.0.50
 */
function prime2g_categs_and_ids_array() {
$categsArray	=	wp_cache_get( 'prime2g_categs_array' );

	if ( false !== $categsArray ) {
		return $categsArray;
	}
	else {
		$categs	=	get_categories();
		$ids	=	array_column( $categs, 'term_id' );
		$names	=	array_column( $categs, 'name' );

		$categsArray	=	array_combine( $ids, $names );

		wp_cache_set( 'prime2g_categs_array', $categsArray, '', PRIME2G_CACHE_EXPIRES );

		return $categsArray;
	}

}



/**
 *	@since ToongeePrime Theme 1.0.50
 */
function prime2g_posttypes_names_array() {
$posttypesArray	=	wp_cache_get( 'prime2g_posttypes_array' );

	if ( false !== $posttypesArray ) {
		return $posttypesArray;
	}
	else {

		$args	=	array( 'public' => true, 'publicly_queryable' => true );
		$post_types	=	get_post_types( $args, 'objects' );
		$slugs	=	$names = [];

		foreach ( $post_types as $post_type ) {
			if ( ! isset( $post_type ) ) continue;
			$slugs[]	=	$post_type->name;
			$names[]	=	$post_type->labels->name;
		}

		$posttypesArray	=	array_combine( $slugs, $names );

		wp_cache_set( 'prime2g_posttypes_array', $posttypesArray, '', PRIME2G_CACHE_EXPIRES );

		return $posttypesArray;
	}

}



/**
 *	@since ToongeePrime Theme 1.0.55
 */
function prime2g_get_current_url() {
if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' ) $url	=	"https://";   
else $url	=	"http://";   
	$url	.=	$_SERVER[ 'HTTP_HOST' ];
	$url	.=	$_SERVER[ 'REQUEST_URI' ];
return $url;
}



/**
 *	@since ToongeePrime Theme 1.0.55
 */
function prime2g_get_postsdata_array( array $get, array $args, array $options ) {

$index	=	$value	=	'';	# @$get
$emptyoption	=	false;

extract( $get );

$indexes	=	$values	=	[];

if ( $emptyoption ) {
	$indexes[]	=	'';
	$values[]	=	'';
}

$getPosts	=	prime2g_wp_query( $args, $options );

foreach ( $getPosts as $post ) {
	$indexes[]	=	$post->$index;
	$values[]	=	$post->$value;
}

return array_combine( $indexes, $values );

}

