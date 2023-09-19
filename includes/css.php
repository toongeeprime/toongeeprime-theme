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

#	The Sidebar
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

$css	=	'<style id="prime2g_conditional_css">
#wp-custom-header img,#wp-custom-header-video-button{display:none;}';

#	Video Media
if ( get_theme_mod( 'prime2g_enable_video_features' ) ) {
$css	.=	'#header.title_over_video iframe{min-height:75vh;}
.title_over_video .page_title{position:absolute;width:max-content;}';
}

$css	.=
"@media(min-width:821px){
{$sidebar821}
}
@media(min-width:901px){
{$sidebar901}
}
@media(min-width:1101px){
{$sidebar1101}
}";

$css	.=	'</style>';

echo $css;
}

