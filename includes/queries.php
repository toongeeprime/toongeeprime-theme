<?php defined( 'ABSPATH' ) || exit;
/**
 *	POSTS QUERY
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	Since 1.0.50: $get argument changed to $options
 */

#	@since 1.0.96
function prime2g_calc_query_offset( $count ) {
$paged	=	get_query_var( 'paged' );
return $paged ? $count * ( $paged - 1 ) : '';
}


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
	$cache_time	=	1;	# @since 1.0.61
extract( $options );
}

$cachTime	=	(int) $cache_time * HOUR_IN_SECONDS;	# @since 1.0.80

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
		wp_cache_set( $cache_name, $loop, PRIME2G_POSTSCACHE, $cachTime );
	}
}
else {
	$loop	=	new WP_Query( $args );
	$loop	=	$get === 'posts' ? $loop->posts : $loop;
	if ( $set_cache ) wp_cache_set( $cache_name, $loop, PRIME2G_POSTSCACHE, $cachTime );
}

wp_reset_postdata();

return $loop;	# object if $get === null || array
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
	'posts_per_page'=>	-1
);

$options=	[ 'cache_name' => 'prime2g_template_parts' ];
$parts	=	prime2g_wp_query( $args, $options );
$id		=	(int) $id;

if ( $parts->have_posts() ) {
	while ( $parts->have_posts() ) {
	$parts->the_post();
	if ( $id !== get_the_ID() ) continue;

		if ( $echo )
			$part	=	the_content();
		else
			$part	=	apply_filters( 'the_content', get_the_content() );
	}
}

wp_reset_postdata();
return $part;
}



/**
 *	DEFAULT OPTIONS FOR prime2g_get_posts_output() and other functions that use it
 *	@since 1.0.80
 */
function prime2g_get_posts_output_default_options() : array {
return [
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
	'post_ids'	=>	'',	#	@since 1.0.79
	'cache_time'=>	'',	#	@since 1.0.80
	'get'		=>	'',
	'classes'	=>	'widget_posts grid',	#	*** 'woocommerce' for products, @since 1.0.98
	'product_classes'=>	'grid columns-4'
];
}



/**
 *	GET TEMPLATED POSTS QUERY OUTPUT
 *	@since 1.0.71
 */
function prime2g_get_posts_output( array $params = [] ) {
$process	=	array_merge( prime2g_get_posts_output_default_options(), $params );

extract( $process );

$isMobile	=	wp_is_mobile();
$devices	=	prime2g_devices_array();
if ( in_array( $device, $devices->desktops ) && $isMobile ) return;
if ( in_array( $device, $devices->mobiles ) && ! $isMobile ) return;

$is_product	=	$post_type === 'product';	# @since 1.0.98

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
'ignore_sticky_posts'=>	true,
'tax_query'	=>	array( [
	'taxonomy'	=>	$taxonomy,
	'field'		=>	'slug',
	'operator'	=>	$inornot,
	'terms'		=>	$terms
] )
);


$options	=	array(
	'set_cache'	=>	$set_cache === 'yes',
	'use_cache'	=>	$use_cache === 'yes',
	'cache_name'=>	$cache_name,
	'cache_time'=>	$cache_time,
	'get'		=>	$get === 'posts' ? 'posts' : null	#	@since 1.0.80
);

$output	=	$set_cache ? '<div class="hide query-startcache">Start ' . $cache_name : '<div class="'. $classes .'">';

$output	.=	$is_product ? '<ul class="products '. $product_classes .'">' : '';

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

if ( $get === 'posts' ) {
	if ( $isNetwork && $site_id ) restore_current_blog();
	return $loop;
}

if ( $loop->have_posts() ) {

if ( $set_cache ) { $output	.=	''; }	#	cache setter must not output
else {

/**
 *	WooCommerce echoes, so buffer is needed
 *	Start buffer before loop to prevent repeat
 */
if ( $is_product ) ob_start();


while ( $loop->have_posts() ) {
$post	=	$loop->the_post();

if ( $is_product ) {
	#	args not needed in WooCommerce
	$output	.=	$looptemplate && function_exists( $looptemplate ) ? $looptemplate()
	: prime2g_archive_loop_product_template();
}
else {
	$postArgs	=	[
		'post'		=>	$post,
		'length'	=>	$words,
		'readmore'	=>	$read_more,
		'size'		=>	$image_size,
		'edit_link'	=>	false,
		'switch_img_vid'	=>	$image_to_video === 'yes' ? true : false
	];
	$output	.=	$looptemplate && function_exists( $looptemplate ) ? $looptemplate( $postArgs )
	: prime2g_get_archive_loop_post_object( $postArgs );
}
}


/*	End product buffer after loop	*/
if ( $is_product ) {
	$output	.=	ob_get_contents();
	ob_end_clean();
}

wp_reset_postdata();
}

}
else {
if ( current_user_can( 'edit_posts' ) )
	$output	.=	__( $no_result, PRIME2G_TEXTDOM );
}

#	@since 1.0.70
if ( $isNetwork && $site_id ) restore_current_blog();

$output	.=	$is_product ? '</ul>' : '';

$output	.=	'</div>';

if ( is_object( $loop ) && $pagination === 'yes' && is_page() ) {
	$output	.=	prime2g_pagination_nums( $loop, false );
}

return $output;
}




/**
 *	Allow searching of custom fields
 *	@since 1.0.88
 *	@ https://gist.github.com/coffeepostal/e3bb164658781a962cf21d37dd3aaf63
 */
if ( ToongeePrime_Styles::mods_cache()->search_in_cf ) {

//	Join for searching metadata
add_filter( 'posts_join', 'prime2g_filter_wp_posts_join' );
function prime2g_filter_wp_posts_join( $join ) {
global $wpdb, $wp_query;
// if ( is_search() ) {
if ( ! empty( $wp_query->query_vars['s'] ) ) {
	// $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
	$join .=' LEFT JOIN '.$wpdb->postmeta. ' cfmeta ON '. $wpdb->posts . '.ID = cfmeta.post_id ';
}
return $join;
}


add_filter( 'posts_where', 'prime2g_filter_wp_posts_where', 10 );
function prime2g_filter_wp_posts_where( $where ) {
global $wpdb, $wp_query;
if ( ! empty( $wp_query->query_vars['s'] ) ) {
	$where	=	preg_replace(
	"/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
	// "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
	"(".$wpdb->posts.".post_title LIKE $1) OR (cfmeta.meta_value LIKE $1)", $where );
}
return $where;
}


//	Prevent duplicate results
add_filter( 'posts_distinct', 'prime2g_search_distinct_filter' );
function prime2g_search_distinct_filter( $where ) {
global $wpdb, $wp_query;
if ( ! empty( $wp_query->query_vars['s'] ) ) {
	return "DISTINCT";
}
return $where;
}

}



/**
 *	Theme's WP Search Filtering
 *	@since 1.0.89
 */
add_filter( 'pre_get_posts', 'prime2g_theme_pre_get_posts' );
function prime2g_theme_pre_get_posts( $query ) {

if ( $query->is_search && ! is_admin() ) {
	$query->set( 'post__not_in', prime_exclude_ids_from_search() );
}

return $query;
}


