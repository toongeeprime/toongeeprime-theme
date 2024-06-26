<?php defined( 'ABSPATH' ) || exit;
/**
 *	THEME FOOTER
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

$styles			=	ToongeePrime_Styles::mods_cache();	# 1.0.93
$sidebarBySite	=	! wp_is_mobile() && in_array( $styles->sidebar_place, [ 'site_right', 'site_left' ] );

if ( is_singular() ) echo '</article><!-- #primary -->'; ?>

		</main><!-- #main -->

		<?php if ( ! $sidebarBySite ) prime2g_sidebar(); ?>

	</div><!-- #content -->
</div><!-- #contentWrap -->

<?php
prime2g_footer_top_widgets();
do_action( 'prime2g_after_content' );	# 1.0.92

#	@since 1.0.90
if ( false === prime2g_remove_footer() ) {
?>

<div id="footerWrap" class="footerWrap">

<footer id="site_footer" class="site_footer site_width">

<?php
	prime2g_footer_widgets();
	prime2g_footer_menu();
?>

</footer><!-- #site_footer -->

	<section id="colophon" class="colophon prel site_width" role="contentinfo">

<?php
if ( get_theme_mod( 'prime2g_theme_add_footer_logo', '1' ) )
	echo prime2g_title_or_logo( '<div class="footer_logo prel title_tagline_logo">', '</div>' );
?>

		<div class="site-info site_width">
<?php
if ( get_theme_mod( 'prime2g_show_socials_and_contacts', 1 ) )
	echo prime2g_theme_mod_social_and_contacts();
?>
		</div><!-- .site-info -->

	</section><!-- #colophon -->

<?php
	prime2g_site_base_strip();	# Theme Hook
	echo prime2g_theme_mod_footer_credit();
?>

</div><!-- #footerWrap -->

<?php } ?>

</div><!-- #page -->

<?php if ( $sidebarBySite ) prime2g_sidebar(); ?>

</div><!-- #page_wrapper -->
</div><!-- #container -->

<?php wp_footer(); ?>

</body>
</html>
