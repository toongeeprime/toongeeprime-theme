<?php defined( 'ABSPATH' ) || exit;

/**
 *	CONDITIONAL THEME CSS
 *
 *	Aimed at limiting the theme.css file footprint
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

add_action( 'wp_head', 'prime2g_conditional_css', 3 );
function prime2g_conditional_css() {
$styles	=	ToongeePrime_Styles::mods_cache();	# 1.0.57

/**
 *	THE SIDEBAR
 */
$sidebar821	=	'.mainsidebar{padding-right:var(--min-pad);}';
$sidebar901	=	'.has-sidebar .site_content,.has-sidebar.width_960px .site_content{grid-template-columns:2.5fr 1fr;}';
$sidebar1101	=	'.has-sidebar .site_content{grid-template-columns:1fr minmax(200px, 300px);}';

if ( $styles->sidebar_place === 'left' ) {
$sidebar821	=	'.mainsidebar{padding-left:var(--min-pad);}';
$sidebar901	=
'#main{grid-area:sbMain;}
#sidebar{grid-area:sbSide;}
.has-sidebar .site_content,.has-sidebar.width_960px .site_content{grid-template-columns:1fr 2.5fr;grid-template-areas:\'sbSide sbMain\';}
';
$sidebar1101	=	'.has-sidebar .site_content{grid-template-columns:minmax(200px, 300px) 1fr;}';
}


$themeV2css	=	$mainMenu = $menuMin821 = $menuMax820 = '';


/**
 *	@since ToongeePrime Theme 1.0.56
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

$mainMenu	=	'.main_menu_wrap{z-index:99990;}';

if ( $mainMenuType === 'togglers' ) {
	$mainMenu	.=	'';
}
else {
	$mainMenu	.=	prime2g_menu_main_css();

	$menuMin821	=	prime2g_menu_min821_css();

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
if ( get_theme_mod( 'prime2g_enable_video_features' ) ) {
$css	.=	'#header.title_over_video iframe{min-height:75vh;}
.title_over_video .page_title{position:absolute;width:max-content;}';
}

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
 *	@since ToongeePrime Theme 1.0.57
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



if ( ! function_exists( 'prime2g_main_menu_css' ) ) {
function prime2g_main_menu_css() {
$styles	=	ToongeePrime_Styles::mods_cache();

$css	=	'
/* Menu Togglers */
';

$menu_type	=	$styles->menu_type;

$css	.=	'.menu_togs{width:50px; cursor:pointer;}
.menu_togs span{
width:80%;background:var(--content-text);height:4px;
position:absolute;top:calc(50% - 5%);right:calc(50% - 30%);
transition:0.3s;
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
#menu_toggbar{position:fixed;z-index:100500;top:50px;right:10px;}
@media(min-width:821px){
#menu_toggbar{top:100px;right:30px;}
}';

}

return $css;
}
}


/**
 *	Remove from theme.css/child.css to make code style optional
 *	this does not need to be pluggable
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

/** @since 1.0.57 End **/


/**
 *	@since 1.0.60
 */
function prime_custom_theme_classes_styles() {
return	'.site_width, .ext_stretch_head .footerWrap, .ext_stretch_foot .site_header{
margin:auto;max-width:var(--site-width);	/* Don\'t use width:100% */
}
.ext_stretch_head .site_container,.ext_stretch_foot .site_container,.ext_stretch_foot .footerWrap,
.ext_stretch_hf .site_container, .ext_stretch_hf .footerWrap{max-width:100vw;}
.shader{position:absolute;left:0;right:0;top:0;bottom:0;background:rgba(0,0,0,0.5);}
.hide, .logged-in .logged-out, .logged-out .logged-in{display:none!important;}
.w100pc{width:100%;}
.centered{margin:auto;text-align:center;display:block;}
.p-abso{position:absolute;}
.prel{position:relative;}
.p-fix{position:fixed;}
.grid{display:grid;gap:var(--min-pad);}
.flex{display:flex;flex-wrap:wrap;}
.flexnw{display:flex;}
.hidden{opacity:0;visibility:hidden;z-index:0;}
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
.scrollX{overflow:hidden;overflow-x:auto;}';
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
.page_parts a, .page_parts span{display:inline-block; border-width:2px; margin-right:10px;}';
}
}


if ( ! function_exists( 'prime2g_archives_css' ) ) {
function prime2g_archives_css() {
return '#archive_loop{height:max-content;}
.infinite-scroll .archive.prev_next{display:none;}
#page #infinite-handle span{display:inline-block;}
.pagination .page-numbers{line-height:1;}
.home_headlines{padding:1px var(--min-pad);}';
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
.logo_with_menu .custom-logo{margin-top:5px;}
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
li:hover .sub-menu, .sub-menu li:hover .sub-menu{opacity:1;visibility:visible;}
.sub-menu .sub-menu{left:100%;top:0;}
.sub-menu li, .collapsible-navs .sub-menu a{display:block;}
.logo_with_menu{display:flex;}
.logo_with_menu .custom-logo{margin-left:var(--min-pad);}
.logo_with_menu .main-menu{margin:auto var(--min-pad);}';
}
}


if ( ! function_exists( 'prime2g_menu_max820_css' ) ) {
function prime2g_menu_max820_css() {
return '#container{top:46px;}
.main_menu_wrap{background:none;}
.menu_toggbar{
	position:fixed;background:var(--content-background);padding:5px;
	top:0;left:0;right:0;
	height:46px;display:flex;align-items:center;
	justify-content:space-between;z-index:+1;
}
.main-menu, .menu_toggbar{box-shadow:0 0 12px rgba(0,0,0,0.25);}
.main-menu{
	background:var(--content-background);right:var(--min-pad);position:fixed;
	left:0;bottom:0;padding-bottom:var(--min-pad);
	transition:0.4s;transform:translateX(-200%);overflow-y:auto;
}
.admin-bar .main-menu{top:46px;}
.pop.admin-bar .main-menu{top:0;}
.main-menu::-webkit-scrollbar{width:12px;background:silver;}
.main-menu::-webkit-scrollbar-thumb{background:var(--content-text);border-radius:10px;}
.main-menu::-webkit-scrollbar-thumb:hover{background:steelblue;}
.prime .main-menu{transform:translate(0);}
.collapsible-navs .sub-menu a{margin-left:var(--min-pad);}
.collapsible-navs a{border-left:3px solid transparent;display:inline-block;}
.collapsible-navs a:hover{border-color:var(--content-background);}';
}
}


/** @since 1.0.70 End **/

