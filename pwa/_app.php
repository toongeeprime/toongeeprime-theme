<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME' PWA
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

$path	=	PRIME2G_PWA_PATH.'classes/';

require_once $path . 'class-pwa-icons.php';
require_once $path . 'class-pwa-manifest.php';	# app center
require_once $path . 'class-pwa-offline-manager.php';
require_once $path . 'class-pwa-offline-script.php';
require_once $path . 'class-pwa-service-worker.php';



