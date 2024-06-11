<?php defined( 'ABSPATH' ) || exit;
/**
 *	SITE'S SIDEBARS AND WIDGET AREAS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

#	@since 1.0.95
if ( ! function_exists( 'prime2g_sidebar_toggler' ) ) {
function prime2g_sidebar_toggler() {
return '<style id="ssbTogCSS">
#stickySidebarToggler{top:100px;z-index:99999;background:var(--content-background);color:var(--content-text);padding:5px 10px;}
.hide_sticky_sidebar #stickySidebarToggler .cl,#stickySidebarToggler .op{display:none;}
#stickySidebarToggler span,.hide_sticky_sidebar #stickySidebarToggler .op{display:inline-block;}
.sticky_right_sidebar #stickySidebarToggler{left:0;}
.sticky_left_sidebar #stickySidebarToggler{right:0;}
.sticky_left_sidebar #stickySidebarToggler span{transform:rotate(180deg);}
</style>

<div id="stickySidebarToggler" class="p-fix desktop">
<div class="prel pointer">
<span class="op" title="'. __( 'Open Sidebar', PRIME2G_TEXTDOM ) .'"><i class="bi bi-layout-sidebar-reverse"></i></span>
<span class="cl" title="'. __( 'Close Sidebar', PRIME2G_TEXTDOM ) .'"><i class="bi bi-layout-sidebar-inset-reverse"></i></span>
</div>
</div>';
}
}


#	MAIN SIDEBAR
if ( !function_exists( 'prime2g_sidebar' ) ) {
function prime2g_sidebar() {

if ( prime2g_remove_sidebar() ) return;

if ( is_active_sidebar( 'primary-sidebar' ) ) {

if ( prime2g_has_sticky_sidebar_togg() ) {
	echo prime2g_sidebar_toggler();
	add_action( 'wp_footer', 'prime2g_sidebar_toggler_js', 900 );
}
?>

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
 *	@since 1.0.55
 *
 *	WIDGETS SET ABOVE SITE HEADER
 */
add_action( 'prime2g_before_header', 'prime2g_widgets_above_header' );
if ( ! function_exists( 'prime2g_widgets_above_header' ) ) {
function prime2g_widgets_above_header() {

if ( prime2g_is_plain_page_template() ) return;

if ( is_active_sidebar( 'aboveheader-widgets' ) ) { ?>
	<aside id="above_headerWidgets" class="header asides clear">
		<div class="widgets-box grid">
			<?php dynamic_sidebar( 'aboveheader-widgets' ); ?>
		</div>
	</aside>
<?php
}
}
}


/**
 *	WIDGETS SET BELOW SITE HEADER
 */
add_action( 'prime2g_sub_header', 'prime2g_widgets_below_header' );
if ( ! function_exists( 'prime2g_widgets_below_header' ) ) {
function prime2g_widgets_below_header() {

if ( prime2g_is_plain_page_template() ) return;

if ( is_active_sidebar( 'belowheader-widgets' ) ) { ?>
	<aside id="below_headerWidgets" class="header asides clear">
		<div class="widgets-box grid">
			<?php dynamic_sidebar( 'belowheader-widgets' ); ?>
		</div>
	</aside>
<?php
}
}
}


/**
 *	WIDGETS SET BELOW HOME "MAIN" HEADLINE POST
 */
add_action( 'prime2g_after_home_main_headline', 'prime2g_widgets_after_main_headline' );
if ( ! function_exists( 'prime2g_widgets_after_main_headline' ) ) {
function prime2g_widgets_after_main_headline() {

if ( is_active_sidebar( 'belowmainheadline-widgets' ) ) { ?>
	<aside id="below_mainHeadlineWidgets" class="asides clear">
		<div class="widgets-box grid">
			<?php dynamic_sidebar( 'belowmainheadline-widgets' ); ?>
		</div>
	</aside>
<?php
}
}
}


/**
 *	WIDGETS SET BELOW HOME HEADLINE POSTS
 */
add_action( 'prime2g_after_home_headlines', 'prime2g_widgets_after_home_headlines' );
if ( ! function_exists( 'prime2g_widgets_after_home_headlines' ) ) {
function prime2g_widgets_after_home_headlines() {

if ( is_active_sidebar( 'belowhomeheadlines-widgets' ) ) { ?>
	<aside id="below_mainHeadlineWidgets" class="asides clear">
		<div class="widgets-box grid">
			<?php dynamic_sidebar( 'belowhomeheadlines-widgets' ); ?>
		</div>
	</aside>
<?php
}
}
}


/**
 *	WIDGETS SET BEFORE POST
 */
add_action( 'prime2g_before_post', 'prime2g_widgets_above_post' );
if ( ! function_exists( 'prime2g_widgets_above_post' ) ) {
function prime2g_widgets_above_post() {

if ( prime2g_is_plain_page_template() ) return;

if ( is_active_sidebar( 'aboveposts-widgets' ) ) { ?>
	<aside id="above_postsWidgets" class="asides clear">
		<div class="widgets-box grid">
			<?php dynamic_sidebar( 'aboveposts-widgets' ); ?>
		</div>
	</aside>
<?php
}
}
}
#	@since 1.0.55 - end	#


/**
 *	WIDGETS SET AFTER POST
 */
add_action( 'prime2g_after_post', 'prime2g_below_posts_widgets', 20 );
if ( ! function_exists( 'prime2g_below_posts_widgets' ) ) {
function prime2g_below_posts_widgets() {

if ( prime2g_is_plain_page_template() ) return;

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
 */
if ( ! function_exists( 'prime2g_footer_top_widgets' ) ) {
function prime2g_footer_top_widgets() {

if ( prime2g_is_plain_page_template() ) return;

if ( is_active_sidebar( 'footer-top' ) ) { ?>
	<aside id="footer_topWidgets" class="footer_topWidgets asides clear">
		<div class="widgets-box site_width grid">
			<?php dynamic_sidebar( 'footer-top' ); ?>
		</div>
	</aside>
<?php
}
}
}


/**
 *	FOOTER WIDGETS
 *	Updated for customizer columns @since 1.0.55
 */
if ( ! function_exists( 'prime2g_footer_widgets' ) ) {
function prime2g_footer_widgets() {

$cols	=	4;
$wID	=	'';
if ( defined( 'CHILD2G_VERSION' ) && CHILD2G_VERSION >= '2.0' ) {
	$cols	=	(int) get_theme_mod( 'prime2g_footer_columns_num', '4' );
}

for ( $n = 1; $n <= $cols; $n++ ) {
if ( $n > 1 ) $wID	=	'-' . $n;
	$hasactive	=	is_active_sidebar( 'footers'. $wID ); break;
}

if ( $hasactive ) { ?>

<aside id="sitebasebar" role="complementary" class="asides grid grid<?php echo $cols; ?> site_width footer">
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


/**
 *	@since 1.0.84
 *
 *	MOBILE MENU WIDGETS
 */
add_action( 'prime2g_mobile_menu_top', 'prime2g_mobile_menu_top_widgets' );
if ( ! function_exists( 'prime2g_mobile_menu_top_widgets' ) ) {
function prime2g_mobile_menu_top_widgets() {

if ( is_active_sidebar( 'mobilemenutop-widgets' ) ) { ?>
	<aside id="mobilemenu_top_widgets" class="mobilemenu asides clear">
		<div class="widgets-box grid">
			<?php dynamic_sidebar( 'mobilemenutop-widgets' ); ?>
		</div>
	</aside>
<?php
}

}
}


add_action( 'prime2g_mobile_menu_bottom', 'prime2g_mobile_menu_bottom_widgets' );
if ( ! function_exists( 'prime2g_mobile_menu_bottom_widgets' ) ) {
function prime2g_mobile_menu_bottom_widgets() {

if ( is_active_sidebar( 'mobilemenubottom-widgets' ) ) { ?>
	<aside id="mobilemenu_bottom_widgets" class="mobilemenu asides clear">
		<div class="widgets-box grid">
			<?php dynamic_sidebar( 'mobilemenubottom-widgets' ); ?>
		</div>
	</aside>
<?php
}

}
}

