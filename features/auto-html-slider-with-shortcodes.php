<?php defined( 'ABSPATH' ) || exit;

/**
 *	HTML SLIDER FRAME SCRIPTS
 *
 *	@since ToongeePrime Theme 1.0.44.00
 */

/*
 *****	HTML SLIDER FRAME TEMPLATE	*****
<section id="prime2g_posts_slider" class="prime2g_posts_slider">
	<div class="prime2g_slides_wrap">
		<div class="prime2g_slides_box prel">

		<!-- put all html blocks within here @ parent class: slidebox -->

		</div>
		<div id="sContrlz"></div>
		<div class="prel"><span class="ps_rzmr">Resume</span></div>
	</div>
</section><!-- #prime2g_posts_slider -->
 */


add_shortcode( 'prime2g_slider_css', 'prime2g_auto_html_slider_frame_css_shortcode' );
function prime2g_auto_html_slider_frame_css_shortcode() {
add_action( 'wp_footer', 'prime2g_auto_html_slider_frame_css' );
}

function prime2g_auto_html_slider_frame_css() { ?>
<style id="prime2g_html_sliderCSS">
.prime2g_slides_wrap{display:grid;}
.prime2g_posts_slider .media_post{margin:0;}
.prime2g_posts_slider .slidebox{grid-area:1/1;opacity:0;visibility:hidden;position:relative;
min-height:50vh;background-position:center;background-size:cover;}
.prime2g_posts_slider .slidebox.lit{opacity:1;visibility:visible;}
.prime2g_slides_box{display:grid;grid-template-columns:1fr;grid-template-rows:1fr;}
.ps_rzmr{opacity:0;visibility:hidden;cursor:pointer;position:absolute;z-index:+10;top:-50px;right:0;
color:#fff;background:#111;font-size:12px;padding:5px 10px;}
.pause .ps_rzmr{opacity:1;visibility:visible;}

#sContrlz{display:flex;justify-content:center;z-index:+1;margin-top:-40px;background:rgba(0,0,0,0.5);}
.slCtrl{height:15px;width:15px;margin:9px;border-radius:15px;background:#ccc;cursor:pointer;}
.slCtrl:hover{background:#000;}
.slCtrl.lit{background:#f0b417;}
</style>
<?php
}



add_shortcode( 'prime2g_slider_js', 'prime2g_auto_html_slider_frame_js_shortcode' );
function prime2g_auto_html_slider_frame_js_shortcode( $atts ) {
$atts	=	shortcode_atts( array( 'timer'	=>	4000 ), $atts );
extract( $atts );

add_action( 'wp_footer', function() use( &$timer ) { prime2g_auto_html_slider_frame_js( $timer ); }, 20 );
}


function prime2g_auto_html_slider_frame_js( $timer = 4000 ) { ?>
<script id="prime2g_html_sliderJS">
const wrapr	=	document.getElementById( 'prime2g_posts_slider' ),
	slCtrlr	=	document.getElementById( 'sContrlz' ),
	i_timer	=	<?php echo $timer; ?>;

let slidez	=	document.querySelectorAll( '.prime2g_posts_slider .slidebox' ),
	slNum	=	slidez.length,
	sID		=	1;

ctSpan	=	document.createElement( "span" );
ctSpan.className += "slCtrl";
for( cs = 0; cs < slNum; cs++ ) {
slCtrlr.appendChild( ctSpan.cloneNode(true) );
}

let slCtrlz	=	document.querySelectorAll( '.slCtrl' );

slidez.forEach( (s)=>{ s.classList.add( 'itm_' + sID++ ); } );
slCtrlz.forEach( (ct)=>{
	let slSID	=	( sID++ ) - slNum, tID	=	'itm_' + slSID;
	ct.classList.add( tID );
	prime2g_switch_slide( ct, tID );
} );

prime2g_reset_slide();
function prime2g_reset_slide() { slidez[0].classList.add( 'lit' ); slCtrlz[0].classList.add( 'lit' ); }

// Auto-run Slider
function prime2g_run_slides( arr ) {
	arr.forEach( (ss)=>{
		let sNxt	=	ss.nextElementSibling;
		if ( sNxt && ( sNxt.classList.contains( 'slidebox' ) || sNxt.classList.contains( 'slCtrl' ) ) ) {
			sNxt.classList.add( 'lit' );
			ss.classList.remove( 'lit' );
		}
		else {
			ss.classList.remove( 'lit' );
			prime2g_reset_slide();
		}
	} );
}

function prime2g_remv_resume() {
	slidez.forEach( (as)=>{ as.classList.remove( 'resume' ); } );
	slCtrlz.forEach( (as)=>{ as.classList.remove( 'resume' ); } );
}

const prime2g_runInt	=	setInterval(
()=>{
	if ( ! wrapr.classList.contains( 'pause' ) ) {
		prime2g_run_slides( document.querySelectorAll( '#prime2g_posts_slider .lit' ) );
		prime2g_remv_resume();
	}
},
i_timer,
);

function prime2g_switch_slide( el, id ) {
	el.addEventListener( 'click',
	()=>{
	let sibs	=	document.querySelectorAll( '.' + id );
		slidez.forEach( (s)=>{ s.classList.remove( 'lit', 'resume' ); } );
		slCtrlz.forEach( (s)=>{ s.classList.remove( 'lit', 'resume' ); } );
		sibs.forEach( (sib)=>{ sib.classList.add( 'lit', 'resume' ); } );
		if ( el.classList.contains( 'lit' ) ) {
			wrapr.classList.add( 'pause' );
		}
	} );
}

document.querySelectorAll( '.ps_rzmr' ).forEach( (sp)=>{
	sp.addEventListener( 'click', ()=>{
		wrapr.classList.remove( 'pause' );
	});
});
</script>
<?php
}


