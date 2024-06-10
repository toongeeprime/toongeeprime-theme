<?php defined( 'ABSPATH' ) || exit;
/**
 *	POSTS SLIDER
 *	@since ToongeePrime Theme 1.0.70
 */

if ( ! function_exists( 'prime2g_posts_slider_css' ) ) {
function prime2g_posts_slider_css() {
return	'.prime_post_slides_wrap .post_taxonomies{position:absolute;}
.prime_posts_slider article{grid-area:1/1;opacity:0;visibility:hidden;}
.prime_posts_slider article.lit{opacity:1;visibility:visible;}
.prime_posts_slider .entry_img, .prime_posts_slider .thumbnail{height:400px;}
.prime_slides_box{display:grid;grid-template-columns:1fr;grid-template-rows:1fr;}
.slide_entry_title{position:relative;cursor:pointer;opacity:0.7;margin-bottom:7px;width:20%;display:grid;place-content:center;height:50px;}
#post_s_rzmr{opacity:0;visibility:hidden;cursor:pointer;position:absolute;z-index:+10;top:0;right:0;background:#111;font-size:12px;padding:5px 10px;}
.pause #post_s_rzmr{opacity:1;visibility:visible;color:#fff;}
.titles_box{display:flex;flex-wrap:wrap;}

.slide_entry_title:hover{opacity:1;background:var(--brand-color-2);color:#fff;}
.slide_entry_title.lit{opacity:1;background:var(--brand-color);color:#fff;}

@media(min-width:801px){
.prime_posts_slider .media_post{margin-top:-20px;}
}';
}
}


function prime2g_home_slideshow_template() { ?>
<article id="entry-<?php the_ID(); ?>" <?php post_class( [ 'home_slide' ] ); ?>>
<?php
$title	=	get_the_title();
$link	=	get_the_permalink();
$has_pic	=	has_post_thumbnail();
$thumb_link	=	$has_pic ? get_the_post_thumbnail_url( null, 'large' ) : '';
// prime2g_archive_post_top();
// prime2g_archive_post_footer();

$entry	=	'<div class="entry_img"><a href="'. $link .'" title="'. $title .'">';
$entry	.=	$has_pic ? '<div class="thumbnail" style="background-image:url('. $thumb_link .');"></div>' :
'<div class="thumbnail">'. $title .'</div>';
$entry	.=	'</a></div>
<div class="entry_text">
<a href="'. $link .'" title="See this entry"><h2 class="entry_title">"'. $title .'"</h2></a>
</div>';

echo $entry;
?>
</article>
<?php
}


if ( ! function_exists( 'prime2g_posts_slider' ) ) {
function prime2g_posts_slider( array $options = [] ) {
if ( ! prime2g_use_extras() ) return;

// for use in function state
$posttype = $taxonomy = $slug = $css = $count = $timer = $template = $orderby = null;

extract( $options );

// default use @ is_home()
$posttype	=	$posttype ?? get_theme_mod( 'prime2g_slideshow_post_type', 'post' );
$taxonomy	=	$taxonomy ?? get_theme_mod( 'prime2g_slideshow_taxonomy', 'category' );
$slug		=	$slug ?? get_theme_mod( 'prime2g_slideshow_tax_term_slug', 'headlines' );
$css		=	$css ?? prime2g_posts_slider_css();
$count		=	$count ?? get_theme_mod( 'prime2g_slideshow_posts_count', 5 );
$timer		=	$timer ?? get_theme_mod( 'prime2g_slideshow_timer_speed', '5' );
$template	=	$template ?? 'prime2g_home_slideshow_template';
$orderby	=	$orderby ?? 'date';

echo '<style id="prime_posts_sliderCSS">'. $css .'</style>';
?>

<section id="prime_posts_slider" class="prime_posts_slider">

<div class="prime_post_slides_wrap">
	<div class="prime_slides_box prel">
<?php
prime2g_get_posts_output( [
'count'	=>	$count,
'orderby'	=>	$orderby,
'posts_type'=>	$posttype,
'inornot'	=>	'IN',
'taxonomy'	=>	$taxonomy,
'terms'		=>	$slug,
// 'cache_name'=>	'home_headlines_cache',
'looptemplate'	=>	$template	# Template must echo
] );
?>
	</div>
	<div class="titles_box prel">
	<?php
	for ( $c = 0; $c < $count; $c++ ) {
		echo '<p class="slide_entry_title" title="View slide '. $c+1 .'"><span>'. $c+1 .'</span></p>';
	}
	?>
	<span id="post_s_rzmr" class="ps_rzmr">Resume</span>
	</div>
</div>

</section><!-- # -->

<script id="prime_posts_sliderJS">
const ps_wrapr	=	p2getEl( '#prime_posts_slider' ),
	ps_slidesN	=	<?php echo $count; ?>,
	ps_iTimer	=	<?php echo $timer; ?> * 1000;

let ps_slidez	=	p2getAll( '.prime_posts_slider article' ),
	ps_titlez	=	p2getAll( '.slide_entry_title' ),
	ps_titleP	=	p2getAll( '.slide_entry_title p' ),
	ps_sID		=	1;

prime_pslider_reset_slide();
function prime_pslider_reset_slide() {
	ps_slidez[0].classList.add( 'lit' ); ps_titlez[0].classList.add( 'lit' );
}

ps_slidez.forEach( (s)=>{ s.classList.add( 'itm_' + ps_sID++, 'slide' ); } );
ps_titlez.forEach( (t)=>{
	let thips_sID	=	( ps_sID++ ) - ps_slidesN, tID	=	'itm_' + thips_sID;
	t.classList.add( tID, 'slide' ); prime_pslider_switch_slide( t, tID );
} );


//Auto-run Slider
function prime_pslider_run_slides( arr ) {
arr.forEach( (ss)=>{
let sNxt	=	ss.nextElementSibling;
if ( sNxt ) { sNxt.classList.add( 'lit' ); ss.classList.remove( 'lit' ); }
else { ss.classList.remove( 'lit' ); prime_pslider_reset_slide(); }
});
}

function prime_pslider_remv_resume() {
	p2getAll( '.slide' ).forEach( (as)=>{ as.classList.remove( 'resume' ); } ); 
}

const prime_pslider_runInt	=	setInterval(
()=>{ if ( ! ps_wrapr.classList.contains( 'pause' ) ) {
	prime_pslider_run_slides( p2getAll( '.slide.lit' ) );
	prime_pslider_remv_resume();
} }, ps_iTimer );

function prime_pslider_switch_slide( el, id ) {
el.addEventListener( 'click', ()=>{
let sibs	=	p2getAll( '.' + id );
	ps_slidez.forEach( (s)=>{ s.classList.remove( 'lit' ); } );
	ps_titlez.forEach( (s)=>{ s.classList.remove( 'lit' ); } );
	sibs.forEach( (sib)=>{ sib.classList.add( 'lit', 'resume' ); } );
	if ( el.classList.contains( 'lit' ) ) { ps_wrapr.classList.add( 'pause' ); }
} );
}

p2getAll( '.ps_rzmr' ).forEach( (sp)=>{
	sp.addEventListener( 'click', ()=>{ ps_wrapr.classList.remove( 'pause' ); });
});
</script>
<?php
}
}

