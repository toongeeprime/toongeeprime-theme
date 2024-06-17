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
 *	Live Search set to work with one form on webpage... target with $id
 */
if ( ! function_exists( 'prime2g_wp_block_search_form' ) ) {
function prime2g_wp_block_search_form( $echo = true, $label = 'Search', $buttontext = null ) {
$placeholder	=	$required = $form = $id = $post_type = '';
$livesearch		=	false;
$template		=	'prime2g_get_post_object_template';

if ( is_array( $echo ) ) {
extract( $echo );
$echo		=	'yes' === $echo ? true : false;
}

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
</div>
</form>';

//	Added filters @since 1.0.90
$searchbox	=	'<div class="liveSearchBox hidden">
<span class="close_lsearch pointer p-abso" title="Close">x</span>';
$searchbox	.=	apply_filters( 'prime2g_livesearchform_top', '' );
$searchbox	.=	'<div class="slimscrollbar"><div class="liveSearchResults"></div></div>';
$searchbox	.=	apply_filters( 'prime2g_livesearchform_base', '' );
$searchbox	.=	'</div>' . prime2g_ajax_search_js( [ 'id' => $formID, 'post_type' => $post_type, 'template' => $template ] );

$form	.=	$livesearch ? $searchbox : '';

$form	.=	'</div><!-- .formWrap -->';

if ( $echo ) echo $form;
else return $form;
}
}


/**
 *	@since 1.0.90
 */
add_filter( 'prime2g_livesearchform_top', 'prime_do_livesearchform_top' );
add_filter( 'prime2g_livesearchform_base', 'prime_do_livesearchform_base' );

function prime_do_livesearchform_top() {
	return function_exists( 'prime_livesearchform_top' ) ? prime_livesearchform_top() : '';
}

function prime_do_livesearchform_base() {
	return function_exists( 'prime_livesearchform_base' ) ? prime_livesearchform_base() : '';
}



/**
 *	Class Remover Sheet
 *	Background div to remove class from elements on click
 *	@since 1.0.57
 */
if ( ! function_exists( 'prime2g_class_remover_sheet' ) ) {
add_action( 'wp_footer', 'prime2g_class_remover_sheet', 10, 900 );
function prime2g_class_remover_sheet( string $items, string $class = 'prime' ) {
if ( ! function_exists( 'prime_remover_sheet_items' ) ) return; #	activator function

$function	=	prime_remover_sheet_items();
#	escaped:
$items		=	$function->items;
$class		=	$function->class;
$items_add	=	$function->items_add;
$class_add	=	$function->class_add;
echo	'<div id="prime_class_remover" class="hidden p-fix" style="top:0;bottom:0;right:0;left:0;z-index:99990;"
 onclick="prime_sheet_remover();"></div>
<script id="primeRemovrSheetJS">
function prime_sheet_remover() {
	if ( "'. $items_add .'" ) prime2g_addClass( ['. $items_add .'], [\''. $class_add .'\'] );
	prime2g_remClass( ['. $items .', \'#prime_class_remover\'], [\''. $class .'\'] );
}
</script>';

}
}


/**
 *	Activate prime2g_class_remover_sheet()
 *	@since 1.0.60
 */
if ( ! function_exists( 'prime_remover_sheet_items' ) ) {
function prime_remover_sheet_items() {
return (object) [
#	comma separated escapes:
   'items'	=>	"'#tog_menu_target', '.togs'",
   'class'	=>	"prime",
   'items_add'	=>	"'.liveSearchBox'",
   'class_add'	=>	"hidden"
];
}
}


/**
 *	@since 1.0.89
 */
if ( get_theme_mod( 'prime2g_show_est_read_time', 0 ) ) {
	$hook	=	get_theme_mod( 'prime2g_est_read_time_placement', 'prime2g_after_title' );
	add_action( $hook, 'prime2g_estimated_reading_time', 10, 0 );
}


if ( ! function_exists( 'prime2g_estimated_reading_time' ) ) {
function prime2g_estimated_reading_time( array $options = [] ) {
if ( ! is_singular() ) return;
if ( ! empty( get_theme_mod( 'prime2g_show_est_read_time' ) ) ) {

$post_types	=	get_theme_mod( 'prime2g_est_read_time_posttypes', 'post' );	#	@1.0.94
$sep	=	', ';
$include_sec	=	$plain = false;
$echo	=	true;

extract( $options );

$post_types	=	explode( ',', str_replace( ' ', '', $post_types ) );

global $post;

if ( ! in_array( $post->post_type, $post_types ) ) return;

$content	=	$post->post_content;
$words		=	str_word_count( strip_tags( $content ) );
$min		=	ceil( $words / 200 );
$sec		=	ceil( $words % 200 / (200 / 60) );
$minutes	=	$min . ' minute' . ( $min == 1 ? '' : 's' );
$seconds	=	$sec . ' second' . ( $sec == 1 ? '' : 's' );

$raw		=	__( $minutes . ( $include_sec ? $sep . $seconds : '' ), PRIME2G_TEXTDOM );
if ( $plain ) return $raw;

$prepend	=	get_theme_mod( 'prime2g_est_read_time_prepend', 'Est. read time: ' );
$estimate	=	'<p class="prel prime est_read_time">
<span class="pre">'. $prepend .'</span> <span class="est">'. $raw .'</span></p>';

if ( $echo )
	echo $estimate;
else 
	return $estimate;
}
}
}

