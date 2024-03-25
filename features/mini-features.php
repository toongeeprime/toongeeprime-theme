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
	<p onclick="prime2g_gotoThis( 'body' );" title="Back to the Top"><i class="bi bi-arrow-up"></i></p>
</div>
<?php
}
}


/**
 *	Search form based on WP Blocks
 *	@since 1.0.49
 *	Added get_search_query() and pluggable, @since 1.0.51
 *	First arg preferrably as array @since 1.0.55
 *	Live Search Feature & refactored @since 1.0.78
 */
if ( ! function_exists( 'prime2g_wp_block_search_form' ) ) {
function prime2g_wp_block_search_form( $echo = true, $label = 'Search', $buttontext = null ) {
$placeholder	=	$required = $form = $id = '';
$livesearch		=	false;

if ( is_array( $echo ) ) {
extract( $echo );
}

$echo			=	'yes' === $echo ? true : false;
$livesearch		=	'yes' === $livesearch && prime2g_use_extras() ? true : false;
$liveClass		=	$livesearch ? 'livesearch ' : '';
$required		=	in_array( $required, [ 'yes', 'required', 'true', '1' ] ) ? ' required' : '';
$formID			=	empty( $id ) ? '' : $id;
$id				=	empty( $id ) ? '' : ' id="'. $id .'"';
$button_text	=	$buttontext ?: $label;

$form	.=	$livesearch ? prime2g_ajax_search_css() . '<div'. $id .' class="liveSearchFormWrap formWrap prel">'
: '<div'. $id .' class="formWrap">';

$form	.=	'<form role="search" method="get" action="' . get_home_url() . '" class="'. $liveClass .'searchform wp-block-search__button-outside wp-block-search__text-button wp-block-search">
<label for="wp-block-search__input'. $formID .'" class="wp-block-search__label">' . $label . '</label>
<div class="wp-block-search__inside-wrapper ">
<input type="search" id="wp-block-search__input'. $formID .'" class="wp-block-search__input wp-block-search__input" name="s" value="' . get_search_query() . '" placeholder="'. $placeholder .'"'. $required .'>
<button type="submit" class="wp-block-search__button wp-element-button">' . $button_text . '</button>
</div>';

// Non-ajax:
// $form	.=	$livesearch ? '<input type="hidden" name="prime_do_ajax" value="ajax_search">' . wp_nonce_field( 'prime_search_action', '_prime-nonce' ) : '';
$form	.=	'</form>';

$form	.=	$livesearch ? '<div class="liveSearchBox hidden p-abso"><div class="liveSearchResults"></div></div>
</div>' . prime2g_ajax_search_js( $formID )
: '</div>';

if ( $echo ) echo $form;
else return $form;
}
}


/**
 *	Class Remover Sheet
 *	Background div to remove class from elements on click
 *	@since 1.0.57
 */
if ( ! function_exists( 'prime2g_class_remover_sheet' ) ) {
add_action( 'wp_footer', 'prime2g_class_remover_sheet', 10, 2 );
function prime2g_class_remover_sheet( string $items, string $class = 'prime' ) {
if ( ! function_exists( 'prime_remover_sheet_items' ) ) return; #	activator function

$function	=	prime_remover_sheet_items();

$items	=	$function->items;	#	$items must be escaped
$class  =   $function->class;
echo	'<div id="prime_class_remover" class="hidden p-fix" style="top:0;bottom:0;right:0;left:0;z-index:90000;"
 onclick="prime2g_remClass( ['. $items .', \'#prime_class_remover\'], \''. $class .'\' );"></div>';

}
}
