<?php defined( 'ABSPATH' ) || exit;
/**
 *	CUSTOM POST TYPES
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.50
 *	https://developer.wordpress.org/reference/functions/register_post_type/
 */

if ( ! function_exists( 'prime2g_register_custom_post_types' ) ) {

add_action( 'init', 'prime2g_register_custom_post_types', 0 );
function prime2g_register_custom_post_types() {

# 1.0.74: condition is now only prime2g_use_extras()
# 1.0.77: made public because of Elementor

if ( prime2g_use_extras() ) {
#	Template Parts
$labels	=	array(
	'name'				=>	__( 'Template Parts', PRIME2G_TEXTDOM ),
	'singular_name'		=>	__( 'Template Part', PRIME2G_TEXTDOM ),
	'menu_name'			=>	__( 'Template Parts', PRIME2G_TEXTDOM ),
	'parent_item_colon'	=>	__( 'Parent Template Part', PRIME2G_TEXTDOM ),
	'all_items'			=>	__( 'Theme Template Parts', PRIME2G_TEXTDOM ),
	'view_item'			=>	__( 'View Template Part', PRIME2G_TEXTDOM ),
	'add_new_item'		=>	__( 'Add New Template Part', PRIME2G_TEXTDOM ),
	'add_new'			=>	_x( 'Add New Part', 'prime_template_parts', PRIME2G_TEXTDOM ),
	'edit_item'			=>	__( 'Edit Template Part', PRIME2G_TEXTDOM ),
	'update_item'		=>	__( 'Update Template Part', PRIME2G_TEXTDOM ),
	'search_items'		=>	__( 'Search Template Parts', PRIME2G_TEXTDOM ),
	'not_found'			=>	__( 'No Template Part Found', PRIME2G_TEXTDOM ),
	'not_found_in_trash'=>	__( 'No Template Parts in Trash', PRIME2G_TEXTDOM )
);

$args	=	array(
	'label'				=>	__( 'Template Parts', PRIME2G_TEXTDOM ),
	'description'		=>	__( 'Theme Template Parts', PRIME2G_TEXTDOM ),
	'labels'			=>	$labels,
	'supports'			=>	array( 'title', 'editor', 'author', 'custom-fields' ),
	'taxonomies'		=>	array( 'template_parts_section' ),
	'hierarchical'		=>	true,
	'public'			=>	true,
	'show_ui'			=>	true,
	// 'show_in_menu'		=>	'themes.php',
	'show_in_nav_menus'	=>	false,
	'show_in_admin_bar'	=>	true,
	'menu_position'		=>	25,
	'menu_icon'			=>	'dashicons-admin-appearance',
	'can_export'		=>	true,
	'has_archive'		=>	false,
	'exclude_from_search'	=>	true,
	'publicly_queryable'	=>	true,
	'query_var'			=>	true,
	'capability_type'	=>	'page',
	'show_in_rest'		=>	true,
	'template'			=>	[ [ 'core/html' ] ],
	// 'template_lock'		=>	'all',
	'rewrite'		=>	array(
		'slug'		=>	'template_part',
		'feeds'		=>	false,
		'with_front'=>	true
	),
	'insert_into_item'		=>	_x( 'Insert into this Template Part', 'prime_template_parts', PRIME2G_TEXTDOM )
);

register_post_type( 'prime_template_parts', $args );
}
}

}

