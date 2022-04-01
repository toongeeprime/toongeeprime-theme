<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME HOOKS
 *
 *	Use add_action( 'function_name', 'callback' );
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *		Add WP Comment Form
 *
 *	// if( comments_open() || get_comments_number() ) { comments_template(); }
 */
add_action( 'prime2g_after_post', 'comment_form' );



/**
 *	Is set Before the Site's Header
 */
function prime2g_before_header() {

echo '<section id="prime2g_before_header">';
	do_action( 'prime2g_before_header' );
echo '</section>';

}


/**
 *	Is set After the Site's Header
 */
function prime2g_after_header() {

echo '<section id="prime2g_after_header">';
	do_action( 'prime2g_after_header' );
echo '</section>';

}



/**
 *	Is set After Single entry Titles
 */
function prime2g_after_title() {

echo '<section id="prime2g_after_title">';
	do_action( 'prime2g_after_title' );
echo '</section>';

}


/**
 *	Is set Before Single entry
 */
function prime2g_before_post() {

echo '<section id="prime2g_before_post">';
	do_action( 'prime2g_before_post' );
echo '</section>';

}


/**
 *	Is set After Single entry
 */
function prime2g_after_post() {

echo '<section id="prime2g_after_post">';
	do_action( 'prime2g_after_post' );
echo '</section>';

}


/**
 *	Is set Before Archive post title
 */
function prime2g_archive_post_top() {

echo '<section class="archive_post_top metas">';
	do_action( 'prime2g_archive_post_top' );
echo '</section>';

}


/**
 *	Is set at Footer of Archive post entries
 */
function prime2g_archive_post_footer() {

if ( is_attachment() ) return;

echo '<footer class="archive_post_footer metas">';
	do_action( 'prime2g_archive_post_footer' );
echo '</footer>';

}

