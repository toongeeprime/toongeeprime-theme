<?php defined( 'ABSPATH' ) || exit;

/**
 *	CUSTOM TAXONOMIES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.50
 *	https://developer.wordpress.org/reference/functions/register_taxonomy/
 */

#	@since 1.0.94
add_action( 'admin_init', 'prime2g_remove_submenus', 1000 );
function prime2g_remove_submenus() {
    remove_submenu_page( 'themes.php', 'edit-tags.php?taxonomy=template_parts_section' );
}

add_action( 'admin_footer', function() {
	if ( isset( $_GET[ 'post_type' ], $_GET[ 'taxonomy' ] ) &&
	$_GET[ 'post_type' ] === 'prime_template_parts' && $_GET[ 'taxonomy' ] === 'template_parts_section' ) {
	echo	'<script id="primeRefocusCurrentItem">
	primetParts	=	document.querySelector( "#menu-posts-prime_template_parts" );
	primetParts.classList.add( "wp-has-current-submenu", "wp-menu-open" );
	primetParts.classList.remove( "wp-not-current-submenu" );
	document.querySelector( "#menu-appearance" ).classList.remove( "wp-has-current-submenu", "wp-menu-open" );
	document.querySelector( "#menu-appearance a" ).classList.remove( "wp-has-current-submenu" );
	</script>';
	}
} );
#	@since 1.0.94 End



if ( ! function_exists( 'prime2g_register_custom_taxonomies' ) ) {

add_action( 'init', 'prime2g_register_custom_taxonomies', 1 );

function prime2g_register_custom_taxonomies() {
# 1.0.74: condition is now only prime2g_use_extras()
if ( prime2g_use_extras() ) {
#	Template Part Sections
$parts_labels	=	array(
	'name'			=>	_x( 'Template Sections', 'taxonomy general name', PRIME2G_TEXTDOM ),
	'singular_name'	=>	__( 'Template Section', PRIME2G_TEXTDOM ),
	'search_items'	=>	__( 'Search Sections', PRIME2G_TEXTDOM ),
	'all_items'		=>	__( 'All Sections', PRIME2G_TEXTDOM ),
	'parent_item'	=>	__( 'Parent Section', PRIME2G_TEXTDOM ),
	'parent_item_colon'	=>	__( 'Parent Template Parts Section:', PRIME2G_TEXTDOM ),
	'edit_item'		=>	__( 'Edit Template Parts Section', PRIME2G_TEXTDOM ),
	'update_item'	=>	__( 'Update Section', PRIME2G_TEXTDOM ),
	'add_new_item'	=>	__( 'Add New Section', PRIME2G_TEXTDOM ),
	'new_item_name'	=>	__( 'New Template Parts Section', PRIME2G_TEXTDOM ),
	'menu_name'		=>	__( 'Template Sections', PRIME2G_TEXTDOM ),
	'not_found'		=>	__( 'No Sections Found', PRIME2G_TEXTDOM )
);
$parts_args	=	array(
	'label'			=>	__( 'Template Parts Sections', PRIME2G_TEXTDOM ),
	'labels'		=>	$parts_labels,
	'query_var'		=>	false,
	'public'		=>	false,
	'hierarchical'	=>	true,
	'show_ui'		=>	true,
	'show_in_rest'	=>	true,
	'show_in_quick_edit'=>	true,
	'show_admin_column'	=>	true,
	'show_in_menu'	=>	true
);

register_taxonomy( 'template_parts_section', 'prime_template_parts', $parts_args );


#	Brands for Defined Post Types
$brand_labels	=	array(
	'name'			=>	_x( 'Brands', 'taxonomy general name', PRIME2G_TEXTDOM ),
	'singular_name'	=>	__( 'Brand', PRIME2G_TEXTDOM ),
	'search_items'	=>	__( 'Search Brands', PRIME2G_TEXTDOM ),
	'all_items'		=>	__( 'All Brands', PRIME2G_TEXTDOM ),
	'parent_item'	=>	__( 'Parent Brand', PRIME2G_TEXTDOM ),
	'parent_item_colon'	=>	__( 'Parent Brand:', PRIME2G_TEXTDOM ),
	'edit_item'		=>	__( 'Edit Brand', PRIME2G_TEXTDOM ),
	'update_item'	=>	__( 'Update Brand', PRIME2G_TEXTDOM ),
	'add_new_item'	=>	__( 'Add New Brand', PRIME2G_TEXTDOM ),
	'new_item_name'	=>	__( 'New Brand', PRIME2G_TEXTDOM ),
	'menu_name'		=>	__( 'Brands', PRIME2G_TEXTDOM ),
	'not_found'		=>	__( 'No Brands Found', PRIME2G_TEXTDOM )
);
$brand_args	=	array(
	'label'			=>	__( 'Brands', PRIME2G_TEXTDOM ),
	'labels'		=>	$brand_labels,
	'query_var'		=>	true,
	'public'		=>	true,
	'hierarchical'	=>	true,
	'show_ui'		=>	true,
	'show_in_rest'	=>	true,
	'show_in_quick_edit'=>	true,
	'show_admin_column'	=>	true,
	'show_in_menu'	=>	true
);

register_taxonomy( 'brand', prime_post_types_group()->has_brand, $brand_args );
}

}

}


