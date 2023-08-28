<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME'S HTML CLASSES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	Add Classes to Post Title Header
 */
function prime2g_title_header_classes() {
$classes	=	has_custom_logo() ? ' has-logo' : '';
$classes	.=	has_nav_menu( 'main-menu' ) ? ' has-menu' : '';
return $classes;
}


/**
 *	Body Classes
 */
add_filter( 'body_class', 'prime2g_body_classes' );
function prime2g_body_classes( $classes ) {

	# Helps detect if JS is enabled or not
	$classes[]	=	'no-js';

	# Add a body class if sidebar is set
	if ( ! function_exists( 'define_2gRMVSidebar' ) && get_post_type() !== 'product' ) {
		$classes[]	=	'has-sidebar';
	}

	# Add a body class if title is unset
	$classes[]	=	function_exists( 'define_2gRMVTitle' ) ? 'no_title' : '';

	# Site's Width and Extras
	$classes[]	=	'width_' . get_theme_mod( 'prime2g_site_width' );
	$classes[]	=	'ext_' . get_theme_mod( 'prime2g_site_style_extras' );

	# If post title is in header
	$classes[]	=	'header' === get_theme_mod( 'prime2g_title_location' ) ? 'title_in_header' : '';

	# By Main Menu Position
	$menuPosition	=	get_theme_mod( 'prime2g_menu_position' );
	$classes[]	=	'menu_on_header' === $menuPosition ? 'menu_on_header' : '';
	$classes[]	=	'fixed' === $menuPosition ? 'fixed_main_menu' : '';
	$classes[]	=	'bottom' === $menuPosition ? 'bottom_main_menu' : '';

	# If Preloader feature is active
	# @since ToongeePrime Theme 1.0.48.50
	if ( ! empty( get_theme_mod( 'prime2g_use_page_preloader' ) ) ) {
		$classes[]	=	'preloading';
	}

	# If Video features active
	# @since ToongeePrime Theme 1.0.55
	if ( ! empty( get_theme_mod( 'prime2g_enable_video_features' ) ) ) {
		$classes[]	=	'video_site';
	}

	$classes[]	=	isset( $GLOBALS[ 'pwa_css_class' ] ) ? $GLOBALS[ 'pwa_css_class' ] : '';

	$classes[]	=	'left' === get_theme_mod( 'prime2g_sidebar_position' ) ? 'left_sidebar' : '';
	$classes[]	=	is_header_video_active() ? 'video_header' :'';

	# With or without a header image
	$classes[]	=	has_header_image() ? 'has-header-image' : 'no-header-image';

	# When there's a custom background image
	# WP has `custom-background`
	$classes[]	=	get_background_image() ? 'has-background-image' : '';

	# Singular Entries & Archives
	if ( is_singular() ) {
		global $post;

		$classes[]	=	'singular';
		$classes[]	=	'replace_header' === get_theme_mod( 'prime2g_video_embed_location' ) ? 'video_as_header' : '';

		# Has featured image?
		$classes[]	=	has_post_thumbnail() ? 'has-thumbnail' : 'no-thumbnail';

		# Page width
		$classes[]	=	$post->page_width ?: '';

		# Default Header Removed
		$classes[]	=	'remove' === $post->remove_header ? 'header_removed' : '';
	}
	else {
		$classes[]	=	'hfeed';
	}

	# Sites with more than 1 published author
	$classes[]	=	is_multi_author() ? 'multi-authors' : '';

	# Device class
	$classes[]	=	wp_is_mobile() ? 'is-mobile' : 'is-desktop';

	# WP has `logged-in` class
	# Logged in user's role else logged out
	if ( is_user_logged_in() ) {
		global $current_user;
		$user_roles	=	$current_user->roles;
		$user_role	=	array_shift( $user_roles );
		$classes[]	=	'user-role-' . $user_role;
	} else {
		$classes[]	=	'logged-out';
	}

	# WooCommerce product category as class(es)
	if ( function_exists( 'is_product' ) && is_product() ) {
		$categs	=	get_the_terms( get_the_ID(), 'product_cat' );
		foreach ( $categs as $cat ) {
			$classes[]	=	'product-cat-' . $cat->slug;
		break;
		}
	}

return $classes;
}




/**
 *	Post Classes
 */
add_filter( 'post_class', 'prime2g_post_classes', 10, 3 );
function prime2g_post_classes( $classes ) {

	$classes[]	=	'entry';
	$classes[]	=	is_sticky() ? 'sticky' : '';

return $classes;
}



/**
 *	HTML Classes
 */
function prime2g_theme_html_classes( $echo = true ) {

	$addClass	=	ToongeePrime_Colors::theme_color_classes();

if ( $echo ) { echo 'class="'. implode( ' ', $addClass ) .'"'; }
else { return 'class="'. implode( ' ', $addClass ) .'"'; }
}


