<?php defined( 'ABSPATH' ) || exit;

/**
 *	ACCORDION FRAME & SCRIPTS
 *
 *	@since ToongeePrime Theme 1.0.55
 */

/*
 *****	ACCORDION FRAME TEMPLATE	*****
<section class="prime2g_accordion_wrap">
<div class="prime2g_accordion_set prel">

<!--- Accordion blocks: --->
<div class="p2g_accordion">
	<header>
		<div class="acc_toggle"></div>
	</header>
	<div class="acc_body">
		<div class="acc_content">
		</div>
	</div>
</div>

</div>
</section><!-- .prime2g_accordion -->
*/


function prime2g_accordion_frames_css() {
echo	'<style id="prime2g_accordion_baseCSS">
.prime2g_accordion_wrap{margin:0 auto var(--min-pad);}
.acc_toggle{cursor:pointer;display:inline-block;}
.acc_content,.p2g_accordion header{padding:10px;}
.acc_body{overflow:hidden;max-height:0;transition:all 0.3s;}
.p2g_accordion.on .acc_body{max-height:500vh;transition:all 1.5s 0.2s;}
</style>';
}



add_shortcode( 'prime2g_set_accordions', 'prime2g_accordion_frame_shortcode_set' );
function prime2g_accordion_frame_shortcode_set( $atts ) {

$atts	=	shortcode_atts( array( 'closeothers' => '', 'open' => '', 'css' => 'yes' ), $atts );
extract( $atts );

if ( $css === 'yes' ) prime2g_accordion_frames_css();
add_action( 'wp_footer', function() use( &$closeothers, $open ) {
	prime2g_accordion_frames_js( $closeothers, $open );
}, 20 );
}



function prime2g_accordion_frames_js( $closeothers, $open ) { ?>
<script id="prime2g_accordion_JS">
const accords	=	p2getAll( '.p2g_accordion' ),
	accToggs	=	p2getAll( '.acc_toggle' ),
	openfirst	=	'<?php echo $open; ?>',	// incomplete >> which to open / simply add class "on"
	closeOthers	=	'<?php echo $closeothers; ?>';

accToggs.forEach( tog =>{
	tog.onclick	=	()=>{
		parent	=	tog.closest( '.p2g_accordion' );
		if ( closeOthers === 'yes' ) {
			if ( ! parent.classList.contains( 'on' ) ) {
			accs	=	parent.closest( '.prime2g_accordion_wrap' ).querySelectorAll( '.p2g_accordion' );
			accs.forEach( acc => { acc.classList.remove( 'on' ); } );
			parent.classList.add( 'on' );
			return; }
		}
		parent.classList.toggle( 'on' );
	}
} );
</script>
<?php
}

