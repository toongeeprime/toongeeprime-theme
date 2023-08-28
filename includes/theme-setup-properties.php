<?php defined( 'ABSPATH' ) || exit;

/**
 *	SETTING UP THEME PROPERTIES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

add_action( 'after_setup_theme', 'toongeeprime_theme_setup2' );
if ( ! function_exists( 'toongeeprime_theme_setup2' ) ) {
function toongeeprime_theme_setup2() {
#	Custom Logo
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

#	@since ToongeePrime Theme 1.0.55:
$enableVideo	=	prime2g_video_features_active() ?: false;
$videoActive	=	get_theme_mod( 'prime2g_video_header_placements', 'is_front_page' );

#	Custom Header
$header_width	=	2000;
$header_height	=	900;
add_theme_support(
	'custom-header',
	array(
		'header-text'			=>	true,
		'default-text-color'	=>	'000',
		'width'					=>	$header_width,
		'height'				=>	$header_height,
		'flex-height'			=>	true,
		'flex-width'			=>	true,
		'video'					=>	$enableVideo,
		'video-active-callback'	=>	$videoActive
	)
);



#	Navigation Menus
register_nav_menus(
	array(
		'main-menu'		=>	esc_html__( 'Main Menu', PRIME2G_TEXTDOM ),
		'footer-menu'	=>	esc_html__( 'Footer menu', PRIME2G_TEXTDOM )
	)
);


/**
 *	@since ToongeePrime Theme 1.0.55
 */
if ( get_theme_mod( 'prime2g_use_site_top_menu' ) ) {

register_nav_menus(
	[ 'site-top-menu'	=>	esc_html__( 'Site-Top Menu', PRIME2G_TEXTDOM ) ]	# @ Theme 1.0.55
);

}


/**
 *	Extra Navigation Menu Locations
 *	@since ToongeePrime Theme 1.0.55
 */
if ( defined( 'CHILD2G_VERSION' ) && CHILD2G_VERSION >= '2.2' ) {
$extras	=	get_theme_mod( 'prime2g_extra_menu_locations', 0 );

if ( $extras ) {
	for ( $e = 0; $e < $extras; $e++ ) {
		$val	=	$e+1;
		register_nav_menus(
		array( 'extra-menu-location-' . $val => esc_html__( 'Extra Menu Location ' . $val, PRIME2G_TEXTDOM ) )
		);
	}
}

}



#	SIDEBARS
add_action( 'widgets_init', 'prime2g_sidebars', 5 );
function prime2g_sidebars() {
register_sidebar(
	array(
		'name'          =>	__( 'Primary Sidebar', PRIME2G_TEXTDOM ),
		'id'            =>	'primary-sidebar',
		'description'   =>	__( 'Site\'s Main Sidebar', PRIME2G_TEXTDOM ),
		'before_widget' =>	'<div id="%1$s" class="sidebarwidget %2$s"><div class="widget">',
		'after_widget'  =>	'</div></div>',
		'before_title'	=>	'<div class="w-headers"><h3 class="widget-title sidebar">',
		'after_title'	=>	'</h3></div>'
	)
);
#	@since ToongeePrime Theme 1.0.55
register_sidebar(
	array(
		'name'          =>	__( 'Above The Header', PRIME2G_TEXTDOM ),
		'id'            =>	'aboveheader-widgets',
		'description'   =>	__( 'Widgets above the site Header', PRIME2G_TEXTDOM ),
		'before_widget' =>	'<div id="%1$s" class="aboveheader %2$s">',
		'after_widget'  =>	'</div>',
		'before_title'  =>	'<div class="hide">',
		'after_title'   =>	'</div>'
	)
);
#	@since ToongeePrime Theme 1.0.55
register_sidebar(
	array(
		'name'          =>	__( 'Below The Header', PRIME2G_TEXTDOM ),
		'id'            =>	'belowheader-widgets',
		'description'   =>	__( 'Widgets below the site Header', PRIME2G_TEXTDOM ),
		'before_widget' =>	'<div id="%1$s" class="belowheader %2$s">',
		'after_widget'  =>	'</div>',
		'before_title'  =>	'<div class="hide">',
		'after_title'   =>	'</div>'
	)
);
#	@since ToongeePrime Theme 1.0.55
register_sidebar(
	array(
		'name'          =>	__( 'After Main Headline Story', PRIME2G_TEXTDOM ),
		'id'            =>	'belowmainheadline-widgets',
		'description'   =>	__( 'Widgets below the main headline entry', PRIME2G_TEXTDOM ),
		'before_widget' =>	'<div id="%1$s" class="belowmainheadline %2$s">',
		'after_widget'  =>	'</div>',
		'before_title'  =>	'<div class="hide">',
		'after_title'   =>	'</div>'
	)
);
#	@since ToongeePrime Theme 1.0.55
register_sidebar(
	array(
		'name'          =>	__( 'After Headlines Section', PRIME2G_TEXTDOM ),
		'id'            =>	'belowhomeheadlines-widgets',
		'description'   =>	__( 'Widgets below headlines section', PRIME2G_TEXTDOM ),
		'before_widget' =>	'<div id="%1$s" class="belowhomeheadlines %2$s">',
		'after_widget'  =>	'</div>',
		'before_title'  =>	'<div class="hide">',
		'after_title'   =>	'</div>'
	)
);
#	@since ToongeePrime Theme 1.0.55
register_sidebar(
	array(
		'name'          =>	__( 'Above Posts', PRIME2G_TEXTDOM ),
		'id'            =>	'aboveposts-widgets',
		'description'   =>	__( 'Widgets above post entries', PRIME2G_TEXTDOM ),
		'before_widget' =>	'<div id="%1$s" class="abovepostwidget %2$s"><div class="widget">',
		'after_widget'  =>	'</div></div>',
		'before_title'  =>	'<div class="hide">',
		'after_title'   =>	'</div>'
	)
);
register_sidebar(
	array(
		'name'          =>	__( 'Below Posts', PRIME2G_TEXTDOM ),
		'id'            =>	'belowposts-widgets',
		'description'   =>	__( 'Widgets below post entries', PRIME2G_TEXTDOM ),
		'before_widget' =>	'<div id="%1$s" class="belowpostwidget %2$s"><div class="widget">',
		'after_widget'  =>	'</div></div>',
		'before_title'  =>	'<div class="hide">',
		'after_title'   =>	'</div>'
	)
);
register_sidebar(
	array(
		'name'          =>	__( 'Footer Top', PRIME2G_TEXTDOM ),
		'id'            =>	'footer-top',
		'description'   =>	__( 'Widgets at the top part of the website Footer', PRIME2G_TEXTDOM ),
		'before_widget' =>	'<div id="%1$s" class="footertop %2$s"><div class="widget">',
		'after_widget'  =>	'</div></div>',
		'before_title'  =>	'<div class="hide">',
		'after_title'   =>	'</div>'
	)
);

/**
 *	@since ToongeePrime Theme 1.0.55
 */
$cols	=	4;
$num	=	' %d';
$name	=	'Footer Widgets';
$fname	=	$name . $num;
if ( defined( 'CHILD2G_VERSION' ) && CHILD2G_VERSION >= '2.0' ) {
	$cols	=	(int) get_theme_mod( 'prime2g_footer_columns_num', '4' );
	$name	=	( $cols > 1 ) ? $fname : $name;
}
register_sidebars( $cols,
	array(
		'name'			=>	__( $name, PRIME2G_TEXTDOM ),
		'id'			=>	'footers',
		'before_widget'	=>	'<div id="%1$s" class="footerwidget %2$s"><div class="widget">',
		'after_widget'	=>	'</div></div>',
		'before_title'	=>	'<div class="w-headers"><h3 class="widget-title footer">',
		'after_title'	=>	'</h3></div>'
	)
);

}

}
}
