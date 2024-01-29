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

/**
 *	THE SIDEBAR
 */
$sidebar821	=	'.mainsidebar{padding-right:var(--min-pad);}';
$sidebar901	=	'.has-sidebar .site_content,.has-sidebar.width_960px .site_content{grid-template-columns:2.5fr 1fr;}';
$sidebar1101	=	'.has-sidebar .site_content{grid-template-columns:1fr minmax(200px, 300px);}';

if ( get_theme_mod( 'prime2g_sidebar_position' ) === 'left' ) {
$sidebar821	=	'.mainsidebar{padding-left:var(--min-pad);}';
$sidebar901	=
'#main{grid-area:sbMain;}
#sidebar{grid-area:sbSide;}
.has-sidebar .site_content,.has-sidebar.width_960px .site_content{grid-template-columns:1fr 2.5fr;grid-template-areas:\'sbSide sbMain\';}
';
$sidebar1101	=	'.has-sidebar .site_content{grid-template-columns:minmax(200px, 300px) 1fr;}';
}


/**
 *	@since ToongeePrime Theme 1.0.56
 *	Introduced file theme-2.css for child themes of minimum version 2.3
 */
if ( prime_child_min_version( '2.3' ) ) {

$themeV2css	=	'';

if ( is_singular() ) {

$themeV2css	.=	prime2g_comments_css();
$themeV2css	.=	'.prev_next{margin:var(--min-pad) 0;}
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
else {

if ( get_theme_mod( 'prime2g_theme_show_stickies' ) ) {
$themeV2css	.=	'.stickies, .home_headlines{padding:1px var(--min-pad);}
.stickies .thumbnail, .sides .thumbnail, .widget_posts .thumbnail{height:150px;}
.stickies .grid{grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));}
.stickies .grid.by3{grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));}
.stickies .entry_title, .sides .entry_title, .widget_posts .entry_title{font-size:1rem; margin:10px 0 0;}
.stickies p, .sides p, .widget_posts p{margin:0;}';
}

$themeV2css	.=	'#archive_loop{height:max-content;}
.infinite-scroll .archive.prev_next{display:none;}
#page #infinite-handle span{display:inline-block;}
.pagination .page-numbers{line-height:1;}';

}

if ( is_search() ) {
$themeV2css	.=	'.search.grid .thumbnail{min-height:100px;}
.search.grid{grid-template-columns:1fr 4fr;}
.search.grid, .search_result_count{margin-bottom:var(--min-pad);}
.search_result_title{margin:0 0 10px;}
.nothing_found_div .searchform,.search .searchform{max-width:600px; margin:auto;}';
}

if ( is_404() ) {
$themeV2css	.=	'.nothing_found_info{text-align:center;}
.nothing_found_div{padding:var(--med-pad) var(--min-pad);}
.nothing_found_div p, .nothing_found_div #searchform{padding:var(--min-pad) 1rem;}';
}


/**
 *	MAIN MENU
 */
$menuMin821 = $menuMax820 = '';

$mainMenu	=	'.main_menu_wrap{z-index:99990;position:relative;}
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

$menuMin821	=	'.main_menu_wrap, .collapsible-navs .sub-menu{background:var(--content-background);}
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

$menuMax820	=	'#container{top:46px;}
.main_menu_wrap{ background:none;}
.menu_toggbar{
	position:fixed;background:var(--content-background);padding:5px;
	top:0;left:0;right:0;
	height:46px;display:flex;align-items:center;
	justify-content:space-between;z-index:+1;
}
.main-menu, .menu_toggbar{ box-shadow:0 0 12px rgba(0,0,0,0.25);}
.main-menu{
	background:var(--content-background);right:var(--min-pad);position:fixed;
	left:0;bottom:0;padding-bottom:var(--min-pad);
	transition:0.4s;transform:translateX(-200%);overflow-y:auto;
}
.admin-bar .main-menu{ top:46px;}
.main-menu::-webkit-scrollbar{ width:12px;background:silver;}
.main-menu::-webkit-scrollbar-thumb{ background:var(--content-text);border-radius:10px;}
.main-menu::-webkit-scrollbar-thumb:hover{ background:steelblue;}
.prime .main-menu{ transform:translate(0);}
.collapsible-navs .sub-menu a{ margin-left:var(--min-pad);}
.collapsible-navs a{ border-left:3px solid transparent;display:inline-block;}
.collapsible-navs a:hover{ border-color:var(--content-background) }';

}


/**
 *	CSS OUTPUT
 */
$css	=	'<style id="prime2g_conditional_css">
#wp-custom-header img,#wp-custom-header-video-button{display:none;}';

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
 */
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


