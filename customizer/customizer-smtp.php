<?php defined( 'ABSPATH' ) || exit;
/**
 *	SMTP Settings
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

function prime2g_customizer_smtp( $wp_customize ) {

$network	=	is_multisite();

if ( $network ) {
	switch_to_blog( 1 );
	$route	=	get_theme_mod( 'prime2g_route_smtp_to_networkhome' );
	restore_current_blog();
	if ( $route && get_current_blog_id() !== 1 ) return;
}

$postMsg_text	=	[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ];
$postMsg_email	=	[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_email' ];

	$wp_customize->add_setting( 'prime2g_use_theme_smtp', array_merge( $postMsg_text, [ 'default' => 0 ] ) );
	$wp_customize->add_control( 'prime2g_use_theme_smtp', array(
		'label'		=>	__( 'Activate SMTP', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_use_theme_smtp',
		'section'	=>	'prime2g_theme_smtp_section'
	) );

if ( $network && get_current_blog_id() === 1 ) {
	$wp_customize->add_setting( 'prime2g_route_smtp_to_networkhome', $postMsg_text );
	$wp_customize->add_control( 'prime2g_route_smtp_to_networkhome', array(
		'label'		=>	__( 'Route All Sites\' SMTP to Network Home?', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_route_smtp_to_networkhome',
		'section'	=>	'prime2g_theme_smtp_section'
	) );
}


	$siteName	=	get_bloginfo( 'name' );
	$adminEmail	=	get_bloginfo( 'admin_email' );

	$wp_customize->add_setting( 'prime2g_smtp_sender_name', array_merge( $postMsg_text, [ 'default' => $siteName ] ) );
	$wp_customize->add_control( 'prime2g_smtp_sender_name', array(
		'label'		=>	__( 'Name of Mails Sender', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_smtp_sender_name',
		'section'	=>	'prime2g_theme_smtp_section',
		'input_attrs'	=>	array(
			'placeholder'	=>	$siteName
		)
	) );

	$wp_customize->add_setting( 'prime2g_smtp_from_email', $postMsg_email );
	$wp_customize->add_control( 'prime2g_smtp_from_email', array(
		'label'		=>	__( 'SMTP "From" Email', PRIME2G_TEXTDOM ),
		'type'		=>	'email',
		'settings'	=>	'prime2g_smtp_from_email',
		'section'	=>	'prime2g_theme_smtp_section',
		'input_attrs'	=>	array(
			'placeholder'	=>	$adminEmail
		)
	) );

	$wp_customize->add_setting( 'prime2g_smtp_username', $postMsg_email );
	$wp_customize->add_control( 'prime2g_smtp_username', array(
		'label'		=>	__( 'SMTP Username (Email)', PRIME2G_TEXTDOM ),
		'type'		=>	'email',
		'settings'	=>	'prime2g_smtp_username',
		'section'	=>	'prime2g_theme_smtp_section',
		'input_attrs'	=>	array(
			'placeholder'	=>	$adminEmail
		)
	) );

	$wp_customize->add_setting( 'prime2g_smtp_password', $postMsg_text );
	$wp_customize->add_control( 'prime2g_smtp_password', array(
		'label'		=>	__( 'SMTP Password', PRIME2G_TEXTDOM ),
		'type'		=>	'password',
		'settings'	=>	'prime2g_smtp_password',
		'section'	=>	'prime2g_theme_smtp_section'
	) );

	$wp_customize->add_setting( 'prime2g_smtp_server', $postMsg_text );
	$wp_customize->add_control( 'prime2g_smtp_server', array(
		'label'		=>	__( 'SMTP Server', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_smtp_server',
		'section'	=>	'prime2g_theme_smtp_section',
		'input_attrs'	=>	array(
			'placeholder'	=>	'Example: smtp.servername.com'
		)
	) );

	$wp_customize->add_setting( 'prime2g_smtp_port', $postMsg_text );
	$wp_customize->add_control( 'prime2g_smtp_port', array(
		'label'		=>	__( 'SMTP Port', PRIME2G_TEXTDOM ),
		'type'		=>	'number',
		'settings'	=>	'prime2g_smtp_port',
		'section'	=>	'prime2g_theme_smtp_section',
		'input_attrs'	=>	array(
			'max'		=>	'999',
			'placeholder'=>	'465'
		)
	) );

	$wp_customize->add_setting( 'prime2g_smtp_security_type', array_merge( $postMsg_text, [ 'default' => 'ssl' ] ) );
	$wp_customize->add_control( 'prime2g_smtp_security_type', array(
		'label'		=>	__( 'Security', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_smtp_security_type',
		'section'	=>	'prime2g_theme_smtp_section',
		'choices'	=>	array(
			''		=>	__( 'None', PRIME2G_TEXTDOM ),
			'ssl'	=>	__( 'SSL', PRIME2G_TEXTDOM ),
			'tls'	=>	__( 'TLS', PRIME2G_TEXTDOM )
		)
	) );

}


