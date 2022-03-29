<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME FUNCTIONS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *
 **
 *	THEME CONSTANTS
 */
define( 'PRIME2G_THEMEURL', get_template_directory_uri() . '/' );
define( 'PRIME2G_THEME', get_template_directory() . '/' );
define( 'PRIME2G_PARTS', PRIME2G_THEME . 'parts/' );
define( 'PRIME2G_SINGULAR', PRIME2G_PARTS . 'singular/' );
define( 'PRIME2G_ARCHIVE', PRIME2G_PARTS . 'archive/' );


/**
 *	LOAD THEME FILES
 */
require_once 'files-loader.php';


/**
 *	Add Files to the Queue
 */
add_action( 'wp_enqueue_scripts', 'prime2g_theme_enqueues' );
if ( ! function_exists( 'prime2g_theme_enqueues' ) ) {
function prime2g_theme_enqueues() {

	// Add WP Dashicons
	wp_enqueue_style( 'dashicons' );

    // Theme Styles
	wp_enqueue_style(
		'prime2g_reset_and_wp_css',
		get_theme_file_uri( '/files/reset-and-wp.css' ),
		array(),
		wp_get_theme()->get( 'Version' )
	);

	wp_register_style(
		'prime2g_css',
		get_theme_file_uri( '/files/theme.css' ),
		array(),
		wp_get_theme()->get( 'Version' )
	);

    wp_enqueue_style( 'prime2g_css' );


    // Theme Scripts
	// jQuery:
	wp_enqueue_script(
		'add_jQuery_v360',
		'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'
	);

	wp_enqueue_script(
		'prime2g_js',
		get_theme_file_uri( '/files/theme.js' ),
		array(),
		wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_script(
		'prime2g_footer_js',
		get_theme_file_uri( '/files/footer.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true // places script in footer
	);


/**
 *	Removing Default WooCommerce styles
 */
if ( class_exists( 'woocommerce' ) ) {
	add_filter( 'woocommerce_enqueue_styles', 'prime2g_remove_woo_css' );


// Or just remove them all in one line
// add_filter( 'woocommerce_enqueue_styles', '__return_false' );

}

if ( ! function_exists( 'prime2g_remove_woo_css' ) ) {

function prime2g_remove_woo_css( $enqueue_styles ) {

	// Remove only general styles
	unset( $enqueue_styles[ 'woocommerce-general' ] );

return $enqueue_styles;
}

}


} // Ends prime2g_theme_enqueues()
}

