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
		return CHILD2G_SINGULAR . get_post_type() . $format . '.php';
	}
	else {
		return PRIME2G_SINGULAR . get_post_type() . $format . '.php';
	}

}



/**
 *	Get Archive Template
 */
function prime2g_archive_template( $format = '' ) {

	if ( is_child_theme() ) {
		return CHILD2G_ARCHIVE . get_post_type() . $format . '.php';
	}
	else {
		return PRIME2G_ARCHIVE . get_post_type() . $format . '.php';
	}

}





