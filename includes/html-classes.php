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
$styles	=	ToongeePrime_Styles::mods_cache();	#	@since 1.0.57

	#	Detects if JS is enabled or not
	$classes[]	=	'no-js';

	#	Add classes by sidebar status
	if ( false === prime2g_remove_sidebar() ) {
		$classes[]	=	'has-sidebar';
		$classes[]	=	$styles->sidebar_place ? $styles->sidebar_place . '_sidebar' : ''; # @since 1.0.93
		$classes[]	=	isset( $_COOKIE[ 'hideStickySidebar' ] ) && prime2g_has_sticky_sidebar_togg() ?
		'hide_sticky_sidebar' : ''; # @since 1.0.95
	}

	#	Add class if title is not set
	$classes[]	=	function_exists( 'define_2gRMVTitle' ) ? 'no_title' : '';

	#	Site's Width and Extras
	$classes[]	=	'width_' . $styles->width;
	$classes[]	=	$styles->style_extras ? 'ext_' . $styles->style_extras : '';

	#	Post title in header
	$classes[]	=	'header' === $styles->title_place ? 'title_in_header' : '';

	#	By Main Menu Position
	$classes[]	=	'menu_on_header' === $styles->menu_place ?
	$styles->menu_place : $styles->menu_place . '_main_menu';

	#	Preloader feature
	#	@since 1.0.48.50
	if ( ! empty( get_theme_mod( 'prime2g_use_page_preloader' ) ) ) {
		$classes[]	=	'preloading';
	}

	#	If Video features active
	#	@since 1.0.55
	if ( ! empty( get_theme_mod( 'prime2g_enable_video_features' ) ) ) {
		$classes[]	=	'video_site';
		$classes[]	=	is_header_video_active() ? 'video_active' : '';
		$classes[]	=	'replace_header' === $styles->video_place ? 'video_as_header' : '';
	}

	$classes[]	=	isset( $GLOBALS[ 'pwa_css_class' ] ) ? $GLOBALS[ 'pwa_css_class' ] : '';

	#	With or without a header image
	$classes[]	=	has_header_image() ? 'has-header-image' : 'no-header-image';

	#	When there's a custom background image
	#	WP has `custom-background`
	$classes[]	=	get_background_image() ? 'has-background-image' : '';

	#	Singular Entries & Archives
	if ( is_singular() ) {
		global $post;

		$classes[]	=	'singular';

		#	Has featured image?
		$classes[]	=	has_post_thumbnail() ? 'has-thumbnail' : 'no-thumbnail';

		#	Page width
		$classes[]	=	$post->page_width ?: '';

		#	Default Header Removed
		$classes[]	=	'remove' === $post->remove_header ? 'header_removed' : '';
	}
	else {
		$classes[]	=	'hfeed';
	}

	#	Sites with more than 1 published author
	$classes[]	=	is_multi_author() ? 'multi-authors' : '';

	#	Device
	$classes[]	=	wp_is_mobile() ? 'is-mobile' : 'is-desktop';

	#	WP has `logged-in`
	#	Logged in user's role else logged-out
	if ( is_user_logged_in() ) {
		global $current_user;
		$user_roles	=	$current_user->roles;
		$user_role	=	array_shift( $user_roles );
		$classes[]	=	'user-role-' . $user_role;
	} else {
		$classes[]	=	'logged-out';
	}

	#	WooCommerce product category as class(es)
	if ( function_exists( 'is_product' ) && is_product() ) {
		$categs	=	get_the_terms( get_the_ID(), 'product_cat' );
		foreach ( $categs as $cat ) {
			$classes[]	=	'product-cat-' . $cat->slug;
		break;
		}
	}

	#	@since 1.0.90
	if ( defined( 'PRIME2G_ALT_POST_OBJ' ) ) {
		$classes[]	=	'prime_alt_post';
		$classes[]	=	PRIME2G_ALT_POST_OBJ->page_width ?: '';
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

if ( $echo ) echo 'class="'. implode( ' ', $addClass ) .'"';
else return 'class="'. implode( ' ', $addClass ) .'"';
}



