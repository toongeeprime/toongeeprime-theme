<?php defined( 'ABSPATH' ) || exit;
/**
 *	TOUCHING WP
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( ! prime_child_min_version( '2.3' ) ) {

add_action( 'admin_notices', function() {
echo '<div class="notice notice-warning notice-alt">
<p style="font-size:125%;">
'. __( 'Hello! *Your Theme needs to be Upgraded. Please contact your website developer soon.', PRIME2G_TEXTDOM ) .'
</p></div>';
} );

}


/**
 *	ADMIN FOOTER
 */
add_filter( 'admin_footer_text', 'prime2g_admin_footer_text' );
function prime2g_admin_footer_text() {
	_e( '<span id="prime2g_footer_credit">Site developed by <a href="https://akawey.com/" target="_blank">Akàwey Online</a> using the <a href="' . esc_url( home_url( '/' ) ) . '" target="_blank">' . esc_html( wp_get_theme() ) . '</a>.</span>', PRIME2G_TEXTDOM );
}


/**
 *	Modifies tag cloud widget arguments to display all tags in the same font size
 *	and use list format for better accessibility
 */
add_filter( 'widget_tag_cloud_args', 'prime2g_widget_tag_cloud_args' );
function prime2g_widget_tag_cloud_args( $args ) {
	$args['largest']	=	1;
	$args['smallest']	=	1;
	$args['unit']		=	'em';
	$args['format']		=	'list';
return $args;
}


/**
 *	STOP WP HEARTBEAT
 *	@since 1.0.49
 */
if ( ! function_exists( 'prime2g_stop_wp_heartbeat' ) ) {

add_action( 'admin_init', 'prime2g_stop_wp_heartbeat', 1 );
add_action( 'admin_enqueue_scripts', 'prime2g_stop_wp_heartbeat' );

function prime2g_stop_wp_heartbeat() {
if ( 'stop' === get_theme_mod( 'prime2g_stop_wp_heartbeat' ) ) {
global $pagenow;
	if ( 'post.php' !== $pagenow && 'post-new.php' !== $pagenow ) {
		wp_deregister_script( 'heartbeat' );
		wp_register_script( 'heartbeat', false );
	}
}
}
}


/**
 *	USE CLASSIC WIDGETS
 *	@WP Classic Widgets plugin
 *	@since 1.0.83
 */
if ( get_theme_mod( 'prime2g_use_classic_widgets' ) ) {
	// Disables the block editor from managing widgets in the Gutenberg plugin.
	add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
	// Disables the block editor from managing widgets.
	add_filter( 'use_widgets_block_editor', '__return_false' );
}


/**
 *	DISABLE WP AUTOP
 *	@since 1.0.51
 */
add_filter( 'the_content', 'prime2g_disable_wpautop', 0 );
function prime2g_disable_wpautop( $content ) {
global $post;
	if ( $post && $post->disable_autop === '1' ) {
		remove_filter( 'the_content', 'wpautop' );
		remove_filter( 'the_excerpt', 'wpautop' );
	}
return $content;
}


/**
 *	Add Shortcode Column To Template Parts Edit screen
 *	@since 1.0.70
 */
add_filter( 'manage_prime_template_parts_posts_columns', 'prime2g_template_parts_posts_cols' );
add_filter( 'manage_prime_template_parts_posts_custom_column', 'prime2g_template_parts_posts_custom_cols', 10, 2 );
function prime2g_template_parts_posts_cols( $cols ) {
$cols	=	[
'cb'	=>	$cols[ 'cb' ],
'title'	=>	__( 'Title', PRIME2G_TEXTDOM ),
'taxonomy-template_parts_section'	=>	__( 'Template Parts Sections', PRIME2G_TEXTDOM ),
'template_part_shortcode'	=>	__( 'Template Part Shortcode', PRIME2G_TEXTDOM ),
];
return $cols;
}

function prime2g_template_parts_posts_custom_cols( $col, $post_id ) {
if ( 'template_part_shortcode' === $col ) {
	echo '<div id="scid_'. $post_id .'" class="scids p2gClipCopyThis">[prime_insert_template_part id="'. $post_id .'"]</div>';
	// echo '<input type="text" readonly id="scid_'. $post_id .'" class="scids p2gClipCopyThis" value="[prime_insert_template_part id=\''. $post_id .'\']" />';
}
Prime2gJSBits::copy_to_clipboard(true);
}


/**
 *	REDIRECTIONS
 *	@since 1.0.73
 */
add_action( 'admin_init', 'prime2g_admin_access_control', 100 );
function prime2g_admin_access_control() {

#	run for non-admins/super-admins only
if ( is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) && ! current_user_can( 'update_core' ) ) {

$capability	=	'custom_capability' === get_theme_mod( 'prime2g_admin_access_capability' ) ?
get_theme_mod( 'prime2g_admin_access_custom_capability' ) : get_theme_mod( 'prime2g_admin_access_capability' );

if ( ! empty( $capability ) && ! current_user_can( $capability ) ) {
$wp_get_referer	=	wp_get_referer();
$login_page	=	Prime2gLoginPage::get_instance();

	if ( $wp_get_referer && prime_strip_url_end( $wp_get_referer ) !== $login_page->new_login_slug() ) {
		#	if referer is an admin page
		if ( str_contains( $wp_get_referer, 'wp-admin' ) ) {
			wp_safe_redirect( site_url( '404' ) );
		}
		else { wp_safe_redirect( $wp_get_referer ); }
	}
	else { wp_safe_redirect( site_url( '/' ) ); }
exit;
}

}
}


/**
 *	Front-end Admin Bar
 */
add_filter( 'show_admin_bar', 'akawey_remove_admin_bar' );
function akawey_remove_admin_bar( $show_admin_bar ) {
$has_access	=	get_theme_mod( 'prime2g_admin_bar_access', 'edit_posts' );
return ! empty( $has_access ) && current_user_can( $has_access ) ? true : false;
}


/*
add_filter( 'use_block_editor_for_post_type', '__return_false' );
*/

/**
 *	@since 1.0.85
 *
 *	Hardcoded: Edit Theme's Template Parts only at Block Editor
 */
add_action( 'admin_init', function() {
if ( ! class_exists( 'Classic_Editor' ) ||
	! isset( $_GET[ 'action' ], $_GET[ 'post' ] ) || $_GET[ 'action' ] !== 'edit' ) return;

$post	=	get_post( $_GET[ 'post' ] );
if ( $post->post_type !== 'prime_template_parts' ) return;

if ( 'classic-editor' !== get_post_meta( $_GET[ 'post' ], 'classic-editor-remember' )[0] ) return;

$edit_link	=	prime2g_get_current_url();

if ( isset( $_GET[ 'classic-editor' ] ) ) {
	$edit_link	=	str_replace( [ '&classic-editor__forget', 'classic-editor' ], '', $edit_link );
	$edit_link	=	$edit_link . '&classic-editor__forget';
}

update_post_meta( $post->ID, 'classic-editor-remember', 'block-editor' );
wp_safe_redirect( $edit_link );
exit;
} );


/**
 *	Hardcoded: Remove linking to Classic editor for Theme Template Parts @ edit.php
 */
add_action( 'admin_footer', function() {
if ( ! class_exists( 'Classic_Editor' ) ) return;
global $pagenow;

if ( $pagenow === 'edit.php' && isset( $_GET[ 'post_type' ] ) && $_GET[ 'post_type' ] === 'prime_template_parts' ) {
echo	'<script id="prime_remove_classic_edit_link">
document.querySelectorAll( "a.row-title" ).forEach( a => {
	initLink	=	a.href;
	a.href		=	initLink.replace( "&classic-editor", "" );
} );

document.querySelectorAll( "[class=\"1\"]" ).forEach( s => { s.remove(); } );
</script>';
}
}, 999 );


