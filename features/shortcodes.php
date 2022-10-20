<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME SHORTCODES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */
/**
 *	DISPLAY POSTS SHORTCODE
 *	Function Upgraded
 *	@since ToongeePrime Theme 1.0.45.00
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
		),
	$atts
);
extract( $atts );


$args	=	array(
	'post_type'		=>	$post_type,
	'orderby'		=>	$order,
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

$loop	=	prime2g_wp_query( $args, null );

if ( $loop->have_posts() ) {

$template	=	'<div class="widget_posts grid">';

	while ( $loop->have_posts() ) {

		$loop->the_post();
		$template	.=	prime2g_get_archive_loop( 'medium', true, $words, false, false, 'h3' );

	}

$template	.=	'</div>';

wp_reset_postdata();

return $template;

}
else {
	if ( current_user_can( 'edit_others_posts' ) )
		return __( 'No entries found for this shortcode request', PRIME2G_TEXTDOM );
}

}

