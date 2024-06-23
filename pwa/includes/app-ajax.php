<?php defined( 'ABSPATH' ) || exit;
/**
 *	APP DOING AJAX
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.97
 */

add_action( 'wp_ajax_prime2g_app_doing_ajax', 'prime2g_app_doing_ajax' );
add_action( 'wp_ajax_prime2g_app_doing_ajax_nopriv', 'prime2g_app_doing_ajax_nopriv' );
add_action( 'wp_ajax_nopriv_prime2g_app_doing_ajax_nopriv', 'prime2g_app_doing_ajax_nopriv' );

function prime2g_app_doing_ajax() {
if ( 'POST' != $_SERVER[ 'REQUEST_METHOD' ] || empty( $_POST[ 'action' ] ) ) return;
prime2g_verify_nonce( 'prime_nonce_action' );

$doAjax	=	$_POST[ 'app_do_ajax' ];

if ( $doAjax === 'update_app' ) {
	// prime2g_app_option( 'version', true, PRIME2G_PWA_VERSION );
}


wp_send_json( $response );

wp_die();
}




function prime2g_app_doing_ajax_nopriv() {
if ( 'POST' != $_SERVER[ 'REQUEST_METHOD' ] || empty( $_POST[ 'action' ] ) ) return;
prime2g_verify_nonce( 'prime_nonce_action' );

$doAjax	=	$_POST[ 'app_do_ajax' ];


wp_send_json( $response );

wp_die();
}


