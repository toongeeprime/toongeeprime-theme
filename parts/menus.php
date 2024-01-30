<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME MENUS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	Menu Togglers
 *	@since ToongeePrime Theme 1.0.56
 */
if ( ! function_exists( 'prime2g_menu_togglers' ) ) {
function prime2g_menu_togglers( array $options = [] ) {
$incLogo	=	false;
$theLogo	=	'';
$class		=	'';
$togTargets	=	'\'.main_menu_wrap\'';	// be sure to escape
extract( $options );

echo '<div id="menu_toggbar" class="menu_toggbar ' . $class . '">
	<div>';
	if ( $incLogo ) echo $theLogo;
echo '</div>
<div class="menu_togs prel" onclick="prime2g_toggClass( [ '. $togTargets .' ] );">
	<span></span>
	<span></span>
	<span></span>
</div>
</div>';
}
}



/**
 *	MAIN MENU
 */
if ( ! function_exists( 'prime2g_main_menu' ) ) {
function prime2g_main_menu( $id = 'main_nav', $ul_id = 'main_menu_items' ) {

# Theme 1.0.57
if ( prime_child_min_version( '2.3' ) && 'togglers' === get_theme_mod( 'prime2g_main_menu_type' ) ) {
	prime2g_toggler_menu_type_elements();
}
else {

$incLogo	=	get_theme_mod( 'prime2g_logo_with_menu' );
$cta_menu	=	get_theme_mod( 'prime2g_set_cta_menu_item' );	# Theme 1.0.55
$theLogo	=	prime2g_siteLogo();
$isMobile	=	wp_is_mobile();
?>

<div id="<?php echo $id; ?>" class="togs main_menu_wrap<?php if ( $incLogo ) echo ' logo_with_menu'; ?>">
<div class="w100pc flexnw site_width">

<?php if ( has_nav_menu( 'main-menu' ) ) {

if ( ! $isMobile && $incLogo ) echo '<div class="desktop">' . $theLogo . '</div>';

prime2g_menu_togglers( [ 'incLogo'=>$incLogo, 'theLogo'=>$theLogo, 'class'=>'mobiles' ] ); ?>

<nav class="main-menu collapsible-navs site-menus<?php if ( $cta_menu ) echo ' cta'; ?>"
 aria-label="<?php esc_attr_e( 'Main Menu', PRIME2G_TEXTDOM ); ?>">

<?php
if ( $isMobile ) prime2g_site_top_menu();

$main_menu	=	'main-menu';
if ( is_singular() && get_theme_mod( 'prime2g_extra_menu_locations' ) ) {
	global $post;
	$menuOption	=	get_post_meta( $post->ID, 'use_main_nav_location', true );
	$main_menu	=	$menuOption ?: $main_menu;
}
wp_nav_menu(
	array(
		'theme_location'	=>	$main_menu,
		'menu_class'		=>	'main-menu-wrapper',
		'container_class'	=>	'main-menu-container',
		'items_wrap'		=>	'<ul id="'. $ul_id .'" class="%2$s">%3$s</ul>',
		'fallback_cb'		=>	false,
	)
);
?>

<div id="prime_cta_menu" class="prime_cta_menu"><?php if ( $cta_menu ) echo prime2g_cta_menu(); ?></div>

</nav><!-- .main-menu -->
<?php
}
else { if ( current_user_can( 'edit_theme_options' ) ) esc_html_e( 'No Main Menu', PRIME2G_TEXTDOM ); }
?>

</div>
</div><!-- #main_nav -->
<?php
}
}
}



/**
 *	Site Top Menu
 *	@since ToongeePrime Theme 1.0.55
 */
if ( ! function_exists( 'prime2g_site_top_menu' ) ) {
function prime2g_site_top_menu() {
if ( has_nav_menu( 'site-top-menu' ) && get_theme_mod( 'prime2g_use_site_top_menu' ) ) { ?>
<div id="site_top_menu">
<div class="w100pc flexnw site_width collapsible-navs">
<?php
wp_nav_menu(
[	'depth'	=>	1,
	'theme_location'	=>	'site-top-menu',
	'menu_class'		=>	'site-menu-wrapper',
	'container_class'	=>	'site-menu-container',
	'items_wrap'		=>	'<ul id="site_top_menu_items" class="%2$s">%3$s</ul>',
	'fallback_cb'		=>	false
]
);
?>
</div>
</div>
<?php
}
}
}


/**
 *	CTA Menu Item
 *	@since ToongeePrime Theme 1.0.55
 */
if ( ! function_exists( 'prime2g_cta_menu' ) ) {
function prime2g_cta_menu() {
$url	=	get_theme_mod( 'prime2g_cta_menu_url' );
$text	=	get_theme_mod( 'prime2g_cta_button_text' );
$target	=	get_theme_mod( 'prime2g_cta_link_target' ) ? ' target="_blank"' : '';
$classes	=	get_theme_mod( 'prime2g_cta_button_classes' ) ?: '';

return '<ul><li><a class="btn cta1 '. $classes .'" href="'. $url .'"'. $target .' rel="noopener">'. $text .'</a></ul>';
}
}


/**
 *	Footer Menu
 */
if ( ! function_exists( 'prime2g_footer_menu' ) ) {
function prime2g_footer_menu( $id = 'sitefooter_menu' ) {
if ( get_theme_mod( 'prime2g_theme_add_footer_menu' ) )	{ ?>

<div id="<?php echo $id; ?>" class="footer_menu_wrap">
<?php if ( has_nav_menu( 'footer-menu' ) ) { ?>
<nav aria-label="<?php esc_attr_e( 'Footer Menu', PRIME2G_TEXTDOM ); ?>" class="footer-navigation">
	<ul class="footer_menu_items">
		<?php
		wp_nav_menu(
			array(
				'theme_location'	=>	'footer-menu',
				'items_wrap'		=>	'%3$s',
				'container'			=>	false,
				'depth'				=>	1,
				'link_before'		=>	'<span>',
				'link_after'		=>	'</span>',
				'fallback_cb'		=>	false,
			)
		);
		?>
	</ul><!-- .footer-navigation-wrapper -->
</nav><!-- .footer-navigation -->
<?php
}
else { if ( current_user_can( 'edit_theme_options' ) ) esc_html_e( 'No Footer Menu', PRIME2G_TEXTDOM ); }
?>
</div><!-- .site-menu-base -->

<?php
}
}
}



/**
 *	TOGGLER MENU ELEMENTS
 *	@since ToongeePrime Theme 1.0.57
 */
if ( ! function_exists( 'prime2g_toggler_menu_type_elements' ) ) {
function prime2g_toggler_menu_type_elements( array $options = [] ) {
$wrap_class	=	'hidden';
$div_class	=	'';
extract( $options );

$target	=	'<section id="tog_menu_target" class="main_menu_wrap '. $wrap_class .'"><div class="prel '. $div_class .'">';

$target	.=	'</div></section>';

prime2g_menu_togglers( [ 'class' => 'togs', 'togTargets' => "'#tog_menu_target', '.togs'" ] );

add_action( 'wp_footer', function() use( $target ) { echo $target; }, 5 );
}
}

