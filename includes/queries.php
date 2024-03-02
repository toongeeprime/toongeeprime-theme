<?php defined( 'ABSPATH' ) || exit;

/**
 *	POSTS QUERY
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	Since 1.0.50: $get argument changed to $options
 */

function prime2g_wp_query( array $args, $options = 'posts' ) {
/**
 *	$get == string, for backwards compatibility
 *	$setCache & $useCache == false, not to break former output
 */

#	get_transient || get_site_transient vs cache??
$get		=	$options;
$setCache	=	$useCache	=	false;

if ( is_array( $options ) ) {
	$get		=	null;
	$cacheName	=	'prime2g_wp_query';
	$cacheTime	=	PRIME2G_CACHE_EXPIRES;	# @since 1.0.61
extract( $options );
}

/**
 *	The cache-setting call should not "use" cache:
 *	Other calls can use the set cache
 */
if ( $useCache ) {
	$cached	=	wp_cache_get( $cacheName, PRIME2G_POSTSCACHE );

	if ( false !== $cached ) {
		$loop	=	$cached;
	}
	else {
		$loop	=	new WP_Query( $args );
		wp_cache_set( $cacheName, $loop, PRIME2G_POSTSCACHE, $cacheTime );
	}
}
else {
	$loop	=	new WP_Query( $args );
	if ( $setCache ) wp_cache_set( $cacheName, $loop, PRIME2G_POSTSCACHE, $cacheTime );
}

wp_reset_postdata();

if ( $get === 'posts' ) return $loop->posts;	# array
if ( $get === 'count' ) return $loop->found_posts;	# not exactly necessary
return $loop; # object when $get === null
}



/**
 *	Disable WP Rich Text Editor for 'prime_template_part' post type *hardcoded
 *	@since 1.0.49
 */
add_filter( 'user_can_richedit', function( $default ) {
global $post;
if ( ! is_object( $post ) ) return $default;

# 1.0.57
$net_home_extras	=	prime2g_constant_is_true( 'PRIME2G_EXTRAS_BY_NETWORK_HOME' );
if ( $net_home_extras ) switch_to_blog( 1 );

if ( ! get_theme_mod( 'prime2g_template_parts_richedit' ) ) {
	if ( $post->post_type === 'prime_template_part' ||
	$post->post_type === 'prime_template_parts' ) return false;
}

if ( $net_home_extras ) restore_current_blog();

return $default;
}
);



/**
 *	INSERT TEMPLATE PART
 *	Gets Theme "Template Parts" Post Type
 *	@since 1.0.50
 */
function prime2g_insert_template_part( $id, bool $echo = true ) {
$part	=	null;

$args	=	array(
	'post_type'	=>	'prime_template_parts',
	'offset'	=>	0,
	'posts_per_page'	=>	-1
);

$options	=	[ 'cacheName' => 'prime2g_template_parts' ];

$parts	=	prime2g_wp_query( $args, $options );

if ( $parts->have_posts() ) {
	while ( $parts->have_posts() ) {
	$parts->the_post();
	if ( $id != get_the_ID() ) continue;

		if ( $echo )
			$part	=	the_content();
		else
			$part	=	do_shortcode( get_the_content() );
	}
}
return $part;
}



/**
 *	GET TEMPLATED POSTS QUERY OUTPUT
 *	@since ToongeePrime Theme 1.0.71
 */
function prime2g_get_posts_output( array $params = [] ) {
$process	=	array_merge(
[
	'count'	=>	5,
	'words'	=>	10,
	'order'	=>	'DESC',
	'orderby'	=>	'rand',
	'post_type'	=>	'post',
	'taxonomy'	=>	'category',
	'inornot'	=>	'NOT IN',
	'terms'		=>	'uncategorized',
	'looptemplate'	=>	null,
	'read_more'	=>	'Read more',
	'set_cache'	=>	false,	#	should be used for the starting function call in a group
	'use_cache'	=>	false,	#	should be used for outputting in the group
	'cache_name'=>	'prime2g_posts_output',	#	should be named according to groups
	'offset'	=>	0,
	'device'	=>	'',
	'pagination'=>	0,	#	works best in a "page"
	'image_size'	=>	'medium',
	'image_to_video'=>	'',
	'site_id'	=>	null,
	'randomize_sites'	=>	''
],
$params
);

extract( $process );

$isMobile	=	wp_is_mobile();
if ( in_array( $device, prime2g_devices_array()->desktops ) && $isMobile ) return;
if ( in_array( $device, prime2g_devices_array()->mobiles ) && ! $isMobile ) return;

$termsArray	=	explode( ',', $terms );
if ( count( $termsArray ) > 1 ) {
	$terms	=	$termsArray;
}

$pagedNum	=	basename( prime2g_get_current_url() );
$paged		=	is_numeric( $pagedNum ) ? (int) $pagedNum : 1;

$args	=	array(
'post_type'	=>	$post_type,
'order'		=>	$order,
'orderby'	=>	$pagination ? 'date' : $orderby,
'paged'		=>	$paged,
'page'		=>	$paged,
'offset'	=>	$pagination ? null : $offset,
'posts_per_page'	=>	(int) $count,
'ignore_sticky_posts'	=>	true,
'tax_query'	=>	array( [
	'taxonomy'	=>	$taxonomy,
	'field'		=>	'slug',
	'operator'	=>	$inornot,
	'terms'		=>	$terms
] )
);

if ( $set_cache === 'yes' ) $set_cache = true;
if ( $use_cache === 'yes' ) $use_cache = true;

$options	=	array(
	'setCache'	=>	$set_cache,
	'useCache'	=>	$use_cache,
	'cacheName'	=>	$cache_name
);

$output	=	$set_cache ? '<div class="hide scode-startcache">Start ' . $cache_name : '<div class="widget_posts grid">';

#	@since 1.0.70
$isNetwork	=	is_multisite();
if ( $isNetwork ) {

#	$site_id should override site randomization
if ( $site_id ) {
	$site_id	=	(int) $site_id;
}
else {
if ( $randomize_sites === 'yes' ) {
	$siteIDs	=	get_sites( [ 'fields' => 'ids' ] );
	shuffle( $siteIDs );
	$site_id	=	$siteIDs[0];
}
}

if ( $site_id ) switch_to_blog( $site_id );
}

$loop	=	prime2g_wp_query( $args, $options );

if ( $loop->have_posts() ) {

if ( $set_cache ) { $output	.=	''; }
else {

while ( $loop->have_posts() ) {
$post	=	$loop->the_post();
	$postArgs	=	[
		'post'		=>	$post,
		'length'	=>	$words,
		'readmore'	=>	$read_more,
		'size'		=>	$image_size,
		'edit_link'	=>	false,
		'switch_img_vid'	=>	$image_to_video === 'yes' ? true : false
	];
	$output	.=	$looptemplate ?
	( function_exists( $looptemplate ) ? $looptemplate() : prime2g_get_archive_loop_post_object( $postArgs ) )
	: prime2g_get_archive_loop_post_object( $postArgs );
}

}

}
else {
if ( current_user_can( 'edit_posts' ) )
	$output	.=	__( 'No entries found for this shortcode request.', PRIME2G_TEXTDOM );
}

#	@since 1.0.70
if ( $isNetwork && $site_id ) restore_current_blog();

$output	.=	'</div>';

if ( is_object( $loop ) && $pagination === 'yes' && is_page() ) {
	$output	.=	prime2g_pagination_nums( $loop, false );
}

wp_reset_postdata();
return $output;
}


