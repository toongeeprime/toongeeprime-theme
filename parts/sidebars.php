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

<aside id="sidebar" role="complementary" class="right sidebars asides">
	<div id="primary_side" class="widgets-box grid">

	<?php dynamic_sidebar( 'primary-sidebar' ); ?>

	</div>
</aside>

<?php
}

}

}



/**
 *	WIDGETS SET UNDER POSTS
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
 */
if ( ! function_exists( 'prime2g_footer_widgets' ) ) {

function prime2g_footer_widgets() {

if ( is_active_sidebar( 'footers' ) || is_active_sidebar( 'footers-2' ) ||
is_active_sidebar( 'footers-3' ) || is_active_sidebar( 'footers-4' ) ) { ?>

<aside id="sitebasebar" role="complementary" class="sidebars asides grid site_width">

	<div id="f-widgets1" class="footer-widgets">

		<?php if ( is_active_sidebar( 'footers' ) ) { ?>
			<div class="widgets-box grid">
				<?php dynamic_sidebar( 'footers' ); ?>
			</div>
		<?php } ?>

	</div>

	<div id="f-widgets2" class="footer-widgets">

		<?php if ( is_active_sidebar( 'footers-2' ) ) { ?>
			<div class="widgets-box grid">
				<?php dynamic_sidebar( 'footers-2' ); ?>
			</div>
		<?php } ?>

	</div>

	<div id="f-widgets3" class="footer-widgets">

		<?php if ( is_active_sidebar( 'footers-3' ) ) { ?>
			<div class="widgets-box grid">
				<?php dynamic_sidebar( 'footers-3' ); ?>
			</div>
		<?php } ?>

	</div>

	<div id="f-widgets4" class="footer-widgets">

		<?php if ( is_active_sidebar( 'footers-4' ) ) { ?>
			<div class="widgets-box grid">
				<?php dynamic_sidebar( 'footers-4' ); ?>
			</div>
		<?php } ?>

	</div>

</aside><!-- .widget-area -->
<?php
}

}

}
