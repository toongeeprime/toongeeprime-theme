<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME ACTION HOOKS & FILTERS
 *
 *	Use add_action( 'function_name', 'callback' );
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	Add WP Comment Form
 */
add_action( 'prime2g_after_post', 'prime2g_comments' );
function prime2g_comments() {
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}


/**
 *		Add Edit post link to archive entries
 */
add_action( 'prime2g_archive_post_footer', 'prime2g_edit_entry', 5 );



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
function prime2g_sub_header() {
echo '<section id="prime2g_sub_header">';
	do_action( 'prime2g_sub_header' );
echo '</section>';
}


/**
 *	Is set After the Sub Header Section Above
 */
function prime2g_after_header() {
echo '<section id="prime2g_after_header" class="site_width">';
	do_action( 'prime2g_after_header' );
echo '</section>';
}


/**
 *	Is set Before Single entry Titles
 *	@since ToongeePrime Theme 1.0.50
 */
function prime2g_before_title() {
echo '<section id="prime2g_before_title">';
	do_action( 'prime2g_before_title' );
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
$par1 = $par2 = $par3 = '';

echo '<section id="prime2g_before_post">';
	do_action( 'prime2g_before_post', $par1, $par2, $par3 );
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
 *	@since ToongeePrime Theme 1.0.55 direct hooks: prime2g_before_head, prime2g_before_body
 *	And:
 */
function prime2g_after_archive_title() {
echo '<section id="prime2g_after_archive_title">';
	do_action( 'prime2g_after_archive_title' );
echo '</section>';
}


/**
 *	Replaced with prime2g_archive_post_top_filter_part()
 */
function prime2g_archive_post_top() {
echo '<section class="archive_post_top metas">';
	do_action( 'prime2g_archive_post_top' );
echo '</section>';
}


/**
 *	Replaced with prime2g_archive_post_footer_filter_part()
 */
function prime2g_archive_post_footer() {
if ( is_attachment() ) return;

echo '<footer class="archive_post_footer metas">';
	do_action( 'prime2g_archive_post_footer' );
echo '</footer>';
}


/**
 *	Is set Before Footer Credit
 */
function prime2g_site_base_strip() {
echo '<section id="site_base_strip">';
	do_action( 'prime2g_site_base_strip' );
echo '</section>';
}


/**
 *	Set Before post title in Archive
 *	@since ToongeePrime Theme 1.0.45
 *	Added $post ToongeePrime Theme 1.0.50
 */
function prime2g_archive_post_top_filter_part( $post = null ) {
$start	=	'';

$div	=	'<section class="archive_post_top metas">';
$div	.=	apply_filters( 'prime2g_archive_post_top_filter', $start, $post );
$div	.=	'</section>';

return $div;
}


/**
 *	Is set at Footer of Archive post entries
 *	@since ToongeePrime Theme 1.0.45
 */
function prime2g_archive_post_footer_filter_part() {
if ( is_attachment() ) return;

$start	=	'';

$div	=	'<footer class="archive_post_footer metas">';
$div	.=	apply_filters( 'prime2g_archive_post_footer_filter', $start );
$div	.=	'</footer>';

return $div;
}


/**
 *	FUNCTIONS HOOKED TO FILTERS
 *	Filters added and hooked @since ToongeePrime Theme 1.0.45
 */
add_filter( 'prime2g_archive_post_top_filter', 'prime2g_archive_postmeta_hooked', 10, 2 );
add_filter( 'prime2g_archive_post_footer_filter', 'prime2g_edit_entry_get_hooked', 5, 1 );
add_filter( 'prime2g_archive_post_footer_filter', 'prime2g_archive_postbase_hooked', 10 );

function prime2g_archive_postmeta_hooked( $text, $post ) {
	return $text . prime2g_archive_postmeta( $post, false );
}

function prime2g_edit_entry_get_hooked( $text ) {
	return $text . prime2g_edit_entry_get();
}

function prime2g_archive_postbase_hooked( $text ) {
	return $text . prime2g_archive_postbase( false );
}


