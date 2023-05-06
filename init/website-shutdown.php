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

	# Return conditions
	if (
		is_admin() || is_user_logged_in() ||
		in_array( $GLOBALS[ 'pagenow' ], array( 'wp-login.php', 'wp-register.php' ) )
	 ) return;


/**
 *	SHUTDOWN PAGE
 *	@since ToongeePrime Theme @ 1.0.55
 */
$usePage	=	get_theme_mod( 'prime2g_shutdown_display' );
if ( 'use_page' === $usePage ) {

if ( ! is_singular() ) { wp_safe_redirect( home_url() ); exit; }

$pageID	=	get_theme_mod( 'prime2g_shutdown_page_id' );

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


$title	=	( 'maintenance' == $shutDown ) ? 'Website is Under Maintenance!' : 'Coming Soon!';

echo '<!DOCTYPE html><html lang="en">
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

echo '
<style id="coming-soon-style">
body{display:grid;place-content:center;text-align:center;min-height:100vh;padding:var(--min-pad);
background-size:cover;background-position:center;background-image:url('. get_background_image() .');}
</style>
</head>';

	# Run Close-down
	if ( current_user_can( 'edit_theme_options' ) && empty( get_background_image() ) )
		echo '<p style="position:fixed;top:0;left:0;">* You can add a background image in Customizer</p>';

	echo '<body class="coming_soon">';

	prime2g_close_down_template( $shutDown );

	wp_footer();

	echo '</body>';

	exit;

}



/**
 *	Closed Website Page Template
 */
if ( ! function_exists( 'prime2g_close_down_template' ) ) {
function prime2g_close_down_template( $shutDown ) {

$headline	=	'maintenance' == $shutDown ?
'This website is undergoing Maintenance!' : 'This website is under construction and will be live soon!';

$msg	=	'maintenance' == $shutDown ? 'We will be back soon.' : 'Thank you for checking in.';

	echo '<main id="message">';
	echo '<h1>'. __( $headline, PRIME2G_TEXTDOM ) .'</h1>';
	echo '<h3>'. __( $msg, PRIME2G_TEXTDOM ) .'</h3>';
	echo '</main>';
}
}
