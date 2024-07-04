<?php defined( 'ABSPATH' ) || exit;
/**
 *	CLASS: DOING CREDENTIALS
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.98
 */
class Prime2gCredentials {
	private	$head_alg	=	'SHA256',	#	confirm @ server
			$head_typ	=	'JWT',	#	confirm @ server
			$public_sslkey,
			#	@ Payload
			$claim_iss,		#	enc, Issuer
			$claim_sub,		#	Contact/url
			$claim_aud,		#	URL: Recipient site's Authorization processing path
			$claim_iat,		#	Issued At
			$claim_exp,		#	Expiration time
			$claim_jti,		#	JWT ID: ever unique
			$data_client_id=	'',	#	enc
			$other_data	=	[];	#	Response type, etc.


	public function __construct() {
		$user	=	wp_get_current_user();

		$timeNow	=	time();
		$this->claim_iat	=	$timeNow;
		$this->claim_exp	=	$timeNow + HOUR_IN_SECONDS;
		$this->claim_jti	=	$timeNow + get_current_user_id();
		$this->claim_iss	=	get_bloginfo( "name" );
		$this->claim_aud	=	esc_url( trailingslashit( get_home_url() ) . 'prime-auth/' );
		$this->claim_sub	=	'mailto:'.prime2g_get_site_domain();
		// $this->public_sslkey=	$this->ssl_keys()->public;
		$this->data_client_id=	$user ? $user->ID .'_'. strtotime($user->user_registered) : null;
	}


	function set_var( string $var_name, $value ) {
		return $this->$var_name	=	$value;
	}


	private function app_keys() : array {
	$key_base	=	'prime2gThemeAuth_er_via_'.prime2g_get_site_domain();
	$public_base=	$key_base . $this->claim_aud;
	$private	=	hash_hmac( 'sha256', get_home_url().'RANDM_5hjsgdh_03vJH_GBcvs_shsd09ij3', $key_base, true );
	return [
		'basic'		=>	$key_base,
		'public'	=>	prime2g_encode( $public_base, true ),
		'private'	=>	prime2g_encode( $private, true )
	];
	}


	function vapid() {
	#	Double-encoded
	$parts	=	$this->jwt_parts( true );
	$keys	=	$this->app_keys();
	return prime2g_encode( $this->claim_sub );
	return prime2g_encode( bin2hex( "0prime2g_ThemeAuth_erPlZ" ) );
	return prime2g_encode( prime2g_encode( $keys['basic'] ) .'.'. prime2g_encode( $keys['public'] ), true );
	}


	function vapid_valid( string $vapid ) {
	$vapid_split=	explode( '.', prime2g_decode( $vapid ) );
	if ( count( $vapid_split ) !== 2 ) return false;
	$public_check	=	prime2g_decode( $vapid_split[1] );
	return $public_check === $this->app_keys()['public'];
	// return in_array( $public_check, $this->app_keys() );
	}


	#	Token output verified @https://jwt.io/ but for signature
	function jwt() {
	$parts	=	$this->jwt_parts( true );
	$header	=	prime2g_encode( $parts->header, true );
	$payload=	prime2g_encode( $parts->payload, true );
	return $header .'.'. $payload .'.'. $this->signature( $header . $payload );
	}


	private function jwt_parts( bool $json ) {
	$raw	=	$this->build_jwt();

	return (object) [
	'header'	=>	$json ? json_encode( $raw->header ) : $raw->header,
	'payload'	=>	$json ? json_encode( $raw->payload ) : $raw->payload
	];
	}


	private function build_jwt() {
	$header	=	[ 'alg' => $this->head_alg, 'typ' => $this->head_typ ];
	$claims	=	[
		'iss' => prime2g_encode($this->claim_iss), 'sub' => $this->claim_sub,
		'aud' => $this->claim_aud, 'iat' => $this->claim_iat, 'exp' => $this->claim_exp,
		'jti' => $this->claim_jti
	];
	$data	=	array_merge( [ 'client_id' => prime2g_encode($this->data_client_id) ], $this->other_data );
	$payload=	array_merge( $claims, $data );

	return (object) [
	'header'	=>	$header,
	'claims'	=>	$claims,
	'data'		=>	$data,
	'payload'	=>	$payload
	];
	}


	#	Caching doesn't work
	private function signature( $data ) {
	// openssl_sign( $data, $signature, $this->ssl_keys()->private, 'sha256' );
	$signature	=	hash_hmac( 'sha256', $data, $this->app_keys()['private'], true );

	return	prime2g_encode( $signature, true );
	}


	private function ssl_keys() {
	$config	=	[
		"private_key_bits"	=>	2048,
		"private_key_type"	=>	OPENSSL_KEYTYPE_RSA // RSA algorithm
	];

	$res	=	openssl_pkey_new( $config );
	openssl_pkey_export( $res, $private_key );
	$public_key	=	openssl_pkey_get_details( $res );

	return (object) [
	'private'	=>	$private_key,
	'public'	=>	$public_key[ 'key' ],
	'auth_token'=>	prime2g_encode( openssl_random_pseudo_bytes(16) )
	];

/*	$private_key	=	openssl_pkey_new([
	'private_key_type'=>	OPENSSL_KEYTYPE_EC,
	'curve_name'	=>	'prime256v1',
	]);

	$details		=	openssl_pkey_get_details( $private_key );
	$private_key_raw=	$details['ec']['d'];
	$public_key_raw	=	$details['ec']['x'] . $details['ec']['y'];
	$auth_token		=	base64_encode(openssl_random_pseudo_bytes(16));

	$key_set	=	[
	'private_key'	=>	prime2g_encode( $private_key_raw ),
	'public_key'	=>	prime2g_encode( $public_key_raw ),
	'auth_token'	=>	$auth_token
	];

	return $key_set;
	return prime2g_encode( json_encode($key_set) );
*/
	}


	#	Verify Token
	function jwt_valid( $token ) {
	$token_parts	=	explode( '.', $token );
	if ( count( $token_parts ) !== 3 ) return false;

	$header		=	prime2g_decode( $token_parts[0], true );
	$payload	=	prime2g_decode( $token_parts[1], true );
	$signature	=	$token_parts[2];
	$dec_sign	=	prime2g_decode( $signature );

	$header_data=	json_decode( $header );
	if ( ! isset( $header_data->alg ) || $header_data->alg !== $this->head_alg ) return false;

	// $result	=	openssl_verify( $token, $signature, $this->public_sslkey, 'sha256' );
	// return $result;

	$valid_signature	=	hash_hmac( 'sha256', $header . $payload, $this->app_keys()['private'], true );
	$valid_signature	=	prime2g_encode( $valid_signature, true );

	return $signature === $valid_signature;
	}

}


/*
WHAT HAPPENS DURING LIVE VALIDATION

// Include the JwtManager class
require 'vendor/autoload.php';
use JwtManager;
// Your secret key (keep this secure)
$secretKey = 'your_secret_key';
// Create an instance of JwtManager
$jwtManager = new JwtManager($secretKey);
// Create a JWT
$payload = [
    "user_id" => 123,
    "username" => "john_doe",
    "exp" => time() + 3600, // Token expiration time (1 hour)
];
$jwt = $jwtManager->createToken($payload);
echo "JWT Token: " . $jwt . PHP_EOL;
// Validate and decode the JWT
if ($jwtManager->validateToken($jwt)) {
    echo "JWT is valid." . PHP_EOL;
    $decodedPayload = $jwtManager->decodeToken($jwt);
    echo "Decoded Payload: " . json_encode($decodedPayload, JSON_PRETTY_PRINT);
} else {
    echo "JWT is invalid.";
}
*/


