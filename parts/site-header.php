<?php defined( 'ABSPATH' ) || exit;

/**
 *	SITE HEADER.
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

$title_in_headr	=	( 'header' == get_theme_mod( 'prime2g_title_location' ) );
$hasHeader		=	has_header_image();
$menuPlace		=	get_theme_mod( 'prime2g_menu_position' );
$pid			=	get_the_ID();
$isSingular		=	is_singular();
$keepHeader		=	( post_custom( 'remove_header' ) !== 'remove' );

if ( $hasHeader ) {

	if ( $isSingular && has_post_thumbnail() && ( '' == get_theme_mod( 'prime2g_thumb_replace_header' ) ) ) {
		$headerUrl	=	get_the_post_thumbnail_url( $pid, 'full' );
	}
	else {
		$headerUrl	=	get_header_image();
	}

}
else {
	$headerUrl	=	'';
}


	prime2g_before_header();

	if ( 'bottom' != $menuPlace ) prime2g_main_menu();

if ( ! $isSingular || $isSingular && $keepHeader ) :

?>

<header id="header" class="site_header prel" style="background-image:url(<?php echo $headerUrl; ?>);">

	<?php if ( $hasHeader ) echo '<div class="shader"></div>'; ?>

	<?php
		if ( $title_in_headr ) {
			prime2g_title_header( prime2g_title_header_classes() );
		}
		else {
			echo prime2g_title_or_logo();
		}
	?>

</header>

<?php

endif;

	if ( 'bottom' == $menuPlace ) prime2g_main_menu();

	if ( $keepHeader ) {
		prime2g_sub_header();
		prime2g_after_header();
	}


