<?php defined( 'ABSPATH' ) || exit;

/**
 *	HTML SLIDER FRAME SCRIPTS
 *
 *	@since ToongeePrime Theme 1.0.44
 */

/*
 *****	HTML SLIDER FRAME TEMPLATE	*****
<section id="prime2g_posts_slider" class="prime2g_posts_slider">
	<div class="prime2g_slides_wrap prel">
		<div class="prime2g_slides_box prel">

		<!-- put all html blocks within here @ parent class: slidebox -->

		</div>
		<div id="sContrlz"></div>
		<div class="psPrev pslide_pn"><span></span></div>
		<div class="psNext pslide_pn"><span></span></div>
		<div class="prel"><span class="ps_rzmr">Resume</span></div>
	</div>
</section><!-- #prime2g_posts_slider -->
*/


add_shortcode( 'prime2g_slider_css', 'prime2g_auto_html_slider_frame_css' );

function prime2g_auto_html_slider_frame_css() { ?>
<style id="prime2g_html_sliderCSS">
.prime2g_slides_wrap{display:grid;}
.prime2g_posts_slider .media_post{margin:0;}
.prime2g_posts_slider .slidebox{grid-area:1/1;opacity:0;visibility:hidden;position:relative;
min-height:50vh;background-position:center;background-size:cover;}
.prime2g_posts_slider .slidebox.lit{opacity:1;visibility:visible;}
.prime2g_slides_box{display:grid;grid-template-columns:1fr;grid-template-rows:1fr;}
.ps_rzmr{opacity:0;visibility:hidden;cursor:pointer;position:absolute;z-index:+10;top:-40px;right:0;
color:#fff;background:#111;font-size:14px;padding:5px 15px;}
.pause .ps_rzmr{opacity:1;visibility:visible;}

.msCtrlz{display:flex;justify-content:center;z-index:+1;margin-top:0;}
#sContrlz{display:flex;justify-content:center;z-index:+1;margin-top:-40px;background:rgba(0,0,0,0.5);}
.slCtrl{height:15px;width:15px;margin:9px;border-radius:15px;background:#ccc;cursor:pointer;}
.slCtrl:hover{background:#000;}
.slCtrl.lit{background:#f0b417;}

.pslide_pn{position:absolute;bottom:25%;padding:50px 5px;opacity:0;background:rgba(0,0,0,0.5);}
.psNext{right:0;}
.prime2g_slides_wrap:hover .pslide_pn{opacity:1;}
.pslide_pn span{position:relative;font-size:2.5rem;color:#fff;cursor:pointer;z-index:1;}
.pslide_pn span::before{font-family:bootstrap-icons;}
.psPrev span::before{content:"\F284";}
.psNext span::before{content:"\F285";}
</style>
<?php
}



add_shortcode( 'prime2g_slider_js', 'prime2g_auto_html_slider_frame_js_shortcode' );
function prime2g_auto_html_slider_frame_js_shortcode( $atts ) {

/**
 *	Multislider logic added
 *	@since ToongeePrime Theme 1.0.55
 */
$atts	=	shortcode_atts( array( 'timer' => 4000, 'multislides' => '', 'slider_ids' => '' ), $atts );
extract( $atts );

add_action( 'wp_footer', function() use( &$timer, $multislides, $slider_ids ) {
	prime2g_sliders_helper_funcs( $multislides );
	if ( $multislides === 'yes' ) {
		prime2g_multi_instance_slider_js( $slider_ids, $timer );
	} else {
		prime2g_auto_html_slider_frame_js( $timer );
	}
}, 20 );
}


function prime2g_auto_html_slider_frame_js( $timer = 4000 ) { ?>
<script id="prime2g_html_sliderJS">
const wrapr	=	p2getEl( '#prime2g_posts_slider' ),
	slCtrlr	=	p2getEl( '#sContrlz' ),
	i_timer	=	<?php echo $timer; ?>;

let slidez	=	p2getAll( '#prime2g_posts_slider .slidebox' ),
	slNum	=	slidez.length,
	slNumIndex	=	slNum - 1;
	sID		=	1;

ctSpan	=	document.createElement( "span" );
ctSpan.className += "slCtrl";
for ( cs = 0; cs < slNum; cs++ ) {
	slCtrlr.appendChild( ctSpan.cloneNode(true) );
}

let slCtrlz	=	p2getAll( '.slCtrl' );

slidez.forEach( (s)=>{ s.classList.add( 'itm_' + sID++ ); } );
slCtrlz.forEach( (ct)=>{
	let slSID	=	( sID++ ) - slNum,
		tID	=	'itm_' + slSID;
	ct.classList.add( tID );
	prime2g_switch_slide( ct, tID, '', wrapr );
} );

prime2g_reset_slide();

// Run Slider:
const prime2g_runInt	=	setInterval( ()=>{
	if ( ! wrapr.classList.contains( 'pause' ) ) {
		prime2g_htmlslide_prev_next( 'next', slNumIndex );
	}
},
i_timer,
);

// @since ToongeePrime Theme 1.0.49
let sp_prev	=	p2getEl( '.psPrev span' ),
	sp_next	=	p2getEl( '.psNext span' );

if ( sp_prev ) {
	sp_prev.addEventListener( 'click', ()=>{
		if ( ! wrapr.classList.contains( 'pause' ) ) { wrapr.classList.add( 'pause' ); }
		prime2g_htmlslide_prev_next( 'previous', slNumIndex );
	} );
}

if ( sp_next ) {
	sp_next.addEventListener( 'click', ()=>{
		if ( ! wrapr.classList.contains( 'pause' ) ) { wrapr.classList.add( 'pause' ); }
		prime2g_htmlslide_prev_next( 'next', slNumIndex );
	} );
}

p2getAll( '.ps_rzmr' ).forEach( (sp)=>{
	sp.addEventListener( 'click', ()=>{
		wrapr.classList.remove( 'pause' );
	} );
} );
</script>
<?php
}




/**
 *	Separated to be reuseable & upgraded for multi-instance use
 *	@since ToongeePrime Theme 1.0.55
 */
function prime2g_sliders_helper_funcs( $multislides = '' ) {

$slides_n_controls	=	'';
$prev_next_lits		=
"let litSlide	=	p2getEl( '.slidebox.lit' ),
	litCntrl	=	p2getEl( '.slCtrl.lit' ),
	slider_id	=	'';";

if ( $multislides == 'yes' ) {
$slides_n_controls	=
"let slidez	=	p2getAll( sliderID + ' .slidebox' ),
	slCtrlz	=	p2getAll( sliderID + ' .slCtrl' );";
$prev_next_lits	=
"let litSlide	=	p2getEl( sliderID + ' .slidebox.lit' ),
	litCntrl	=	p2getEl( sliderID + ' .slCtrl.lit' ),
	slider_id	=	sliderID;";
}
?>

<script id="prime2g_slider_helpers">
function prime2g_reset_slide( sliderID = '' ) {
<?php echo $slides_n_controls; ?>

	slidez[0].classList.add( 'lit' );
	slCtrlz[0].classList.add( 'lit' );
}

function prime2g_switch_slide( el, id, sliderID = '', wrapr = '' ) {
<?php echo $slides_n_controls; ?>

	el.addEventListener( 'click', ()=>{
	let sibs	=	p2getAll( '.' + id );
		slidez.forEach( (s)=>{ s.classList.remove( 'lit' ); } );
		slCtrlz.forEach( (s)=>{ s.classList.remove( 'lit' ); } );
		sibs.forEach( (sib)=>{ sib.classList.add( 'lit' ); } );
		if ( el.classList.contains( 'lit' ) ) {
			wrapr.classList.add( 'pause' );
		}
	} );
}

function prime2g_htmlslide_prev_next( direction, slNumIndex, sliderID = '' ) {

<?php echo $slides_n_controls; ?>
<?php echo $prev_next_lits; ?>

	litSlide.classList.remove( 'lit' );
	litCntrl.classList.remove( 'lit' );

if ( direction == 'previous' ) {
	prevSlide	=	prime2g_get_sibling( 'previous', litSlide, 'slidebox' );
	prevCntrl	=	prime2g_get_sibling( 'previous', litCntrl, 'slCtrl' );

	if ( prevSlide && prevCntrl ) {
		prevSlide.classList.add( 'lit' );
		prevCntrl.classList.add( 'lit' );
	}
	else {
		slidez[ slNumIndex ].classList.add( 'lit' );
		slCtrlz[ slNumIndex ].classList.add( 'lit' );
	}
}

if ( direction == 'next' ) {
	nxSlide	=	prime2g_get_sibling( 'next', litSlide, 'slidebox' );
	nxCntrl	=	prime2g_get_sibling( 'next', litCntrl, 'slCtrl' );

	if ( nxSlide && nxCntrl ) {
		nxSlide.classList.add( 'lit' );
		nxCntrl.classList.add( 'lit' );
	}
	else { prime2g_reset_slide( slider_id ); }
}

}
</script>
<?php
}



/**
 *	Multislider Capability
 *	@since ToongeePrime Theme 1.0.55
 */
function prime2g_multi_instance_slider_js( $sliderIDs, $timer = 4000 ) { ?>
<script id="prime2g_multi_instance_slider">
const i_timer	=	<?php echo $timer; ?>,
	idsString	=	"<?php echo $sliderIDs; ?>",
	slider_ids	=	idsString.split( /[ ,]+/ );

slider_ids.forEach( id=>{ prime2g_multi_instance_slider( id, i_timer ); } );

function prime2g_multi_instance_slider( sliderID, i_timer ) {
const wrapr	=	p2getEl( sliderID ),
	msCtrr	=	p2getEl( sliderID + ' .msCtrlz' );

let slidez	=	p2getAll( sliderID + ' .slidebox' ),
	slNum	=	slidez.length,
	idName	=	sliderID.replace( '#', '' ),
	slNumIndex	=	slNum - 1;
	sID		=	1;

ctSpan	=	document.createElement( "span" );
ctSpan.className += "slCtrl";
for ( cs = 0; cs < slNum; cs++ ) {
	msCtrr.appendChild( ctSpan.cloneNode(true) );
}

let msCtrz	=	p2getAll( sliderID + ' .slCtrl' );

slidez.forEach( (s)=>{ s.classList.add( 'msl_' + idName + '_' + sID++ ); } );
msCtrz.forEach( (ct)=>{
	let slSID	=	( sID++ ) - slNum,
		tID	=	'msl_' + idName + '_' + slSID;
	ct.classList.add( tID );
	prime2g_switch_slide( ct, tID, sliderID, wrapr );
} );

// Set Initial State
prime2g_reset_slide( sliderID );

// Run Slider
var run_mSlide	=	'runSlide_'+idName;
this.run_mSlide	=	setInterval( ()=>{
	if ( ! wrapr.classList.contains( 'pause' ) ) {
		prime2g_htmlslide_prev_next( 'next', slNumIndex, sliderID );
	}
}, i_timer );

let sp_prev	=	p2getEl( sliderID + ' .psPrev span' ),
	sp_next	=	p2getEl( sliderID + ' .psNext span' );

if ( sp_prev ) {
	sp_prev.onclick	=	()=>{
		if ( ! wrapr.classList.contains( 'pause' ) ) { wrapr.classList.add( 'pause' ); }
		prime2g_htmlslide_prev_next( 'previous', slNumIndex, sliderID );
	};
}

if ( sp_next ) {
	sp_next.onclick	=	()=>{
		if ( ! wrapr.classList.contains( 'pause' ) ) { wrapr.classList.add( 'pause' ); }
		prime2g_htmlslide_prev_next( 'next', slNumIndex, sliderID );
	};
}

p2getAll( sliderID + ' .ps_rzmr' ).forEach( (sp)=>{
	sp.addEventListener( 'click', ()=>{ wrapr.classList.remove( 'pause' ); } );
} );

}
</script>
<?php
}

