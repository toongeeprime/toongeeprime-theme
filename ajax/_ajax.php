<?php defined( 'ABSPATH' ) || exit;
/**
 *	AJAX BASE
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.46
 */
/*
//	Call
@var formData, action:'callbackFunction'
jQuery( document.body ).on( 'click', ()=>{
	prime2g_run_ajax( formData, ajaxSuccess, ajaxError );
} );
*/
add_action( 'wp_head', 'prime2g_ajax_head', 1 );
function prime2g_ajax_head() { ?>
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
// Ajax is already async... gosh!
return new Promise( ( resolve, reject ) => {
resolve( done );
} );
}
</script>
<?php
}
