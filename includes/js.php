<?php defined( 'ABSPATH' ) || exit;
/**
 *	THEME FEATURES & CONDITIONAL JS
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

#	@since 1.0.92
add_action( 'prime2g_after_content', 'prime2g_after_content_js', 1 );
function prime2g_after_content_js() {
#	https://developer.mozilla.org/en-US/docs/Web/API/LargestContentfulPaint
#	For now, do not async/defer:
$js	=	'';

if ( is_singular() || is_front_page() ) {
$js	.=	'<script id="prime2gLCP_js">
const pObserver1	=	new PerformanceObserver( (list)=>{
const entries	=	list.getEntries();
const lastEntry	=	entries[entries.length - 1]; // Use the latest LCP candidate
theLCP	=	lastEntry.element;
if ( theLCP instanceof HTMLImageElement ) {
	theLCP.setAttribute( "rel", "preload" );
	theLCP.setAttribute( "fetchpriority", "high" );
	theLCP.removeAttribute( "loading" );
}
} );
pObserver1.observe({ type: "largest-contentful-paint", buffered: true });
</script>';
}

echo $js;
}



add_action( 'wp_footer', 'prime2g_conditional_js', 500 );
function prime2g_conditional_js() {
$styles		=	ToongeePrime_Styles::mods_cache();	// @since 1.0.86

$singular	=	is_singular();
$jsSingular	=	$singular ? 'true' : 'false';
$isMobile	=	wp_is_mobile();

$js	=	'<script defer id="prime2g_conditional_js">
const	singular	=	'. $jsSingular .',
menuLItems	=	p2getAll( "nav.main-menu li" );';

if ( ! prime2g_remove_sidebar() ) {
$stickyNavs	=	in_array( $styles->sidebar_place, [ 'sticky_right', 'sticky_left' ] );
$sideNavs	=	in_array( $styles->sidebar_place, [ 'site_right', 'site_left' ] );
$stickyNJS	=	$stickyNavs ? 'true' : 'false';

#	@since 1.0.93
if ( ! $isMobile && ( $sideNavs || $stickyNavs ) ) {
$js	.=	'window.onload	=	p2g_containers_width_by_sidebar;
window.onresize	=	p2g_containers_width_by_sidebar;

function prime2g_clear_sidebarStickiness() {
mainNav			=	p2getEl( "#main_nav" );
siteContainer	=	p2getEl( ".has-sidebar #container" );
	siteContainer.style.width	=	"auto";
	siteContainer.style.margin	=	"auto";
	siteContainer.style.maxWidth=	"none";
	mainNav.style.maxWidth	=	"none";
	p2getEl( "body.has-sidebar" ).classList.contains( "sticky_left_sidebar" ) ? mainNav.style.left = "0" : null;
}

async function p2g_containers_width_by_sidebar() {
windwWidth	=	window.innerWidth;
isSticky	=	'. $stickyNJS .';

if ( windwWidth > 901 ) {
mainNav			=	p2getEl( "#main_nav" );
stickyNav		=	p2getEl( "#sticky_nav" );
siteContainer	=	p2getEl( ".has-sidebar #container" );
sidebarWidth	=	p2getEl( "#sidebar" ).offsetWidth;
containerWidth	=	windwWidth - sidebarWidth + "px";
sbBodyClasses	=	p2getEl( "body.has-sidebar" ).classList;
fixedMenu		=	sbBodyClasses.contains( "fixed_main_menu" );
menuOnHeader	=	sbBodyClasses.contains( "menu_on_header" );

if ( sbBodyClasses.contains( "hide_sticky_sidebar" ) ) return;

if ( isSticky ) {
	siteContainer.style.maxWidth=	containerWidth;
	if ( menuOnHeader || fixedMenu ) mainNav.style.maxWidth	=	containerWidth;
}

if ( sbBodyClasses.contains( "sticky_right_sidebar" ) ) {
	siteContainer.style.marginRight		=	sidebarWidth + "px";
	stickyNav ? stickyNav.style.right	=	sidebarWidth + "px" : "";
	if ( fixedMenu ) mainNav.style.right=	sidebarWidth + "px";
}
else if ( sbBodyClasses.contains( "sticky_left_sidebar" ) )  {
	siteContainer.style.marginLeft		=	sidebarWidth + "px";
	stickyNav ? stickyNav.style.left	=	sidebarWidth + "px" : "";
	if ( menuOnHeader || fixedMenu ) mainNav.style.left	=	sidebarWidth + "px";
}
else if ( sbBodyClasses.contains( "site_left_sidebar" ) ) {
	if ( menuOnHeader ) {
		sideRect	=	p2getEl( "#sidebar" ).getBoundingClientRect();
		mainNav.style.left	=	(sideRect.left + sidebarWidth) + "px";
	}
}

}
else {
	if ( isSticky ) {
		prime2g_clear_sidebarStickiness();
	}
	mainNav.style.right		=	"0";
	mainNav.style.left		=	"0";
	stickyNav.style.right	=	"0";
	stickyNav.style.left	=	"0";
}
}';
}
}


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
$js	=	'<script src="'. get_theme_file_uri( '/files/jquery.min.js' ) .'" id="jQueryCtm"></script>
<script id="prime2g_conditional_customizer_js" defer>
jQuery( document ).ready( ()=>{';

if ( prime2g_design_by_network_home() && get_current_blog_id() !== 1 ) {
$js	.=	'setTimeout( ()=>{
let p2gPane		=	jQuery( "#sub-accordion-panel-prime2g_customizer_panel .customize-info" );
p2gPane.append( \'<div style="background:#fff;padding:25px 15px 15px;text-align:center;"><h3>'. __( 'MAIN SITE DESIGNS ARE FROM THE NETWORK HOME', PRIME2G_TEXTDOM ) .'</h3></div>\' );
}, 5000 );';
}

$js	.=	'} );
</script>';
echo $js;
}
}



/**
 *	@since 1.0.73
 *	Password View Toggler for custom login form
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

//	Password view toggle
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
	pageBody	=	p2getEl( "#page" );

async function prime_setMegaMenu() {
if ( typeof p2g_containers_width_by_sidebar === "function" ) {
	await p2g_containers_width_by_sidebar();
}

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

/*** DO NOT Auto-off
tForm'. $id .'.addEventListener( "mouseleave", ()=>{
if ( tSBox'. $id .'.classList.contains( "del" ) ) return;
setTimeout( ()=>{
if ( ! tSRes'. $id .'.matches( ":hover" ) ) {
	tSRes'. $id .'.innerHTML	=	"";
	tSBox'. $id .'.classList.add( "hidden" );
}
}, 3000 );
} );
*/

function prime_runAjaxSearch( e ) {

/**
 *	Keys to ignore
 *	" " === spacebar
 */
if ( e.type === "input" ) {
	if ( [ " " ].includes( e.data ) ) return;
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
prime2g_addClass( ["#prime_class_remover"] );
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


/*	@since 1.0.95	*/
function prime2g_sidebar_toggler_js() {
$site	=	is_multisite() && prime2g_design_by_network_home() ? 1 : null;
$domain	=	prime2g_get_site_domain( $site );
echo	'<script id="ssbTogJS">
if ( primeHasCookie( "hideStickySidebar" ) ) {
	prime2g_sb_toggler_close_state();
}

function prime2g_sb_toggler_close_state() {
	prime2g_clear_sidebarStickiness();
	stickyNav	=	p2getEl( "#sticky_nav" );
	if ( stickyNav ) {
		stickyNav.style.right = "0";
		stickyNav.style.left = "0";
	}
}

p2getEl( "#stickySidebarToggler .pointer" ).addEventListener( "click", ()=>{
	prime2g_sb_toggler_close_state();
	p2getEl( "#stickySidebarToggler" ).classList.toggle( "open" );

//	Maintain event sequence:
	bHasSidebar	=	p2getEl( "body.has-sidebar" ).classList;
	bHasSidebar.contains( "hide_sticky_sidebar" ) ?
	bHasSidebar.remove( "hide_sticky_sidebar" ) : bHasSidebar.add( "hide_sticky_sidebar" );
	p2g_containers_width_by_sidebar();
	bHasSidebar.contains( "hide_sticky_sidebar" ) ?
	primeSetCookie( "hideStickySidebar", "true", 30, "'. $domain .'" ) :
	primeSetCookie( "hideStickySidebar", "true", 0, "'. $domain .'" );
} );
</script>';
}

