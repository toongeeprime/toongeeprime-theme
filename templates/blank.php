<?php defined( 'ABSPATH' ) || exit;

/**
 *	Template Name: All-Blank Sheet
 *	Template Post Type: post, page
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php endif; ?>
	<title><?php wp_title( ' | ', true, 'right' ); bloginfo( 'name' ); ?></title>
<?php
	prime2g_removeSidebar();
	wp_head();
?>
<style>
#comments{width:900px;max-width:90%;margin-left:auto;margin-right:auto;padding:var(--min-pad);}
</style>
</head>

<body <?php body_class(); ?>>

<?php while ( have_posts() ) {
	the_post();

	prime2g_pageCSS();
	prime2g_edit_entry();
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-content">
			<?php
			the_content();
			prime2g_comments();
			?>
		</div><!-- .entry-content -->
	</article>

<?php
	prime2g_pageJS();
}

wp_footer();
?>

</body>
</html>

