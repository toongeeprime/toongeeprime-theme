<?php defined( 'ABSPATH' ) || exit;

/**
 *	404 ERROR PAGE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( ! get_theme_mod( 'prime2g_use_page_for404' ) && ! function_exists( 'define_2gRMVSidebar' ) ) prime2g_removeSidebar();

get_header();

/**
 *	404 Error Page set @ Customizer
 *	@since ToongeePrime Theme 1.0.55
 */

if ( get_theme_mod( 'prime2g_use_page_for404' ) ) {

$pageID	=	(int) get_theme_mod( 'prime2g_404error_page_id' );
$page	=	prime2g_wp_query( [ 'page_id' => $pageID ], [ 'cacheName' => 'custom_404error_page' ] );

if ( $pageID ) {
if ( $page->have_posts() ) {
	$page->the_post();

$page_id	=	get_the_ID();

if ( get_post_meta( $page_id, 'remove_header', true ) === 'remove' ) {
	echo '<style>#header{display:none!important;}</style>';
}

if ( get_post_meta( $page_id, 'remove_sidebar', true ) === 'remove' ||
in_array( get_theme_mod( 'prime2g_remove_sidebar_in_singular' ), [ 'and_pages', 'pages_only' ] )
) {
	echo '<style>#content{grid-template-columns:1fr;}</style>';
	prime2g_removeSidebar();
}

	prime2g_before_post();

	the_content();

}
}
else {
if ( ! function_exists( 'define_2gRMVSidebar' ) ) prime2g_removeSidebar();
	if ( current_user_can( 'edit_theme_options' ) ) {
		echo '<style>#content{grid-template-columns:1fr;}</style>
		<div class="centered">
		<h1>' . __( 'Custom Error Page Not Set', PRIME2G_TEXTDOM ) . '!</h1>';
		esc_html_e( 'No page is set for custom 404 error page.', PRIME2G_TEXTDOM );
		echo '</div>';
	}
}

}

else {

echo '<section class="nothing_found_div">';

echo '<p class="nothing_found_info">'. esc_html__( 'Maybe try a search?', PRIME2G_TEXTDOM ) . '</p>';

get_search_form();

echo '</section>';


prime2g_below_posts_widgets();

}

get_footer();

