<?php defined( 'ABSPATH' ) || exit;


/**
 *	Theme Update Checker Library 4.5
 *	http://w-shadow.com/
 *
 *	Copyright 2019 Janis Elsts
 *	Released under the MIT license. See license.txt for details.
 *
 *	Stripped to theme updater only!
 *	Also removed third-party file hosting options.
 */

require dirname( __FILE__ ) . '/Puc/Factory.php';
require dirname( __FILE__ ) . '/Puc/Autoloader.php';

new Puc_v4p5_Autoloader();

# Register classes defined in this file with the factory.
Puc_v4p5_Factory::addVersion( 'Theme_UpdateChecker', 'Puc_v4p5_Theme_UpdateChecker', '4.5' );
Puc_v4p5_Factory::addVersion( 'Vcs_ThemeUpdateChecker', 'Puc_v4p5_Vcs_ThemeUpdateChecker', '4.5' );


# Activate theme update check
$myUpdateChecker	=	Puc_v4p5_Factory::buildUpdateChecker(
	'https://dev.akawey.com/wp/themes/toongeeprime-theme/theme.json',
	get_template_directory(),
	PRIME2G_TEXTDOM
);

