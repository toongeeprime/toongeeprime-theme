<?php defined( 'ABSPATH' ) || exit;

/**
 *	ADD FILES TO QUEUE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	Contents moved to this file being new @since ToongeePrime Theme 1.0.49
 */
add_action( 'wp_enqueue_scripts', 'prime2g_theme_enqueues' );
if ( ! function_exists( 'prime2g_theme_enqueues' ) ) {
function prime2g_theme_enqueues() {
$version	=	PRIME2G_VERSION;

    #	Theme Styles
if ( prime_child_min_version( '2.3' ) ) {
	$themeCSS	=	'theme.css';
} else {
	$themeCSS	=	'theme-old.css';
}
	wp_register_style(
		'prime2g_css',
		get_theme_file_uri( '/files/' . $themeCSS ),
		[], $version
	);

    wp_enqueue_style( 'prime2g_css' );

	#	WooCommerce Styles
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style(
			'prime2g_woocommerce_css',
			get_theme_file_uri( '/files/prime_woocommerce.css' ),
			array( 'prime2g_css' ), $version
		);
	}

    /**
	 *	Theme Scripts
	 */
// @since 1.0.59
if ( is_multisite() ) {
	switch_to_blog( 1 );
	$useJQ	=	 ! empty( get_theme_mod( 'prime2g_enqueue_theme_jquery' ) );
	restore_current_blog();
} else {
	$useJQ	=	 ! empty( get_theme_mod( 'prime2g_enqueue_theme_jquery' ) );
}

if ( $useJQ ) {
	#	jQuery
	wp_enqueue_script(
		'prime2g_jQuery',
		get_theme_file_uri( '/files/jquery.min.js' ),
		[], '3.7.1', [ 'strategy' => 'defer' ]
	);
}

	wp_register_script(
		'prime2g_js',
		get_theme_file_uri( '/files/theme-min.js' ),
		[], $version
	);

	wp_enqueue_script( 'prime2g_js' );

if ( ! prime_child_min_version( '2.3' ) ) {
	wp_enqueue_script( 'prime2g_deprecated_js', get_theme_file_uri( '/files/deprecated.js' ), [], $version );
}

	wp_enqueue_script(
		'prime2g_footer_js',
		get_theme_file_uri( '/files/footer.js' ),
		array( 'prime2g_js' ), $version,
		true // script in footer
	);
}
}


/**
 *	Removing Default WooCommerce styles
 */
if ( class_exists( 'woocommerce' ) ) { add_filter( 'woocommerce_enqueue_styles', '__return_false' ); }


/**
 *	@since ToongeePrime Theme 1.0.50
 */
add_action( 'admin_enqueue_scripts', 'prime2g_admin_enqueues' );
if ( !function_exists( 'prime2g_admin_enqueues' ) ) {
function prime2g_admin_enqueues() {
	wp_register_script(
		'prime2g_js',
		get_theme_file_uri( '/files/theme.js' ),
		[], PRIME2G_VERSION
	);

	wp_enqueue_script( 'prime2g_js' );
}
}

add_action( 'customize_controls_enqueue_scripts', 'prime2g_customizer_enqueues' );
add_action( 'customize_preview_init', 'prime2g_customizer_preview_enqueues' );
function prime2g_customizer_enqueues() {
    wp_enqueue_script(
		'prime2g_customizer_js',
		get_theme_file_uri( '/files/customizer.js' ),
		array( 'jquery', 'customize-controls' ),
		PRIME2G_VERSION,
		true
	);
}

function prime2g_customizer_preview_enqueues() {
    wp_enqueue_script(
		'prime2g_customizer_preview_js',
		get_theme_file_uri( '/files/customizer-preview.js' ),
		array( 'jquery', 'customize-preview' ),
		PRIME2G_VERSION,
		true
	);
}
/* @since ToongeePrime Theme 1.0.50 End */


