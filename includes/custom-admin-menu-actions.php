<?php defined( 'ABSPATH' ) || exit;

/**
 *	REWORKING ADMIN MENUS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.50
 */

add_action( 'admin_menu', 'prime2g_reposition_admin_menus' );
if ( ! function_exists( 'prime2g_reposition_admin_menus' ) ) {

function prime2g_reposition_admin_menus() {

if ( get_theme_mod( 'prime2g_cpt_template_parts' ) ) {
	add_submenu_page(
	'themes.php',
	__( 'Manage Template Parts Sections', PRIME2G_TEXTDOM ),
	__( 'Template Parts Sections', PRIME2G_TEXTDOM ),
	'manage_categories',
	'edit-tags.php?taxonomy=template_parts_section',
	'', 7
	);
}

}

}



add_action( 'parent_file', 'prime2g_prefix_highlight_parent_menu' );
if ( ! function_exists( 'prime2g_prefix_highlight_parent_menu' ) ) {

function prime2g_prefix_highlight_parent_menu( $parent_file ) {

	if ( get_current_screen()->taxonomy === 'template_parts_section' ) {
		$parent_file	=	'themes.php';
	}

return $parent_file;
}

}

