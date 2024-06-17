<?php defined( 'ABSPATH' ) || exit;

/**
 *	AJAX BASE
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.46
 */

add_action( 'template_redirect', 'prime2g_ajax_head', 3 );
function prime2g_ajax_head() {
/*	@since 1.0.89 / 96	*/
if ( false === PRIME2G_AJAXING ) return;

add_action( 'wp_enqueue_scripts', function() {
if ( ! wp_script_is( 'prime2g_jQuery' ) ) {
	wp_enqueue_script( 'prime2g_jQuery', get_theme_file_uri( '/files/jquery.min.js' ), [], '3.7.1' );
}
} );

add_action( 'wp_head', function() { ?>
<script id="prime2g_ajax_base">
const prime2g_ajaxurl	=	"<?php echo admin_url( 'admin-ajax.php' ); ?>";

function prime2g_run_ajax( formData, ajaxSuccess, ajaxError = '', reqType = 'POST' ) {
const done	=	jQuery.ajax( {
		url: prime2g_ajaxurl,
		type: reqType,
		data: formData,
		success: ajaxSuccess,
		error: ajaxError,
	} );
// Just learnt ajax is already async... gosh!
return new Promise( ( resolve, reject ) => {
resolve( done );
} );

}
/*
//	Call
@var formData, action:'callbackFunction'
jQuery( document.body ).on( 'click', ()=>{
	prime2g_run_ajax( formData, ajaxSuccess, ajaxError );
} );
*/
</script>
<?php
} );
}

