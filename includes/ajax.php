<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME'S AJAX BASE
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.46.00
 */

add_action( 'wp_head', 'prime2g_ajax_head', 3 );
function prime2g_ajax_head() { ?>
<script type="text/javascript" id="prime2g_ajax_base">
const prime2g_ajaxurl	=	"<?php echo admin_url( 'admin-ajax.php' ); ?>";

function prime2g_run_ajax( formData, ajaxSuccess, ajaxError = '' ) {
	jQuery.ajax( {
		url: prime2g_ajaxurl,
		type: 'POST',
		data: formData,
		success: ajaxSuccess,
		error: ajaxError,
	} );
}

/*
// Calling Sample:
In var formData, action: 'callbackFunction'
jQuery( document.body ).on( 'click', function() {
	prime2g_run_ajax( formData, ajaxSuccess, ajaxError );
} );
*/

</script>
<?php
}



