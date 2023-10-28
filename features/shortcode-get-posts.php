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
	'read_more'		=>	'Read more',#	@since 1.0.50, works with caching template
	'cache_it'		=>	false,
	'use_cache'		=>	false,
	'start_cache'	=>	false,
	'cache_name'	=>	'prime2g_posts_shortcode',
	'offset'		=>	0,
	'device'		=>	0,	#	@since 1.0.55
	// 'pagination'	=>	0
	),
$atts
);

//***	REVIEW CACHING SYSTEM	***//

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
	// 'orderby'		=>	$pagination ? 'date' : $order,
	'offset'		=>	$offset,
	'posts_per_page'	=>	$count,
	'ignore_sticky_posts'	=>	true,
	'tax_query'		=>	array(
		array(
			'taxonomy'	=>	$taxonomy,
			'field'		=>	'slug',
			'operator'	=>	$inornot,
			'terms'		=>	$terms
			)
		)
);


#	null returns object else return posts array when using cache
$get_array	=	in_array( 'yes', [ $use_cache, $cache_it ] ) ? 'posts' : null;

if ( $cache_it === 'yes' ) $cache_it = true;
if ( $use_cache === 'yes' ) $use_cache = true;
if ( $start_cache === 'yes' ) $start_cache	=	true;

$options	=	array(
	'get'		=>	$get_array,
	'cacheIt'	=>	$cache_it,
	'useCache'	=>	$use_cache,
	'cacheName'	=>	$cache_name
);

$template	=	$start_cache ? '<div class="hide scode-cache">' : '<div class="widget_posts grid">';


/**
 *	If using cache, work with wp_query as an array
 */
if ( $cache_it || $use_cache ) {

	$loop	=	prime2g_wp_query( $args, $options ); #array
	if ( ! empty( $loop ) ) {

	if ( $order === 'rand' ) shuffle( $loop );

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

}
else {

	$loop	=	prime2g_wp_query( $args, $options ); #object

	if ( $loop->have_posts() ) {

	while ( $loop->have_posts() ) {

		$loop->the_post();
		$template	.=	$looptemplate ?
			( function_exists( $looptemplate ) ? $looptemplate() : prime2g_get_archive_loop( 'medium', true, $words, false, false, 'h3' ) )
			: prime2g_get_archive_loop( 'medium', true, $words, false, false, 'h3' );

	}

	}
	else {
		if ( current_user_can( 'edit_posts' ) )
			$template	.=	__( 'No entries found for this shortcode request', PRIME2G_TEXTDOM );
	}

}

$template	.=	'</div>';

// if ( is_object( $loop ) && $pagination === 'yes' && is_page() ) {
	// $template	.=	prime2g_pagination_nums( $loop, false );
// }

wp_reset_postdata();

return $template;
}


