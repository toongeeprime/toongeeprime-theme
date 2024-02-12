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

$get		=	$options;
$setCache	=	false;
$useCache	=	false;

if ( is_array( $options ) ) {
	$get		=	null;
	$setCache	=	true;
	$useCache	=	true;
	$cacheName	=	'prime2g_wp_query';
	$cacheTime	=	PRIME2G_CACHE_EXPIRES;	# @since 1.0.61
extract( $options );
}

/**
 *	The cache-setting call should not "use" cache
 *	Other calls can use the set cache
 */
if ( $useCache ) {
	$cached	=	wp_cache_get( $cacheName, PRIME2G_POSTSCACHE );

	if ( false !== $cached ) {
		$loop	=	$cached;
	}
	else {
		$loop	=	new WP_Query( $args );
		wp_reset_postdata();
		wp_cache_set( $cacheName, $loop, PRIME2G_POSTSCACHE, $cacheTime );
	}
}
else {
	$loop	=	new WP_Query( $args );
	wp_reset_postdata();
	if ( $setCache ) wp_cache_set( $cacheName, $loop, PRIME2G_POSTSCACHE, $cacheTime );
}

if ( $get === 'posts' ) return $loop->posts;
if ( $get === 'count' ) return $loop->found_posts;	# not exactly necessary
return $loop; # $get == null
}



function prime2g_defaults_query( $count, $tax_slug, $taxonomy = 'category', $ptype = 'post' ) {
$args	=	array(
	'post_type'		=>	$ptype,
	'posts_per_page'	=>	$count,
	'ignore_sticky_posts'	=>	true,
	'tax_query'		=>	array(
	array(
		'taxonomy'	=>	$taxonomy,
		'field'		=>	'slug',
		'operator'	=>	'IN',
		'terms'		=>	$tax_slug,
	)
	)
);
return prime2g_wp_query( $args );
}



/**
 *	Disable WP Rich Text Editor for 'prime_template_part' post type *hardcoded
 *	@since 1.0.49
 */
add_filter( 'user_can_richedit', function( $default ) {
global $post;
if ( ! is_object( $post ) ) return $default;

if ( ! get_theme_mod( 'prime2g_template_parts_richedit' ) ) {
	if ( $post->post_type === 'prime_template_part' ||
	$post->post_type === 'prime_template_parts' ) return false;
}

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


