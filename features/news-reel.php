<?php defined( 'ABSPATH' ) || exit;

/**
 *	NEWSREEL
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.50
 */

if ( ! function_exists( 'prime2g_news_reel_css' ) ) {
function prime2g_news_reel_css() {
$css	=
'<style id="prime2g_newsreel_css">
#prime2g_news_reel_frame.stretch{max-width:none;}
#prime2g_news_reel{display:grid;grid-template-columns:max-content 1fr;background:var(--content-background);}
.reelPosts{display:grid;grid-template-columns:1fr;grid-template-rows:1fr;overflow:hidden;}
.reel-entry{grid-area:1/1;opacity:0;visibility:hidden;position:relative;transition:0.3s;}
.reel-entry.show{opacity:1;visibility:visible;}
#newsreelHeading,.reel-post-title{line-height:1;padding:10px;margin:0;font-size:1rem;}
#newsreelHeading{background:var(--content-text);color:var(--content-background);}
.reel-post-title{display:inline-block;width:max-content;}
</style>';
return $css;
}
}


if ( ! function_exists( 'prime2g_news_reel' ) ) {

add_action( 'prime2g_sub_header', function() {
	echo '<div id="prime2g_news_reel_frame">' . prime2g_news_reel() . '</div>';
}, 3 );


function prime2g_news_reel() {

if ( prime2g_theme_newsreel_active() ) {

$rWidth		=	get_theme_mod( 'prime2g_news_reel_width', 'site_width' );
$title		=	get_theme_mod( 'prime2g_theme_news_reel_title', 'Latest News' );
$pType		=	get_theme_mod( 'prime2g_theme_news_reel_post_type', 'post' );
$count		=	get_theme_mod( 'prime2g_theme_news_reel_posts_count', 5 );
$categID	=	get_theme_mod( 'prime2g_theme_news_reel_category', 1 );
$mod_taxonomy	=	get_theme_mod( 'prime2g_theme_news_reel_taxonomy' );
$taxonID	=	get_theme_mod( 'prime2g_theme_news_reel_tax_term_id' );


#	Query Vars:
$rTaxonomy	=	$mod_taxonomy;
$rTerms		=	intval( $taxonID );

if ( $pType === 'post' ) {
	$rTaxonomy	=	'category';
	$rTerms		=	intval( $categID );
}

$tax_query	=	array(
	'taxonomy'	=>	$rTaxonomy,
	'field'		=>	'term_id',
	'terms'		=>	$rTerms,
);


if ( $pType === 'page' || empty( $rTaxonomy ) ) {
	$tax_query	=	null;
}


#	Construct Query
$query	=	array(
	'post_type'	=>	$pType,
	'tax_query'	=>	array( $tax_query ),
);

$options	=	array(
	'get'	=>	'posts',
	'cacheName'	=>	'prime2g_reel_cache',
);

$loop	=	prime2g_wp_query( $query, $options );


$reel	=	prime2g_news_reel_css();
$reel	.=
'<div id="prime2g_news_reel" class="' . $rWidth . '">
	<div class="reelHead"><h3 id="newsreelHeading">'. __( $title, PRIME2G_TEXTDOM ) .'</h3></div>
	<div class="reelPosts prel">';

	if ( ! empty( $loop ) ) {

	for ( $p = 0; $p < $count; $p++ ) {
	if ( ! isset( $loop[ $p ] ) ) continue;
		$args	=	array(
			'post'	=>	$loop[ $p ],
			'tag'	=>	'p',
			'class'	=>	'reel-entry',
			'class2'=>	'reel-post-title',
		);
		$reel	.=	prime2g_entry_titles_template( $args );
	}

	wp_reset_postdata();

	}
	else {
		if ( current_user_can( 'edit_options' ) )
			$reel	.=	__( 'No entries found for the reel', PRIME2G_TEXTDOM );
	}

$reel	.=	'</div></div>';


add_action( 'wp_footer', function() { ?>
<script id="prime2g_news_reel_id">
let nrIndex	=	0,
	nrReels	=	p2getAll( '.reel-entry' );

run_nReel();
setInterval( run_nReel, 4000 );

function run_nReel() {
for ( nr = 0; nr < nrReels.length; nr++ ) {
	nrReels[ nr ].classList.remove( 'show' );
}

nrIndex++;
if ( nrIndex > nrReels.length ) { nrIndex = 1 }
	nrReels[ nrIndex - 1 ].classList.add( 'show' );
}
</script>
<?php
} );

return $reel;
}

}

}
