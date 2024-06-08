<?php defined( 'ABSPATH' ) || exit;

/**
 *	HOMEPAGE PARTS
 *
 *	@package WordPress
 *	@since 1.0
 */

/**
 *	HEADLINES
 */
add_action( 'prime2g_after_header', 'prime2g_home_headlines', 12 );

if ( ! function_exists( 'prime2g_headlines_loop' ) ) {
function prime2g_headlines_loop( $post ) {
return prime2g_get_archive_loop_post_object( [
	'post' => $post, 'size' => 'medium', 'length' => 20, 'metas' => false, 'switch_img_vid' => true
] );
}
}


if ( ! function_exists( 'prime2g_headlines_css' ) ) {
function prime2g_headlines_css() {
if ( prime_child_min_version( '2.3' ) ) {
return '<style id="headlines_css">.home_headlines .display{align-items:start;}
.mid .thumbnail{min-height:200px;}
@media(min-width:821px){
.mid .thumbnail{min-height:300px;}
.home_headlines .display{grid-template-columns:1fr 2fr 1fr;}
}</style>';
}
}
}


if ( ! function_exists( 'prime2g_home_headlines' ) ) {
function prime2g_home_headlines() {
if ( ! is_home() ) return;

if ( get_theme_mod( 'prime2g_theme_show_headlines' ) ) {
$is_slider	=	prime2g_use_extras() && 'slideshow' === get_theme_mod( 'prime2g_home_main_headline_type' );
$cat	=	null;

	if ( ! $is_slider ) {
	$cat	=	get_category( get_theme_mod( 'prime2g_headlines_category', 1 ) );	# By Category ID
	if ( is_object( $cat ) && is_wp_error( $cat ) ) {
		echo '<h2>Category Error</h2>'; return;
	}
	}

	if ( $is_slider || ! $is_slider && $cat ) {
	if ( is_object( $cat ) ) {
		$slug		=	$cat->slug;
		$term_name	=	$cat->name;
	} else {
		$slug		=	get_theme_mod( 'prime2g_slideshow_tax_term_slug' );
		$the_term	=	get_term_by( 'slug', $slug, get_theme_mod( 'prime2g_slideshow_taxonomy', 'category' ) );
		$term_name	=	$the_term ? $the_term->name : '*Check Slider Term';
	}

$options	=	[ 'use_cache' => false, 'set_cache' => false ];
$tax_query	=	[ 'taxonomy' => 'category', 'field' => 'slug', 'operator' => 'IN', 'terms' => $slug ];

$set_1	=	prime2g_wp_query( [ 'posts_per_page' => 2, 'offset' => 1, 'orderby' => 'date', 'no_found_rows' => true, 'tax_query' => [$tax_query] ], $options );
$mid	=	$is_slider ? null : prime2g_wp_query( [ 'posts_per_page' => 1, 'orderby' => 'date', 'no_found_rows' => true, 'tax_query' => [$tax_query] ], $options );
$set_2	=	prime2g_wp_query( [ 'posts_per_page' => 2, 'offset' => 3, 'orderby' => 'date', 'no_found_rows' => true, 'tax_query' => [$tax_query] ], $options );


	echo prime2g_headlines_css() . '<section class="home_headlines">

		<h1 class="headlines_heading">'. $term_name .'</h1>
		<div class="grid display prel">

			<div class="left sides grid prel">';
			if ( $set_1->have_posts() ) {
				while ( $set_1->have_posts() ) { $set_1->the_post(); echo prime2g_headlines_loop( null ); }
			}
			echo '</div>

			<div class="mid grid prel">
			<div class="mainheadline">';
			if ( $is_slider ) {
				prime2g_posts_slider();
			} else {
				if ( $mid->have_posts() ) {
					while ( $mid->have_posts() ) {
						$mid->the_post();
						echo prime2g_get_archive_loop_post_object( [ 'switch_img_vid' => true ] );
					}
				}
			}
			echo '</div>';
			do_action( 'prime2g_after_home_main_headline' );	# @since 1.0.55
			echo '</div>

			<div class="right sides grid prel">';
			if ( $set_2->have_posts() ) {
				while ( $set_2->have_posts() ) { $set_2->the_post(); echo prime2g_headlines_loop( null ); }
			}
			echo '</div>
			</div>';

		do_action( 'prime2g_after_home_headlines' );	# @since 1.0.55

	echo '</section>';
wp_reset_postdata();
	}
	else { echo '<h2>Select Category</h2>'; }
}

}
}

