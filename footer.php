<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME FOOTER
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */
?>

		<?php if ( is_singular() ) echo '</article><!-- #primary -->'; ?>

		</main><!-- #main -->

		<?php prime2g_sidebar(); ?>

	</div><!-- #content -->
</div><!-- #contentWrap -->


<?php prime2g_footer_top_widgets(); ?>


<div id="footerWrap" class="footerWrap">

<footer id="site_footer" class="site_footer">

	<?php prime2g_footer_widgets(); ?>
	<?php prime2g_footer_menu(); ?>

</footer><!-- #site_footer -->

	<section id="colophon" class="colophon prel" role="contentinfo">

	<?php
	if ( get_theme_mod( 'prime2g_theme_add_footer_logo', '1' ) ) {
		echo prime2g_title_or_logo( '<div class="footer_logo prel title_tagline_logo">', '</div>' );
	}
	?>

		<div class="site-info">

<?php
if ( get_theme_mod( 'prime2g_show_socials_and_contacts', 1 ) ) {
	echo prime2g_theme_mod_social_and_contacts();
}
?>

		</div><!-- .site-info -->

	</section><!-- #colophon -->

	<?php prime2g_site_base_strip();	# Theme Hook ?>
	<?php echo prime2g_theme_mod_footer_credit(); ?>

</div><!-- #footerWrap -->


</div><!-- #page -->

</div><!-- #container -->

<?php wp_footer(); ?>

</body>
</html>
