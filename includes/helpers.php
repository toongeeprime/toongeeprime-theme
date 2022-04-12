<?php defined( 'ABSPATH' ) || exit;

/**
 *	HELPER FUNCTIONS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	Use prime2g_removeSidebar() to remove the sidebar from a template
 *	Sidebar is added throughout the theme via footer.php by prime2g_add_sidebar()
 */
function prime2g_removeSidebar() {

	function define_2gRMVSidebar(){}

}


/**
 *	Get Singular Template
 */
function prime2g_singular_template( $format = '' ) {

	if ( is_child_theme() ) {
		$file	=	CHILD2G_SINGULAR . get_post_type() . $format . '.php';
	}
	else {
		$file	=	PRIME2G_SINGULAR . get_post_type() . $format . '.php';
	}

	if ( file_exists( $file ) ) {
		require $file;
	}
	else {
		require PRIME2G_SINGULAR . 'post.php';
	}

}



/**
 *	Get Archive Template
 */
function prime2g_archive_template( $format = '' ) {

	if ( is_child_theme() ) {
		$file	=	CHILD2G_ARCHIVE . get_post_type() . $format . '.php';
	}
	else {
		$file	=	PRIME2G_ARCHIVE . get_post_type() . $format . '.php';
	}

	if ( file_exists( $file ) ) {
		require $file;
	}
	else {
		require PRIME2G_ARCHIVE . 'post.php';
	}

}



/**
 *	Include or exclude post types
 */
if ( ! function_exists( 'prime2g_include_post_types' ) ) {
	function prime2g_include_post_types( array $addTo = [ 'post', 'page' ] ) {
		return $addTo;
	}
}

if ( ! function_exists( 'prime2g_exclude_post_types' ) ) {
	function prime2g_exclude_post_types( array $pTypes = [ 'page' ] ) {
		return ( ! in_array( get_post_type(), $pTypes ) );
	}
}

