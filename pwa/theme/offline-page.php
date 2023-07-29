<?php defined( 'ABSPATH' ) || exit;

if ( function_exists( 'pwa_offline_page_maker_override' ) ) {
	pwa_offline_page_maker_override(); exit;
}

add_filter( 'get_the_archive_title', function() { return 'You are Offline!'; } );

prime2g_removeSidebar();

get_header();

echo '<h2 class="centered">Please check your connection</h2>';

echo '<script id="checkAndReload">'. Prime2g_PWA_Offline_Scripts::checkAndReload() .'</script>';

get_footer();

exit;
