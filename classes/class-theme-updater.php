<?php defined( 'ABSPATH' ) || exit;
/**
 *	THEME UPDATER
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 *	https://make.wordpress.org/core/2020/07/30/recommended-usage-of-the-updates-api-to-support-the-auto-updates-ui-for-plugins-and-themes-in-wordpress-5-5
 */

class Prime2gThemeUpdater {
	public
		$theme,
		$slug	=	PRIME2G_TEXTDOM,
		$current_version;
	protected
		$transient_name	=	'prime2g_update_theme',
		$metadataUrl	=	'https://dev.akawey.com/wp/themes/toongeeprime-theme/theme.json';


	public function __construct() {
		if ( defined( 'PRIMETHEMEUPDATER' ) ) return;
		define( 'PRIMETHEMEUPDATER', true );

		$this->theme			=	wp_get_theme( $this->slug );
		$this->current_version	=	$this->theme->get( 'Version' );

		$this->maybe_clear_transients();

		$this->set_this_theme_transient();

		$this->admin_notices();

		add_filter( 'pre_set_site_transient_update_themes', [ $this,'set_theme_status_response' ] );
		add_filter( 'site_transient_update_themes', [ $this,'set_update_notice' ] );

		$this->upgrade_processing();

		add_action( 'deleted_site_transient', [ $this, 'delete_transient_if' ], 10, 1 );
	}


	private function update_available() {
		$update_data	=	get_site_transient( $this->transient_name );
		if ( ! $update_data || isset( $update_data->error ) && $update_data->error === true )
			return false;
		return version_compare( $this->current_version, $update_data->version, '<' );
	}


	/**
	 *	Retrieve update info from metadata URL
	 */
	private function get_remote_data() {
		$remote	=	wp_remote_get(
			$this->metadataUrl,
			array(
			'timeout'	=>	10,
			'headers'	=>	[ 'Accept' => 'application/json' ]
			)
		);

		$remote_body	=	wp_remote_retrieve_body( $remote );

		if ( is_wp_error( $remote ) || 200 !== wp_remote_retrieve_response_code( $remote )
			|| empty( $remote_body ) ) {
			return (object) [ 'error' => true, 'message' => 'Failed remote request' ];
		}

		return	json_decode( $remote_body );
	}


	/**
	 *	Establish workings within this class
	 */
	private function set_this_theme_transient() {
		if ( $remote_to_transient = get_site_transient( $this->transient_name ) ) {
			return $remote_to_transient;
		}
		else {
			$remote_to_transient	=	$this->get_remote_data();

			if ( isset( $remote_to_transient->error )
			&& $remote_to_transient->error === true ) return;

			set_site_transient( $this->transient_name, $remote_to_transient, DAY_IN_SECONDS );
			return $remote_to_transient;
		}
	}


	private function transient_item_data() {
	$remote_in_transient	=	get_site_transient( $this->transient_name );

	if ( ! $remote_in_transient ) {
		return	[
			'theme'			=>	$this->slug,
			'new_version'	=>	$this->current_version,
			'url'			=>	'',
			'package'		=>	'',
			'requires'		=>	'',
			'requires_php'	=>	''
		];
	}

	return	array(
		'theme'			=>	$this->slug,
		'new_version'	=>	$this->update_available() ? $remote_in_transient->version : $this->current_version,
		'url'			=>	$remote_in_transient->details_url,
		'package'		=>	$remote_in_transient->download_url,
		'requires'		=>	$remote_in_transient->requires,
		'requires_php'	=>	$remote_in_transient->requires_php
	);
	}


	private function update_qualified() {
	$remote_in_transient	=	get_site_transient( $this->transient_name );

	return version_compare( $remote_in_transient->requires, get_bloginfo( 'version' ), '<=' )
		&& version_compare( $remote_in_transient->requires_php, PHP_VERSION, '<=' );
	}


	/**
	 *	Callback @ pre_set_site_transient_update_themes
	 */
	function set_theme_status_response( $transient ) {
	$item_data	=	$this->transient_item_data();

		if ( $this->update_available() && $this->update_qualified() ) {
			$transient->response[ $this->slug ]	=	$item_data;
		}
		else {
			$transient->no_update[ $this->slug ]=	$item_data;
		}
	return $transient;
	}


	/**
	 *	Callback @ site_transient_update_themes
	 */
	function set_update_notice( $transient ) {
	if ( is_object( $transient ) ) {
		#	The Notice
		$transient	=	$this->set_theme_status_response( $transient );
	}
	else {
		#	Fix for warning messages on Dashboard / Updates page
		$transient	=	new stdClass();
		$item_data	=	$this->transient_item_data();
		$transient->response	=	$transient->no_update	=	[];
		$transient->response[ $this->slug ]		=	$item_data;
		$transient->no_update[ $this->slug ]	=	$item_data;
	}
	return $transient;
	}


	function upgrade_processing() {
	if ( wp_doing_ajax() || ! is_admin() || ! current_user_can( 'update_themes' ) ) return;

		// add_action( 'after_setup_theme', function() {
			// remove_filter( 'pre_set_site_transient_update_themes', [ $this, 'set_theme_status_response' ] );
			// remove_filter( 'site_transient_update_themes', [ $this, 'set_update_notice' ] );
		// }, 11 );

		add_action( 'upgrader_process_complete', function( $upgrader_object, $options ) {
			if ( $options['action'] === 'update'
			&& $options['type'] === 'theme' && isset( $options['themes'] ) ) {
				foreach( $options['themes'] as $theme ) {
					if ( $theme === $this->slug ) {
						flush_rewrite_rules();
						set_site_transient( 'p2gtheme_updated', 1 );
					}
				}
			}
		}, 10, 2 );
	}


	private function admin_notices() {
	add_action( 'admin_notices', function() {
	global $pagenow;

		if ( $this->update_available() && ! in_array( $pagenow, [ 'update-core.php', 'themes.php' ] ) && current_user_can( 'edit_others_posts' ) ) {
			echo '<div class="notice notice-warning notice-alt is-dismissible">
			<p>'. __( 'New ToongeePrime Theme Update is available, please update now ', $this->slug ) .'
			<a href="'. admin_url( 'update-core.php?prime-update=theme' ) .'" title="Update the theme here">'. __( 'here', $this->slug ) .'</a>!
			</p></div>';
		}

		if ( get_site_transient( 'p2gtheme_updated' ) ) {
			echo '<div class="notice notice-success notice-alt is-dismissible"><p>'
			. __( 'Thanks for updating the Theme, ToongeePrime!', $this->slug ) .
			'</p></div>';
			delete_site_transient( 'p2gtheme_updated' );
		}

	} );
	}


	private function maybe_clear_transients() {
	if ( wp_doing_ajax() ) return;
	if ( is_admin() && current_user_can( 'update_themes' ) ) {
	global $pagenow;

	if ( $pagenow === 'update-core.php' && ! isset( $_GET[ 'action' ] ) ) {
		if ( isset( $_GET[ 'force-check' ] ) && $_GET[ 'force-check' ] === '1' ) {
			if ( get_site_transient( $this->transient_name ) ) {
				$deleted	=	delete_site_transient( $this->transient_name );
				wp_clean_themes_cache();
				if ( $deleted ) {
					add_action( 'admin_notices', function() {
					echo '<div class="notice notice-warning notice-alt is-dismissible">
					<p>'. __( 'Updates data has been refreshed!', $this->slug ) .'</p></div>';
					} );
				}
			}
		}
		else if ( $this->update_available() ) {
			add_action( 'admin_notices', function() {
			echo '<div class="notice notice-warning notice-alt is-dismissible">
			<p>
			'. __( 'To re-check update availability, click the "Check again" link below!', $this->slug ) .'
			</p></div>';
			} );
		}
	}

	}
	}


	function delete_transient_if( $deleted_transient ) {
	if ( $deleted_transient === 'update_themes' )
		delete_site_transient( $this->transient_name );
	}

}



/**
 *		ACTIVATE
 */
if ( ! function_exists( 'prime2g_theme_updater' ) ) {
add_action( 'admin_init', 'prime2g_theme_updater' );
function prime2g_theme_updater() {
	new Prime2gThemeUpdater;
}
}

