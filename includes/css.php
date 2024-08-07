<?php defined( 'ABSPATH' ) || exit;
/**
 *	CONDITIONAL CSS
 *	Aimed at limiting the theme.css file size
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

add_action( 'wp_head', 'prime2g_conditional_css', 3 );
function prime2g_conditional_css() {
$styles	=	ToongeePrime_Styles::mods_cache();	# 1.0.57
/**
 *	THE SIDEBAR
 */
$sidebar821	=	'';
$sidebar901	=	'.has-sidebar .site_content,.has-sidebar.width_960px .site_content{grid-template-columns:2.5fr 1fr;}';
$sidebar1101=	'.has-sidebar .site_content{grid-template-columns:1fr minmax(200px, 300px);}';

if ( $styles->sidebar_place === 'left' ) {
$sidebar901	=
'#main{grid-area:sbMain;}
#sidebar{grid-area:sbSide;}
.has-sidebar .site_content,.has-sidebar.width_960px .site_content{grid-template-columns:1fr 2.5fr;grid-template-areas:\'sbSide sbMain\';}
';
$sidebar1101=	'.has-sidebar .site_content{grid-template-columns:minmax(200px, 300px) 1fr;}';
}

#	@since 1.0.93
if ( in_array( $styles->sidebar_place, [ 'sticky_right', 'sticky_left' ] ) ) {
$sidebar901	=	'#container{margin:0;}
.has-sidebar #page .site_content{display:block;}
#sidebar{position:fixed;bottom:0;top:0;overflow-y:auto;z-index:99990;}
.admin-bar #sidebar{top:32px;}';
$sidebar901	.= $styles->sidebar_place === 'sticky_right' ?
'.has-sidebar:not(.hide_sticky_sidebar) #container{margin-right:317px;}
.has-sidebar.fixed_main_menu #main_nav{right:317px;}
#sidebar{right:0;}
.hide_sticky_sidebar #sidebar{transform:translateX(120%);}'
:
'.has-sidebar:not(.hide_sticky_sidebar) #container{margin-left:317px;}
.has-sidebar.fixed_main_menu #main_nav,.has-sidebar.menu_on_header #main_nav{left:317px;}
#sidebar{left:0;}
.hide_sticky_sidebar #sidebar{transform:translateX(-120%);}';
$sidebar821	=	$sidebar1101 = '';
}

if ( in_array( $styles->sidebar_place, [ 'site_right', 'site_left' ] ) ) {
$sidebar821	=	'.has-sidebar #page_wrapper{display:grid;}
.has-sidebar #page .site_content{display:block;}
#page{grid-area:sbPage;}
#sidebar{grid-area:sbSide;}';
$sidebar821	.= $styles->sidebar_place === 'site_right' ?
'.has-sidebar #page_wrapper{grid-template-columns:2.5fr 1fr;grid-template-areas:\'sbPage sbSide\';}' :
'.has-sidebar #page_wrapper{grid-template-columns:1fr 2.5fr;grid-template-areas:\'sbSide sbPage\';}';
$sidebar901	=	$sidebar1101 = '';
}


$themeV2css	=	$mainMenu = $menuMin821 = $menuMax820 = '';


/**
 *	@since 1.0.56
 *	Introduced file theme-old.css for child themes below version 2.3
 */
if ( prime_child_min_version( '2.3' ) ) {

$themeV2css	.=	prime2g_main_menu_css();

if ( is_singular() ) {
	$themeV2css	.=	prime2g_single_entry_css() . prime2g_comments_css();
}
else {
	$themeV2css	.=	prime2g_archives_css();
}

if ( is_search() ) {
	$themeV2css	.=	prime2g_search_page_css();
}

if ( is_404() ) {
	$themeV2css	.=	prime2g_404_page_css();
}


/**
 *	MAIN MENU
 */
$mainMenuType	=	$styles->menu_type;

$mainMenu		=	'.main_menu_wrap{z-index:99990;}';

if ( $mainMenuType === 'togglers' ) {
	$mainMenu	.=	'';
}
elseif ( $mainMenuType === 'mega_menu' ) {
	$menuMin821	=	prime2g_mega_menu_css();	# mega menu does not appear on mobile

	$menuMax820	=	prime2g_menu_max820_css();
}
else {
	$mainMenu	.=	prime2g_menu_main_css();

	$menuMin821	=	prime2g_menu_min821_css() . prime2g_sticky_menu_css();

	$menuMax820	=	prime2g_menu_max820_css();
}

}


/**
 *	CSS OUTPUT
 */
$css	=	'<style id="prime2g_conditional_css">
#wp-custom-header img,#wp-custom-header-video-button{display:none;}';

$css	.=	prime_custom_theme_classes_styles();

#	Video Media
$css	.=	prime2g_header_video_css();

$css	.=
"{$themeV2css}
{$mainMenu}

@media(min-width:821px){
{$sidebar821}
{$menuMin821}
}
@media(min-width:901px){
{$sidebar901}
}
@media(min-width:1101px){
{$sidebar1101}
}

@media(max-width:820px){
{$menuMax820}
}";

$css	.=	'</style>';

echo $css;
}



/**
 *	FUNCTIONS
 *	@since 1.0.57
 */
if ( ! function_exists( 'prime2g_comments_css' ) ) {
function prime2g_comments_css() {
return '/* Comments */
.comments-area{padding-top:var(--min-pad);}
.comment-list, .comment-list .children{list-style:none;}
.comment-list{padding:0;}
.comment-list .children{padding-left:15px;}
#comments ol:not(.children) li{margin-bottom:var(--min-pad);}
.comment-body{padding:10px 10px var(--min-pad);}
a.comment-reply-link{padding:5px 10px; background:var(--content-text); color:var(--content-background);}
a.comment-reply-link:hover{color:var(--content-text); background:var(--content-background);}
.comment-metadata a{border:0;font-size:90%;}
.required-field-message{display:block; font-size:80%; font-style:italic;color:tomato;}
#reply-title small a{display:block;width:max-content;}
em.comment-awaiting-moderation{display:block;margin:var(--min-pad);}
@media(min-width:821px){
.comment-form-email{width:48%; float:left; margin-right:2%;}
.comment-form-url{width:48%; float:right; margin-left:2%;}
}';
}
}



#	@since 1.0.87
if ( ! function_exists( 'prime2g_header_video_css' ) ) {
function prime2g_header_video_css() {
if ( get_theme_mod( 'prime2g_enable_video_features' ) ) {
return	'.video_header.video_active #header,
.video_as_header.video_active #header{padding:0;overflow:hidden;display:block;}
#header iframe,.video_as_header.video_active #header .title_wrap,
.video_as_header.video_active #header .page_title{position:absolute;left:0;bottom:0;}
.video_as_header #wp-custom-header-video{width:100%}';
}
}
}



if ( ! function_exists( 'prime2g_main_menu_css' ) ) { // note also prime2g_menu_main_css()
function prime2g_main_menu_css() {
$styles	=	ToongeePrime_Styles::mods_cache();

$css	=	'
/* Menu Togglers */
';

$menu_type	=	$styles->menu_type;

$css	.=	'.menu_togs{width:50px; cursor:pointer;}
.menu_togs span{width:80%;background:var(--content-text);height:4px;
position:absolute;top:calc(50% - 5%);right:calc(50% - 30%);transition:0.3s;
}
.menu_togs span:nth-child(1){transform:translateY(-12px) scale(0.8);}
.menu_togs span:nth-child(3){transform:translateY(12px) scale(0.8);}
.menu_togs span:nth-child(2){transition:0.5s;}
.togs.prime .menu_togs span:nth-child(1){transform:translateY(0) rotate(-45deg) scale(1);}
.togs.prime .menu_togs span:nth-child(3){transform:translateY(0) rotate(45deg) scale(1);}
.togs.prime .menu_togs span:nth-child(2){opacity:0;transform:scale(0);}';

if ( 'togglers' === $menu_type ) {

$css	.=	'#tog_menu_target{position:fixed;transition:0.4s;background:var(--content-background);
color:var(--content-text);top:var(--min-pad);bottom:var(--min-pad);right:var(--min-pad);left:var(--min-pad);
box-shadow:0 10px 20px 10px rgba(0,0,0,0.3);margin:auto;max-width:700px;}
#menu_toggbar{position:fixed;z-index:100500;top:5px;right:10px;}
@media(min-width:821px){
#menu_toggbar{top:100px;right:30px;}
}';

}

return $css;
}
}



#	@since 1.0.83
if ( ! function_exists( 'prime2g_sticky_menu_css' ) ) {
function prime2g_sticky_menu_css() {
if ( ToongeePrime_Styles::mods_cache()->sticky_menu ) {
return	'#sticky_nav{position:fixed;left:0;right:0;top:0;z-index:99998;transform:translateY(-200%);}
.pop #sticky_nav{transform:translate(0);}
.admin-bar #sticky_nav{top:32px;}';
}
}
}



/**
 *	Remove from theme.css/child.css to make code style optional
 *	Does not need to be pluggable
 */
function prime2g_animations_css() {
$entrance	=	'.inUp{transform:translateY(50px);opacity:0;}
.inDown{transform:translateY(-50px);opacity:0;}
.inRight{transform:translateX(50px);opacity:0;}
.inLeft{transform:translateX(-50px);opacity:0;}
.enter{transition:0.5s;transition-delay:0.2s;}
#page .enter{transform:translate(0);}';

$spin	=	'
@keyframes prime_spin {
from{transform:rotate(0deg);}
to{transform:rotate(360deg);}
}';

return (object)[
'entrance'	=>	$entrance,
'spin'		=>	$spin
];
}


/**
 *	@since 1.0.60
 */
function prime_custom_theme_classes_styles() {
//	@since 1.0.90
$alts	=	'';
if ( defined( 'PRIME2G_ALT_POST_OBJ' ) ) {
$alts	=	'
.prime_alt_post.post_narrow{--site-width:960px;}
.prime_alt_post.post_wide{--site-width:1250px;}
.prime_alt_post .right.sidebars, .prime_alt_post .site_main{padding:0;margin:0;}

.prime_alt_post.post_w100vw .page_wrapper, .prime_alt_post.post_wstretch .page_wrapper,
.prime_alt_post.post_w100vw .content, .prime_alt_post.post_wstretch .content{max-width:100vw;}';
}

return	'.site_width, .ext_stretch_head .footerWrap, .ext_stretch_foot .site_header{
margin:auto;max-width:var(--site-width);	/* Don\'t use width:100% */
}
.ext_stretch_head .page_wrapper,.ext_stretch_foot .page_wrapper,.ext_stretch_foot .footerWrap,
.ext_stretch_hf .page_wrapper, .ext_stretch_hf .footerWrap{max-width:100vw;}
.shader{position:absolute;left:0;right:0;top:0;bottom:0;background:rgba(0,0,0,0.5);}
.hide, .logged-in .logged-out, .logged-out .logged-in{display:none!important;}
.w100pc{width:100%;}
.centered{margin:auto;text-align:center;display:block;}
.p-abso{position:absolute;}
.prel{position:relative;}
.fit_abso{position:absolute;top:0;bottom:0;left:0;right:0;}
.p-fix{position:fixed;}
.grid{display:grid;gap:var(--min-pad);}
.flex{display:flex;flex-wrap:wrap;}
.flexnw{display:flex;}
.hidden{opacity:0;visibility:hidden;z-index:0;}
.ohidden{overflow:hidden;}
.pointer{cursor:pointer;}
.breakall{word-break:break-all;}
.white, .white a{color:#fff;}
.alignC{align-items:center;}
.justifC{justify-content:center;}
.fixBG{background-attachment:fixed;}
.brandcolor{color:var(--brand-color);}
.brandcolor2{color:var(--brand-color-2);}
.acaps{text-transform:uppercase;}
.has-icons{font-family:"bootstrap-icons";}
.oshadow{box-shadow:0 0 12px rgba(0,0,0,0.25);}
.hidden.prime, .show, .enter{visibility:visible!important;opacity:1!important;}
.clear, .prev_next{clear:both;width:100%;}
.clear:before,.clear:after{content:\'\';display:block;clear:both;}
.slimscrollbar{overflow:hidden;overflow-y:auto;}
.scrollX{overflow:hidden;overflow-x:auto;}

.mainsidebar{scrollbar-color:var(--sidebar-bg) var(--sidebar-text);scrollbar-width:thin;}
.mainsidebar:hover{scrollbar-color:#000 #b0b0b0;}
.searchform input{outline:0;}' . $alts;
}


/**
 *	Embedded in prime2g_get_stickies_by_customizer()
 *	@since 1.0.70
 */
if ( ! function_exists( 'prime2g_stickies_css' ) ) {
function prime2g_stickies_css() {
if ( ! defined( 'PRIME2G_STICKIES_CSS' ) ) {
$css	=	'<style id="prime2g_stickies_css">
.stickies{padding:1px var(--min-pad);}
.stickies .thumbnail{height:150px;}
.stickies .grid{grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));}
.stickies .entry_title{font-size:1rem; margin:10px 0 0;}
.stickies p{margin:0;}
@media(min-width:681px){
.stickies .grid.by3,.stickies .grid.by6{grid-template-columns:1fr 1fr 1fr;}
}
@media(min-width:821px){
.stickies .grid.by4{grid-template-columns:repeat(4, 1fr);}
}
@media(min-width:1001px){
.stickies .grid.by5{grid-template-columns:repeat(5, 1fr);}
.stickies .grid.by6{grid-template-columns:repeat(6, 1fr);}
}</style>';
define( 'PRIME2G_STICKIES_CSS', true );
return $css;
}
}
}


if ( ! function_exists( 'prime2g_single_entry_css' ) ) {
function prime2g_single_entry_css() {
return '.prev_next{margin:var(--min-pad) 0;}
.numbers.prev_next{display:flex; gap:20px;}
.nav-links div, .nav-previous, .nav-next{width:45%;}
.nav-links div:first-child, #page .nav-previous{float:left;}
.nav-links div:last-child, .nav-next{float:right;}
.meta-nav{font-size:85%; font-weight:600; margin-bottom:0; display:inline-block;}
.nav-next{text-align:right;}
.post_taxonomies{font-size:70%;}
.post_taxonomies a{display:inline-block; padding:0 5px; margin:2.5px; text-transform:uppercase;}
.post_taxonomies a:hover, .post_taxonomies a:focus{background:var(--content-text); color:var(--content-background);}
#prime2g_before_post, #prime2g_after_post{width:100%; clear:both;}
.page_parts{margin-top:var(--min-pad); text-align:center;}
.page_parts a, .page_parts span{display:inline-block; border-width:2px; margin-right:10px;}

.singular.post_narrow{--site-width:960px;}
.singular.post_wide{--site-width:1250px;}
.post_wstretch .right.sidebars, .post_wstretch .site_main{padding:0;margin:0;}

.singular.post_w100vw .page_wrapper, .singular.post_wstretch .page_wrapper,
.singular.post_w100vw .content, .singular.post_wstretch .content{max-width:100vw;}';
}
}


if ( ! function_exists( 'prime2g_archives_css' ) ) {
function prime2g_archives_css() {
$css	=	'#archive_loop{height:max-content;}
.infinite-scroll .archive.prev_next{display:none;}
#page #infinite-handle span{display:inline-block;}
.pagination .page-numbers{line-height:1;}
.home_headlines{padding:1px var(--min-pad);}
';

#	@since 1.0.94
if ( get_theme_mod( 'prime2g_archive_masonry_layout' ) ) {
$cols	=	get_theme_mod( 'prime2g_archive_post_columns_num' );
$cols	=	$cols ? str_replace( 'grid', '', $cols ) : '';
$css	.=	'.posts_loop.masonry{display:block;column-fill:initial;columns:'. $cols .';}
.posts_loop.masonry > * {break-inside:avoid;margin-bottom:var(--min-pad);}

@supports (grid-template-columns: masonry) {
.posts_loop.masonry{display:grid;grid-template-rows:masonry;align-tracks:stretch;}
}';
}

return $css;
}
}


if ( ! function_exists( 'prime2g_search_page_css' ) ) {
function prime2g_search_page_css() {
return '.search.grid .thumbnail{min-height:100px;}
.search.grid{grid-template-columns:1fr 4fr;}
.search.grid, .search_result_count{margin-bottom:var(--min-pad);}
.search_result_title{margin:0 0 10px;}
.nothing_found_div .searchform,.search .searchform{max-width:600px; margin:auto;}';
}
}


if ( ! function_exists( 'prime2g_404_page_css' ) ) {
function prime2g_404_page_css() {
return '.nothing_found_info{text-align:center;}
.nothing_found_div{padding:var(--med-pad) var(--min-pad);}
.nothing_found_div p, .nothing_found_div #searchform{padding:var(--min-pad) 1rem;}';
}
}


if ( ! function_exists( 'prime2g_menu_main_css' ) ) {
function prime2g_menu_main_css() {
return '.main_menu_wrap{position:relative;}
.sub-menu{padding-left:1rem;}
.site-menus ul{list-style:none;padding:0;margin:0;}
.collapsible-navs li{position:relative;}
.collapsible-navs li a{padding:7px 15px;margin:3px;}
.collapsible-navs a:hover, .collapsible-navs a:focus{color:var(--content-text);background:var(--content-background);}
.current-menu-item a{position:relative;}
.current-menu-item a::after{
	/* This approach bypasses a border-radius */
	content:"";height:1px;background:var(--content-text);
	left:0;right:0;bottom:0;position:absolute;
}
.current-menu-item .sub-menu a::after{height:0;}
.collapsible-navs .menu-item-has-children a{padding-right:30px;}
.collapsible-navs .menu-item-has-children::after{
position:absolute;font-family:bootstrap-icons;content:"\F282";
font-size:70%;right:10px;top:10px;color:var(--content-text);}';
}
}


if ( ! function_exists( 'prime2g_menu_min821_css' ) ) {
function prime2g_menu_min821_css() {
return '.main_menu_wrap, .collapsible-navs .sub-menu{background:var(--content-background);}
.main_menu_wrap a{color:var(--content-text);}
.collapsible-navs li{display:inline-block;}
.collapsible-navs li a{display:inline-block;}
.sub-menu{min-width:200px;max-width:250px;}
.collapsible-navs .sub-menu, .collapsible-navs .sub-menu .sub-menu{
opacity:0;visibility:hidden;position:absolute;
}
.fixed_main_menu .site_container{margin-top:50px;}
li:hover .sub-menu, .sub-menu li:hover .sub-menu{opacity:1;visibility:visible;}
.sub-menu .sub-menu{left:100%;top:0;}
.sub-menu li, .collapsible-navs .sub-menu a{display:block;}
.logo_with_menu{display:flex;}
.logo_with_menu .main-menu{margin:auto var(--min-pad);}';
}
}


if ( ! function_exists( 'prime2g_menu_max820_css' ) ) {
function prime2g_menu_max820_css() {
$css	=	'#container{top:46px;}
.main_menu_wrap{background:none;}
.menu_toggbar{
	position:fixed;background:var(--content-background);padding:5px;
	top:0;left:0;right:0;
	height:46px;display:flex;align-items:center;
	justify-content:space-between;z-index:+1;
}
.main-menu, .menu_toggbar{box-shadow:0 0 12px rgba(0,0,0,0.25);z-index:999991;}
.main-menu{
background:var(--content-background);left:0;right:var(--min-pad);position:fixed;
bottom:0;padding-bottom:var(--min-pad);transition:0.4s;transform:translateX(-200%);overflow-y:auto;
}
.main-menu::-webkit-scrollbar{width:12px;background:silver;}
.main-menu::-webkit-scrollbar-thumb{background:var(--content-text);border-radius:10px;}
.main-menu::-webkit-scrollbar-thumb:hover{background:steelblue;}
.prime .main-menu{transform:translate(0);z-index:999990;}
.collapsible-navs .sub-menu a{margin-left:var(--min-pad);}
.collapsible-navs a{border-left:3px solid transparent;display:inline-block;}
.collapsible-navs a:hover{border-color:var(--content-background);}';

/**	@since 1.0.86	**/
if ( ToongeePrime_Styles::mods_cache()->mob_submenu_open ) {
$css	.=	'nav.main-menu ul.sub-menu,nav.main-menu li.open .sub-menu .sub-menu{overflow:hidden;max-height:0;transition:all 0.2s;}
nav.main-menu li.open .sub-menu,nav.main-menu li.open li.open .sub-menu{max-height:100vh;transition:all 0.5s;}
.menu-item-has-children::after{transition:0.4s;}
.collapsing .open.menu-item-has-children::after{transform:rotate(180deg);}';
}

return $css;
}
}
/** @since 1.0.70 End **/


/**	@since 1.0.73	**/
if ( ! function_exists( 'prime2g_admin_metabox_css' ) ) {
function prime2g_admin_metabox_css() {
$css	=	'
.prime2g_postbox{border:0;}
.prime2g_postbox .postbox-header{background:#222;color:#fff;border:0;}
.prime2g_postbox .postbox-header h2,.prime2g_postbox .postbox-header button,.prime2g_postbox .toggle-indicator{color:#fff;}';
return $css;
}
}

#	css for prime2g_view_password_toggler()
if ( ! function_exists( 'prime2g_login_page_css' ) ) {
function prime2g_login_page_css() {
/*
return '.login-password,.password{position:relative;}
#page .pwTogg .bi{font-size:1.2rem;margin:0;}
.pwTogg{bottom:0;height:56%;right:10px;}
.pwTogg .bi-eye-slash,.pwTogg.visible .bi-eye{display:none;}
.pwTogg.visible .bi-eye-slash,.pwTogg .bi-eye{display:inline;}';
*/
}
}
/** @since 1.0.73 End **/


/**	@since 1.0.78	**/
if ( ! function_exists( 'prime2g_mega_menu_css' ) ) {
function prime2g_mega_menu_css() {
$css	=	'
#megaMenuWrap{color:var(--content-text);z-index:99999;}
#megaMenuWrap a{color:var(--content-text);}
#megaMenuLinks{display:flex;padding:0;margin:0;}
#megaMenuWrap,#megaMenu li{position: relative;}
#megaMenu li{list-style:none;margin:0 5px;padding:5px 20px;}
.megamenuContents{opacity:0;visibility:hidden;max-height:85vh;position:absolute;padding:var(--min-pad);
background:var(--content-background);transition:0.2s;box-shadow:0 20px 15px 5px rgba(0,0,0,0.2);}
#megaMenu li:hover .megamenuContents{visibility:visible;opacity:1;transition:0.3s;}';
return $css;
}
}


if ( ! function_exists( 'prime2g_ajax_search_css' ) ) {
function prime2g_ajax_search_css() {
if ( defined( 'PRIME_AJX_SEARCHCSS' ) ) return;
define( 'PRIME_AJX_SEARCHCSS', true );

return	'<style id="prime_livesearchCSS">
.wp-block-search__inside-wrapper{position:relative;z-index:99991;}
.liveSearchBox{position:absolute;left:0;right:0;background:var(--content-background);color:var(--content-text);
z-index:99992;border:5px solid #f8f8f8;border-radius:5px;padding:20px;box-shadow:0 5px 15px 5px rgba(0,0,0,0.2);}
.liveSearchBox .slimscrollbar{max-height:300px;margin-right:-10px;margin-left:-10px;}
.liveSearchBox article{display:grid;grid-template-columns:60px 1fr;gap:10px;margin-bottom:0;}
.liveSearchResults{display:grid;gap:10px;}
.liveSearchResults .entry_img{height:40px;overflow:hidden;}
.liveSearchResults .thumbnail{height:40px;}
.close_lsearch{display:grid;place-content:center;width:17px;height:17px;color:#fff;background:red;
border-radius:50px;top:0;right:0;}
div.liveSearchFormWrap .searchform{margin:0;}
</style>';
}
}
/**	@since 1.0.78 End	**/



#	@since 1.0.80
if ( ! function_exists( 'prime2g_media_gallery_css' ) ) {
function prime2g_media_gallery_css( string $template = '1' ) {
$css	=	'<style id="prime2g_gallery_css">
.gallery_box{background:#000;color:#fff;width:200px;margin:auto;}
.p2_media_gallery_wrap.g_hide,.g_hide .gallery_screen,.g_hide .gallery_screen img{visibility:hidden;opacity:0;}
.g_hide .gallery_screen img{display:none;}
.p2_media_gallery_wrap{overflow:hidden;width:max-content;max-width:100%;margin:auto;}
.gallery_screen{top:0;left:0;right:0;max-height:550px;
display:grid;grid-template-columns:1fr;grid-template-rows:1fr;}
.previewScroll{scrollbar-width:none;}
.previewScroll::-webkit-scrollbar{display:none;}
.p2_media_gallery_btns{display:flex;width:max-content;}
.preview_thumb,.gallery_thumb{opacity:0.6;background-size:cover;background-position:center;}
.p2_media_gallery .thumbnail{background-size:cover;background-position:center;}
.preview_thumb:hover,.preview_thumb.live{opacity:1;}
.gallery_media{opacity:0;visibility:hidden;margin:auto;grid-area:1/1;}
.gallery_media.live{opacity:1;visibility:visible;transition:0.5s;}
.gallery_media img{display:block;margin:auto;}
.thumbs_strip{padding:5px;gap:10px;width:max-content;min-width:100%;}
.preview_thumb,.gallery_thumb{background-size:cover;background-position:center;cursor:pointer;}
.gallery_thumb:hover,.gallery_thumb.live{opacity:1;box-shadow:0 0 5px 5px rgba(255,255,255,0.7);}
.thumbsScroll{padding-bottom:10px;}
i.bi.dirBtn{bottom:50%;z-index:10;font-size:1.7rem;left:10px;color:#fff;}
i.dirBtn.right{left:auto;right:10px;}
.dataCounts{color:#fff;font-weight:700;}

.thumbs_strip,#dataStrip,.p2_media_gallery_btns{justify-content:center;}';

if ( $template === '1' ) {
$css	.=	'.gallery_screen img,.gallery_screen .thumbnail{height:300px;}
.preview_thumb{height:80px;width:150px;}
.gallery_thumb{height:50px;width:100px;}';
}

if ( $template === '2' ) {
$css	.=	'.gallery_screen{height:0;}
.imageIDs .preview_thumb{min-width:300px;}	/*in case there\'s no image in post template*/
.preview_thumb,.preview_thumb img,.preview_thumb .thumbnail{height:300px;}
.gallery_thumb{height:50px;width:100px;}

@media(min-width:821px){
.imageIDs .preview_thumb{min-width:400px;}
}
';
}

if ( $template === '3' ) {
$css	.=	'.gallery_screen{height:0;}
.imageIDs .gallery_thumb{min-width:300px;}
.gallery_thumb,.gallery_thumb img,.gallery_thumb .thumbnail{height:300px;}
.preview_thumb{height:50px;width:100px;}

@media(min-width:821px){
.imageIDs .gallery_thumb{min-width:400px;}
}
';
}

$css	.=	'</style>';
return $css;
}
}



#	@since 1.0.89
if ( ! function_exists( 'prime2g_woo_mini_cart_css' ) ) {
function prime2g_woo_mini_cart_css() {
if ( defined( 'PRIME_MINICARTCSS' ) ) return;
define( 'PRIME_MINICARTCSS', true );

return	'<style id="prime_minicart_CSS">
.widget_shopping_cart_content{position:relative;z-index:0;}
.widget_shopping_cart_content .woocommerce-mini-cart{padding-left:5px;}
li.mini_cart_item{position:relative;}
.remove_from_cart_button{position:absolute;background:red;width:15px;height:15px;border-radius:25px;color:#fff;display:grid;place-content:center;}
.remove_from_cart_button:hover{transform:scale(1.2);}
.cart_item_grid{display:grid;grid-template-columns:50px 1fr;gap:15px;}
.minicart_product_title{margin:0;}
.woocommerce-mini-cart__buttons{display:grid;grid-template-columns:1fr 1fr;gap:10px;text-align:center;}
</style>';
}
}


#	@since 1.0.90
if ( ! function_exists( 'prime2g_prod_categ_imgs_css' ) ) {
function prime2g_prod_categ_imgs_css() {
if ( defined( 'PRIME_CATEGIMGCSS' ) ) return;
define( 'PRIME_CATEGIMGCSS', true );

return	'
#prime_prod_categ_img_links{gap:30px;text-align:center;}
.prime_prod_cat_img span{display:block;height:120px;width:120px;background-size:cover;background-position:center;}
@media(min-width:821px){
#prime_prod_categ_img_links{gap:50px;}
.prime_prod_cat_img span{height:150px;width:150px;}
}';
}
}

