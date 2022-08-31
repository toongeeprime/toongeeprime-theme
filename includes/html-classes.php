<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME'S HTML CLASSES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */


/**
 *	Add Classes to Post Title Header.
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

	// Helps detect if JS is enabled or not
	$classes[]	=	'no-js';

	// Add a body class if sidebar is set
	if ( ! function_exists( 'define_2gRMVSidebar' ) && get_post_type() != 'product' ) {
		$classes[]	=	'has-sidebar';
	}

	// Add a body class if title is unset
	if ( function_exists( 'define_2gRMVTitle' ) ) {
		$classes[]	=	'no_title';
	}

	// Site's Width and Extras
		$classes[]	=	'width_' . get_theme_mod( 'prime2g_site_width' );
		$classes[]	=	'ext_' . get_theme_mod( 'prime2g_site_style_extras' );

	// If post title is in header
	if ( 'header' == get_theme_mod( 'prime2g_title_location' ) ) {
		$classes[]	=	'title_in_header';
	}

	// If Main Menu is set to Fixed
	if ( 'fixed' == get_theme_mod( 'prime2g_menu_position' ) ) {
		$classes[]	=	'fixed_main_menu';
	}

	// With or without a header image
	if ( has_header_image() ) {
		$classes[]	=	'has-header-image';
	}
	else {
		$classes[]	=	'no-header-image';
	}

	// When there's a custom background image
	// WP has `custom-background`
	if ( get_background_image() ) {
		$classes[]	=	'has-background-image';
	}

	// To entries with a featured image
	if ( is_singular() ) {

		// Add `singular` to singular entries and `hfeed` to archives
		$classes[]	=	'singular';

		// Default Header Removed
		if ( post_custom( 'remove_header' ) == 'remove' ) {
			$classes[]	=	'header_removed';
		}

		if ( has_post_thumbnail() ) {
			$classes[]	=	'has-thumbnail';
		} else {
			$classes[]	=	'no-thumbnail';
		}

	}
	else {
		$classes[]	=	'hfeed';
	}

	// Sites with more than 1 published author
	if ( is_multi_author() ) {
		$classes[]	=	'multi-authors';
	}

	// Device class
	if ( wp_is_mobile() ) {
		$classes[]	=	'is-mobile';
	}
	else {
		$classes[]	=	'is-desktop';
	}

	// WP has `logged-in` class
	// Logged in user's role else logged out
	if ( is_user_logged_in() ) {
		global $current_user;
		$user_roles	=	$current_user->roles;
		$user_role	=	array_shift( $user_roles );
		$classes[]	=	'user-role-' . $user_role;
	} else {
		$classes[]	=	'logged-out';
	}

	// WooCommerce product category as class(es)
	if ( function_exists( 'is_product' ) && is_product() ) {
			$categs	=	get_the_terms( get_the_ID(), 'product_cat' );
			foreach ( $categs as $cat ) {
				$pcatClass	=	'product-cat-' . $cat->slug;
			break;
			}
		$classes[]	=	$pcatClass;
	}

return $classes;

}



/**
 *	Post Classes
 */
add_filter( 'post_class', 'prime2g_post_classes', 10, 3 );
function prime2g_post_classes( $classes ) {

	$classes[]	=	'entry';

	if ( get_option( 'sticky_posts' ) ) {
		$classes[]	=	'sticky';
	}

return $classes;
}



/**
 *	HTML Classes
 */
function prime2g_theme_html_classes() {

	$addClass	=	array();

	$addClass	=	ToongeePrime_Colors::theme_color_classes();

echo 'class="'. implode( ' ', $addClass ) .'"';
}


