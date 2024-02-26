<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME SHORTCODE: GET POSTS & DISPLAY POSTS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 ***
 *	Upgraded @since ToongeePrime Theme 1.0.45
 */

add_shortcode( 'prime2g_display_posts', 'prime2g_posts_shortcode' );
function prime2g_posts_shortcode( $atts ) {
$atts	=	shortcode_atts(
array(
	'count'	=>	5,
	'words'	=>	10,
	'order'	=>	'DESC',	# ASC
	'orderby'	=>	'rand',
	'post_type'	=>	'post',
	'taxonomy'	=>	'category',
	'inornot'	=>	'NOT IN',
	'terms'		=>	'uncategorized',
	'looptemplate'	=>	null,	#	@since 1.0.46
	'read_more'	=>	'Read more',#	@since 1.0.50
	'set_cache'	=>	false,	#	should be used by the starting shortcode in a group
	'use_cache'	=>	false,	#	should be used by outputting shortcodes in the group
	'cache_name'=>	'prime2g_posts_shortcode',	#	should be named according to groups
	'offset'	=>	0,
	'device'	=>	0,	#	@since 1.0.55
	'pagination'=>	0,	#	works when shortcode is used in a "page"
	'image_size'	=>	'medium',	#	@since 1.0.70
	'image_to_video'=>	'',
	'site_id'	=>	'',
	'randomize_sites'	=>	''
),
$atts
);

extract( $atts );

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

$template	=	$set_cache ? '<div class="hide scode-startcache">Start ' . $cache_name : '<div class="widget_posts grid">';

#	@since 1.0.70
$isNetwork	=	is_multisite();
if ( $isNetwork ) {

#	$site_id should override site randomization
if ( ! empty( $site_id ) ) {
	$site_id	=	(int) $site_id;
}

if ( empty( $site_id ) && $randomize_sites === 'yes' ) {
$siteIDs	=	get_sites( [ 'fields' => 'ids' ] );
shuffle( $siteIDs );
$site_id	=	$siteIDs[0];
}

if ( $site_id ) switch_to_blog( $site_id );
}

$loop	=	prime2g_wp_query( $args, $options );

if ( $loop->have_posts() ) {

if ( $set_cache ) { $template	.=	''; }
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
	$template	.=	$looptemplate ?
	( function_exists( $looptemplate ) ? $looptemplate() : prime2g_get_archive_loop_post_object( $postArgs ) )
	: prime2g_get_archive_loop_post_object( $postArgs );
}

}

}
else {
if ( current_user_can( 'edit_posts' ) )
	$template	.=	__( 'No entries found for this shortcode request', PRIME2G_TEXTDOM );
}

#	@since 1.0.70
if ( $isNetwork && ! empty( $site_id ) ) restore_current_blog();

$template	.=	'</div>';

if ( is_object( $loop ) && $pagination === 'yes' && is_page() ) {
	$template	.=	prime2g_pagination_nums( $loop, false );
}

wp_reset_postdata();
return $template;
}

