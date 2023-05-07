<?php defined( 'ABSPATH' ) || exit;

/**
 *	DETERMINE TEMPLATE FILE TO RUN
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 *	Separated from helpers.php @includes: @since ToongeePrime Theme 1.0.47
 *
 **
 *	This function is so that there doesn't have to be a long list of template files
 *	in the theme's root directory as per WP template hierarchy.
 *	Any unattended templates can use WP defaults, eg: author, 404, etc.
 */
function prime2g_get_theme_template( $archive = false ) {

	if ( $archive ) {

	$defaultArch		=	PRIME2G_ARCHIVE . 'post.php';
	$defaultArch_child	=	CHILD2G_ARCHIVE . 'post.php';
	$obj	=	get_queried_object();

		if ( is_category() || is_tag() || is_tax() ) {

		# *Template filename format: taxonomy_slug.php or taxonomy.php

			$slug	=	'_' . $obj->slug;
			$taxon	=	$obj->taxonomy;
			$taxonomy	=	$taxon ?? null;

			/**
			 *	Run Template for Archive Queries
			 *	Pass template narrowing to Child theme
			 */
			$childfile_slug		=	CHILD2G_ARCHIVE . $taxonomy . $slug . '.php';
			$childfile			=	CHILD2G_ARCHIVE . $taxonomy . '.php';

			if ( file_exists( $childfile_slug ) ) { require $childfile_slug; }

			elseif ( file_exists( $childfile ) ) { require $childfile; }

			elseif ( file_exists( $defaultArch_child ) ) { require $defaultArch_child; }

			else { require $defaultArch; }

		}
		elseif ( is_post_type_archive() ) {

			# *Template filename format: posttypename.php

			$posttypename	=	$obj->name;

			/**
			 *	Run Template for Archive Queries
			 *	Pass template narrowing to Child theme
			 */
			$child_filename		=	CHILD2G_ARCHIVE . $posttypename . '.php';

			if ( file_exists( $child_filename ) ) { require $child_filename; }

			elseif ( file_exists( $defaultArch_child ) ) { require $defaultArch_child; }

			else { require $defaultArch; }

		}
		else {

			if ( file_exists( $defaultArch_child ) ) { require $defaultArch_child; }
			else { require $defaultArch; }

		}
	}
	else {
		/**
		 *	See if query has post format
		 */
		$pType		=	get_post_type();
		$get_format	=	get_post_format();
		$format		=	$get_format ? '_' . $get_format : null;

		/**
		 *	Run Template for Singular Queries
		 *	Pass template narrowing only to Child theme
		 *	Template filename format: post_formatname.php or posttypename.php
		 */
		$childformat	=	CHILD2G_SINGULAR . $pType . $format . '.php';
		$childpType		=	CHILD2G_SINGULAR . $pType . '.php';
		$childDefault	=	CHILD2G_SINGULAR . 'post.php';

		if ( file_exists( $childformat ) ) { require $childformat; }

		elseif ( file_exists( $childpType ) ) { require $childpType; }

		elseif ( file_exists( $childDefault ) ) { require $childDefault; }

		else { require PRIME2G_SINGULAR . 'post.php'; }

	}

}
