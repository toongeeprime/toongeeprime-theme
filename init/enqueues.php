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
global $post;
$version	=	PRIME2G_VERSION;

#	STYLES
if ( prime_child_min_version( '2.3' ) ) {
	$themeCSS	=	'theme.css';
} else {
	$themeCSS	=	'theme-old.css';
}
	wp_register_style( 'prime2g_css', get_theme_file_uri( '/files/' . $themeCSS ), [], $version );
    wp_enqueue_style( 'prime2g_css' );

	#	WooCommerce Styles
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style(
			'prime2g_woocommerce_css',
			get_theme_file_uri( '/files/prime_woocommerce.css' ),
			array( 'prime2g_css' ), $version
		);
	}

if ( isset( $post ) && $post->font_url ) {
	wp_enqueue_style( 'prime_post_font_url', $post->font_url, [], null );
}

/**
 *	SCRIPTS
 *
 ** 
 *	Theme's local jQuery?
 *	@since 1.0.59
 */
if ( PRIME2G_ENQ_JQUERY || isset( $post ) && $post->enqueue_jquery === 'yes' ) {
wp_enqueue_script( 'prime2g_jQuery', get_theme_file_uri( '/files/jquery.min.js' ), [], '3.7.1', true ); # do not async/defer
}

	wp_register_script( 'prime2g_js', get_theme_file_uri( '/files/theme-min.js' ), [], $version );
	wp_enqueue_script( 'prime2g_js' );

	wp_enqueue_script(
		'prime2g_footer_js', get_theme_file_uri( '/files/footer.js' ),
		array( 'prime2g_js' ), $version, [ 'in_footer' => true, 'strategy' => 'async' ]
	);

/**
 *	ICONS
 *	@since 1.0.60
 */
# echo '<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">';
wp_enqueue_style( PRIME2G_ICONS_HANDLE, prime2g_icons_file_url(), [], '1.11.1' );


if ( ! prime_child_min_version( '2.3' ) ) {
	wp_enqueue_script( 'prime2g_deprecated_js', get_theme_file_uri( '/files/deprecated.js' ), [], $version );
}

// wp_deregister_script( 'jquery-migrate' );

}
}


/**
 *	Remove Default WooCommerce styles
 */
if ( class_exists( 'woocommerce' ) ) { add_filter( 'woocommerce_enqueue_styles', '__return_false' ); }


/**
 *	@since 1.0.50
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
/* @since 1.0.50 End */

