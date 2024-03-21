<?php defined( 'ABSPATH' ) || exit;

/**
 *	CLASS: EMAILER
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */
if ( ! class_exists( 'Prime2gMailer' ) ) {

class Prime2gMailer {

	/**
	 *	Variables
	 */
	public $content_type	=	'text/html';
	public $domain;
	public $sender_name;
	public $sender_email;
	public $default_css	=	'yes';
	public $css			=	'';
	public $headers		=	'';	// string|string[]
	public $subject		=	'MAILER CLASS TEST';
	public $recipients;		// string|string[]
	public $mail_content	=	'<h3>ToongeePrime Theme Mailer Test</h3><p>Testing theme\'s mailer class.</p>';
	public $attachments	=	[];	// string|string[]
	public $closing_remark;

// $headers[]	=	'Reply-To: Person Name <person.name@akawey.com>';
// $headers[]	=	'Cc: John <john@akawey.com>';

	/**
	 *	Defaults
	 */
	public function defaults() {
	$siteName	=	get_bloginfo( 'name' );
	$domain		=	prime2g_get_site_domain();

	return (object) [
		'domain'	=>	$domain,
		'sender_name'	=>	$siteName,
		'sender_email'	=>	get_option( 'admin_email' ),
		'closing_remark'=>	'<p>'. __( 'Kind Regards', PRIME2G_TEXTDOM ) .',</p><p>'. esc_html( $siteName ) .'.</p>',
		'recipients'	=>	$this->admin_emails( $domain )
	];
	}


	public function __construct( array $config = [] ) {
		$default	=	$this->defaults();

		$mailer		=	array_merge(
		[
			'content_type'	=>	$this->content_type,
			'headers'		=>	$this->headers,
			'subject'		=>	$this->subject,
			'mail_content'	=>	$this->mail_content,
			'attachments'	=>	$this->attachments,
			'css'			=>	$this->css,
			'domain'		=>	$default->domain,
			'sender_name'	=>	$default->sender_name,
			'sender_email'	=>	$default->sender_email,
			'recipients'	=>	$default->recipients,
			'closing_remark'=>	$default->closing_remark
		],
		$config
		);

		$this->headers = $mailer[ 'headers' ];
		$this->subject = $mailer[ 'subject' ];
		$this->recipients = $mailer[ 'recipients' ];
		$this->content_type = $mailer[ 'content_type' ];
		$this->domain = $mailer[ 'domain' ];
		$this->sender_name = $mailer[ 'sender_name' ];
		$this->sender_email = $mailer[ 'sender_email' ];
		$this->mail_content = $mailer[ 'mail_content' ];
		$this->attachments = $mailer[ 'attachments' ];
		$this->closing_remark = $mailer[ 'closing_remark' ];
		$this->css = $mailer[ 'css' ];
	}


	/**
	 *	Send Mail
	 */
	public function send() {
	add_filter( 'wp_mail_content_type', function() { return $this->content_type; } );

	//	Set "From:" headers (These get overridden by phpmailer_init action)
	add_filter( 'wp_mail_from_name', function() { return $this->sender_name; } );
	add_filter( 'wp_mail_from', function() { return $this->sender_email; } );

	return wp_mail( $this->recipients, $this->subject, $this->mail_template(), $this->headers, $this->attachments );
	}


	/**
	 *	Admin Emails
	 */
	public function admin_emails( string $domain = '' ) {
		$adminEmail	=	get_option( 'admin_email' );
		$smptemail	=	get_theme_mod( 'prime2g_smtp_username' ) ?: ''; # is email
		$admin_alt	=	$domain ? 'admin@' . $domain : '';
	return array( $adminEmail, $smptemail, $admin_alt );
	}


	/**
	 *	Mail Template
	 */
	public function mail_template() {
$template	=
'<html><head>' . $this->mailbox_css() . '</head><body>
<div id="mail_page">
<div id="in_mail_page">
<div id="mailContent">
<div id="mail_details">' . $this->mail_content . '</div>
<div id="closingRem">' . $this->closing_remark . '</div>
</div>
</div>
</div>
</body></html>';

return $template;
	}


	public function mailbox_css() {
//	DO NOT LEAVE LINE SPACES @ WRAPPING '' QUOTES
$css	=	'<style id="myh_mailbox_css">';

if ( $this->default_css === 'yes' ) {
$css	.=	'#mail_details #mheader img{max-height:100px;width:auto;}
#mail_details #mheader{padding:10px;text-align:center;}
#mail_details #mheader p,#mail_details #intro{border:0;display:block;}
#mail_page{background:#555;padding:30px;}
#in_mail_page{background:#fff;color:#303030;padding:25px;width:90%;border-radius:5px;
max-width:600px;margin:auto;box-shadow:0 10px 20px 5px rgba(0,0,0,0.5);}
#mail_details p{padding:15px 0;margin:0;}
#mail_details #custom_b_note{padding:30px 0;}
#mail_details p span{font-weight:600;display:inline-block;min-width:220px;}
#mail_details .date,#mail_details .time{display:block;}';
}

$css	.=	$this->css .
'</style>';

return $css;
}

}

}

