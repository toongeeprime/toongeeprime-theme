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
		'order'	=>	'rand',
		'post_type'	=>	'post',
		'taxonomy'	=>	'category',
		'inornot'	=>	'NOT IN',
		'terms'		=>	'uncategorized',
		'looptemplate'	=>	null,	#	@since 1.0.46
		'read_more'	=>	'Read more',#	@since 1.0.50, works with caching template
		'cache_it'	=>	false,	#	@since 1.0.50
		'use_cache'		=>	false,	#	@since 1.0.50
		'start_cache'	=>	false,	#	@since 1.0.50
		'cache_name'	=>	'prime2g_posts_shortcode',	#	@since 1.0.50
		'offset'		=>	0,	#	@since 1.0.50
		'device'		=>	0,	#	@since 1.0.55
		),
	$atts
);
extract( $atts );

$isMobile	=	wp_is_mobile();

if ( $device === 'desktop' ) { if ( $isMobile ) return; }
if ( $device === 'mobile' ) { if ( ! $isMobile ) return; }


#	@since ToongeePrime Theme 1.0.49
$termsArray	=	explode( ',', $terms );
if ( count( $termsArray ) > 1 ) {
	$terms	=	$termsArray;
}


$args	=	array(
	'post_type'		=>	$post_type,
	'orderby'		=>	$order,
	'offset'		=>	$offset,
	'posts_per_page'	=>	$count,
	'ignore_sticky_posts'	=>	true,
	'tax_query'		=>	array(
		array(
			'taxonomy'	=>	$taxonomy,
			'field'		=>	'slug',
			'operator'	=>	$inornot,
			'terms'		=>	$terms,
			),
		),
);


$get_array	=	null;
# string 'posts' returns array in prime2g_wp_query()
if ( $cache_it == 'yes' || $use_cache == 'yes' ) $get_array = 'posts';
if ( $cache_it == 'yes' ) $cache_it = true;
if ( $use_cache == 'yes' ) $use_cache = true;

if ( $start_cache == 'yes' ) $start_cache	=	true;


$options	=	array(
	'get'		=>	$get_array,
	'cacheIt'	=>	$cache_it,
	'useCache'	=>	$use_cache,
	'cacheName'	=>	$cache_name,
);


$template	=	$start_cache ? '<div class="hide scode-cache">' : '<div class="widget_posts grid">';


if ( $cache_it || $use_cache ) {

/**
 *	If using cache, work with wp_query as an array
 */

	$loop	=	prime2g_wp_query( $args, $options ); #array
	if ( ! empty( $loop ) ) {

	if ( $order === 'rand' )
		shuffle( $loop );

	for ( $p = 0; $p < $count; $p++ ) {
	if ( ! isset( $loop[ $p ] ) ) continue;
		if ( $start_cache ) {
			$template	.=	'';
		}
		else {
			$postArgs	=	[
				'post'	=>	$loop[ $p ],
				'length'	=>	$words,
				'readmore'	=>	$read_more,
			];
			$template	.=	( $looptemplate ) ? $looptemplate() :
				prime2g_get_archive_loop_post_object( $postArgs );
		}
	}

	}
	else {
		if ( current_user_can( 'edit_posts' ) )
			$template	.=	__( 'No entries found for this shortcode request', PRIME2G_TEXTDOM );
	}

}
else {

	$loop	=	prime2g_wp_query( $args, $options ); #object

	if ( $loop->have_posts() ) {

	while ( $loop->have_posts() ) {

		$loop->the_post();
		$template	.=	( $looptemplate ) ?
			$looptemplate() : prime2g_get_archive_loop( 'medium', true, $words, false, false, 'h3' );

	}

	}
	else {
		if ( current_user_can( 'edit_posts' ) )
			$template	.=	__( 'No entries found for this shortcode request', PRIME2G_TEXTDOM );
	}

}

$template	.=	'</div>';

return $template;

}


