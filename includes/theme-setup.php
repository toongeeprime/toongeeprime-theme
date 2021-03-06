<?php defined( 'ABSPATH' ) || exit;

/**
 *	SETTING UP THE THEME
 *	Sets the custom logo and custom header dimensions, nav menus and widget areas
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

add_action( 'after_setup_theme', 'toongeeprime_theme_setup2' );
if ( ! function_exists( 'toongeeprime_theme_setup2' ) ) {

function toongeeprime_theme_setup2() {
// Custom Logo
$logo_width		=	250;
$logo_height	=	200;
add_theme_support(
	'custom-logo',
	array(
		'height'				=>	$logo_height,
		'width'					=>	$logo_width,
		'flex-width'			=>	true,
		'flex-height'			=>	true,
		'unlink-homepage-logo'	=>	true,
		'header-text'			=>	array( 'site-title', 'site-description' ),
	)
);


// Custom Header
$header_width	=	2000;
$header_height	=	750;
add_theme_support(
	'custom-header',
	array(
		'header-text'			=>	true,
		'default-text-color'	=>	'000',
		'width'					=>	$header_width,
		'height'				=>	$header_height,
		'flex-height'			=>	true,
		'flex-width'			=>	true,
		// 'video'					=>	true,
		// 'video-active-callback'	=>	'is_front_page'
	)
);



// Navigation Menus
register_nav_menus(
	array(
		'main-menu'		=>	esc_html__( 'Main Menu', 'toongeeprime-theme' ),
		'footer-menu'	=>	esc_html__( 'Footer menu', 'toongeeprime-theme' )
	)
);



//	SIDEBARS
add_action( 'widgets_init', 'prime2g_sidebars', 5 );
function prime2g_sidebars() {
register_sidebar(
	array(
		'name'          =>	__( 'Primary Sidebar', 'toongeeprime-theme' ),
		'id'            =>	'primary-sidebar',
		'description'   =>	__( 'Site\'s Main Sidebar', 'toongeeprime-theme' ),
		'before_widget' =>	'<div id="%1$s" class="sidebarwidget %2$s"><div class="widget">',
		'after_widget'  =>	'</div></div>',
		'before_title'	=>	'<div class="w-headers"><h3 class="widget-title sidebar">',
		'after_title'	=>	'</h3></div>'
	)
);
register_sidebar(
	array(
		'name'          =>	__( 'Below Posts', 'toongeeprime-theme' ),
		'id'            =>	'belowposts-widgets',
		'description'   =>	__( 'Widgets below post entries', 'toongeeprime-theme' ),
		'before_widget' =>	'<div id="%1$s" class="belowpostwidget %2$s"><div class="widget">',
		'after_widget'  =>	'</div></div>',
		'before_title'  =>	'<div class="hide">',
		'after_title'   =>	'</div>'
	)
);
register_sidebar(
	array(
		'name'          =>	__( 'Footer Top', 'toongeeprime-theme' ),
		'id'            =>	'footer-top',
		'description'   =>	__( 'Widgets at the top part of the website Footer', 'toongeeprime-theme' ),
		'before_widget' =>	'<div id="%1$s" class="footertop %2$s"><div class="widget">',
		'after_widget'  =>	'</div></div>',
		'before_title'  =>	'<div class="hide">',
		'after_title'   =>	'</div>'
	)
);
register_sidebars( 4,
	array(
		'name'			=>	__( 'Footer Widgets %d', 'toongeeprime-theme' ),
		'id'			=>	'footers',
		'before_widget'	=>	'<div id="%1$s" class="footerwidget %2$s"><div id="%1$s" class="widget %2$s">',
		'after_widget'	=>	'</div></div>',
		'before_title'	=>	'<div class="w-headers"><h3 class="widget-title footer">',
		'after_title'	=>	'</h3></div>'
	)
);
}

}

}

