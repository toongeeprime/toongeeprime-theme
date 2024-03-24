<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME MENUS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	Menu Togglers
 *	@since 1.0.56
 */
if ( ! function_exists( 'prime2g_menu_togglers' ) ) {
function prime2g_menu_togglers( array $options = [] ) {
$incLogo	=	false;
$theLogo	=	'';
$class		=	'';
$id			=	'menu_toggbar';
$inner_el	=	'<span></span><span></span><span></span>';
$togTargets	=	'\'.main_menu_wrap\'';	// ESCAPE!
extract( $options );

echo '<div id="'. $id .'" class="menu_toggbar '. $class .'">
	<div>';
	if ( $incLogo ) echo $theLogo;
echo '</div>
<div class="menu_togs prel" onclick="prime2g_toggClass( ['. $togTargets .'] );">
'. $inner_el .'
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
$styles		=	ToongeePrime_Styles::mods_cache();
$min_v23	=	prime_child_min_version( '2.3' );

$incLogo	=	$styles->logo_with_menu;
$lwm_class	=	$incLogo ? ' logo_with_menu' : '';
$theLogo	=	prime2g_siteLogo();
$isMobile	=	wp_is_mobile();

echo	'<div id="'. $id .'" class="togs main_menu_wrap'. $lwm_class .'">
<div class="w100pc flexnw site_width">';

if ( $min_v23 && 'togglers' === $styles->menu_type ) {

	if ( $incLogo ) echo '<div>' . $theLogo . '</div>';
	prime2g_toggler_menu_type_elements();

}
#	@since 1.0.76 / 1.0.77
elseif ( ! $isMobile && $min_v23 && 'mega_menu' === $styles->menu_type ) {

	if ( $incLogo ) echo '<div>' . $theLogo . '</div>';

	$partID	=	get_theme_mod( 'prime2g_mega_menu_template_part_id', '' );
	echo '<div id="megaMenuWrap" class="prel">'. prime2g_insert_template_part( $partID, false ) .'</div>';
	add_action( 'wp_footer', 'prime2g_mega_menu_js' );

}
else {

$cta_menu	=	get_theme_mod( 'prime2g_set_cta_menu_item' );	# Theme 1.0.55

if ( has_nav_menu( 'main-menu' ) ) {

if ( ! $isMobile && $incLogo ) echo '<div class="desktop">' . $theLogo . '</div>';

prime2g_menu_togglers( [ 'incLogo'=>$incLogo, 'theLogo'=>$theLogo, 'class'=>'mobiles' ] ); ?>

<nav class="main-menu collapsible-navs site-menus<?php if ( $cta_menu ) echo ' cta'; ?>"
 aria-label="<?php esc_attr_e( 'Main Menu', PRIME2G_TEXTDOM ); ?>">

<?php
#	Conditions added @since 1.0.77
if ( $isMobile ) {

if ( 'mega_menu' !== $styles->menu_type ) prime2g_site_top_menu();

if ( $min_v23 && 'mega_menu' === $styles->menu_type ) {

	$partID	=	get_theme_mod( 'prime2g_mobile_menu_template_part_id', '' );
	echo '<div id="megaMenuWrap" class="prel">'. prime2g_insert_template_part( $partID, false ) .'</div>';
	add_action( 'wp_footer', 'prime2g_mobile_mega_menu_js' );

}

}

#	@since 1.0.77
if ( 'mega_menu' !== $styles->menu_type ) {

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

}
?>

<div id="prime_cta_menu" class="prime_cta_menu"><?php if ( $cta_menu ) echo prime2g_cta_menu(); ?></div>

</nav><!-- .main-menu -->
<?php
}
else { if ( current_user_can( 'edit_theme_options' ) ) esc_html_e( 'No Main Menu', PRIME2G_TEXTDOM ); }
}

echo	'</div></div><!-- #'. $id .' -->';

}
}



/**
 *	@since 1.0.55
 *
 *	Site Top Menu
 */
if ( ! function_exists( 'prime2g_site_top_menu' ) ) {
function prime2g_site_top_menu() {
$styles		=	ToongeePrime_Styles::mods_cache();

if ( has_nav_menu( 'site-top-menu' ) && $styles->top_menu ) { ?>
<div id="site_top_menu">
<div class="w100pc flexnw site_width collapsible-navs">
<?php
wp_nav_menu( [
	'depth'				=>	1,
	'theme_location'	=>	'site-top-menu',
	'menu_class'		=>	'site-menu-wrapper',
	'container_class'	=>	'site-menu-container',
	'items_wrap'		=>	'<ul id="site_top_menu_items" class="%2$s">%3$s</ul>',
	'fallback_cb'		=>	false
] );
?>
</div>
</div>
<?php
}
}
}


/**
 *	CTA Menu Item
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
/* @since 1.0.55 End */


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
 *	@since 1.0.57
 */
if ( ! function_exists( 'prime2g_toggler_menu_type_elements' ) ) {
function prime2g_toggler_menu_type_elements( array $options = [] ) {
$wrap_class	=	'hidden';
$div_class	=	'';
$tog_class	=	'';
$togTargets	=	"'#tog_menu_target', '.togs', '#prime_class_remover'";
extract( $options );

prime2g_menu_togglers( [ 'class' => $tog_class, 'togTargets' => $togTargets ] );

add_action( 'wp_footer', function() use( $wrap_class, $div_class ) {

$partID	=	get_theme_mod( 'prime2g_toggle_menu_template_part_id', '' );

echo	'<section id="tog_menu_target" class="tog_menu_target '. $wrap_class .'" style="z-index:99999;">
<div class="in_menu_target prel slimscrollbar '. $div_class .'">';
prime2g_insert_template_part( $partID );
echo	'</div></section>';

} );
}
}


/**
 *	Activate prime2g_class_remover_sheet() mini feature
 *	@since 1.0.60
 */
if ( ! function_exists( 'prime_remover_sheet_items' ) ) {
function prime_remover_sheet_items() {
return (object) [
   'items' => "'#tog_menu_target', '.togs'",
   'class' => "prime"
];
}
}


/***
 *	DESKTOP MEGAMENU HTML STRUCTURE
 *	@since 1.0.76

<nav id="megaMenu" class="desktop menu-main-container">
<ul id="megaMenuLinks" class="menu">
 	<li class="megamenuLi megaMenuContents1"><a href="#" class="megamenu_link">Item 1</a>
	<div id="megaMenuContents1" class="megamenuContents">
	<div class="mmcontent">[prime_insert_template_part id="123" device="desktop"]</div>
	</div>
	</li>

 	<li class="megamenuLi megaMenuContents2"><a href="#" class="megamenu_link">Item 2</a>
	<div id="megaMenuContents2" class="megamenuContents">
	<div class="mmcontent">[prime_insert_template_part id="234" device="mobile"]</div>
	</div>
	</li>

 	<li class="megamenuLi megaMenuContents3"><a href="#" class="megamenu_link">Item 3</a>
	<div id="megaMenuContents3" class="megamenuContents">
	<div class="mmcontent">[prime_insert_template_part id="345" device="desktop"]</div>
	</div>
	</li>
</ul>
</nav>
 **/

