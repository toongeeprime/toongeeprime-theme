<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME SHORTCODES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */


/**
 *	DISPLAY POSTS IN WIDGET
 */
add_shortcode( 'prime2g_display_posts', 'prime2g_posts_shortcode' );
function prime2g_posts_shortcode( $atts ) {
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
