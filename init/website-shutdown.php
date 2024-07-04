<?php defined( 'ABSPATH' ) || exit;
/**
 *	SHUTTING DOWN THE WEBSITE
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

add_action( 'template_redirect', 'prime2g_close_down_website', 5 );
function prime2g_close_down_website() {

/* NOTE: WordPress still loads frontpage object */
$shutDown	=	get_theme_mod( 'prime2g_website_shutdown' );
$administrator	=	current_user_can( 'edit_theme_options' );
$bypassKey	=	get_theme_mod( 'prime2g_shutdown_url_bypass_key' );	#	@since 1.0.96
$is_shutdown=	! empty( $shutDown );
$bypassing	=	$is_shutdown && isset( $_GET[ $bypassKey ] );
$shoppinng	=	function_exists( 'is_woocommerce' );

if ( $bypassing ) {
echo '<div id="byPassingNote" class="p-fix" style="color:#fff;background:red;z-index:99999;left:0;right:0;">
<p class="centered">'. __( 'Website is shut down', PRIME2G_TEXTDOM ) .'</p>
</div>';
}

#	Return conditions
if ( ! $is_shutdown || $bypassing || is_admin() || $administrator ||
	in_array( $GLOBALS[ 'pagenow' ], [ 'wp-login.php', 'wp-register.php' ] )
) return;

/*	@since 1.0.90	*/
status_header( 503 );
nocache_headers();


/**
 *	USE A SHUTDOWN PAGE?
 *	@since 1.0.55
 */
if ( 'use_page' === get_theme_mod( 'prime2g_shutdown_display' ) ) {

if ( $shoppinng )
	$return_home	=	is_singular() && ! is_front_page() || ! is_shop() && is_archive() && ! is_home();
else
	$return_home	=	is_singular() && ! is_front_page() || is_archive() && ! is_home();

if ( $return_home ) {
	wp_safe_redirect( home_url() );
exit;
}

$page_id	=	get_theme_mod( 'prime2g_shutdown_page_id' );

if ( empty( $page_id ) || $front_home = is_front_page() && is_home() ) {
	echo $front_home ? 'Posts home is front page!' : 'No page selected for display!';
	prime2g_close_down_template( $shutDown );	//	use raw template *no header & footer
	exit;
}

$pageID	=	(int) $page_id;
$page	=	new WP_Query( [ 'post_type' => 'page', 'p' => $pageID ] );

if ( $page->have_posts() ) {

define( 'PRIME2G_ALT_POST_OBJ', $page->posts[0] );

get_header();

	while ( $page->have_posts() ) {
	$page->the_post();

	prime2g_before_post();

	the_content();

	prime2g_link_pages();

	prime2g_after_post();
break;
	}
get_footer();
}

exit;
}


$title	=	'maintenance' === $shutDown ? 'Website is Under Maintenance!' : 'Coming Soon!';
$icon	=	get_site_icon_url();

echo '<!DOCTYPE html><html '. get_language_attributes() .' '. prime2g_theme_html_classes( false ) .'>
<head>
	<meta charset="' . get_bloginfo( 'charset' ) . '" />
	<title>' . $title . ' - ' . get_bloginfo( 'name' ) . '</title>
	<link rel="icon" href="'. $icon .'">
	<!-- Open Graph -->
	<meta property="og:url" content="' . get_home_url() . '" />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="'. $icon .'" />
	<!-- Twitter Card -->
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:image" content="'. $icon .'" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />';

wp_head();

$background_image	=	get_background_image();
$add_css	=	function_exists( 'prime2g_add_shutdown_css' ) ? prime2g_add_shutdown_css() : '';
$add_js		=	function_exists( 'prime2g_add_shutdown_js' ) ? prime2g_add_shutdown_js() : '';

echo '<style id="comingSoonCSS">
body{display:grid;place-content:center;text-align:center;min-height:100vh;padding:var(--min-pad);
background-size:cover;background-position:center;background-image:url('. $background_image .');}
#prime2g_toTop{display:none;}
'. $add_css .'
</style>
</head>';

	#	Run Closedown
	echo '<body class="coming_soon '. implode( ' ', get_body_class() ) .'">';

	wp_body_open();

	if ( $administrator && empty( $background_image ) )
		echo '<p style="position:fixed;top:0;left:0;">* You can add a background image in Customizer</p>';

	prime2g_close_down_template( $shutDown );

	wp_footer();

	echo '<script id="comingSoonJS">'. $add_js .'</script>';

	echo '</body></html>';
exit;
}


/**
 *	Closed Website Page Template
 */
if ( ! function_exists( 'prime2g_close_down_template' ) ) {
function prime2g_close_down_template( $shutDown ) {

$headline	=	'maintenance' === $shutDown ?
'This website is undergoing Maintenance!' : 'This website is under construction and will be live soon!';

$msg	=	'maintenance' === $shutDown ? '... and will be back soon' : 'Thank you for checking in';

	echo '<main id="message">
	<h1 class="entry-title page-title">'. __( $headline, PRIME2G_TEXTDOM ) .'</h1>
	<h3>'. __( $msg, PRIME2G_TEXTDOM ) .'</h3>';

	if ( get_theme_mod( 'prime2g_show_socials_and_contacts', 0 ) ) {
		echo '<p style="margin:50px 0;">Contact/Follow Us</p>' . prime2g_theme_mod_social_and_contacts();
	}

	echo '</main>';
}
}

