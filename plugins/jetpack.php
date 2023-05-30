<?php defined( 'ABSPATH' ) || exit;

/**
 *	OF JETPACK
 *
 *	@package WordPress
 *	@package JetPack
 *	@since ToongeePrime Theme 1.0.47
 */

if ( class_exists( 'Jetpack' ) ) :

/**
 *	Set JetPack related posts count
 */
add_filter( 'jetpack_relatedposts_filter_options', 'prime2g_moreJP_related_posts' );
function prime2g_moreJP_related_posts( $options ) {
	$options[ 'size' ]	=	prime2g_jp_relatedposts_count();
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
 *	@since ToongeePrime Theme 1.0.48
 */
add_action( 'prime2g_after_post', 'prime2g_add_jp_related_posts', 8 );
if ( ! function_exists( 'prime2g_add_jp_related_posts' ) ) {
function prime2g_add_jp_related_posts() {
	if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
		echo do_shortcode( '[jetpack-related-posts]' );
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
add_action( 'after_setup_theme', 'prime2g_set_jp_infiniteScroll', 11 );
if ( ! function_exists( 'prime2g_set_jp_infiniteScroll' ) ) {

function prime2g_set_jp_infiniteScroll() {
if ( prime2g_use_extras() ) {

add_theme_support(
	'infinite-scroll',
	array(
		'container'	=>	'archive_loop',
		'wrapper'	=>	false,
		'footer'	=>	false,
		'render'	=>	'prime2g_infiniteScroll_render',
		'posts_per_page'	=>	prime2g_jp_infiniteScroll_count(),
	)
);
}

function prime2g_infiniteScroll_render() {
if ( function_exists( 'is_shop' ) && is_woocommerce() ) return;
	while ( have_posts() ) {
		the_post();
		prime2g_archive_loop();
	}
}
}

}


/**
 *	@since ToongeePrime Theme Theme 1.0.50
 */
add_filter( 'infinite_scroll_settings', 'prime2g_infinite_scroll_settings' );
function prime2g_infinite_scroll_settings( $args ) {
if ( is_array( $args ) )
	$args[ 'posts_per_page' ]	=	prime2g_jp_infiniteScroll_count();
return $args;
}


if ( ! function_exists( 'prime2g_jp_infiniteScroll_count' ) ) {
	function prime2g_jp_infiniteScroll_count() { return 8; }
}

/**
 *	@since ToongeePrime Theme Theme 1.0.51
 */
if ( ! function_exists( 'prime2g_jp_relatedPosts_count' ) ) {
	function prime2g_jp_relatedPosts_count() { return 6; }
}




endif;

