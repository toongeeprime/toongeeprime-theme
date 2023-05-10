<?php defined( 'ABSPATH' ) || exit;
/**
 *	PAGINATION
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

#	Extend paginated page title
if ( ! function_exists( 'prime2g_extendPaginationTitle' ) ) {

function prime2g_extendPaginationTitle( $text = ' - page ', $extend = '' ) {
$paged	=	get_query_var( 'paged' );
if ( $paged ) return $text . $paged . $extend;
}

}



#	Pagination by numbers
if ( ! function_exists( 'prime2g_pagination_nums' ) ) {

function prime2g_pagination_nums( $the_query, $echo = true, $max_page = '' ) {

$paged	=	is_front_page() ? 'page' : 'paged';

$big	=	999999999;
$paged	=	( get_query_var( $paged ) ) ?: 1;

if ( ! $max_page ) $max_page	=	$the_query->max_num_pages;

	$div	=	'<div id="pagination-wrap" class="pagination"><nav class="numbers navigation archive prev_next">' .	
	paginate_links( array(
		# 'base'		=>	htmlspecialchars_decode( str_replace( $big, '%#%', get_pagenum_link( $big ) ) ),
		# 'format'	=>	'?page=%#%', // '%#%' is the page number
		'current'	=>	max( 1, $paged ),
		'total'		=>	$max_page,
		'mid_size'	=>	2,
		'prev_text'	=>	__( '&laquo; Previous', PRIME2G_TEXTDOM ),
		'next_text'	=>	__( 'Next &raquo;', PRIME2G_TEXTDOM ),
	) )
	. '</nav></div>';

if ( $echo ) echo $div;
else return $div;
}

}
