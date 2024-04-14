<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME FEATURES & CONDITIONAL JS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

add_action( 'wp_footer', 'prime2g_conditional_js', 990 );
function prime2g_conditional_js() {
$singular	=	is_singular();
$jsSingular	=	$singular ? 'true' : 'false';

$js	=	'<script async defer id="prime2g_conditional_js">
const	singular	=	'. $jsSingular .';
';

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

if ( $singular && 'replace_header' === get_theme_mod( 'prime2g_video_embed_location' ) ) {
if ( has_header_video() && is_header_video_active() ) {
$js	.=	'var ww_timer	=	setTimeout( function ww_video() {
if ( typeof wp.customHeader !== "undefined" ) {
if ( wp.customHeader.handlers.youtube.player === null ) {
	ww_timer	=	setTimeout( ww_video, 500 );
} else {
	if ( typeof wp.customHeader.handlers.youtube.player !== "undefined" &&
	typeof wp.customHeader.handlers.youtube.player.unMute === "function" ) {
		wp.customHeader.handlers.youtube.player.unMute();
		wp.customHeader.handlers.youtube.player.stopVideo();
	} else {
		ww_timer	=	setTimeout( ww_video, 500 );
	}
}
}
}, 500 );
';
}
}
/*
let ytHeader	=	p2getEl( "#wp-custom-header" );
ytHeader.classList.add( "unclicked" );
ytHeader.onclick	=	()=>{ ytHeader.classList.remove( "unclicked" ); };
*/
$js	.=	'</script>';

echo $js;
}



prime2g_conditional_customizer_js();
function prime2g_conditional_customizer_js() {
$scriptName	=	basename( $_SERVER[ 'PHP_SELF' ] );
if ( $scriptName === 'customize.php' ) {
if ( prime2g_design_by_network_home() && get_current_blog_id() !== 1 ) {

$js	=	'<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" id="jQueryTmp"></script>
<script id="prime2g_conditional_customizer_js">
jQuery( document ).ready( function() {';

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
console.log(mc);
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
$id			=	'';
$post_type	=	'';

extract( $options );

$js	=	'<script id="prime_livesearchJS'. $id .'">
let fID'. $id .'	=	"'. $id .'",
	idID'. $id .'	=	fID'. $id .' ? "#'. $id .'" : "",
	tForm'. $id .'	=	p2getEl( idID'. $id .' + ".liveSearchFormWrap" ),
	tSBox'. $id .'	=	tForm'. $id .'.querySelector( ".liveSearchBox" ),
	tSRes'. $id .'	=	tForm'. $id .'.querySelector( ".liveSearchResults" ),
	tInput'. $id .'	=	tForm'. $id .'.querySelector( "input" );

var counter	=	[],
	input_time	=	0;

tForm'. $id .'.addEventListener( "mouseleave", ()=>{ setTimeout( ()=>{
	tSRes'. $id .'.innerHTML	=	"";
	tSBox'. $id .'.classList.add( "hidden" );
}, 500 );
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
function p2gajmsO() { tSBox'. $id .'.classList.remove( "hidden" ) }

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
	tSRes'. $id .'.innerHTML	=	"<p class=\"centered\"><small>3 characters</small></p>";
return;
}

if ( input_time > 1000 ) input_time = 0;

if ( keytime < 150 ) {
p2gajmsO();
	tSRes'. $id .'.innerHTML	=	"<p class=\"centered\"><small>Slow down a little</small></p>";
return;
}

if ( input_time < 500 && keytime < 200 ) return;


/**
 *	Execute
 */
setTimeout( ()=>{
if ( tValue'. $id .'.length > 2 ) {

tSBox'. $id .'.classList.remove( "hidden" );
tSRes'. $id .'.innerHTML	=	"<p class=\"centered\">Searching</p>";

formData	=	{
	action : "prime2g_doing_ajax_nopriv",
	"prime_do_ajax" : "ajax_search",
	"find" : tInput'. $id .'.value,
	"post_type" : "'. $post_type .'",
	"count" : "10",
	"template" : "prime2g_get_post_object_template",
	"template_args" : '. json_encode( [ 'size' => 'thumbnail', 'tag' => 'span', 'footer' => null ] ) .',
	"_prime-nonce" : "'. wp_create_nonce( 'prime_nonce_action' ) .'"
};
ajaxSuccess	=	function( response ) {
	if ( response && ! response.hasOwnProperty( "error" ) ) {
		// console.log( response );
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
return $js;
}
}


/**	@since 1.0.78 End	**/


/**
 *	@since 1.0.80
 */
if ( ! function_exists( 'prime2g_media_gallery_js' ) ) {
function prime2g_media_gallery_js() {
$js	=	'<script id="prime2g_gallery_js">
let mgWrap	=	p2getEl( ".p2_media_gallery_wrap" ),
	gPrevThumbs	=	p2getAll( ".preview_thumb" ),
	gGalThumbs	=	p2getAll( ".gallery_thumb" ),
	itemsNum	=	gGalThumbs.length;

p2getEl( "#allNum" ).innerText	=	itemsNum;

p2getEl( ".preview_thumb" ).classList.add( "live" );
p2getEl( ".gallery_media" ).classList.add( "live" );
p2getEl( ".gallery_thumb" ).classList.add( "live" );

gGalThumbs.forEach( gt => { gt.addEventListener( "click", (e) => { doGalleryItems( gt ); } ); } );
gPrevThumbs.forEach( gt => { gt.addEventListener( "click", (e) => { doGalleryItems( gt ); p2DoGallery( "on" ); } ); } );

function doGalleryItems( el ) {
p2getAll( ".gItem" ).forEach( gi => { gi.classList.remove( "live" ); } );
	classes	=	Object.values( el.classList );
	classes.forEach( c => { if ( c.includes( "item_" ) ) classI = c; } );
	var currentItems	=	p2getAll( "." + classI );
	currentItems.forEach( ci => {
		p2getEl( "#elNum" ).innerText	=	classI.replace( "item_", "" );
		ci.classList.add( "live" ); p2GallThumbScroll( ci );
	} );
}

function p2DoGallery( toDo ) {
	if ( toDo === "on" ) return mgWrap.classList.remove( "hidden" );
	if ( toDo === "off" ) return mgWrap.classList.add( "hidden" );
}

function p2GalleryOff() {
	p2getAll( ".gItem" ).forEach( gi => { gi.classList.remove( "live" ); } );
	p2DoGallery( "off" );
}

document.addEventListener( "keyup", function( e ) {
if ( e.defaultPrevented ) { return; }
let key = e.key || e.keyCode;

if ( key === "Escape" || key === "Esc" || key === 27 ) { p2GalleryOff(); }
if ( key === "ArrowRight" || key === "Right" || key === 39 ) { p2SwipeGallery( "right" ); }
if ( key === "ArrowLeft" || key === "Left" || key === 37 ) { p2SwipeGallery( "left" ); }
} );

function p2SwipeGallery( dir ) {
	isLive	=	p2getAll( ".gItem.live" )[0];
	classes	=	Object.values( isLive.classList );
	classes.forEach( c => { if ( c.includes( "item_" ) ) { currNum = c.replace( "item_", "" ); } } );
	if ( dir === "right" ) { num = Number(currNum) + 1; }
	if ( dir === "left" ) { num = Number(currNum) - 1; }
	toClass	=	"item_" + num;
	toEls	=	p2getAll( "." + toClass );
	if ( 0 === toEls.length ) return;
	p2getAll( ".gItem" ).forEach( gi => { gi.classList.remove( "live" ); } );
	toEls.forEach( el => { el.classList.add( "live" );p2GallThumbScroll( el ); } );
}

function p2GallThumbScroll( el ) {
if ( el.classList.contains( "gallery_thumb" ) ) {
	classes	=	Object.values( el.classList );
	classes.forEach( c => { if ( c.includes( "item_" ) ) classI = c; } );
	p2getEl( "#elNum" ).innerText	=	classI.replace( "item_", "" );

	width	=	el.getBoundingClientRect().width;
	for ( var i = 0, len = itemsNum; i < len; i++ ) { if ( gGalThumbs[i] === el ) { index = i; break; } }
	if ( ! prime2g_inViewport_get( el ) ) { p2getEl( ".thumbsScroll" ).scroll( { top:0, left: index * width, behavior:"smooth" } ); }
}
}
</script>';
return $js;
}
}



