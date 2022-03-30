<?php defined( 'ABSPATH' ) || exit;

/**
 *	SHUTTING DOWN THE WEBSITE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */


/**
 *	Use basically by adding: add_action( 'init', 'prime2g_close_down_website' );
 */
add_action( 'init', 'prime2g_close_down_website' );
function prime2g_close_down_website() {

if ( empty( get_theme_mod( 'prime2g_website_shutdown' ) ) ) return;

	// Return conditions
	if (
		is_admin() || is_user_logged_in() ||
		in_array( $GLOBALS[ 'pagenow' ], array( 'wp-login.php', 'wp-register.php' ) )
	 ) return;

	// Run Close-down:
	if ( current_user_can( 'edit_theme_options' ) && empty( get_background_image() ) )
		echo '<p style="position:fixed;top:0;left:0;">* You can add a background image in Customizer</p>';
	prime2g_close_down_template(); exit;


}



/**
 *	Closed Website Page Title <head>
 */
function prime2g_comingsoon_head_title() {
	'maintenance' == get_theme_mod( 'prime2g_website_shutdown' ) ?
	$title	=	'Website is Under Maintenance!' :
	$title	=	'Coming Soon!';
return $title;
}



/**
 *	Closed Website Page Template
 */
if ( ! function_exists( 'prime2g_close_down_template' ) ) {
function prime2g_close_down_template() {
$theStyles	=	new ToongeePrime_Styles();
$theColors	=	new ToongeePrime_Colors();

'maintenance' == get_theme_mod( 'prime2g_website_shutdown' ) ?
$headline	=	'This website is undergoing Maintenance!' :
$headline	=	'This website is under construction and will be live soon!';

'maintenance' == get_theme_mod( 'prime2g_website_shutdown' ) ?
$info	=	'We will be back soon.' :
$info	=	'Thank you for checking in.';

echo '<!DOCTYPE html><html lang="en">
		<head>
		<meta charset="' . get_bloginfo( 'charset' ) . '" />
        <title>' . prime2g_comingsoon_head_title() . ' - ' . get_bloginfo( 'name' ) . '</title>
		<!-- Open Graph -->
		<meta property="og:url" content="' . get_home_url() . '" />
		<meta property="og:type" content="website" />
		<!-- Twitter Card -->
		<meta name="twitter:card" content="summary" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />';

wp_head();

echo '
<style id="coming-soon-style">
body{place-content:center;text-align:center;min-height:100vh;
background-size:cover;background-position:center;background-image:url('. get_background_image() .');}
</style>
</head>';

echo '<body class="coming_soon grid">';

	echo '<main id="message">';
	echo '<h1>'. $headline .'</h1>';
	echo '<h3>'. $info .'</h3>';
	echo '</main>';

wp_footer();

echo '</body>';
}
}


