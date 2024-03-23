<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME DOING AJAX
 *
 *	@package WordPress
 *	Essential formData fields: prime_ajaxnonce, prime_do_ajax: to select what to run
 *	@since ToongeePrime Theme 1.0.49.05
 */

add_action( 'wp_ajax_prime2g_doing_ajax', 'prime2g_doing_ajax' );
add_action( 'wp_ajax_prime2g_doing_ajax_nopriv', 'prime2g_doing_ajax_nopriv' );
add_action( 'wp_ajax_nopriv_prime2g_doing_ajax_nopriv', 'prime2g_doing_ajax_nopriv' );

function prime2g_doing_ajax() {
if ( 'POST' != $_SERVER[ 'REQUEST_METHOD' ] || empty( $_POST[ 'action' ] ) ) return;
prime2g_verify_nonce( 'prime_nonce_action' );

$doAjax	=	$_POST[ 'prime_do_ajax' ];



wp_send_json( $response );

wp_die();
}




function prime2g_doing_ajax_nopriv() {
if ( 'POST' != $_SERVER[ 'REQUEST_METHOD' ] || empty( $_POST[ 'action' ] ) ) return;
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


if ( $doAjax === 'ajax_search' ) {
$template		=	$_POST[ 'template' ];
$template_args	=	$_POST[ 'template_args' ];
$searchQuery	=	new WP_Query( array( 's' => $_POST[ 'find' ], 'posts_per_page' => $_POST[ 'count' ] ) );
$output	=	'';
$posts	=	$searchQuery->posts;
$number	=	$_POST[ 'count' ];
$found	=	$searchQuery->found_posts;

$results_num	=	$found < $number ? $found : $number;

if ( $found ) {
	for ( $p = 0; $p < $results_num; $p++ ) {
		$template_args	=	array_merge( [ 'post' => $posts[ $p ], 'title_tag' => 'span' ], $template_args );
		$output	.=	$template( $template_args );
	}
}
else {
	$output	.=	'<p class="centered">'. __( 'Nothing found', PRIME2G_TEXTDOM ) .'</p>';
}

wp_reset_postdata();

$response	=	[ 'posts' => $output, 'number' => $found ];
}


wp_send_json( $response );

wp_die();
}

