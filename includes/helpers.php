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
 *
 *	This function is so that there doesn't have to be a long list of template files
 *	in the theme's root directory as per WP template hierarchy.
 *	Any unattended templates can use WP defaults, eg: author, 404, etc.
 */
function prime2g_get_theme_template( $archive = false ) {

	if ( is_home() ) {
		require PRIME2G_ARCHIVE . 'post.php';
	}
	elseif ( $archive ) {
		if ( is_category() || is_tag() || is_tax() ) {
		// Filename format must be: taxonomy_slug.php or taxonomy.php

			$obj	=	get_queried_object();
			$slug	=	'_' . $obj->slug;
			$taxonomy	=	$obj->taxonomy;
			$fileName	=	$taxonomy ?? null;

			/**
			 *	Run Template for Archive Queries
			 */
			$childfile_slug		=	CHILD2G_ARCHIVE . $fileName . $slug . '.php';
			$childfile			=	CHILD2G_ARCHIVE . $fileName . '.php';
			$parentfile_slug	=	PRIME2G_ARCHIVE . $fileName . $slug . '.php';
			$parentfile			=	PRIME2G_ARCHIVE . $fileName . '.php';

			if ( file_exists( $childfile_slug ) ) { require $childfile_slug; }
			elseif( file_exists( $parentfile_slug ) ) { require $parentfile_slug; }

			elseif ( file_exists( $childfile ) ) { require $childfile; }
			elseif( file_exists( $parentfile ) ) { require $parentfile; }

			else{ require PRIME2G_ARCHIVE . 'post.php'; }
		}
	}
	else {
		/**
		 *	See if query has post format
		 */
		$the_format	=	get_post_format();
		$extension	=	$the_format ? '_' . $the_format : null;
		/**
		 *	Run Template for Singular Queries
		 */
		$childfile	=	CHILD2G_SINGULAR . get_post_type() . $extension . '.php';
		$parentfile	=	PRIME2G_SINGULAR . get_post_type() . $extension . '.php';

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

