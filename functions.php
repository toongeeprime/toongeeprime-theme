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
define( 'PRIME2G_PART', PRIME2G_THEME . 'parts/' );
define( 'PRIME2G_SINGULAR', PRIME2G_PART . 'singular/' );
define( 'PRIME2G_ARCHIVE', PRIME2G_PART . 'archive/' );
define( 'CHILD2G_SINGULAR', get_stylesheet_directory() . '/parts/singular/' );
define( 'CHILD2G_ARCHIVE', get_stylesheet_directory() . '/parts/archive/' );


/**
 *	LOAD THEME FILES
 */
require_once 'files-loader.php';


/**
 *	Add Files to the Queue
 */
add_action( 'wp_enqueue_scripts', 'prime2g_theme_enqueues' );
if ( ! function_exists( 'prime2g_theme_enqueues' ) ) :
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

	// WooCommerce Styles
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style(
			'prime2g_woocommerce_css',
			get_theme_file_uri( '/files/prime_woocommerce.css' ),
			array( 'prime2g_css' ),
			wp_get_theme()->get( 'Version' )
		);
	}

    // Theme Scripts
	// jQuery
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
		array( 'prime2g_js' ),
		wp_get_theme()->get( 'Version' ),
		true // script in footer
	);

}
endif;



/**
 *	Removing Default WooCommerce styles
 */
if ( class_exists( 'woocommerce' ) ) {
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
}



