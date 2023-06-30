<?php defined( 'ABSPATH' ) || exit;

/**
 *	MULTI-HTML SLIDER FRAME SCRIPTS
 *
 *	@since ToongeePrime Theme 1.0.51
 */

/*
 *****	MULTI-HTML SLIDER FRAME TEMPLATE	*****
<section class="prime2g_multi_slider mslidernum">
<div class="parameters" data-p2g-columns="4"></div>
	<div class="prime2g_multislides_container">
		<div class="prime2g_multislide_wrap prel">
			<div class="prime2g_mslides_flex prel">

<div class="mSlidebox"><div class="inslide"></div></div><!-- a html block -->

			</div>
		</div>
	</div><!-- .prime2g_multislides_container -->
	<div class="msPrev mslide_pn"><span></span></div>
	<div class="msNext mslide_pn"><span></span></div>
</section><!-- .prime2g_multi_slider -->
*/

add_shortcode( 'prime2g_multislider_css', 'prime2g_multi_html_slider_frame_css' );

function prime2g_multi_html_slider_frame_css() { ?>
<style id="prime2g_multi_sliderCSS">
.prime2g_multislides_container,.inslide{overflow:hidden;position:relative;}
.prime2g_multislides_container{max-width:95vw;}
.prime2g_multi_slider .mSlidebox{min-height:200px;background-position:center;transition:0.5s;}
.prime2g_mslides_flex{display:flex;flex-wrap:nowrap;transform:translateX(0);}
.prime2g_multi_slider .parameters{display:none!important;}
.inslide{width:max-content;min-width:100%;max-width:100%;}

.mslide_pn{position:absolute;top:0;background:rgba(0,0,0,0.5);padding:5px;left:10px;}
.msNext{left:60px;}
.mslide_pn span{position:relative;font-size:2rem;color:#fff;cursor:pointer;z-index:10;line-height:1;}
.mslide_pn span::before{font-family:bootstrap-icons;}
.msPrev span::before{content:"\F284";}
.msNext span::before{content:"\F285";}
</style>
<?php
}




add_shortcode( 'prime2g_multislider_js', 'prime2g_multi_html_slider_frame_js_shortcode' );
function prime2g_multi_html_slider_frame_js_shortcode() {
	add_action( 'wp_footer', function() { prime2g_multi_html_slider_frame_js(); }, 20 );
}


function prime2g_multi_html_slider_frame_js() { ?>
<script id="prime2g_multi_sliderJS">
let allmSliderz	=	p2getAll( '.mslidernum' ),
	allmPrevz	=	p2getAll( '.msPrev' );
	allmNextz	=	p2getAll( '.msNext' );
const sClass	=	'mslide_';
asID = psID = nsID = 1;



// Get number of slider columns
function p2g_mslideCols( slider ) {
sData	=	slider.querySelector( '.parameters' );
dataCol	=	sData.dataset.p2gColumns ? sData.dataset.p2gColumns : null;

return ( dataCol ? dataCol : 4 );
}



// Determine widths of slider wrapper and slides
function p2g_msWidth( slider, wrap = false, tsNum = null ) {
cols	=	p2g_mslideCols( slider );

if ( prime2g_screenIsSmaller( 821 ) && ( dataCol > 3 ) ) { cols = 3; }
if ( prime2g_screenIsSmaller() ) { cols = 2; }

if ( wrap === true ) {

	if ( tsNum <= cols ) {
		ww	=	100;
	} else {
		ww	=	( 100 / cols ) * tsNum;
	}

	return ww + '%';
}

return ( 100 / cols ) + '%';
}


// Identify each slider on a page with a unique class
allmSliderz.forEach(

(s)=>{
	ssID	=	asID++;
	tClass	=	sClass + ssID;

	s.classList.add( tClass );

	tWrap	=	p2getEl( '.' + tClass + ' .prime2g_multislide_wrap' );
	tSlides	=	p2getAll( '.' + tClass + ' .mSlidebox' );
	tsNum	=	tSlides.length;

	// set widths
	tWrap.style.width	=	p2g_msWidth( s, true, tsNum );
	tSlides.forEach( t=>{
		t.style.width		=	p2g_msWidth(s);
		t.style.maxWidth	=	p2g_msWidth(s);
	} );
}

);



// Activate all previous & next buttons per slider
allmPrevz.forEach(
	(p)=>{
		pID		=	psID++;
		pClass	=	sClass + pID;
		p.addEventListener( 'click', function(event) { p2g_multi_prevnext( p, 'left' ); } );
	}
);

allmNextz.forEach(
	(n)=>{
		nID		=	nsID++;
		nClass	=	sClass + nID;
		n.addEventListener( 'click', function(event) { p2g_multi_prevnext( n, 'right' ); } );
	}
);


// slider previous-next function
function p2g_multi_prevnext( div, direction ) {

parentDiv	=	div.parentElement;
slidesFlex	=	parentDiv.querySelector( '.prime2g_mslides_flex' );

firstDiv	=	slidesFlex.firstElementChild;
lastDiv		=	slidesFlex.lastElementChild;

	if ( direction == 'right' ) {
		firstClone	=	firstDiv.cloneNode( true );
		lastDiv.after( firstClone );
		p2g_movemSlide( firstDiv, firstClone );
	}

	if ( direction == 'left' ) {
		lastClone	=	lastDiv.cloneNode( true );
		firstDiv.before( lastClone );
		p2g_movemSlide( lastDiv, lastClone );
	}

}


// Move slide
function p2g_movemSlide( div, cloned ) {
	div.style.width		=	div.style.opacity	=	'0';
	cloned.style.width	=	cloned.style.opacity	=	'0';

	msWidth		=	p2g_msWidth( parentDiv );

	setTimeout( function() { cloned.style.width		=	msWidth; }, 100 );

	setTimeout( function() { cloned.style.opacity	=	'1'; }, 300 );

	setTimeout( function() { div.remove(); }, 500 );
}
</script>
<?php
}

