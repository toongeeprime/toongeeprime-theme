<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME UPDATER
 *	https://make.wordpress.org/core/2020/07/30/recommended-usage-of-the-updates-api-to-support-the-auto-updates-ui-for-plugins-and-themes-in-wordpress-5-5
 */

class Prime2gThemeUpdater {
	public $theme;
	public $metadataUrl;

	/**
	 *	@param string $theme Theme slug
	 *	@param string $metadataUrl The URL of the theme metadata file
	 */
	public function __construct( $theme, $metadataUrl ) {
		$this->metadataUrl	=	$metadataUrl;
		$this->theme		=	$theme;

		add_filter( 'site_transient_update_themes', [ $this,'setSiteTransientUpdateTheme' ] );
	}

	/**
	 *	Retrieve update info from the configured metadata URL
	 *	Returns either a the theme JSON object, or NULL
	 */
	public function requestUpdate() {
		$remote	=	wp_remote_get(
			$this->metadataUrl,
			array(
			'timeout'	=>	10,
			'headers'	=>	[ 'Accept' => 'application/json' ]
			)
		);

		$remote_body	=	wp_remote_retrieve_body( $remote );

		if (
		is_wp_error( $remote ) || 200 !== wp_remote_retrieve_response_code( $remote ) ||
		empty( $remote_body ) || $remote === null
		) {
			return null;
		}

	return json_decode( $remote_body );
	}

	/**
	 *	Callback for WP hooks
	 *	@param mixed $value
	 *	@return mixed
	 */
	public function setSiteTransientUpdateTheme( $transient ) {
	$theme		=	wp_get_theme( $this->theme );
	$currentVer	=	$theme->get( 'Version' );

	$update		=	$this->requestUpdate();

	if ( ! $update ) { return $transient; }

	$compatible	=	(
		version_compare( $currentVer, $update->version, '<' )
		&& version_compare( $update->requires, get_bloginfo( 'version' ), '<' )
		&& version_compare( $update->requires_php, PHP_VERSION, '<' )
	);

	$data	=	array(
		'theme'			=>	$this->theme,
		'new_version'	=>	$update->version,
		'url'			=>	$update->details_url,
		'package'		=>	$update->download_url,
		'requires'		=>	$update->requires,
		'requires_php'	=>	$update->requires_php
	);

	if ( $compatible ) {
		if ( $transient ) $transient->response[ $this->theme ]	=	$data;
	}
	else {
		if ( $transient ) $transient->no_update[ $this->theme ]	=	$data;
	}

	return $transient;
	}

}



