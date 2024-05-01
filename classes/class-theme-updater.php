<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME UPDATER
 *
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


	/**
	 *	@param string $theme Theme slug
	 *	@param string $metadataUrl The URL of the theme metadata file
	 */
	public function __construct() {
		if ( defined( 'PRIMETHEMEUPDATER' ) ) return;
		define( 'PRIMETHEMEUPDATER', true );

		$this->theme			=	wp_get_theme( $this->slug );
		$this->current_version	=	$this->theme->get( 'Version' );

		$this->set_this_theme_transient();

		add_filter( 'site_transient_update_themes', [ $this,'theme_update_site_transient' ] );
		add_action( 'admin_notices', [ $this, 'add_admin_notice' ] );

		$this->maybe_force_reset_transients();
	}


	function add_admin_notice() {
	global $pagenow;
	if ( $this->update_available() && ! in_array( $pagenow, [ 'update-core.php', 'themes.php' ] ) && current_user_can( 'edit_others_posts' ) ) {
		echo '<div class="notice notice-warning notice-alt is-dismissible">
		<p>'. __( 'New ToongeePrime Theme Update is available, please update now ', $this->slug ) .'
		<a href="'. admin_url( 'update-core.php?source='. $this->slug ) .'" title="Update the theme here">'. __( 'here', $this->slug ) .'</a>!
		</p></div>';
	}
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

		if (
		is_wp_error( $remote ) || 200 !== wp_remote_retrieve_response_code( $remote ) || empty( $remote_body )
		) {
			return (object) [ 'error' => true, 'message' => 'Failed remote request' ];
		}

		return	json_decode( $remote_body );
	}


	/**
	 *	For workings within this class
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
	 *	Callback @ site_transient_update_themes
	 */
	function theme_update_site_transient( $transient ) {
		if ( is_object( $transient ) ) {
			$item_data	=	$this->transient_item_data();

			if ( $this->update_available() && $this->update_qualified() ) {
				$transient->response[ $this->slug ]	=	$item_data;
			}
			else {
				$transient->no_update[ $this->slug ]=	$item_data;
			}
		}

	return $transient;
	}


	function maybe_force_reset_transients() {
		if ( wp_doing_ajax() ) return;
		if ( is_admin()
			&& isset( $_GET[ 'prime-update' ] ) && $_GET[ 'prime-update' ] === 'recheck-theme' ) {

			if ( get_site_transient( $this->transient_name ) ) {
				delete_site_transient( $this->transient_name );
				// set_site_transient( 'update_themes', null );
			}
		}
	}

}


/**
 *		ACTIVATE
 */
if ( ! function_exists( 'prime2g_theme_updater' ) ) {

add_action( 'admin_init', 'prime2g_theme_updater' );
function prime2g_theme_updater() {
	new Prime2gThemeUpdater();
}

}



