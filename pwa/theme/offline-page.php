<?php defined( 'ABSPATH' ) || exit;

if ( function_exists( 'pwa_offline_page_maker_override' ) ) {
	pwa_offline_page_maker_override(); exit;
}

prime2g_removeSidebar();

$get	=	isset( $_GET[ PRIME2G_PWA_SLUG ] ) ? $_GET[ PRIME2G_PWA_SLUG ] : '';

$headline	=	'You are Offline!';
$maintext	=	'Check your connection and try again';

if ( $get === 'error' ) {
	$headline	=	'Error!';
	$maintext	=	'There\'s an error with your request';
}

if ( $get === 'notcached' ) {
	$headline	=	'Not Available!';
	$maintext	=	'Your request is not available - you may have to download it afresh';
}



add_filter( 'get_the_archive_title', function() use( $headline ) {
	return __( $headline, PRIME2G_TEXTDOM );
} );


get_header();

echo	'<div class="centered">';
echo	'<h2>'. __( $maintext, PRIME2G_TEXTDOM ) .'</h2>';


if ( $get === 'notcached' ) {
	echo	'<button id="reloadPage">Download This Page Now</button>';
}
else {
	echo	'<button id="reloadPage">Reload Now</button>';
}


echo	'</div>';


if ( $get === 'notcached' ) {
	// Untested/unfinished
	echo '<script id="getFromNetwork">'. Prime2g_PWA_Scripts::getPageFromNetwork( '#reloadPage' ) .'</script>';
}
else {
	echo '<script id="checkAndReload">'. Prime2g_PWA_Scripts::checkAndReload( '#reloadPage' ) .'</script>';
}


get_footer();

exit;
