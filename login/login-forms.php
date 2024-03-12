<?php defined( 'ABSPATH' ) || exit;

/**
 *	LOGIN FORMS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.73
 */
#	To Do: Registration Form	#
if ( ! function_exists( 'prime2g_login_form' ) ) {
function prime2g_login_form( array $options = [] ) {
if ( ! is_user_logged_in() ) {
$redirect_to=	$wrapper_id	=	$classes	=	null;
$echoform	=	$echo	=	false;
$signup_text=	prime2g_login_action_text( '', 'sign up here.', PRIME2G_TEXTDOM );
$form_id	=	'prime_login_form';
$text_above	=	'<p>Log into your account or '. $signup_text .'</p>';
$text_below	=	'<p>Not a member yet? '. $signup_text .'</p>';
$username_label	=	'Your Username';
$password_label	=	'Your Password';
$button_text	=	'Log in';

extract( $options );

$text_above	=	$text_above === 'default' ? 'Log into your account or '. $signup_text : $text_above;
$text_below	=	$text_below === 'default' ? 'Not a member yet? '. $signup_text : $text_below;

$redirect_to=	$redirect_to ?: wp_get_referer();
$wrapper_id	=	$wrapper_id ? ' id="' . $wrapper_id . '"' : '';
$classes	=	$classes ? $classes . ' ' : '';

$form	=	do_action( 'before_prime_login_form' );
$form	.=	'<div'. $wrapper_id .' class="'. $classes .'prime_loginform form_has_pw_field">' . $text_above;
$form	.=	do_action( 'prime_login_form_top' );

$args	=	array(
	'echo'				=>	$echoform,
	'redirect'			=>	$redirect_to,
	'form_id'			=>	$form_id,
	'label_username'	=>	__( $username_label, PRIME2G_TEXTDOM ),
	'label_password'	=>	__( $password_label, PRIME2G_TEXTDOM ),
	'label_remember'	=>	__( 'Remember Me', PRIME2G_TEXTDOM ),
	'label_log_in'		=>	__( $button_text, PRIME2G_TEXTDOM )
);
$form	.=	wp_login_form( $args );

$form	.=	do_action( 'prime_login_form_bottom' );
$form	.=	$text_below . '</div>';
$form	.=	do_action( 'after_prime_login_form' );

if ( $echo ) echo $form;
else return $form;
}
else {
	return function_exists( 'p2g_form_note_user_is_loggedin' ) ? p2g_form_note_user_is_loggedin() :
	__( '<h3>You are logged in. <a href="'. wp_logout_url() .'" title="Log out now">Log out</a>.</h3>', PRIME2G_TEXTDOM );
}

}
}


function prime2g_login_action_text( $loginTxt = 'Please Log In', $signTxt = 'Sign Up', $refr = '' ) {
$login	=	( ! empty( $loginTxt ) );
$signup	=	( ! empty( $signTxt ) );
$loginHtm	= '';

if ( $login )
	$loginHtm .= '<a href="' . wp_login_url( $refr ) . '" class="login" title="Log into your account">' . __( $loginTxt, PRIME2G_TEXTDOM ) . '</a>';

if ( $login && $signup ) $loginHtm .= ' <span class="liORsu">or</span> ';

if ( $signup )
	$loginHtm .= '<a href="' . wp_registration_url() . '" class="signup" title="Create your account">' . __( $signTxt, PRIME2G_TEXTDOM ) . '</a>';

return $loginHtm;
}


