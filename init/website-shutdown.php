<?php defined( 'ABSPATH' ) || exit;

/**
 *	SHUTTING DOWN THE WEBSITE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

add_action( 'template_redirect', 'prime2g_close_down_website' );

function prime2g_close_down_website() {

$shutDown	=	get_theme_mod( 'prime2g_website_shutdown' );
if ( empty( $shutDown ) ) return;

#	Other return conditions
if ( is_admin() || is_user_logged_in() ||
	in_array( $GLOBALS[ 'pagenow' ], [ 'wp-login.php', 'wp-register.php' ] )
) return;


$add_css	=	function_exists( 'prime2g_add_shutdown_css' ) ? prime2g_add_shutdown_css() : '';
$add_js		=	function_exists( 'prime2g_add_shutdown_js' ) ? prime2g_add_shutdown_js() : '';

/**
 *	OPTION TO USE A SHUTDOWN PAGE
 *	@since ToongeePrime Theme @ 1.0.55
 */
$usePage	=	get_theme_mod( 'prime2g_shutdown_display' );
if ( 'use_page' === $usePage ) {

if ( is_archive() && ! is_home() || is_singular() && ! is_front_page() ) {
	wp_safe_redirect( home_url() ); exit;
}

$pageID	=	(int) get_theme_mod( 'prime2g_shutdown_page_id' );

$page	=	new WP_Query( [ 'page_id' => $pageID ] );

if ( $page->have_posts() ) {
	$page->the_post();

if ( get_post_meta( get_the_ID(), 'remove_sidebar', true ) === 'remove' ) prime2g_removeSidebar();

get_header();

	prime2g_before_post();

	the_content();

	prime2g_link_pages();

	prime2g_after_post();

get_footer();

}

exit;
}


$title	=	( 'maintenance' === $shutDown ) ? 'Website is Under Maintenance!' : 'Coming Soon!';

echo '<!DOCTYPE html><html '. get_language_attributes() .' '. prime2g_theme_html_classes( false ) .'>
<head>
	<meta charset="' . get_bloginfo( 'charset' ) . '" />
	<title>' . $title . ' - ' . get_bloginfo( 'name' ) . '</title>
	<!-- Open Graph -->
	<meta property="og:url" content="' . get_home_url() . '" />
	<meta property="og:type" content="website" />
	<!-- Twitter Card -->
	<meta name="twitter:card" content="summary" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />';

wp_head();

$background_image	=	get_background_image();

echo '<style id="comingSoonCSS">
body{display:grid;place-content:center;text-align:center;min-height:100vh;padding:var(--min-pad);
background-size:cover;background-position:center;background-image:url('. $background_image .');}
'. $add_css .'
</style>
</head>';

	//	Run Close-down
	echo '<body class="coming_soon '. implode( ' ', get_body_class() ) .'">';

	wp_body_open();

	if ( current_user_can( 'edit_theme_options' ) && empty( $background_image ) )
		echo '<p style="position:fixed;top:0;left:0;">* You can add a background image in Customizer</p>';

	prime2g_close_down_template( $shutDown );

	echo '<script id="comingSoonJS">'. $add_js .'</script>';

	wp_footer();

	echo '</body></html>';

	exit;
}


/**
 *	Closed Website Page Template
 */
if ( ! function_exists( 'prime2g_close_down_template' ) ) {
function prime2g_close_down_template( $shutDown ) {

$headline	=	'maintenance' == $shutDown ?
'This website is undergoing Maintenance!' : 'This website is under construction and will be live soon!';

$msg	=	'maintenance' == $shutDown ? 'We will be back soon' : 'Thank you for checking in';

	echo '<main id="message">
	<h1 class="entry-title page-title">'. __( $headline, PRIME2G_TEXTDOM ) .'</h1>
	<h3>'. __( $msg, PRIME2G_TEXTDOM ) .'</h3>';

	if ( get_theme_mod( 'prime2g_show_socials_and_contacts', 0 ) ) {
		echo '<p style="margin:50px 0;">Contact/Follow Us</p>' . prime2g_theme_mod_social_and_contacts();
	}

	echo '</main>';
}
}
