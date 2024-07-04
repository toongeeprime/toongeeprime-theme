<?php defined( 'ABSPATH' ) || exit;
/**
 *	THEME DOING AJAX
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.49.05
 */

add_action( 'wp_ajax_prime2g_doing_ajax', 'prime2g_doing_ajax' );
add_action( 'wp_ajax_prime2g_doing_ajax_nopriv', 'prime2g_doing_ajax_nopriv' );
add_action( 'wp_ajax_nopriv_prime2g_doing_ajax_nopriv', 'prime2g_doing_ajax_nopriv' );

function prime2g_doing_ajax() {
if ( 'POST' !== $_SERVER[ 'REQUEST_METHOD' ] || empty( $_POST[ 'action' ] ) ) return;
prime2g_verify_nonce( 'prime_nonce_action' );

$doAjax	=	$_POST[ 'prime_do_ajax' ];


wp_send_json( $response );

wp_die();
}




function prime2g_doing_ajax_nopriv() {
if ( 'POST' !== $_SERVER[ 'REQUEST_METHOD' ] || empty( $_POST[ 'action' ] ) ) return;
prime2g_verify_nonce( 'prime_nonce_action' );

$doAjax	=	$_POST[ 'prime_do_ajax' ];

if ( $doAjax === 'get_logo' ) {
	$useDarkLogo	=	$_POST[ 'use_dark_logo' ];
	$hasDarkLogo	=	get_theme_mod( 'prime2g_dark_theme_logo' );

	if ( $hasDarkLogo && $useDarkLogo === 'yes' ) {
		$response	=	prime2g_get_dark_logo_url();
	}
	else {
		$response	=	prime2g_get_custom_logo_url();
	}
}



if ( $doAjax === 'subscribe_pwa_notifications' ) {
	$response	=	"GOTCHA! Again...";
}



if ( $doAjax === 'ajax_search' ) {
$cache_name	=	str_replace( ' ', '-', $_POST[ 'find' ] );

if ( $searchCache = wp_cache_get( $cache_name, PRIME2G_POSTSCACHE ) ) {
	$response	=	$searchCache;
}
else {
$template		=	$_POST[ 'template' ];
$post_type		=	! empty( $_POST[ 'post_type' ] ) ? explode( ',', $_POST[ 'post_type' ] ) : [ 'post','page','product' ];
$template_args	=	$_POST[ 'template_args' ];

$searchQuery	=	new WP_Query( array(
's' => $_POST[ 'find' ], 'posts_per_page' => $_POST[ 'count' ], 'post_type' => $post_type, 'post_status' => 'publish',
'post__not_in' => prime_exclude_ids_from_search()
) );

$output		=	'';
$nothing	=	'<p class="centered">'. __( 'Nothing found.<br>Try the search button or "Enter".', PRIME2G_TEXTDOM ) .'</p>';
$nothing	=	apply_filters( 'prime2g_filter_livesearch_nothingfound', $nothing, $nothing );

if ( $searchQuery->have_posts() ) {
	while ( $searchQuery->have_posts() ) {
		$searchQuery->the_post();
		global $post;
		if ( $post->exclude_from_search === '1' ) continue;
		$template_args	=	array_merge( $template_args, [ 'post' => $post ] );
		$output	.=	$template( $template_args, $post );
	}
	if ( empty( $output ) ) $output	.=	$nothing;
wp_reset_postdata();
}
else {
	$output	.=	$nothing;
}

$response	=	[ 'posts' => $output, 'number' => $searchQuery->found_posts ];
wp_cache_set( $cache_name, $response, PRIME2G_POSTSCACHE, HOUR_IN_SECONDS + 17 );
}

}


wp_send_json( $response );

wp_die();
}


