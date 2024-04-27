<?php defined( 'ABSPATH' ) || exit;

/**
 *	CAROUSEL
 *	Supports multiple instances
 *	Autoplay only works with the first carousel for now
 *	@since ToongeePrime Theme 1.0.82
 */


/**
	HTML Structure:
<div class="carousel_wrap">
<div class="in_carousel">

<div class="screen prel">
<div class="carousel p-abso">

	<!-- Carousel Contents -->
	<div class="cell"></div>

</div>
</div>

<div class="carousel_controls centered">
	<div class="dots"></div>
	<div class="prev_next">
		<button class="prev_btn">Previous</button>
		<button class="next_btn">Next</button>
	</div>
</div>

<button id="car1Togglr" onclick="p2g_toggle_carouselplay('#car1Togglr')">
<span class="pause">PAUSE</span>
<span class="play">PLAY</span>
</button>

</div><!-- .in_carousel -->
</div>
*/


add_shortcode( 'prime_activate_carousel', 'prime_activate_carousel' );
function prime_activate_carousel( $atts ) {
$atts	=	shortcode_atts( [ 'css' => 'yes', 'autoplay' => '1', 'interval' => '4' ], $atts );
extract( $atts );

if ( $css === 'yes' ) { ?>
<style id="primeCarouselCSS">
.carousel_wrap{opacity:0;}
.screen{overflow:hidden;position:relative;width:250px;height:200px;max-width:100%;margin:auto;perspective:5000px;}
.carousel{width:100%;height:100%;position:absolute;transform-style:preserve-3d;transition:transform 1s;}
.cell{position:absolute;left:0;right:0;top:0;height:100%;background:#aaa;backface-visibility:hidden;
transition:transform 1s, opacity 1s;background-size:cover;background-position:center;}
.c_dot{display:inline-block;width:10px;height:10px;border:2px solid;background:#fff;cursor:pointer;margin:7px;}
.c_dot.on,.c_dot:hover{background:#333;}
.carousel_wrap:not(.play) .pause,.carousel_wrap.play .play{display:none;}

@media(min-width:681px){
.screen{width:480px;height:350px;}
}
@media(min-width:821px){
.screen{width:800px;}
}
@media(min-width:1201px){
.screen{width:1000px;height:400px;}
}
</style>
<?php
}


add_action( 'wp_footer', function() use( $autoplay, $interval ) { ?>
<script id="primeCarouselJS">
const carousels	=	p2getAll( '.carousel_wrap' );

carousels.forEach( ( wrap, i )=>{
setTimeout( ()=>{ wrap.style.opacity = '1'; }, 1000 );
options	=	p2g_prepare_carousel( wrap, i );

//	Maintain sequence:
p2g_set_carousel_dots( options );
p2g_set_carousel_cells( options );
p2g_rotate_carousel( options );
p2g_carousel_keyUp( options );
p2g_carousel_prevNext( options );
} );



function p2g_prepare_carousel( wrap, i ) {
el_num	=	i+1;
wrap.id	=	'carousel_wrap_'+el_num;	// set id
wrapID	=	'#' + wrap.id;
wrapper	=	p2getEl( wrapID );

carousel	=	wrap.querySelector( '.carousel' );
carousel.id	=	'carousel_'+el_num;
cells		=	carousel.querySelectorAll( '.cell' );
initCells	=	cells;

init	=	0;
ii		=	i;
if ( i > 0 ) { init++; ii	=	1-init; }

if ( cells.length < 8 ) {
NodeList.prototype.forEach = Array.prototype.forEach;
children	=	carousel.childNodes;
children.forEach( c => {
cln	=	c.cloneNode( true );
carousel.appendChild( cln );
} );

cells	=	carousel.querySelectorAll( '.cell' );
}

cellCount	=	cells.length;
width		=	carousel.offsetWidth;

return	{
'wrapper':	wrapper,
'carousel':	carousel,
'cells':	cells,
'count':	cellCount,
'theta':	360 / cellCount,
'width':	width,
'index':	ii,
'initCells':	initCells,
'radius':	Math.round( ( width / 2 ) / Math.tan( Math.PI / cellCount ) )
};
}



function p2g_set_carousel_dots( options ) {
cellCount	=	options.count;
wrapper	=	options.wrapper;
dots	=	wrapper.querySelector( '.dots' );
dot		=	document.createElement( 'span' );
dot.classList.add( 'c_dot' );
options.initCells.forEach( ( cc, id )=>{ dots.appendChild( dot.cloneNode( true ) ); } );

wrapper.querySelector( '.c_dot' ).classList.add( 'on' );

newDots	=	wrapper.querySelectorAll( '.c_dot' );
newDots.forEach( ( d, i )=>{
cellNo	=	i+1;
cellClass	=	'cell_'+cellNo;
d.classList.add( cellClass );

d.addEventListener( 'click', ()=>{
	wrapper.classList.remove( 'play' );
	options.index	=	i;
	p2g_rotate_carousel( options );
} );
} );
}



function p2g_manage_carousel_classes( options ) {
slot	=	options.index;
cells	=	options.cells;
wrapper	=	options.wrapper;
cellCount	=	options.count;

remSlot	=	slot%cellCount;
absSlot	=	Math.abs( remSlot );
cellSlot=	absSlot;
if ( 0 > remSlot ) {
	cellSlot	=	Math.abs( cellCount-cellSlot );
}
cellNum	=	cellSlot+1;

cells.forEach( ( c, i ) => {
cellNo	=	'cell_'+(i+1);
c.classList.add( cellNo );
c.classList.remove( 'view' );
} );

wrapper.classList.forEach( c => { if ( c.includes( 'cell_' ) ) { wrapper.classList.remove( c ); } } );
dots	=	wrapper.querySelectorAll( '.c_dot' );
dots.forEach( o => { o.classList.remove( 'on' ); } );

wrapper.classList.add( 'cell_' + cellNum );
wrapper.dataset.cellNumber	=	cellNum;
cells[cellSlot].classList.add( 'view' );

dotsNum	=	dots.length;
dotSlot	=	cellSlot%dotsNum;
dots[dotSlot].classList.add( 'on' );
}



function p2g_rotate_carousel( options ) {
p2g_manage_carousel_classes( options );

slot	=	options.index;
radius	=	options.radius;

angleY	=	options.theta * slot * -1;
options.carousel.style.transform	=	'translateZ(' + -radius + 'px) ' + 'rotateY(' + angleY + 'deg)';
}


function p2g_carousel_prevNext( options ) {
wrapper	=	options.wrapper;
wrapper.querySelector( '.prev_btn' ).addEventListener( 'click', ()=>{
	wrapper.classList.remove( 'play' );
	options.index--;
	p2g_rotate_carousel( options );
});
wrapper.querySelector( '.next_btn' ).addEventListener( 'click', ()=>{
	wrapper.classList.remove( 'play' );
	options.index++;
	p2g_rotate_carousel( options );
});
}


function p2g_set_carousel_cells( options ) {
cellCount	=	options.count;
theta		=	options.theta;

options.wrapper.dataset.cellNumber	=	'1';

for ( i = 0; i < cellCount; i++ ) {
	cell	=	options.cells[i];
	cellAngle	=	theta * i;
	cell.style.transform=	'rotateY(' + cellAngle + 'deg) translateZ(' + options.radius + 'px)';
}
}


function p2g_carousel_keyUp( options ) {
wrapper	=	options.wrapper;

document.addEventListener( 'keydown', (e)=>{
if ( e.defaultPrevented ) return;
let key	=	e.key || e.keyCode;
if ( prime2g_inViewport( options.carousel ) ) {
	if ( [ ' ', 'Space', 32 ].includes( key ) && e.target === document.body ) {
		e.preventDefault();
		wrapper.classList.toggle( 'play' );
	}
}
} );

document.addEventListener( 'keyup', (e)=>{
if ( e.defaultPrevented ) return;
let key	=	e.key || e.keyCode;

if ( prime2g_inViewport( options.carousel ) ) {
	if ( [ 'ArrowRight', 'Right', 39 ].includes( key ) ) {
		options.index++;
		wrapper.classList.remove( 'play' ); p2g_rotate_carousel( options );
	}
	if ( [ 'ArrowLeft', 'Left', 37 ].includes( key ) ) {
		options.index--;
		wrapper.classList.remove( 'play' ); p2g_rotate_carousel( options );
	}
}
} );
}


function p2g_toggle_carouselplay( btnID ) {
wrapper	=	p2getEl( btnID ).closest( '.carousel_wrap' );
wrapper.classList.toggle( 'play' );
}


<?php if ( $autoplay === '1' ) {
//	Use a button with onclick="p2g_toggle_carouselplay( btnID )" ?>
p2g_autoplay_carousel_1();

function p2g_autoplay_carousel_1( interval = <?php echo $interval ?> ) {
wrapper		=	carousels[0];
index		=	0;
options		=	p2g_prepare_carousel( wrapper, index );
radius		=	options.radius;
wrapper.classList.add( 'play' );

setInterval( ()=>{
if ( wrapper.classList.contains( 'play' ) ) {
options.index	=	index;
p2g_rotate_carousel( options );
index++;
}
}, interval * 1000 );
}
<?php } ?>

</script>
<?php
} );

}

