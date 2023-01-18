<?php defined( 'ABSPATH' ) || exit;

/**
 *	CUSTOM TAXONOMIES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.50.00
 *	https://developer.wordpress.org/reference/functions/register_taxonomy/
 */

add_action( 'init', 'prime2g_register_custom_taxonomies', 0 );

if ( ! function_exists( 'prime2g_register_custom_taxonomies' ) ) {

function prime2g_register_custom_taxonomies() {

if ( get_theme_mod( 'prime2g_cpt_template_parts' ) ) {

#	Template Part Sections
$labels	=	array(
	'name'			=>	_x( 'Template Parts Sections', 'taxonomy general name', PRIME2G_TEXTDOM ),
	'singular_name'	=>	__( 'Template Parts Section', PRIME2G_TEXTDOM ),
	'search_items'	=>	__( 'Search Sections', PRIME2G_TEXTDOM ),
	'all_items'		=>	__( 'All Sections', PRIME2G_TEXTDOM ),
	'parent_item'	=>	__( 'Parent Section', PRIME2G_TEXTDOM ),
	'parent_item_colon'	=>	__( 'Parent Template Parts Section:', PRIME2G_TEXTDOM ),
	'edit_item'		=>	__( 'Edit Template Parts Section', PRIME2G_TEXTDOM ),
	'update_item'	=>	__( 'Update Section', PRIME2G_TEXTDOM ),
	'add_new_item'	=>	__( 'Add New Section', PRIME2G_TEXTDOM ),
	'new_item_name'	=>	__( 'New Template Parts Section', PRIME2G_TEXTDOM ),
	'menu_name'		=>	__( 'Template Parts Sections', PRIME2G_TEXTDOM ),
	'not_found'		=>	__( 'No Sections Found', PRIME2G_TEXTDOM ),
);
$args	=	array(
	'label'			=>	__( 'Template Parts Sections', PRIME2G_TEXTDOM ),
	'labels'		=>	$labels,
	'query_var'		=>	false,
	'public'		=>	false,
	'hierarchical'	=>	true,
	'show_ui'		=>	true,
	'show_in_rest'	=>	true,
	'show_in_quick_edit'	=>	true,
	'show_admin_column'	=>	true,
	'show_in_menu'	=>	true,
);

register_taxonomy( 'template_parts_section', 'prime_template_parts', $args );

}

}



}
