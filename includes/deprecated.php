<?php defined( 'ABSPATH' ) || exit;

/**
 *	DEPRECATED FUNCTIONS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.43.00
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
 *	Function prime2g_posts_shortcode upgraded
 *	@since ToongeePrime Theme 1.0.45.00
 */
function x_prime2g_posts_shortcode( $atts ) {
$atts	=	shortcode_atts(
	array(
		'count'	=>	5,
		'words'	=>	10,
		'order'	=>	'date',
		),
	$atts
);
extract( $atts );

ob_start();
?>
	<div class="widget_posts grid">
	<?php
		prime2g_get_posts_query( "post", $count, 0, $order, "category", "NOT IN", "none",
			function() use( &$words ) {
				prime2g_archive_loop( 'medium', true, $words, false, false, 'h3' );
			}
		);
	?>
	</div>
<?php
return ob_get_clean();
}



