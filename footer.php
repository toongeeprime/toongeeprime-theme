<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME FOOTER
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */
?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php prime2g_sidebar(); ?>

	</div><!-- #content -->
</div><!-- #contentWrap -->


<?php prime2g_footer_top_widgets(); ?>


<div id="footerWrap" class="footerWrap">

<footer id="site_footer" class="site_footer">

	<?php prime2g_footer_widgets(); ?>
	<?php prime2g_footer_menu(); ?>

</footer><!-- #site_footer -->

<hr class="footer_hr" />

	<section id="colophon" class="colophon prel" role="contentinfo">

		<?php echo prime2g_title_or_logo( '<footer class="footer_logo prel title_tagline_logo">', '</footer>' ); ?>

		<div class="site-info">

			<?php echo prime2g_theme_mod_social_and_contacts(); ?>

		</div><!-- .site-info -->

	</section><!-- #colophon -->

	<?php echo prime2g_theme_mod_footer_credit(); ?>

</div><!-- #footerWrap -->


</div><!-- #page -->

</div><!-- #container -->

<?php wp_footer(); ?>

</body>
</html>
