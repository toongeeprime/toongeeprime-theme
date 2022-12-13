<?php defined( 'ABSPATH' ) || exit;

/**
 *	ADD FILES TO QUEUE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.49.00
 */

add_action( 'wp_enqueue_scripts', 'prime2g_theme_enqueues' );
if ( ! function_exists( 'prime2g_theme_enqueues' ) ) {
function prime2g_theme_enqueues() {

    # Theme Styles
	wp_enqueue_style(
		'prime2g_reset_and_wp_css',
		get_theme_file_uri( '/files/reset-and-wp.css' ),
		array(),
		PRIME2G_VERSION
	);

	wp_register_style(
		'prime2g_css',
		get_theme_file_uri( '/files/theme.css' ),
		array(),
		PRIME2G_VERSION
	);

    wp_enqueue_style( 'prime2g_css' );

	# WooCommerce Styles
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style(
			'prime2g_woocommerce_css',
			get_theme_file_uri( '/files/prime_woocommerce.css' ),
			array( 'prime2g_css' ),
			PRIME2G_VERSION
		);
	}

    # Theme Scripts
	# jQuery
	wp_enqueue_script(
		'prime2g_jQuery',
		'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'
	);

	wp_register_script(
		'prime2g_js',
		get_theme_file_uri( '/files/theme.js' ),
		array(),
		PRIME2G_VERSION
	);

	wp_enqueue_script( 'prime2g_js' );

	wp_enqueue_script(
		'prime2g_footer_js',
		get_theme_file_uri( '/files/footer.js' ),
		array( 'prime2g_js' ),
		PRIME2G_VERSION,
		true # script in footer
	);

}
}



/**
 *	Removing Default WooCommerce styles
 */
if ( class_exists( 'woocommerce' ) ) {
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
}

