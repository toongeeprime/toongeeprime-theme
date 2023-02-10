<?php defined( 'ABSPATH' ) || exit;

/**
 *	MULTI FRAME POSTS SLIDER
 *
 *	* MANUALLY ADD CSS AND JS: to prevent mulitple inserts
 *	@since ToongeePrime Theme 1.0.51.00
 */

add_shortcode( 'prime_multiposts_slider', 'prime2g_multiframe_posts_slider' );
function prime2g_multiframe_posts_slider( $atts ) {
$atts	=	shortcode_atts(
	array(
		'post_type'		=>	'post',
		'taxonomy'		=>	'',
		'terms'			=>	'',
		'count'			=>	'7',
		'columns'		=>	'4',
		'set_name'		=>	'scode-mset1',
		'posttemplate'	=>	'prime2g_get_archive_loop_post_object',
	), $atts
);
extract( $atts );

$taxQuery	=	null;

if ( $taxonomy ) {
	$taxTerms	=	explode( ',', $terms );
	$taxQuery	=	array(
	array(
			'taxonomy'	=>	$taxonomy,
			'field'		=>	'slug',
			'operator'	=>	'IN',
			'terms'		=>	$taxTerms,
		),
	);
}


$args	=	[
	'post_type'			=>	$post_type,
	'posts_per_page'	=>	$count,
	'ignore_sticky_posts'	=>	true,
	'tax_query'			=>	$taxQuery,
];

$options	=	[ 'get' => 'posts', 'cacheName' => $set_name ];

$posts	=	prime2g_wp_query( $args, $options );


if ( $posts ) {

$div	=
'<style id="prime_multiposts_slider_css">
.mSlidebox .inslide{width:auto;}
.inslide article{margin:10px;}
.inslide .entry_title{font-size:1.2rem;margin:0;}
</style>

<section class="prime2g_multi_slider mslidernum prel">
<div class="parameters" data-p2g-columns="' . $columns . '"></div>
	<div class="prime2g_multislides_container">
	<div class="prime2g_multislide_wrap prel">
		<div class="prime2g_mslides_flex prel">';

foreach( $posts as $post ) {

$div	.=	'<div class="mSlidebox"><div class="inslide">';

$postArgs	=	[
	'post'	=>	$post,
	'size'	=>	'medium',
	'metas'	=>	false,
	'excerpt'	=>	false,
];


$div	.=	( $posttemplate ) ?
	$posttemplate( $postArgs ) : prime2g_get_archive_loop_post_object( $postArgs );

$div	.=	'</div></div>';

}

$div	.=	'</div>
	</div>
	</div>
	<div class="msPrev mslide_pn"><span></span></div>
	<div class="msNext mslide_pn"><span></span></div>
</section>';

}

else {
	$div	=	'No entries found for this shortcode query';
}

return $div;
}



