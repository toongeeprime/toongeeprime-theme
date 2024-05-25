<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME FEATURES & CONDITIONAL JS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

add_action( 'wp_footer', 'prime2g_conditional_js', 990 );
function prime2g_conditional_js() {
$styles		=	ToongeePrime_Styles::mods_cache();	// @since 1.0.86

$singular	=	is_singular();
$jsSingular	=	$singular ? 'true' : 'false';

$js	=	'<script async defer id="prime2g_conditional_js">
const	singular	=	'. $jsSingular .';
menuLItems	=	p2getAll( "nav.main-menu li" );
';

if ( $styles->mob_submenu_open === 'click' ) {
$js	.=	'menuLItems?.forEach( li => {
li.addEventListener( "click", (e)=>{
	e.stopPropagation(); li.classList.toggle( "open" );
} );
} );';
}

if ( $styles->mob_submenu_open === 'hover' ) {
$js	.=	'menuLItems?.forEach( li => {
li.addEventListener( "mouseenter", (e)=>{
	e.stopPropagation(); li.classList.add( "open" );
} );
li.addEventListener( "mouseleave", (e)=>{
	e.stopPropagation(); li.classList.remove( "open" );
} );
} );';
}

if ( prime2g_video_features_active() ) {
$js	.=
'let sCodeDivs	=	p2getAll( ".wp-video-shortcode" ),
	sCodeVids	=	p2getAll( "video.wp-video-shortcode" ),
	wpVids	=	p2getAll( ".wp-video" );
if ( sCodeVids ) {
sCodeVids.forEach( vid => { vid.setAttribute( "width", "100%" ); vid.style.width = "100%"; } );
}
if ( sCodeDivs ) { sCodeDivs.forEach( div => { div.style.width = "auto"; } ); }
if ( wpVids ) { wpVids.forEach( wpv => { wpv.style.width = "auto"; } ); }
';
}

if ( '' === $styles->autoplay_header_vid ) {
if ( has_header_video() && is_header_video_active() ) {
$js	.=	'if ( wp?.customHeader ) {
var ww_timer	=	setTimeout( function ww_video() {
if ( wp.customHeader.handlers.youtube.player === null ) {
	ww_timer	=	setTimeout( ww_video, 500 );
} else {
	if ( typeof wp.customHeader.handlers.youtube.player.unMute === "function" ) {
		wp.customHeader.handlers.youtube.player.unMute();
		wp.customHeader.handlers.youtube.player.stopVideo();
	} else {
		ww_timer	=	setTimeout( ww_video, 500 );
	}
}
}, 700 );
}
';
}
}
$js	.=	'</script>';

echo $js;
}



prime2g_conditional_customizer_js();
function prime2g_conditional_customizer_js() {
$scriptName	=	basename( $_SERVER[ 'PHP_SELF' ] );
if ( $scriptName === 'customize.php' ) {
if ( prime2g_design_by_network_home() && get_current_blog_id() !== 1 ) {

$js	=	'<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" id="jQueryCtm"></script>
<script id="prime2g_conditional_customizer_js">
jQuery( document ).ready( function() {';

// concat'ed in case more code would be added

$js	.=	'
setTimeout( ()=>{
let p2gPane	=	jQuery( "#sub-accordion-panel-prime2g_customizer_panel .customize-info" );
p2gPane.append( \'<div style="background:#fff;padding:25px 15px 15px;text-align:center;"><h3>'. __( 'MAIN SITE DESIGNS ARE FROM THE NETWORK HOME', PRIME2G_TEXTDOM ) .'</h3></div>\' );
}, 5000
);
';

$js	.=	'} );
</script>';
echo $js;

}
}
}




/**
 *	@since 1.0.73
 *
 *	Password Toggler, for use with custom login form
 */
if ( ! function_exists( 'prime2g_view_password_toggler' ) ) {
function prime2g_view_password_toggler() {
echo Prime2gJSBits::dom_create_and_insert();

$js	=	'<script id="primeLoginJS">
let loginForm	=	p2getEl( "#custom_login_page_form" ),
	userName	=	p2getEl( "#user_login" ),
	passWd		=	p2getEl( "#user_pass" );

userName.setAttribute( "required", true );
passWd.setAttribute( "required", true );

// Password view toggle
let formHasPW	=	p2getAll( ".form_has_pw_field form" );
if ( formHasPW ) {
pwFormNum	=	formHasPW.length;
for ( fpw = 0; fpw < pwFormNum; fpw++ ) {
	parnt	=	formHasPW[ fpw ].querySelector(".login-password");
	if ( ! parnt ) {
		parnt	=	formHasPW[ fpw ].querySelector(".fld-set.password");
	}
	pwInput	=	parnt.childNodes[1];
	p2g_createNewItem( "span", "pwtogg"+fpw, "pwTogg p-abso", parnt, pwInput );
	pwTogglr	=	\'<span tabindex="1" onclick="p2gtoggpwd( this );"><i class="bi bi-eye"></i><i class="bi bi-eye-slash"></i></span>\';
	p2g_addContentToEl( "#pwtogg"+fpw, "", pwTogglr );
}
function p2gtoggpwd( elmt ) {
	thisParent	=	elmt.parentNode;
	thisParent.classList.toggle( "visible" );
	pInputType	=	thisParent.parentNode.querySelector( "input" );
	if ( pInputType.type === "password" ) {
		pInputType.type = "text";
	} else {
		pInputType.type = "password";
	}
}
}
</script>';
return $js;
}
}



/**
 *	CUSTOM FIELDS
 */
add_action( 'admin_footer', 'prime2g_metabox_javascript' );
function prime2g_metabox_javascript() {
global $pagenow, $typenow;
if ( in_array( $pagenow, [ 'post-new.php', 'post.php' ] ) ) { ?>
<script id="prime2g_metaboxesJS">
let p2gBoxIDs	=	[
'#prime2g_prime_fields1', '#prime2g_postdata_box', '#prime2g_settings_fields', '#prime2g_extras_fields', '#prime2g_media_cfields'
];

p2gBoxIDs.forEach( pb => {
box	=	p2getEl( pb );
if ( box ) { box.classList.add( 'prime2g_postbox' ); }
} );

//	@since 1.0.89
let primeInputs	=	document.querySelectorAll( '.prime2g_field input' );

primeInputs.forEach( i => {
	if ( i.type === 'checkbox' ) {
		i.addEventListener( 'click', ()=>{ i.value === '1' ? i.value = '0' : i.value = 1; } );
	}
} );
</script>
<?php
}
}
/*	@since 1.0.73 End	*/


/**
 *	Placeholder function
 *	@since 1.0.77
 */
if ( ! function_exists( 'prime2g_custom_login_js' ) ) {
function prime2g_custom_login_js() {}
}


/**
 *	Placeholder function
 *	@since 1.0.78
 */
if ( ! function_exists( 'prime2g_mobile_mega_menu_js' ) ) {
function prime2g_mobile_mega_menu_js() {}
}


/**
 *	Set mega menu: echo'ed
 */
if ( ! function_exists( 'prime2g_mega_menu_js' ) ) {
function prime2g_mega_menu_js() {
$styles		=	ToongeePrime_Styles::mods_cache();	#	@since 1.0.78
$menu_width	=	$styles->megamenu_width;

$fullwidth	=	'full_width' === $menu_width ? 'true' : 'false';
$pagewidth	=	'page_width' === $menu_width ? 'true' : 'false';

$js	=	'<script id="prime_mega_menuJS" defer>
const 	fullwidth	=	'. $fullwidth .',
		pagewidth	=	'. $pagewidth .';

if ( fullwidth || pagewidth ) {
const mmLIitems	=	p2getAll( "#megaMenu.desktop .megamenuLi" ),
	pageBody	=	p2getEl( "#container" );

function prime_setMegaMenu() {
setTimeout( ()=>{
	let	pageBounding=	pageBody.getBoundingClientRect(),
	widthOfPage	=	pageBounding.width,
	leftOfPage	=	pageBounding.left;

mmLIitems.forEach( li => {
li_rect	=	li.getBoundingClientRect();
mc		=	li.querySelector( ".ctrlw" );
if ( mc ) {
mc_rect	=	mc.getBoundingClientRect();
	if ( fullwidth ) {
		mc.style.width	=	"98.75vw";
		leftAmount		=	li_rect.left > 0 ? (-1 * li_rect.left) : li_rect.left;
		mc.style.left	=	leftAmount + "px";
	}
	else if ( pagewidth ) {
		mc.style.width	=	widthOfPage + "px";
		mc.style.left	=	(-1 * (li_rect.left - leftOfPage)) + "px";
	}
}
} );
}, 300 );
}

window.onload	=	prime_setMegaMenu;
window.onresize	=	prime_setMegaMenu;
}
</script>';
echo $js;
}
}



/**
 *	LIVE SEARCH: AJAX
 */
if ( ! function_exists( 'prime2g_ajax_search_js' ) ) {
function prime2g_ajax_search_js( array $options = [] ) {

add_action( 'wp_footer', function() use( $options ) {

if ( defined( 'P2GAJAXSEARCHJS' ) ) return;
define( 'P2GAJAXSEARCHJS', true );

$id			=	'';
$post_type	=	'';
$template	=	'';	//	@since 1.0.88

extract( $options );

$js	=	'<script id="prime_livesearchJS'. $id .'">
let fID'. $id .'	=	"'. $id .'",
	idID'. $id .'	=	fID'. $id .' ? "#'. $id .'" : "",
	tForm'. $id .'	=	p2getEl( idID'. $id .' + ".liveSearchFormWrap" ),
	tSBox'. $id .'	=	tForm'. $id .'.querySelector( ".liveSearchBox" ),
	tSRes'. $id .'	=	tForm'. $id .'.querySelector( ".liveSearchResults" ),
	tInput'. $id .'	=	tForm'. $id .'.querySelector( "input" );

p2getAll( ".close_lsearch" ).forEach( c => {
	c.addEventListener( "click", ()=>{ tSBox'. $id .'.classList.add( "hidden", "del" ); } )
} );

var counter	=	[],
	input_time	=	0;

tForm'. $id .'.addEventListener( "mouseleave", ()=>{
if ( tSBox'. $id .'.classList.contains( "del" ) ) return;
setTimeout( ()=>{
if ( ! tSRes'. $id .'.matches( ":hover" ) ) {
	tSRes'. $id .'.innerHTML	=	"";
	tSBox'. $id .'.classList.add( "hidden" );
}
}, 3000 );
} );

function prime_runAjaxSearch( e ) {

/**
 *	Keys to ignore
 *	" " === spacebar
 */
if ( e.type === "input" ) {
	// if ( [ " " ].includes( e.data ) ) return;
}
else {
	if ( [ "Tab", "CapsLock", "Shift", "Control", "Alt", "ArrowUp", "ArrowDown",
	"ArrowLeft", "ArrowRight", "PageDown", "PageUp" ].includes( e.key ) ) return;
}


/**
 *	Control execution
 */
function p2gajmsO() { tSBox'. $id .'.classList.remove( "hidden", "del" ) }

var	tValue'. $id .'	=	tInput'. $id .'.value;

if ( ! tValue'. $id .' || tValue'. $id .' == " " ) {
	tSRes'. $id .'.innerHTML	=	"";
	tSBox'. $id .'.classList.add( "hidden" );
return;
}


/**
 *	Control input speed
 */
let now	=	e.timeStamp;
counter.push( now );
all_inputs	=	counter;
last_input	=	counter.slice(-1);
counter		=	counter.slice(-2);	// get last two events to compare timeStamps
var input_time	=	last_input[0] - all_inputs[0],
	keytime	=	counter[1] - counter[0];

if ( input_time && tValue'. $id .'.length < 3 ) {
p2gajmsO();
	tSRes'. $id .'.innerHTML	=	"<p class=\"centered\"><small>'. __( '3 characters', PRIME2G_TEXTDOM ) .'</small></p>";
return;
}

if ( input_time > 1000 ) input_time = 0;

if ( keytime < 150 ) {
p2gajmsO();
	tSRes'. $id .'.innerHTML	=	"<p class=\"centered\"><small>'. __( 'Slow down a little', PRIME2G_TEXTDOM ) .'</small></p>";
return;
}

if ( input_time < 500 && keytime < 200 ) return;


/**
 *	Execute
 */
setTimeout( ()=>{
if ( tValue'. $id .'.length > 2 ) {

tSBox'. $id .'.classList.remove( "hidden", "del" );
tSRes'. $id .'.innerHTML	=	"<p class=\"centered\">'. __( 'Searching...', PRIME2G_TEXTDOM ) .'</p>";

formData	=	{
	action : "prime2g_doing_ajax_nopriv",
	"prime_do_ajax" : "ajax_search",
	"find" : tInput'. $id .'.value,
	"post_type" : "'. $post_type .'",
	"count" : "10",
	"template" : "'. $template .'",
	"template_args" : '. json_encode( [ 'size' => 'thumbnail', 'tag' => 'span', 'footer' => null ] ) .',
	"_prime-nonce" : "'. wp_create_nonce( 'prime_nonce_action' ) .'"
};
ajaxSuccess	=	function( response ) {
	if ( response && ! response.hasOwnProperty( "error" ) ) {
		tSRes'. $id .'.innerHTML	=	response.posts;
	}
	else {
		console.log( "Search Response Failed: " + JSON.stringify( response ) );
	}
}
ajaxError	=	function( response ) {
	console.log( "Server Error: " + response.statusText + " status: " + response.status + " - Error Info: " + JSON.stringify( response ) );
}

return prime2g_run_ajax( formData, ajaxSuccess, ajaxError );
}
}, 500 );

}

tInput'. $id .'.addEventListener( "input", ( e )=>{ prime_runAjaxSearch( e ); } );
</script>';
echo $js;

} );

}
}
/**	@since 1.0.78 End	**/


/**
 *	@since 1.0.80
 */
if ( ! function_exists( 'prime2g_media_gallery_js' ) ) {
function prime2g_media_gallery_js( string $init_hide = 'false' ) {
$js	=	'<script id="prime2g_gallery_js">
let mgWrap	=	p2getEl( ".p2_media_gallery_wrap" ),
	gPrevThumbs	=	p2getAll( ".preview_thumb" ),
	gGalThumbs	=	p2getAll( ".gallery_thumb" ),
	itemsNum	=	gGalThumbs.length;


/**
 *	Set Gallery Width
 */
p2g_mGalleryWidth();
window.onresize	=	p2g_mGalleryWidth;

function p2g_mGalleryWidth() {
let	pGallery	=	p2getEl( ".gallery_box" ),
	pgalParent	=	pGallery.parentElement,
	parentWidth	=	pgalParent.getBoundingClientRect().width;
pGallery.style.maxWidth	=	parentWidth + "px";
pGallery.style.width	=	"max-content";
}


p2getEl( "#allNum" ).innerText	=	itemsNum;
[ ".preview_thumb", ".gallery_media", ".gallery_thumb" ].forEach( g=>{ p2getEl( g ).classList.add( "live" ); } );

gGalThumbs.forEach( ( val, i )=>{
	val.addEventListener( "click", ()=>{ doGalleryItems( i + 1 ); } );
} );
gPrevThumbs.forEach( ( val, i )=>{
	val.addEventListener( "click", ()=>{ doGalleryItems( i + 1 ); p2DoGallery( "on" ); } );
} );


function doGalleryItems( index ) {
	p2getAll( ".gItem" ).forEach( gi => { gi.classList.remove( "live" ); } );
	p2getEl( "#elNum" ).innerText	=	index;
	p2GallThumbScroll( index );
	p2getAll( ".item_" + index ).forEach( ci => { ci.classList.add( "live" ); } );
}


//	class to show/hide main gallery media screen
function p2DoGallery( toDo ) {
	if ( toDo === "on" ) return mgWrap.classList.remove( "g_hide" );
	if ( toDo === "off" ) return mgWrap.classList.add( "g_hide" );
}

function p2GalleryOff() {
	p2getAll( ".gItem" ).forEach( gi => { gi.classList.remove( "live" ); } ); p2DoGallery( "off" );
}

document.addEventListener( "keyup", function( e ) {
if ( e.defaultPrevented ) { return; }
let key = e.key || e.keyCode;

if ( key === "Escape" || key === "Esc" || key === 27 ) { p2GalleryOff(); }
if ( key === "ArrowRight" || key === "Right" || key === 39 ) { p2SwipeGallery( "right" ); }
if ( key === "ArrowLeft" || key === "Left" || key === 37 ) { p2SwipeGallery( "left" ); }
} );

function p2SwipeGallery( dir ) {
	isLive	=	p2getEl( ".gItem.live" );
	classes	=	isLive.className.split( " " );
	classes.forEach( c => { if ( c.includes( "item_" ) ) { currNum = c.replace( "item_", "" ); } } );

	if ( dir === "right" ) { num = Number(currNum) + 1; }
	if ( dir === "left" ) { num = Number(currNum) - 1; }

	toEls	=	p2getAll( ".item_" + num );
	if ( 0 === toEls.length ) return;
	p2getAll( ".gItem" ).forEach( gi => { gi.classList.remove( "live" ); } );
	toEls.forEach( el => { el.classList.add( "live" ); p2GallThumbScroll( num ); } );
}


function p2GallThumbScroll( toNum ) {
	prevw	=	p2getEl( ".preview_thumb.item_" + toNum );
	thumb	=	p2getEl( ".gallery_thumb.item_" + toNum );
	p2getEl( "#elNum" ).innerText	=	toNum;

	pwidth	=	(toNum-1) * prevw.getBoundingClientRect().width;
	twidth	=	(toNum-1) * thumb.getBoundingClientRect().width;

	if ( ! prime2g_inViewport( prevw ) ) { p2getEl( ".previewScroll" ).scroll( { top:0, left: pwidth, behavior:"smooth" } ); }
	if ( ! prime2g_inViewport( thumb ) ) { p2getEl( ".thumbsScroll" ).scroll( { top:0, left: twidth, behavior:"smooth" } ); }
}


if ( '. $init_hide .' ) mgWrap.classList.add( "g_hide" );
else mgWrap.classList.remove( "g_hide" );
</script>';
return $js;
}
}



