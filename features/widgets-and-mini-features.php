<?php defined( 'ABSPATH' ) || exit;

/**
 *	WIDGETS AND MINI THEME FEATURES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */



/**
 *	Scroll back to the top of the page
 */
add_action( 'wp_footer', 'prime2g_toTop' );
function prime2g_toTop() { ?>
	<div id="prime2g_toTop">
		<p onclick="prime_gotoThis( 'body' );" title="Back to the Top">
			<span class="dashicons dashicons-arrow-up-alt"></span>
		</p>
	</div>
<?php
}



/**
 *	DISPLAY NEWS IN WIDGET
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
				prime2g_archive_loop( true, 'medium', $words, false, false, 'h3' );
			}
		);
	?>
	</div>
<?php
return ob_get_clean();
}

