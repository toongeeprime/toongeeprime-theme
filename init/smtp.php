<?php defined( 'ABSPATH' ) || exit;

/**
 *	SMTP CONSTANTS & CONFIG
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

$network	=	is_multisite();

if ( $network ) switch_to_blog( 1 );

$username	=	get_theme_mod( 'prime2g_smtp_username' );
$password	=	get_theme_mod( 'prime2g_smtp_password' );
$server		=	get_theme_mod( 'prime2g_smtp_server' );
$name		=	get_theme_mod( 'prime2g_smtp_sender_name' );
$from		=	get_theme_mod( 'prime2g_smtp_from_email' );
$port		=	get_theme_mod( 'prime2g_smtp_port', '465' );
$secure		=	get_theme_mod( 'prime2g_smtp_security_type', 'ssl' );

if ( $network ) restore_current_blog();


define( 'SMTP_USERNAME', $username );
define( 'SMTP_PASSWORD', $password );
define( 'SMTP_SERVER', $server );
define( 'SMTP_NAME', $name );
define( 'SMTP_FROM', $from );
define( 'SMTP_PORT', $port );
define( 'SMTP_SECURE', $secure );
define( 'SMTP_AUTH', true );
define( 'SMTP_DEBUG', 0 );

/**
 *	CONFIGURE PHP MAILER
 */
if ( defined( 'PRIME2G_EXTRAS' ) && PRIME2G_EXTRAS === true ) {

add_action( 'phpmailer_init', 'prime2g_phpmailer_smtp', 10, 1 );
function prime2g_phpmailer_smtp( $phpmailer ) {
	$phpmailer->IsSMTP();
	$phpmailer->Host		=	SMTP_SERVER;
	$phpmailer->SMTPAuth	=	SMTP_AUTH;
	$phpmailer->Port		=	SMTP_PORT;
	$phpmailer->Username	=	SMTP_USERNAME;
	$phpmailer->Password	=	SMTP_PASSWORD;
	$phpmailer->SMTPSecure	=	SMTP_SECURE;
	$phpmailer->From		=	SMTP_FROM;
	$phpmailer->FromName	=	SMTP_NAME;
	$phpmailer->CharSet		=	get_bloginfo( 'charset' );
}

}
