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
$page	=	new WP_Query( [ 'page_id' => $pageID ] );

if ( $page->have_posts() ) {
	$page->the_post();

if ( get_post_meta( get_the_ID(), 'remove_sidebar', true ) === 'remove' ) {
	echo '<style>#content{grid-template-columns:1fr;}</style>';
	prime2g_removeSidebar();
}

	prime2g_before_post();

	the_content();

}
else {
	'<h1>' . _e( 'Not Found', PRIME2G_TEXTDOM ) . '!</h1>';
	if ( current_user_can( 'edit_theme_options' ) ) {
		esc_html_e( 'No page set for custom 404 error page!', PRIME2G_TEXTDOM );
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

