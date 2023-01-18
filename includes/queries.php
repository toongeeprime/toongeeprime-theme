<?php defined( 'ABSPATH' ) || exit;

/**
 *	POSTS QUERY
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	Updated since ToongeePrime Theme 1.0.43.00
 *	Since ToongeePrime Theme 1.0.50.00: $get argument changed to $options
 */

function prime2g_wp_query( array $args, $options = 'posts' ) {

/**
 *	$get === string, for backwards compatibility
 *	$cacheIt & $useCache === false, not to break former function' results
 */

$get		=	$options;
$cacheIt	=	false;
$useCache	=	false;

if ( is_array( $options ) ) {
	$get		=	null;
	$cacheIt	=	true;
	$useCache	=	true;
	$cacheName	=	'prime2g_wp_query';

	extract( $options );
}


if ( $useCache ) {

	$cached	=	wp_cache_get( $cacheName );

	if ( false !== $cached ) {
		$loop	=	$cached;
	}
	else {
		$loop	=	new WP_Query( $args );
		wp_cache_set( $cacheName, $loop, '', PRIME2G_CACHE_EXPIRES );
	}

}
else {

	$loop	=	new WP_Query( $args );
	if ( $cacheIt ) wp_cache_set( $cacheName, $loop, '', PRIME2G_CACHE_EXPIRES );

}

if ( $get === 'posts' ) return $loop->posts;
if ( $get === 'count' ) return $loop->found_posts;

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
			),
		),
);
return prime2g_wp_query( $args );
}



/**
 *	Disable WP Rich Text Editor for 'prime_template_part' post type *hardcoded
 *	@since ToongeePrime Theme 1.0.49.00
 */
add_filter( 'user_can_richedit', function( $default ) {
global $post;
if ( ! is_object( $post ) ) return $default;

	if ( $post->post_type === 'prime_template_part' ||
	$post->post_type === 'prime_template_parts' ) return false;

return $default;
}
);



/**
 *	INSERT TEMPLATE PART
 *	Uses Theme "Template Parts" Post Type
 *	@since ToongeePrime Theme 1.0.50.00
 */
function prime2g_insert_template_part( $id, bool $echo = true ) {
$part	=	null;

$args	=	array(
	'post_type'	=>	'prime_template_parts',
	'offset'	=>	0,
	'posts_per_page'	=>	-1,
);

$options	=	array(
	'cacheName'	=>	'prime2g_template_parts',
);

$parts	=	prime2g_wp_query( $args, $options );

if ( $parts->have_posts() ) {

	while ( $parts->have_posts() ) {

	$parts->the_post();

	if ( $id != get_the_ID() ) continue;

		if ( $echo )
			$part	=	the_content();
		else
			$part	=	get_the_content();
	}

}

return $part;
}


