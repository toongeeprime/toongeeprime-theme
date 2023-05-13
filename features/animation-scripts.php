<?php defined( 'ABSPATH' ) || exit;

/**
 *	VIEWPORT ENTRY OBSERVER FOR ANIMATIONS
 *
 *	@since ToongeePrime Theme 1.0.44
 *	Added inAction class @since ToongeePrime Theme 1.0.50 for custom animations
 */

/**
 *	Use Shortcode to add scripts
 */

add_shortcode( 'prime2g_animation_script', 'prime2g_animations_observer_shortcode' );
function prime2g_animations_observer_shortcode( $atts ) {
$atts	=	shortcode_atts(
array( 'threshold'	=>	0.25, 'use' => '' ),
$atts );
extract( $atts );

add_action( 'wp_footer', function() use( $threshold, $use ) {
	if ( $use == 'jquery' ) {
		echo '<script id="prime2g_element_observerJQ">prime2g_element_observerJQ();';
		echo prime2g_element_observerJQuery( $threshold );
		echo '</script>';
	}
	else {
		prime2g_element_observerJS( $threshold );
	}
}, 100 );
}



function prime2g_element_observerJS( $threshold = 0.25 ) { ?>
<script id="prime2g_animations_observer">
//	Theme's CSS Animation classes
let inUps	=	p2getAll( '.inUp' ),
	inDwns	=	p2getAll( '.inDown' ),
	inLfts	=	p2getAll( '.inLeft' ),
	inRgts	=	p2getAll( '.inRight' ),
	inActs	=	p2getAll( '.inAction' );

let observerOptions = {
	root: null,
	rootMargin: '0px',
	threshold: <?php echo $threshold; ?>
}

let allAnimElems	=	[ inUps, inDwns, inLfts, inRgts, inActs ];

run_prime_animations( allAnimElems );

function run_prime_animations( allAnimElems ) {

allAnimElems.forEach( ( animEls )=>{
if ( ! animEls ) return;

let prime2g_entryObserver	=	new IntersectionObserver( enterClassElements, observerOptions );

if ( animEls ) {
	animEls.forEach( ( itm )=>{
		prime2g_entryObserver.observe( itm );
	} );
}

function enterClassElements( animEls, prime2g_entryObserver ) {
	animEls.forEach( ( itm )=>{
		if ( itm.isIntersecting ) {
			let elmt = itm.target;
			elmt.classList.add( "enter" );
			prime2g_entryObserver.unobserve( elmt );
		}
	} );
}
} );

}
</script>
<?php
}



/**
 *	USING JQUERY
 *	NOT wrapped in <script> tags
 *	@since ToongeePrime Theme 1.0.46
 */
function prime2g_element_observerJQuery( $threshold = 0.25 ) {
$jq	=	'
function prime2g_element_observerJQ() {
	let jqObserverOptions = {
		root: null,
		rootMargin: \'0px\',
		threshold: ';
	$jq	.=	$threshold;
	$jq	.=	'};

	jqAllAnimElms	=	\'.inUp, .inDown, .inLeft, .inRight, .inAction\';

	const entries	=	Object.values( jQuery( jqAllAnimElms ).get() );
	let jqEntryObserver	=	new IntersectionObserver( onIntersection, jqObserverOptions );

	entries.forEach( ( el )=> { if ( ! el ) return; jqEntryObserver.observe( el ); } );

	function onIntersection( entries ) {
		entries.forEach( entry => {
			elTgt	=	entry.target;
			if ( entry.isIntersecting ) {
				elTgt.classList.add( \'enter\' );
				if ( ! elTgt.classList.contains( \'repeat\' ) )
					jqEntryObserver.unobserve( elTgt );
			}
			else {
				if ( elTgt.classList.contains( \'repeat\' ) )
					elTgt.classList.remove( \'enter\' );
			}
		} );
	}
}';

return $jq;
}



