<?php defined( 'ABSPATH' ) || exit;

/**
 *	MINI THEME FEATURES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */


/**
 *	Scroll back to the top of the page
 */
add_action( 'wp_footer', 'prime2g_toTop' );
if ( ! function_exists( 'prime2g_toTop' ) ) {
function prime2g_toTop() { ?>
	<div id="prime2g_toTop">
		<p onclick="prime2g_gotoThis( 'body' );" title="Back to the Top">
			<i class="bi bi-arrow-up"></i>
		</p>
	</div>
<?php
}
}



/**
 *	Search form based on WP Blocks
 *	@since ToongeePrime Theme 1.0.49
 *	Added get_search_query() and pluggable, @since ToongeePrime Theme 1.0.51
 *	First arg optionally as array @since ToongeePrime Theme 1.0.55
 */
if ( ! function_exists( 'prime2g_wp_block_search_form' ) ) {
function prime2g_wp_block_search_form( $echo = true, $label = 'Search', $buttontext = null ) {

$placeholder	=	'';

if ( is_array( $echo ) ) {
extract( $echo );
}

$button_text	=	$buttontext ?: $label;

$form	=	'<form role="search" method="get" action="' . get_home_url() . '" class="searchform wp-block-search__button-outside wp-block-search__text-button wp-block-search"><label for="wp-block-search__input-1" class="wp-block-search__label">' . $label . '</label><div class="wp-block-search__inside-wrapper "><input type="search" id="wp-block-search__input-1" class="wp-block-search__input wp-block-search__input" name="s" value="' . get_search_query() . '" placeholder="'. $placeholder .'" required=""><button type="submit" class="wp-block-search__button wp-element-button">' . $button_text . '</button></div></form>';

if ( $echo ) echo $form;
else return $form;
}
}

