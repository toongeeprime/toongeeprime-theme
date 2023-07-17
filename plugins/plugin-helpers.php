<?php defined( 'ABSPATH' ) || exit;

/**
 *	HELP PLUGIN MATTERS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */


function prime2g_plugin_exists( string $pluginpath ): bool {
	return file_exists( ABSPATH . 'wp-content/plugins/' . $pluginpath );
}

