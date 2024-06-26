<?php defined( 'ABSPATH' ) || exit;
/**
 *	DEPRECATED FUNCTIONS ::Prepare file removal @1.1.00
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.43
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
	if ( current_user_can( 'edit_others_posts' ) )
		echo __( 'No entries found for your request', PRIME2G_TEXTDOM );
}
}

/**
 *	ADD PART TO TEMPLATE
 *	Deprecated @since 1.0.50
 */
function prime2g_add_template_part( $slug, $section, $echo = true ){
$content	=	null;
$args	=	array(
	'post_type'		=>	'prime_template_part',
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
	if ( $echo ) { $content = the_content(); }
	else { $content = get_the_content(); }
}
wp_reset_postdata();
return $content;
}

/**
 *	Get a Template Part
 *	Deprecated @since 1.0.50
 */
add_shortcode( 'prime2g_add_template_part', 'prime2g_add_template_part_shortcode' );
function prime2g_add_template_part_shortcode( $atts ) {
$atts	=	shortcode_atts( array( 'slug'	=>	'hello', 'section'	=>	'header' ), $atts );
extract( $atts );

$part	=	prime2g_add_template_part( $slug, $section, false );
if ( ! $part ) { return __( 'Requested Template Part Does Not Exist', PRIME2G_TEXTDOM ); }
return $part;

}

/**
 *	Deprecated @since 1.0.55
 */
#	Send contents to footer:
add_shortcode( 'prime_send_to_footer', 'prime2g_send_content_to_footer' );
function prime2g_send_content_to_footer( $atts, $content, $tag ) {

$contents	=	do_shortcode( $content );

add_action( 'wp_footer', function() use( $contents ) { echo $contents; } );
}

/**
 *	Include or exclude post types
 *	@since 1.0.70
 */
if ( ! function_exists( 'prime2g_include_post_types' ) ) {
	function prime2g_include_post_types( array $addTo = [ 'post', 'page' ] ) { return $addTo; }
}

if ( ! function_exists( 'prime2g_exclude_post_types' ) ) {
	function prime2g_exclude_post_types( array $pTypes = [ 'page' ] ) { return ( ! in_array( get_post_type(), $pTypes ) ); }
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

