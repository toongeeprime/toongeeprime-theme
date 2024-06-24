<?php defined( 'ABSPATH' ) || exit;
/**
 *	ENQUEUE FILES
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	Contents moved to this file being new @since 1.0.49
 */

add_action( 'wp_enqueue_scripts', 'prime2g_theme_enqueues' );
if ( ! function_exists( 'prime2g_theme_enqueues' ) ) {
function prime2g_theme_enqueues() {

/*	@since 1.0.89	*/
global $compress_scripts, $concatenate_scripts;
$compress_scripts		=	1;
$concatenate_scripts	=	1;
define( 'ENFORCE_GZIP', true );

$optimize_files	=	! empty( get_theme_mod( 'prime2g_optimize_theme_files' ) );

global $post;
$version	=	PRIME2G_VERSION;

#	STYLES
if ( ! $optimize_files ) {
if ( prime_child_min_version( '2.3' ) ) {
	wp_register_style( 'prime2g_css', get_theme_file_uri( '/files/theme-min.css' ), [], $version );
}
else {
	wp_register_style( 'prime2g_css', get_theme_file_uri( '/deprecated/theme-old.css' ), [], $version );
}

    wp_enqueue_style( 'prime2g_css' );
}

	#	WooCommerce Styles
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style(
			'prime2g_woocommerce_css', get_theme_file_uri( '/files/prime_woocommerce.css' ),
			[ 'prime2g_css' ], $version
		);

		//	if not using mini cart: wp_dequeue_script( 'wc-cart-fragments' );
	}
	else {
		//	WooCommerce Adds jQuery Migrate, so do if jQ is registered & Woo absent
		//	@since 1.0.89
		if ( get_theme_mod( 'prime2g_deregister_jq_migrate', 0 ) ) {
			if ( wp_script_is( 'jquery-migrate', 'registered' ) )
				wp_deregister_script( 'jquery-migrate' );
		}
	}

if ( isset( $post ) && $post->font_url ) {
	wp_enqueue_style( 'prime_post_font_url', $post->font_url, [], null );
}

/**
 *	SCRIPTS
 *
 ***
 *	Theme's local jQuery?
 *	@since 1.0.59
 */
# registration & unconditional @since 1.0.97, mainly for ajax
# Let dependants async/defer
wp_register_script( 'prime2g_jQuery', get_theme_file_uri( '/files/jquery.min.js' ), [], '3.7.1', true );
wp_enqueue_script( 'prime2g_jQuery' );

#	@since 1.0.97
if ( ! $optimize_files ) {
	wp_register_script( 'prime2g_js', get_theme_file_uri( '/files/theme-min.js' ), [], $version, false );
	wp_enqueue_script( 'prime2g_js' );

	wp_register_script(
		'prime2g_footer_js',
		get_theme_file_uri( '/files/footer.js' ),
		[ 'prime2g_js' ],
		$version,
		[ 'in_footer' => true, 'strategy' => 'async' ]
	);
	wp_enqueue_script( 'prime2g_footer_js' );
}

/**
 *	ICONS
 *	@since 1.0.60
 */
#	echo '<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">';
$icons	=	prime2g_theme_icons_info();	//	@since 1.0.89
wp_enqueue_style( PRIME2G_ICONS_HANDLE, $icons->url, [], $icons->version );


// Prepare to remove this completely
if ( ! prime_child_min_version( '2.3' ) ) {
	wp_enqueue_script( 'prime2g_deprecated_js', get_theme_file_uri( '/deprecated/deprecated.js' ), [], $version );
}



/**
 *	DISBLING CSS
 *	@since 1.0.85
 */
if ( get_theme_mod( 'prime2g_disable_blocks_css' ) ) {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
}

if ( get_theme_mod( 'prime2g_disable_wc_blocks_css' ) ) {
	wp_deregister_style( 'wc-blocks-style' );
	wp_dequeue_style( 'wc-blocks-style' );
}

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
if ( ! function_exists( 'prime2g_admin_enqueues' ) ) {
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

