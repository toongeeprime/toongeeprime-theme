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
 *	$set_cache & $use_cache == false, not to break former output
 */

#	get_transient || get_site_transient vs cache??
$get		=	$options;
$set_cache	=	$use_cache	=	false;

if ( is_array( $options ) ) {
	$get		=	null;
	$cache_name	=	'prime2g_wp_query';
	$cacheTime	=	PRIME2G_CACHE_EXPIRES;	# @since 1.0.61
extract( $options );
}

/**
 *	The cache-setting call should not "use" cache
 *	Other calls can use the set cache
 */
if ( $use_cache ) {
	$cached	=	wp_cache_get( $cache_name, PRIME2G_POSTSCACHE );

	if ( false !== $cached ) {
		return $cached;
	}
	else {
		$loop	=	new WP_Query( $args );
		$loop	=	$get === 'posts' ? $loop->posts : $loop;
		wp_cache_set( $cache_name, $loop, PRIME2G_POSTSCACHE, $cacheTime );
	}
}
else {
	$loop	=	new WP_Query( $args );
	$loop	=	$get === 'posts' ? $loop->posts : $loop;
	if ( $set_cache ) wp_cache_set( $cache_name, $loop, PRIME2G_POSTSCACHE, $cacheTime );
}

wp_reset_postdata();

return $loop; # object if $get === null || array
}



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

$options	=	[ 'cache_name' => 'prime2g_template_parts' ];

$parts	=	prime2g_wp_query( $args, $options );

$id	=	(int)$id;

if ( $parts->have_posts() ) {
	while ( $parts->have_posts() ) {
	$parts->the_post();
	if ( $id !== get_the_ID() ) continue;

		if ( $echo )
			$part	=	the_content();
		else
			$part	=	do_shortcode( get_the_content() );
	}
}

wp_reset_postdata();
return $part;
}



/**
 *	GET TEMPLATED POSTS QUERY OUTPUT
 *	@since 1.0.71
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
	'randomize_sites'=>	'',
	'no_result'	=>	'Nothing found for this query!',
	'post_ids'	=>	''	// @since 1.0.79
],
$params
);

extract( $process );

$isMobile	=	wp_is_mobile();
$devices	=	prime2g_devices_array();
if ( in_array( $device, $devices->desktops ) && $isMobile ) return;
if ( in_array( $device, $devices->mobiles ) && ! $isMobile ) return;

$termsArray	=	explode( ',', $terms );
if ( count( $termsArray ) > 1 ) {
	$terms	=	$termsArray;
}

$pagedNum	=	basename( prime2g_get_current_url() );
$paged		=	is_numeric( $pagedNum ) ? (int) $pagedNum : 1;
$postIDs	=	empty( $post_ids ) ? null : explode( ',', $post_ids );

$args	=	array(
'post_type'	=>	$post_type,
'post__in'	=>	$postIDs,
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
	'set_cache'	=>	$set_cache,
	'use_cache'	=>	$use_cache,
	'cache_name'	=>	$cache_name
);

$output	=	$set_cache ? '<div class="hide query-startcache">Start ' . $cache_name : '<div class="widget_posts grid">';

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
	$output	.=	$looptemplate && function_exists( $looptemplate ) ? $looptemplate()
	: prime2g_get_archive_loop_post_object( $postArgs );
}

}

}
else {
if ( current_user_can( 'edit_posts' ) )
	$output	.=	__( $no_result, PRIME2G_TEXTDOM );
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

