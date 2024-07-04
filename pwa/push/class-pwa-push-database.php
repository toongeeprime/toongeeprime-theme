<?php defined( 'ABSPATH' ) || exit;
/**
 *	CLASS: PWA Push Notifications Database
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.98
 *		called @Prime2g_Push_Notifications
 */
class Prime2g_Push_Database {

	private static $instance;
	public
		$current_version=	001,
		$version_table	=	'p2g_app_push_version',
		$table_name		=	'p2g_app_push_notifs';


	public function __construct() {
	if ( ! isset( self::$instance ) ) {

	// add_action( 'init', [ $this, 'create_table' ] );
	// add_action( 'init', [ $this, 'update_table' ] );
	}

	return self::$instance;
	}


	function create_table() {
	#	Use update method if table exists
	if ( get_option( $this->version_table ) ) return;

	global $wpdb;
	// $wpdb->base_prefix
	$table_name	=	$wpdb->prefix . $this->table_name;
	$charset_collate	=	$wpdb->get_charset_collate();

	$sql	=	"CREATE TABLE $table_name (
		id bigint(25) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		user_id mediumint(12) UNSIGNED NOT NULL,
		client_id varchar(100),
		push_subscription_data text,
		public_key varchar(255) NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

		// push_subscribed_time tinytext,

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	$success	=	empty( $wpdb->last_error );
	if ( $success ) add_option( $this->version_table, $this->current_version );
	}


	function add_data() {
	global $wpdb;
	$table_name	=	$wpdb->prefix . $this->table_name;

	$wpdb->insert( $table_name, 
	array( 
		'time'	=>	current_time( 'mysql' ),
		'user_id'	=>	get_current_user_id(),
		'public_key'	=>	'poikjxz9203ikjdns_oikjdw4ijnfd'
	)
	);
	}


	function update_table() {
		global $wpdb;
		$installed_ver	=	get_option( $this->version_table );

		if ( $installed_ver != $this->current_version ) {
		$table_name	=	$wpdb->prefix . $this->table_name;

		$sql	=	"ADD UPDATED TABLE DATA";	# @https://codex.wordpress.org/Creating_Tables_with_Plugins#:~:text=for%20more%20details.-,Adding%20an%20Upgrade%20Function,-Over%20the%20lifetime

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		$success	=	empty( $wpdb->last_error );
		if ( $success ) update_option( $this->version_table, $this->current_version );
		}
	}

}

