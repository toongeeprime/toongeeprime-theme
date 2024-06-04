<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME HEADER
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

global $post;
$isSingular	=	is_singular();
$styles		=	ToongeePrime_Styles::mods_cache();	# 1.0.57 ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php prime2g_theme_html_classes(); ?>>

<?php do_action( 'prime2g_before_head' ); ?>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
wp_head();

#	@since 1.0.92
$hasHeader	=	has_custom_header();
$lcp_link	=	'<link id="p2g_lcp_imglink" rel="preload" fetchpriority="high" as="image" href="'. prime2g_get_header_image_url( $hasHeader ) .'">';
if ( $isSingular )
	echo $hasHeader && $post->remove_header !== 'remove' ? $lcp_link : '';
else
	echo $hasHeader ? $lcp_link : '';
?>
</head>

<?php do_action( 'prime2g_before_body' ); ?>

<body <?php body_class( 'body' ); ?>>

<?php wp_body_open(); ?>

<div id="container" class="site_container site_width prel">

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', PRIME2G_TEXTDOM ); ?></a>

	<?php get_template_part( 'parts/site-header' ); ?>

	<div id="contentWrap" class="contentWrap">

	<?php
	if ( 'header' !== $styles->title_place ) {
		if ( $isSingular ) {
			if ( ! function_exists( 'define_2gRMVTitle' ) ) {
				prime2g_title_header( prime2g_title_header_classes() );
			}
		}
		else {
			prime2g_title_header( prime2g_title_header_classes() );
		}
	}
	?>

	<div id="content" class="site_content content grid site_width">

		<main id="main" class="site_main<?php if ( is_archive() ) echo ' grid'; ?>" role="main">

		<?php if ( $isSingular ) echo '<article id="primary" class="primary_area">'; ?>


