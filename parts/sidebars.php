<?php defined( 'ABSPATH' ) || exit;

/**
 *	SITE'S SIDEBARS AND WIDGET AREAS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	MAIN SIDEBAR
 */
if ( ! function_exists( 'prime2g_sidebar' ) ) {

function prime2g_sidebar() {

/**
 *	return, if prime2g_removeSidebar() is called === where the function is defined
 */
if ( function_exists( 'define_2gRMVSidebar' ) ) return;

if ( is_active_sidebar( 'primary-sidebar' ) ) { ?>

<aside id="sidebar" role="complementary" class="right mainsidebar sidebars asides">
	<div id="primary_side" class="widgets-box grid">

	<?php dynamic_sidebar( 'primary-sidebar' ); ?>

	</div>
</aside>

<?php
}

}

}


/**
 *	WIDGETS SET AFTER POSTS
 */
add_action( 'prime2g_after_post', 'prime2g_below_posts_widgets', 20 );
if ( ! function_exists( 'prime2g_below_posts_widgets' ) ) {

function prime2g_below_posts_widgets() {

if ( function_exists( 'define_2gPlainPage' ) ) return;

if ( is_active_sidebar( 'belowposts-widgets' ) ) { ?>
	<aside id="below_postsWidgets" class="asides clear">
		<div class="widgets-box grid">
			<?php dynamic_sidebar( 'belowposts-widgets' ); ?>
		</div>
	</aside>
<?php
}

}

}


/**
 *	FOOTER-TOP WIDGETS
 *	Widgets at the top of the Site's Footer
 */
if ( ! function_exists( 'prime2g_footer_top_widgets' ) ) {

function prime2g_footer_top_widgets() {

if ( function_exists( 'define_2gPlainPage' ) ) return;

if ( is_active_sidebar( 'footer-top' ) ) { ?>
	<aside id="footer_topWidgets" class="footer_topWidgets asides site_width">
		<div class="widgets-box grid">
			<?php dynamic_sidebar( 'footer-top' ); ?>
		</div>
	</aside>
<?php
}

}

}


/**
 *	FOOTER WIDGETS
 *	Updated for customizer columns @since ToongeePrime Theme 1.0.55
 */
if ( ! function_exists( 'prime2g_footer_widgets' ) ) {

function prime2g_footer_widgets() {

$cols	=	4;
$wID	=	'';
if ( CHILD2G_VERSION >= '2.0' ) {
	$cols	=	(int) get_theme_mod( 'prime2g_footer_columns_num', '4' );
}

for ( $n = 1; $n <= $cols; $n++ ) {
if ( $n > 1 ) $wID	=	'-' . $n;
	$hasactive	=	is_active_sidebar( 'footers'. $wID ); break;
}

if ( $hasactive ) { ?>

<aside id="sitebasebar" role="complementary" class="sidebars asides grid grid<?php echo $cols; ?> site_width footer">

<?php
for ( $n = 1; $n <= $cols; $n++ ) {
if ( $n > 1 ) $wID	=	'-' . $n;

echo	'<div id="f-widgets'. $n .'" class="footer-widgets">';

	if ( is_active_sidebar( "footers{$wID}" ) ) {
	echo '<div class="widgets-box grid">';
		dynamic_sidebar( "footers{$wID}" );
	echo '</div>';
	}

echo	'</div>';

}
?>

</aside>
<?php
}

}

}
