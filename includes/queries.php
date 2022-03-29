<?php defined( 'ABSPATH' ) || exit;

/**
 *	POSTS QUERY
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

function prime2g_get_posts_query( $posttype, $count, $offset, $orderby, $taxonomy, $inornot, $tax_slug, $template ) {

$args	=	array(
	'post_type'		=>	$posttype,
	'posts_per_page'	=>	$count,
	'offset'		=>	$offset,
	'orderby'		=>	$orderby,
	'ignore_sticky_posts'	=>	true,
	'tax_query'		=>	array(
	array(
		'taxonomy'	=>	$taxonomy,
		'field'		=>	'slug',
		'operator'	=>	$inornot,
		'terms'		=>	$tax_slug,
		),
	),
);
	$loop = new WP_Query( $args );

	if ( $loop->have_posts() ) {
		while ( $loop->have_posts() ) {

			$loop->the_post();
			$template();

		}
		wp_reset_postdata();
	}
	else {
		echo __( 'No entries found for your request', 'toongeeprime-theme' );
	}

}


