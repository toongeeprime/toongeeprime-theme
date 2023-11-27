<?php defined( 'ABSPATH' ) || exit;

/**
 *	Theme's Customizer Functions
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

#	Retain this function for holding constant-overridden defaults
function prime2g_theme_styles_constant_overrides() {

$theStyles	=	new ToongeePrime_Styles();

$brandClr	=	defined( 'CHILD_BRANDCOLOR' ) ? CHILD_BRANDCOLOR : $theStyles->brandClr;
$brandClr2	=	defined( 'CHILD_BRANDCOLOR2' ) ? CHILD_BRANDCOLOR2 : $theStyles->brandClr2;
$bgcolor	=	defined( 'CHILD_SITEBG' ) ? CHILD_SITEBG : $theStyles->siteBG;
$headerbg	=	defined( 'CHILD_HEADERBG' ) ? CHILD_HEADERBG : $theStyles->headerBG;
$contentbg	=	defined( 'CHILD_CONTENTBG' ) ? CHILD_CONTENTBG : $theStyles->contentBG;
$footerbg	=	defined( 'CHILD_FOOTERBG' ) ? CHILD_FOOTERBG : $theStyles->footerBG;

#	other recognized constant: CHILD_BUTTONBG @ class ToongeePrime_Colors

return (object) [
	'brandcolor'	=>	$brandClr,
	'brandcolor2'	=>	$brandClr2,
	'bgcolor'	=>	$bgcolor,
	'headerbg'	=>	$headerbg,
	'contentbg'	=>	$contentbg,
	'footerbg'	=>	$footerbg
];
}




