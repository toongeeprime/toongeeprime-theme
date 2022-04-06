<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME MENUS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */


/**
 *	Main Menu
 */
if ( ! function_exists( 'prime2g_main_menu' ) ) {
function prime2g_main_menu( $id = 'main_nav' ) {

$incLogo	=	( ! empty( get_theme_mod( 'prime2g_logo_with_menu' ) ) );

?>

<div id="<?php echo $id; ?>" class="main_menu_wrap<?php if ( $incLogo ) echo ' logo_with_menu'; ?>">

	<?php if ( has_nav_menu( 'main-menu' ) ) { ?>

	<?php if ( ! wp_is_mobile() && $incLogo ) echo '<div class="desktop">' . prime2g_siteLogo() . '</div>'; ?>

	<div id="menu_toggbar" class="menu_toggbar mobiles">
		<div>
			<?php if ( $incLogo ) echo prime2g_siteLogo(); ?>
		</div>
		<div class="menu_togs prel" onclick="prime2g_toggElems( [ '.main_menu_wrap' ] );">
			<span></span>
			<span></span>
			<span></span>
		</div>
	</div>

		<nav class="main-menu collapsible-navs site-menus site_width" role="navigation" aria-label="<?php esc_attr_e( 'Main Menu', 'twentytwentyone' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location'	=>	'main-menu',
					'menu_class'		=>	'main-menu-wrapper',
					'container_class'	=>	'main-menu-container',
					'items_wrap'		=>	'<ul id="main_menu_items" class="%2$s">%3$s</ul>',
					'fallback_cb'		=>	false,
				)
			);
			?>
		</nav><!-- #site-main-menu -->
	<?php
	}
	else {
		if ( current_user_can( 'edit_theme_options' ) ) esc_html_e( 'No Main Menu', 'toongeeprime-theme' );
	}
	?>

</div><!-- #mainNav -->

<?php
}
}




/**
 *	Footer Menu
 */
if ( ! function_exists( 'prime2g_footer_menu' ) ) {
function prime2g_footer_menu( $id = '' ) { ?>

<div id="<?php echo $id; ?>" class="footer_menu_wrap">
	<?php if ( has_nav_menu( 'footer-menu' ) ) { ?>
		<nav aria-label="<?php esc_attr_e( 'Footer Menu', 'toongeeprime-theme' ); ?>" class="footer-navigation">
			<ul class="footer_menu_items">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-menu',
						'items_wrap'     => '%3$s',
						'container'      => false,
						'depth'          => 1,
						'link_before'    => '<span>',
						'link_after'     => '</span>',
						'fallback_cb'    => false,
					)
				);
				?>
			</ul><!-- .footer-navigation-wrapper -->
		</nav><!-- .footer-navigation -->
	<?php
	}
	else {
		if ( current_user_can( 'edit_theme_options' ) ) esc_html_e( 'No Footer Menu', 'toongeeprime-theme' );
	}
	?>
</div><!-- .site-menu-base -->

<?php
}
}




