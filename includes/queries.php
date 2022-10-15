<?php defined( 'ABSPATH' ) || exit;

/**
 *	POSTS QUERY
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	Updated since ToongeePrime Theme 1.0.43.00
 */

function prime2g_wp_query( array $args, $get = 'posts' ) {
$loop	=	new WP_Query( $args );
if ( $get === 'posts' ) return $loop->posts;
if ( $get === 'count' ) return $loop->found_posts;
return $loop;
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

