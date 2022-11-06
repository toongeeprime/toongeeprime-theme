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
 *	ADD PART TO TEMPLATE
 *	Uses "Template Part" Post Type
 *	Useful if just one is needed per template, otherwise use prime2g_wp_query()
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.48.10
 */
function prime2g_add_template_part( $slug, $section ) {
$content	=	null;

$args	=	array(
	'post_type'		=>	'template_part',
	'pagename'		=>	$slug,
	'posts_per_page'	=>	1,
	'tax_query' => array(
		array(
			'taxonomy'	=>	'template_section',
			'field'		=>	'slug',
			'terms'		=>	$section,
		),
	),
);

$part	=	new WP_Query( $args );

if ( $part->have_posts() ) {
	$part->the_post();
	$content	=	the_content();
}

wp_reset_postdata();
return $content;
}

