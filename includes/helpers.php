<?php defined( 'ABSPATH' ) || exit;

/**
 *	HELPER FUNCTIONS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	Use prime2g_removeSidebar() to remove the sidebar from a template
 *	Sidebar is added throughout the theme via footer.php by prime2g_sidebar()
 */
function prime2g_removeSidebar() {
	function define_2gRMVSidebar(){}
}


/**
 *	Use prime2g_remove_title() to remove the title from a template
 */
function prime2g_remove_title() {
	function define_2gRMVTitle(){}
}


/**
 *	Use prime2g_is_plain_page() to declare a template as being plain
 *	Thus, can be used to remove select features, widgets, etc.
 */
function prime2g_is_plain_page() {
	function define_2gPlainPage(){}
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

		# *Filename format must be: taxonomy_slug.php or taxonomy.php

			$obj	=	get_queried_object();
			$slug	=	'_' . $obj->slug;
			$taxonomy	=	$obj->taxonomy;
			$fileName	=	$taxonomy ?? null;

			/**
			 *	Run Template for Archive Queries
			 *	Pass template narrowing to Child theme
			 */
			$childfile_slug		=	CHILD2G_ARCHIVE . $fileName . $slug . '.php';
			$childfile			=	CHILD2G_ARCHIVE . $fileName . '.php';

			if ( file_exists( $childfile_slug ) ) { require $childfile_slug; }

			elseif ( file_exists( $childfile ) ) { require $childfile; }

			else { require PRIME2G_ARCHIVE . 'post.php'; }
		}
		else {

			$childfile		=	CHILD2G_ARCHIVE . 'post.php';
			if ( file_exists( $childfile ) ) { require $childfile; }
			else { require PRIME2G_ARCHIVE . 'post.php'; }

		}
	}
	else {
		/**
		 *	See if query has post format
		 */
		$get_format	=	get_post_format();
		$format		=	$get_format ? '_' . $get_format : null;

		/**
		 *	Run Template for Singular Queries
		 *	Pass template narrowing to Child theme
		 */
		$childformat	=	CHILD2G_SINGULAR . get_post_type() . $format . '.php';
		$childfile		=	CHILD2G_SINGULAR . get_post_type() . '.php';

		if ( file_exists( $childformat ) ) { require $childformat; }

		elseif ( file_exists( $childfile ) ) { require $childfile; }

		else { require PRIME2G_SINGULAR . 'post.php'; }

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

