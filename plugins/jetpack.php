<?php defined( 'ABSPATH' ) || exit;

/**
 *	OF JETPACK
 *
 *	@package WordPress
 *	@package JetPack
 *	@since ToongeePrime Theme 1.0.47.00
 */

if ( is_plugin_active( 'jetpack/jetpack.php' ) ) :


/**
 *	Have 6 JetPack related posts
 */
add_filter( 'jetpack_relatedposts_filter_options', 'prime2g_moreJP_related_posts' );
function prime2g_moreJP_related_posts( $options ) {
	$options[ 'size' ]	=	6;
	return $options;
}



/**
 *	Remove JetPack related posts to add them to theme
 */
add_action( 'wp', 'prime2g_removeJP_related_posts', 20 );
function prime2g_removeJP_related_posts() {
	if ( class_exists( 'Jetpack_RelatedPosts' ) ) { # retain
		$jprp		=	Jetpack_RelatedPosts::init();
		$callback	=	array( $jprp, 'filter_add_target_to_dom' );
		remove_filter( 'the_content', $callback, 40 );
	}
}



/**
 *	Add JetPack related posts to theme
 *	@since ToongeePrime Theme 1.0.48.00
 */
add_action( 'prime2g_after_post', 'prime2g_add_jp_related_posts', 8 );
if ( ! function_exists( 'prime2g_add_jp_related_posts' ) ) {
function prime2g_add_jp_related_posts() {
	if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
		echo do_shortcode( '[[jetpack-related-posts]]' );
	}
}
}



/**
 *	JP Infifite Scroll Footer Credit
 */
add_filter( 'infinite_scroll_credit', 'prime2g_infiniteScroll_credit' );
if ( ! function_exists( 'prime2g_infiniteScroll_credit' ) ) {
function prime2g_infiniteScroll_credit() {
	$text	=	__( 'Designed &#38; Developed by <a href="' . esc_url( 'https://akawey.com/' ) . '" title="Visit Akàwey">Akàwey</a>', PRIME2G_TEXTDOM );
return $text;
}
}



/**
 *	JetPack Infifite Scroll workings
 *	https://jetpack.com/support/infinite-scroll/
 */
if ( defined( 'PRIME2G_EXTRAS' ) ) {
add_action( 'after_setup_theme', 'prime2g_set_jp_infiniteScroll', 11 );

if ( ! function_exists( 'prime2g_set_jp_infiniteScroll' ) ) {

function prime2g_set_jp_infiniteScroll() {
add_theme_support(
	'infinite-scroll',
	array(
		'container'	=>	'archive_loop',
		'wrapper'	=>	false,
		'footer'	=>	false,
		'render'	=>	'prime2g_infiniteScroll_render',
		'posts_per_page'	=>	8,
	)
);
}

}

function prime2g_infiniteScroll_render() {
if ( function_exists( 'is_shop' ) && is_woocommerce() ) return;
	while ( have_posts() ) {
		the_post();
		prime2g_archive_loop();
	}
}
}



endif;

