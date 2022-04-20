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
 *	Determine Template File To Run
 */
function prime2g_get_theme_template( $archive = false ) {

/**
 *	See if query has post format
 */
$the_format	=	get_post_format();
$format		=	$the_format ? '_' . $the_format : null;


	if ( $archive ) {
	/**
	 *	Run Template for Archive Queries
	 */
		$childfile	=	CHILD2G_ARCHIVE . get_post_type() . $format . '.php';
		$parentfile	=	PRIME2G_ARCHIVE . get_post_type() . $format . '.php';

		if ( is_child_theme() && file_exists( $childfile ) ) {
			require $childfile;
		}
		elseif( file_exists( $parentfile ) ) {
			require $parentfile;
		}
		else {
			require PRIME2G_ARCHIVE . 'post.php';
		}

	}
	else {
	/**
	 *	Run Template for Singular Queries
	 */
		$childfile	=	CHILD2G_SINGULAR . get_post_type() . $format . '.php';
		$parentfile	=	PRIME2G_SINGULAR . get_post_type() . $format . '.php';

		if ( is_child_theme() && file_exists( $childfile ) ) {
			require $childfile;
		}
		elseif( file_exists( $parentfile ) ) {
			require $parentfile;
		}
		else {
			require PRIME2G_SINGULAR . 'post.php';
		}

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

