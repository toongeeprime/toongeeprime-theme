<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME HEADER
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */
?>
<!doctype html>
<html <?php language_attributes(); prime2g_theme_html_classes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php wp_title( ' | ', true, 'right' ); bloginfo( 'name' ); ?></title>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div id="container" class="site_container site_width prel">

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'toongeeprime-theme' ); ?></a>

	<?php get_template_part( 'parts/site-header' ); ?>

	<div id="contentWrap" class="contentWrap">

	<?php if ( 'header' != get_theme_mod( 'prime2g_title_location' ) ) prime2g_title_header( prime2g_title_header_classes() ); ?>

		<div id="content" class="site_content grid site_width">

			<div id="primary" class="primary_area">

				<main id="main" class="site_main<?php if ( is_archive() ) echo ' grid'; ?>" role="main">

