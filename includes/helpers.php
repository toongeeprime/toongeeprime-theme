<?php defined( 'ABSPATH' ) || exit;

/**
 *	HELPER FUNCTIONS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	To remove main sidebar from a template
 */
function prime2g_removeSidebar() { if ( ! function_exists( 'define_2gRMVSidebar' ) ) { function define_2gRMVSidebar(){} } }

/**
 *	nonce verifier
 *	@since 1.0.46
 */
function prime2g_verify_nonce( $actionName = 'prime_nonce_action' ) {
	if ( ! isset( $_REQUEST[ '_prime-nonce' ] ) || ! wp_verify_nonce( $_POST[ '_prime-nonce' ], $actionName ) ) {
		$msg	=	__( 'Failed security verification!', PRIME2G_TEXTDOM ); wp_die( $msg );
	}
}

/**
 *	If current user is post author
 *	@since 1.0.45
 */
function prime2g_is_post_author( $post, $userID = null ) {
	return ( $userID ) ? $post->post_author == $userID :
	$post->post_author == get_current_user_id();
}

/**
 *	Use prime2g_remove_title() to remove the title from a template
 */
function prime2g_remove_title() { function define_2gRMVTitle(){} }

/**
 *	Use prime2g_is_plain_page() to declare a template as being plain.
 *	Thus, can be used to remove select features, widgets, etc.
 */
function prime2g_is_plain_page() { function define_2gPlainPage(){} }

/**
 *	Get Country via 2 Char Code
 *	More @ http://country.io/data/
 *	@since 1.0.47
 */
function prime2g_get_country_by_code( $code ) {
	if ( $cached = wp_cache_get( 'country_codes_json', PRIME2G_CACHEGROUP ) ) { return $cached; }
	else {
		//	$countries	=	json_decode( file_get_contents( "http://country.io/names.json" ), true );
		$countries	=	json_decode( file_get_contents( "https://dev.akawey.com/cdn/countrynames.json" ), true );
		wp_cache_set( 'country_codes_json', $countries[ $code ], PRIME2G_CACHEGROUP, MONTH_IN_SECONDS + 2173 );
		return wp_cache_get( 'country_codes_json', PRIME2G_CACHEGROUP );
	}
}

/**
 *	Use Theme Extras?
 *	@since 1.0.48
 */
function prime2g_use_extras() { return ( defined( 'PRIME2G_EXTRAS' ) && PRIME2G_EXTRAS === true ); }

/**
 *	Use PWA?
 *	@since 1.0.55
 */
function prime2g_add_theme_pwa() { return ( defined( 'PRIME2G_ADD_PWA' ) && PRIME2G_ADD_PWA === true ); }

#	Preferred @ front-end
function prime2g_activate_theme_pwa() {
	$activate	=	prime2g_add_theme_pwa();
	if ( function_exists( 'prime2g_child_pwa_activator' ) ) return $activate;
	return get_theme_mod( 'prime2g_use_theme_pwa', 0 ) && $activate;
}

/**
 *	Control Design from Network home on multisite installs?
 *	@since 1.0.55, updated with prime2g_constant_is_true() @since 1.0.57
 */
function prime2g_design_by_network_home() {
	return prime2g_constant_is_true( 'PRIME2G_DESIGN_BY_NETWORK_HOME' );
}

/* @since 1.0.57 */
function prime2g_designing_at_networkhome() { return prime2g_design_by_network_home() && get_current_blog_id() === 1; }

/**
 *	Get Site' Domain name
 *	@since 1.0.49
 */
function prime2g_get_site_domain( $site = null ) {
if ( is_multisite() && in_array( $site, [ 1, '1', 'home', 'main' ] ) )
	$url	=	network_home_url();
else
	$url	=	get_bloginfo( 'url' );

$url	=	parse_url( $url );
$url	=	preg_replace( '/^www\./', '', $url['host'] );
return $url;
}

/**
 *	@since Theme 1.0.50
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
/* @since 1.0.50 End */

/**
 *	@since 1.0.55
 */
function prime2g_get_current_url() {
if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' ) $url	=	"https://";   
else $url	=	"http://";   
	$url	.=	$_SERVER[ 'HTTP_HOST' ];
	$url	.=	$_SERVER[ 'REQUEST_URI' ];
return $url;
}

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
/* @since 1.0.55 End */

/**
 *	Check Minimum Child Theme Version
 *	@since 1.0.56
 */
function prime_child_min_version( string $version ) {
if ( defined( 'CHILD2G_VERSION' ) ) // removed use of is_child_theme()
	return version_compare( CHILD2G_VERSION, $version, '>=' );
return true;	// features should work in parent
}

/* @since 1.0.57 */
function prime2g_constant_is_true( string $constant, bool $for_network = true ) {
	if ( $for_network !== false && ! is_multisite() ) return false;
	return ( defined( $constant ) && constant( $constant ) === true );
}

/* @since 1.0.70 */
function prime2g_devices_array() {
return (object) [
'desktops'	=>	[ 'desktop', 'desktops', 'laptop', 'laptops', 'computer', 'computers' ],
'mobiles'	=>	[ 'mobile', 'mobiles', 'phone', 'phones', 'iphone', 'iphones', 'tablet', 'tablets' ],
];
}

function prime_url_is_ok( string $url ) {
$headers	=	get_headers( $url );
return stripos( $headers[0],"200 OK" ) ? true : false;
}

/* @since 1.0.73 */
function p2g_str_contains( string $string, $contains ) {
	if ( is_string( $contains ) ) {
		return str_contains( $string, $contains );
	}
	if ( is_array( $contains ) ) {
		$result	=	[];
		foreach( $contains as $str ) {
			$result[]	=	str_contains( $string, $str );
		}
	return in_array( true, $result );
	}
return 'Needle type is neither string nor array';
}


function prime_wp_forbidden_slugs() {
$wp	=	new WP;
return array_merge( $wp->public_query_vars, $wp->private_query_vars );
}


function prime_url_has_params( string $url ) {
$args	=	explode( '?', $url );
return  isset( $args[1] );
}


/* @since 1.0.76 */
function prime_strip_url_end( string $url ) {
$path	=	trim( parse_url( $url, PHP_URL_PATH ), '/' );
$parts	=	explode( '/', $path );
return end( $parts );
}


/* @since 1.0.77 */
if ( ! function_exists( 'prime_post_types_group' ) ) {
function prime_post_types_group() {
return (object) [
	'has_brand'	=>	[ 'product' ],
];
}
}

if ( ! function_exists( 'prime_taxonomies_group' ) ) {
function prime_taxonomies_group() {
return (object) [
	'has_archive_image'	=>	[ 'post_tag', 'category', 'brand' ]
];
}
}


/* @since 1.0.89 */
function prime2g_customizer_pages_ids() {
return [
	(int) get_theme_mod( 'prime2g_404error_page_id', 0 ),
	(int) get_theme_mod( 'prime2g_custom_login_page_id', 0 ),
	(int) get_theme_mod( 'prime2g_shutdown_page_id', 0 ),
	(int) get_theme_mod( 'prime2g_privatesite_homepage_id', 0 )
];
}


if ( ! function_exists( 'prime_exclude_ids_from_search' ) ) {
function prime_exclude_ids_from_search() : array {
if ( $idsCache = wp_cache_get( 'exclude_ids_in_search', PRIME2G_CACHEGROUP ) ) { return $idsCache; }
else {

$query	=	new WP_Query( [
'posts_per_page'=>	-1,
'meta_key'		=>	'exclude_from_search',
'meta_value'	=>	'1'
] );

$ids	=	[];
if ( $query->have_posts ) {
$posts	=	$query->posts;
foreach ( $posts as $post ) {
	$ids[]	=	$post->ID;
}
}
wp_reset_postdata();

$idsCache	=	array_merge( $ids, prime2g_customizer_pages_ids() );
wp_cache_set( 'exclude_ids_in_search', $idsCache, PRIME2G_CACHEGROUP, HOUR_IN_SECONDS + 8 );
return $idsCache;
}
}
}


/* @since 1.0.95 */
function prime2g_has_sticky_sidebar_togg() {
$styles	=	ToongeePrime_Styles::mods_cache();
return in_array( $styles->sidebar_place, [ 'sticky_right', 'sticky_left' ] ) && $styles->sticky_sb_tog;
}


