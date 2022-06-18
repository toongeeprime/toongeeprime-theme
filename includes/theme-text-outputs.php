<?php defined( 'ABSPATH' ) || exit;

/**
 *	OUTPUTTING TEXT TO THE THEME
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */


/**
 *	Link Pages
 *	Not hooked because this needs to be just after post content before any other inserted features
 */
if ( ! function_exists( 'prime2g_link_pages' ) ) {

function prime2g_link_pages() {
	wp_link_pages(
		array(
			'before'	=>	'<div id="page_parts" class="page_parts clear"><p>Parts:',
			'after'		=>	'</p></div>',
			'link_before'	=>	' Part ',
			// 'separator'		=>	'>> ',
		)
	);
}

}



/**
 *	Breadcrumbs
 *	Hooked to prime2g_after_header
 */
add_action( 'prime2g_after_header', 'prime2g_breadcrumbs', 7 );
if ( ! function_exists( 'prime2g_breadcrumbs' ) ) {
function prime2g_breadcrumbs() {

if ( is_front_page() || empty( get_theme_mod( 'prime2g_theme_breadcrumbs' ) ) ) return;

function prime2g_shopCrumb() {
if ( ! class_exists( 'woocommerce' ) ) return;
	if ( is_woocommerce() ) {
		$shopTitle	=	__( get_theme_mod( 'prime2g_shop_page_title' ), 'toongeeprime-theme' );
		// This must remain because shop title would be empty if not set in customizer:
		if ( $shopTitle == '' ) $shopTitle	=	__( 'Shop Homepage', 'toongeeprime-theme' );
		return '<span class="archive"><a href="'. wc_get_page_permalink( 'shop' ) .'" title="' . $shopTitle . '">' . $shopTitle . '</a> &#187; </span>';
	}
}


$crumbs	=	'<div id="breadCrumbs" class="breadCrumbs">';

$home	=	'<span class="home"><a href="'. get_home_url() .'/" title="'. __( 'Site\'s Homepage', 'toongeeprime-theme' ) .'">'. __( 'Home', 'toongeeprime-theme' ) .'</a> &#187; </span>';

$crumbs	.=	$home;

if ( is_singular() ) {

	$postTaxs	=	get_post_taxonomies();

	if ( $postTaxs ) {
		if ( class_exists( 'woocommerce' ) && is_product() ) {
			$taxon_1	=	$postTaxs[2];
			$crumbs		.=	prime2g_shopCrumb();
		}
		else {
			$taxon_1	=	( $postTaxs[0] == 'post_tag' ) ? $postTaxs[1] : $postTaxs[0];
		}

		$taxonomy	=	get_taxonomy( $taxon_1 );
		if ( ! is_object( $taxonomy ) ) return;
		$taxName	=	$taxonomy->labels->singular_name;

		$term		=	wp_get_post_terms( get_the_ID(), $taxon_1 )[0];
		$termurl	=	get_term_link( $term->term_id, $term->taxonomy );
		$termAncs	=	get_ancestors( $term->term_id, $term->taxonomy );
	}
	else {
		$taxonomy	=	null;
	}

	if ( is_object( $taxonomy ) ) {

		$crumbs	.=	'<span class="taxonomy">In '. __( $taxName, 'toongeeprime-theme' ) .': </span>';

		if ( $termAncs ) {
			foreach( array_reverse( $termAncs ) as $id ) {
				$tName	=	__( get_term_by( 'term_id', $id, $term->taxonomy )->name, 'toongeeprime-theme' );
				$crumbs	.=	'<span class="term"><a href="'. get_term_link( $id, $term->taxonomy ) .'" title="'. $tName .'">'. $tName .'</a> &#187; </span>';
			}
		}

		$crumbs	.=	'<span class="term"><a href="'. $termurl .'" title="'. $term->name .'">'. __( $term->name, 'toongeeprime-theme' ) .'</a> &#187; </span>';

	}

	$crumbs	.=	'<span class="crumb_page_title" title="Title">'. get_the_title() .'</span>';

}

if ( is_archive() || is_tax() ) {

	$object		=	get_queried_object();
	$termAncs	=	$object ? get_ancestors( $object->term_id, $object->taxonomy ) : null;
	$taxonomy	=	$object ? get_taxonomy( $object->taxonomy ) : null;

	if ( $object && $object->name == 'product' && function_exists( 'wc_get_page_id' ) ) {
		$s_title	=	__( get_theme_mod( 'prime2g_shop_page_title' ), 'toongeeprime-theme' );
		if ( $s_title == '' ) $s_title = __( 'Shop Homepage', 'toongeeprime-theme' );
		$crumbs	.=	'<span class="archive"><a href="'. wc_get_page_permalink( 'shop' ) .'" title="'. $s_title .'">'. $s_title .'</a></span>';
		echo $crumbs;
		return;
	}

	if ( $taxonomy ) {
	if ( ! function_exists( 'is_woocommerce' ) || function_exists( 'is_woocommerce' ) && ! is_woocommerce() )
		{
			$taxName	=	$taxonomy->labels->singular_name;
			$crumbs		.=	'<span class="taxonomy">'. __( $taxName, 'toongeeprime-theme' ) .': </span>';
		}
	}

	$crumbs	.=	prime2g_shopCrumb();

	if ( $termAncs ) {
		foreach( array_reverse( $termAncs ) as $id ) {
			$tName	=	__( get_term_by( 'term_id', $id, $object->taxonomy )->name, 'toongeeprime-theme' );
			$crumbs	.=	'<span class="term"><a href="'. get_term_link( $id, $object->taxonomy ) .'" title="'. $tName .'">'. $tName .'</a> &#187; </span>';
		}
	}

	$crumbs	.=	'<span class="crumb_page_title" title="This Archive">' . get_the_archive_title() .'</span>';

}


// DO NOT use get_the_title() for these:
if ( is_home() ) {
	$crumbs	.=	'<span class="crumb_page_title" title="'. __( 'Homepage', 'toongeeprime-theme' ) .'">'. __( 'Posts', 'toongeeprime-theme' ) .'</span>';
}

if ( is_search() ) {
	$crumbs	.=	'<span class="crumb_page_title" title="'. __( 'Search results', 'toongeeprime-theme' ) .'">'. __( 'Search results for "'. get_search_query() .'"', 'toongeeprime-theme' ) .'</span>';
}

if ( is_404() ) {
	$title	=	__( 'Nothing found', 'toongeeprime-theme' );
	$crumbs	.=	'<span class="crumb_page_title" title="'. $title .'">'. $title .'</span>';
}

	$crumbs	.=	'</div>';

echo $crumbs;

}
}



/**
 *	Edit An Entry
 *	Hooked to prime2g_before_post
 */
add_action( 'prime2g_before_post', 'prime2g_edit_entry', 5 );
if ( ! function_exists( 'prime2g_edit_entry' ) ) {

function prime2g_edit_entry() {
$pType	=	get_post_type();

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post only visible to screen readers */
			esc_html__( 'Edit this ' . $pType . ' %s', 'toongeeprime-theme' ),
			'<span class="screen-reader-text">' . get_the_title() . '</span>'
		),
		'<p class="edit-link edit-entry">',
		'</p>'
	);
}

}


/**
 *	Post Metas
 *
 *	Post meta at top of entries
 *	Hooked to prime2g_after_title
 */
add_action( 'prime2g_after_title', 'prime2g_postmeta_top' );
if ( ! function_exists( 'prime2g_postmeta_top' ) ) {

function prime2g_postmeta_top() {

if ( is_page() || get_post_type() == 'product' ) return;

echo '<div class="authorship postmetas">';
	echo prime2g_posted_by();
	prime2g_posted_on();
echo '</div>';

}

}


/**
 *	Post meta at bottom of entries
 *	Hooked to prime2g_after_post
 */
add_action( 'prime2g_after_post', 'prime2g_postmeta_bottom', 5 );
if ( ! function_exists( 'prime2g_postmeta_bottom' ) ) {

function prime2g_postmeta_bottom() {

echo '<div class="the_post_taxonomies">';

	prime2g_post_taxonomies( 'category' );
	prime2g_post_taxonomies( 'post_tag', '', 'Tags:', 'post_tags' );

echo '</div>';

}

}



/**
 *	Post meta at top of archive entries
 *	Hooked to prime2g_archive_post_top
 */
add_action( 'prime2g_archive_post_top', 'prime2g_archive_postmeta' );
if ( ! function_exists( 'prime2g_archive_postmeta' ) ) {

function prime2g_archive_postmeta() {

echo '<div class="the_metas">';
	echo prime2g_posted_by( 'By', '' );
	prime2g_posted_on();
echo '</div>';

}

}



/**
 *	Post meta at bottom of archive entries
 *	Hooked to prime2g_archive_post_footer
 */
add_action( 'prime2g_archive_post_footer', 'prime2g_archive_postbase' );
if ( ! function_exists( 'prime2g_archive_postbase' ) ) {

function prime2g_archive_postbase() {

echo '<div class="entry_taxonomies">';
	prime2g_post_taxonomies( 'category', '', '' );
echo '</div>';

}

}



/**
 *	Tell Post Author
 */
if ( ! function_exists( 'prime2g_posted_by' ) ) {

function prime2g_posted_by( $text = 'Posted by', $more = 'More entries by' ) {

/**
 *	Copied and edited get_the_author_posts_link() so texts can be optional
 *
 *	@https://developer.wordpress.org/reference/functions/get_the_author_posts_link/
 */
global $post;
$id		=	$post->post_author;

$author	=	get_the_author_meta( 'display_name', $id );
$slug	=	get_the_author_meta( 'user_nicename', $id );

$text	=	__( $text, 'toongeeprime-theme' );
$more	=	__( $more, 'toongeeprime-theme' );

// if ( ! is_object( $authordata ) ) { return ''; }

	$link = sprintf(
	'<span class="post_author vcard">' . $text . ' <a href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
	esc_url( get_author_posts_url( $id, $slug ) ),
		/* translators: %s: Author's display name. */
		esc_attr( sprintf( __( $more . ' %s' ), $author ) ),
		$author
	);

return apply_filters( 'the_author_posts_link', $link );

}

}



/**
 *	Tell Post Date
 */
if ( ! function_exists( 'prime2g_posted_on' ) ) {

function prime2g_posted_on( $text = ', on' ) {

/**
 *	Copied WP's Twenty Twenty-One theme's twenty_twenty_one_posted_on() & edited
 */
$text	=	__( $text, 'toongeeprime-theme' );
$more	=	__( 'More entries posted on', 'toongeeprime-theme' );
$date	=	get_the_date();

/**
 *	Creating Date URL:
 */
$year	=	get_the_date('Y');
$month	=	get_the_date('m');
$day	=	get_the_date('j');

$dateUrl	=	esc_url( home_url( '/' . $year . '/' . $month . '/' . $day . '/' ) );

	$time_string	=	'<time class="entry_date" datetime="%1$s">%2$s</time>';

	$time_string	=	sprintf(
		$time_string,
		esc_attr( $date ),
		esc_html( $date )
	);
	echo '<span class="posted_on">';
	printf(
		/* translators: %s: Publish date. */
		esc_html__( $text . ' %s', 'toongeeprime-theme' ),
		'<a href="' . $dateUrl . '" title="'. $more . ' ' . $date .'">' . $time_string . '</a>' // phpcs:ignore WordPress.Security.EscapeOutput
	);
	echo '</span>';

}

}



/**
 *	Get Post Taxonomy(ies)
 *
 *	Gets post terms
 *	(required) $taxonomy
 *	To get first term only, set $count to (int) 1
 */
if ( ! function_exists( 'prime2g_post_taxonomies' ) ) {

function prime2g_post_taxonomies( $taxonomy, $count = 'all', $text = 'Categories:', $class = 'post_categories' ) {

$taxonomies	=	get_the_terms( get_the_ID(), $taxonomy );
$before		=	'<span><a href="';
$mid		=	'" title="' . __( 'See more entries here', 'toongeeprime-theme' ) . '">';
$after		=	'</a></span> ';

if ( ! empty( $taxonomies ) ) {

	echo '<div class="' . $class . ' post_taxonomies"><span class="taxo_heading">'. __( $text, 'toongeeprime-theme' ) . '</span> ';

	if( $count == 1 ) {

		$cat	=	$taxonomies[0];
		echo $before . esc_url( get_category_link( $cat->term_id ) ) . $mid . esc_html( $cat->name ) . $after;
		
	}
	else {

		foreach( $taxonomies as $cat ) {

			echo $before . esc_url( get_category_link( $cat->term_id ) ) . $mid . esc_html( $cat->name ) . $after;

		}

	}

	echo '</div>';

}

}

}



/**
 *	ARCHIVES TITLES
 */
add_filter( 'get_the_archive_title', 'prime2g_archives_title_filter' );
if ( ! function_exists( 'prime2g_archives_title_filter' ) ) {

function prime2g_archives_title_filter( $title ) {
	if ( is_category() ) {
		$title	=	single_cat_title( '', false );
	}
	if ( is_author() ) {
		$title	=	'<span class="vcard">' . __( get_the_author() . '\'s Posts', 'toongeeprime-theme' ) . '</span>';
	}
	if ( is_post_type_archive() ) {
		$title	=	post_type_archive_title( '', false );
	}
	if ( is_tag() ) {
		$title	=	single_tag_title( '', false );
	}
	if ( is_tax( 'post_format', 'post-format-video' ) ) {
		$title	=	single_term_title( '', false ) . 's';
	}
	if ( is_tax() ) {
		$title	=	single_term_title( '', false );
	}
	if ( is_year() ) {
		$title	=	__( 'Entries for the year ' . get_the_date( 'Y' ), 'toongeeprime-theme' );
	}
	if ( is_month() ) {
		$title	=	__( 'Entries for ' . get_the_date( 'F, Y' ), 'toongeeprime-theme' );
	}
	if ( is_day() ) {
		$title	=	__( 'Entries posted on ' . get_the_date( 'F j, Y' ), 'toongeeprime-theme' );
	}

return $title;
}

}



/**
 *	Archive Description
 */
if ( ! function_exists( 'prime2g_archive_description' ) ) {

function prime2g_archive_description( $tag = 'p' ) {
	$descr = get_the_archive_description();
	if ( is_archive() && $descr ) {
		echo "<div class=\"archive-description\"><$tag>" . __( $descr, 'toongeeprime-theme' ) . "</$tag></div>";
	}
}

}



/**
 *	Post Excerpt, trimmed
 *	@ https://developer.wordpress.org/reference/hooks/get_the_excerpt/
 */
if ( ! function_exists( 'prime2g_post_excerpt' ) ) {

function prime2g_post_excerpt( $length = 25 ) {

	$excerpt_length = apply_filters( 'excerpt_length', $length );

	$text = wp_trim_words( get_the_excerpt(), $excerpt_length, prime2g_read_more_excerpt_link() );

	$text = apply_filters( 'get_the_excerpt', $text );

	if ( ! in_array( $text, array( '', ' ', '&nbsp;' ) ) )
		return '<p class="excerpt">' . $text . '</p>';
}

}



/**
 *	Read more text
 */
if ( ! function_exists( 'prime2g_read_more_text' ) ) {

function prime2g_read_more_text( $text = 'Read more' ) {
	$readMore = sprintf(
		/* translators: %s: Name of current post */
		esc_html__( $text . ' %s', 'toongeeprime-theme' ),
		the_title( '<span class="screen-reader-text">', '</span>', false )
	);

return $readMore;
}

}



/**
 *	Filter the excerpt more link
 */
add_filter( 'excerpt_more', 'prime2g_read_more_excerpt_link' );
if ( ! function_exists( 'prime2g_read_more_excerpt_link' ) ) {

function prime2g_read_more_excerpt_link() {
	if ( ! is_admin() ) {
		return '&hellip; <a class="more-link" href="' . esc_url( get_permalink() ) . '" title="' . get_the_title() . '">' . prime2g_read_more_text( 'Keep reading' ) . '</a>';
	}
}

}



/**
 *	Continue reading link
 *	Filter the excerpt more link
 */
add_filter( 'the_content_more_link', 'prime2g_read_more_link' );
if ( ! function_exists( 'prime2g_read_more_link' ) ) {

function prime2g_read_more_link() {
	if ( ! is_admin() ) {
		return '<div class="more-link-container"><a class="more-link" href="' . esc_url( get_permalink() ) . '#more-' . esc_attr( get_the_ID() ) . '">' . prime2g_read_more_text() . '</a></div>';
	}
}

}



/**
 *	Add a title to posts and pages that are without titles
 */
add_filter( 'the_title', 'prime2g_post_no_title' );
if ( ! function_exists( 'prime2g_post_no_title' ) ) {

function prime2g_post_no_title( $title ) {
	return '' === $title ? esc_html_x( 'Not Titled', 'Added to posts and pages that are without titles', 'toongeeprime-theme' ) : $title;
}

}




/**
 *	TITLING ENTRIES
 */
if ( ! function_exists( 'prime2g_title_header' ) ) {
function prime2g_title_header( $header_classes = '' ) {

$is_singular	=	is_singular();
$hClass			=	$is_singular ? ' entry-header' : ' archive-header';
?>

<div class="page_title site_width prel<?php echo $header_classes . $hClass; ?>">

<?php

	if ( $is_singular ) {
		if ( is_front_page() ) { ?>
			<h1 class="entry-title page-title title">
				<?php _e( 'Welcome to ', 'toongeeprime-theme' ) . bloginfo( 'name' ); ?>
			</h1>
		<?php
		}
		else {
			if ( ! empty( single_post_title( '', false ) ) ) {
				if ( function_exists( 'is_product' ) && is_product() ) {
					$prod_class	=	' product_title';
				}
				else {
					$prod_class	=	'';
				}
				the_title( "<h1 class=\"entry-title page-title title$prod_class\">", "</h1>" );
			}
		}

		// Theme Hook:
		prime2g_after_title();
	}
	elseif ( is_home() ) { ?>
		<h1 class="entry-title page-title title"><?php _e( get_theme_mod( 'prime2g_posts_home_title', get_bloginfo( 'name' ) ), 'toongeeprime-theme' ); ?></h1>
		<div class="archive-description"><p><?php _e( get_theme_mod( 'prime2g_posts_home_description', 'Posts Homepage' ), 'toongeeprime-theme' ); ?></p></div>
	<?php
	}
	elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		$shopTitle	=	get_theme_mod( 'prime2g_shop_page_title' );
		if ( $shopTitle == '' ) $shopTitle = 'Shop Homepage';
	?>
		<h1 class="entry-title woocommerce-products-header__title page-title title"><?php _e( $shopTitle, 'toongeeprime-theme' ); ?></h1>
		<div class="archive-description"><p><?php _e( get_theme_mod( 'prime2g_shop_page_description', prime2g_woo_shop_description() ), 'toongeeprime-theme' ); ?></p></div>
	<?php
	}
	elseif ( is_404() ) {
		_e( '<h1 class="entry-title page-title title">Sorry, what you are looking for can\'t be found</h1>', 'toongeeprime-theme' );
	}
	elseif ( is_search() ) { ?>
		<h1 class="entry-title page-title title">
			<?php
			printf(
				/* translators: %s: Search term */
				esc_html__( 'Search results for "%s"', 'toongeeprime-theme' ),
				'<span class="page-description search-term">' . esc_html( get_search_query() ) . '</span>'
			);
			?>
		</h1>
	<?php
	}
	else {
		the_archive_title( '<h1 class="entry-title page-title">', '</h1>' );
		prime2g_archive_description();
	}
	?>

</div><!-- .page_title -->

<?php
}
}


