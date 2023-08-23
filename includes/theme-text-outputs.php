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
add_action( 'prime2g_after_header', 'prime2g_breadcrumbs', 5 );
if ( ! function_exists( 'prime2g_breadcrumbs' ) ) {
function prime2g_breadcrumbs() {

if ( is_front_page() || empty( get_theme_mod( 'prime2g_theme_breadcrumbs' ) ) ) return;

function prime2g_shopCrumb() {
if ( ! class_exists( 'woocommerce' ) ) return;
	if ( is_woocommerce() ) {
		$shopTitle	=	__( get_theme_mod( 'prime2g_shop_page_title' ), PRIME2G_TEXTDOM );
		// This must remain because shop title would be empty if not set in customizer:
		if ( $shopTitle == '' ) $shopTitle	=	__( 'Shop Homepage', PRIME2G_TEXTDOM );
		return '<span class="archive"><a href="'. wc_get_page_permalink( 'shop' ) .'" title="' . $shopTitle . '">' . $shopTitle . '</a> &#187; </span>';
	}
}


$crumbs	=	'<div id="breadCrumbs" class="breadCrumbs">';

$home	=	'<span class="home"><a href="'. get_home_url() .'/" title="'. __( 'Site\'s Homepage', PRIME2G_TEXTDOM ) .'">'. __( 'Home', PRIME2G_TEXTDOM ) .'</a> &#187; </span>';

$crumbs	.=	$home;

if ( is_singular() ) {

	$postTaxs	=	get_post_taxonomies();

	if ( $postTaxs ) {
		if ( class_exists( 'woocommerce' ) && is_product() ) {
			$taxon_1	=	$postTaxs[2];
			$crumbs		.=	prime2g_shopCrumb();
		}
		else {
			if ( $postTaxs[1] == 'post_format' ) {
				$taxon_1	=	$postTaxs[2];
			}
			elseif ( $postTaxs[0] == 'post_tag' ) {
				$taxon_1	=	$postTaxs[1];
			}
			else {
				$taxon_1	=	$postTaxs[0];
			}
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

		$crumbs	.=	'<span class="taxonomy">In '. __( $taxName, PRIME2G_TEXTDOM ) .': </span>';

		if ( $termAncs ) {
			foreach( array_reverse( $termAncs ) as $id ) {
				$tName	=	__( get_term_by( 'term_id', $id, $term->taxonomy )->name, PRIME2G_TEXTDOM );
				$crumbs	.=	'<span class="term"><a href="'. get_term_link( $id, $term->taxonomy ) .'" title="'. $tName .'">'. $tName .'</a> &#187; </span>';
			}
		}

		$crumbs	.=	'<span class="term"><a href="'. $termurl .'" title="'. $term->name .'">'. __( $term->name, PRIME2G_TEXTDOM ) .'</a> &#187; </span>';

	}

	$crumbs	.=	'<span class="crumb_page_title" title="Title">'. get_the_title() .'</span>';

}

if ( is_archive() || is_tax() ) {

	$object		=	get_queried_object();

	if ( ! $object instanceof WP_Term ) return;

	$termAncs	=	$object ? get_ancestors( $object->term_id, $object->taxonomy ) : null;
	$taxonomy	=	$object ? get_taxonomy( $object->taxonomy ) : null;

	if ( $object && $object->name == 'product' && function_exists( 'wc_get_page_id' ) ) {
		$s_title	=	__( get_theme_mod( 'prime2g_shop_page_title' ), PRIME2G_TEXTDOM );
		if ( $s_title == '' ) $s_title = __( 'Shop Homepage', PRIME2G_TEXTDOM );
		$crumbs	.=	'<span class="archive"><a href="'. wc_get_page_permalink( 'shop' ) .'" title="'. $s_title .'">'. $s_title .'</a></span>';
		echo $crumbs;
		return;
	}

	if ( $taxonomy ) {
	if ( ! function_exists( 'is_woocommerce' ) || function_exists( 'is_woocommerce' ) && ! is_woocommerce() )
		{
			$taxName	=	$taxonomy->labels->singular_name;
			$crumbs		.=	'<span class="taxonomy">'. __( $taxName, PRIME2G_TEXTDOM ) .': </span>';
		}
	}

	$crumbs	.=	prime2g_shopCrumb();

	if ( $termAncs ) {
		foreach( array_reverse( $termAncs ) as $id ) {
			$tName	=	__( get_term_by( 'term_id', $id, $object->taxonomy )->name, PRIME2G_TEXTDOM );
			$crumbs	.=	'<span class="term"><a href="'. get_term_link( $id, $object->taxonomy ) .'" title="'. $tName .'">'. $tName .'</a> &#187; </span>';
		}
	}

	$crumbs	.=	'<span class="crumb_page_title" title="This Archive">' . get_the_archive_title() .'</span>';

}


# DO NOT use get_the_title() for these:
if ( is_home() ) {
	$crumbs	.=	'<span class="crumb_page_title" title="'. __( 'Homepage', PRIME2G_TEXTDOM ) .'">'. __( 'Posts', PRIME2G_TEXTDOM ) .'</span>';
}

if ( is_search() ) {
	$crumbs	.=	'<span class="crumb_page_title" title="'. __( 'Search results', PRIME2G_TEXTDOM ) .'">'. __( 'Search results for "'. get_search_query() .'"', PRIME2G_TEXTDOM ) .'</span>';
}

if ( is_404() ) {
	$title	=	__( 'Nothing found', PRIME2G_TEXTDOM );
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
add_action( 'prime2g_before_post', 'prime2g_edit_entry', 5, 2 );
if ( ! function_exists( 'prime2g_edit_entry' ) ) {
function prime2g_edit_entry( $par1 = '', $par2 = '' ) {
$par1 = '<p class="edit-link edit-entry">';
$par2 = '</p>';

	echo prime2g_edit_entry_get( $par1, $par2 );

}
}


if ( ! function_exists( 'prime2g_edit_entry_get' ) ) {
function prime2g_edit_entry_get( $pre = '<p class="edit-link edit-entry">', $end = '</p>', $postObject = null ) {

$post	=	$postObject;

if ( $postObject === null )
	global $post;

if ( ! is_object( $post ) ) return;

if ( ! prime2g_is_post_author( $post ) ) return;

$pType	=	$post->post_type;
$ptObj	=	get_post_type_object( $pType );
if ( ! is_object( $ptObj ) ) return;

$ptName	=	$ptObj->labels->singular_name;
$title	=	get_the_title();
$url	=	get_edit_post_link( $post );

$link	=	$pre;
$link	.=	'<a href="' . $url . '" title="Edit">';
$link	.=	__( 'Edit this ' . $ptName, PRIME2G_TEXTDOM );
$link	.=	'<span class="screen-reader-text">' . $title . '</span>';
$link	.=	'</a>';
$link	.=	$end;

return $link;
}
}


/**
 *	Post Metas
 *
 *	Post meta at top of entries
 *	Hooked to prime2g_after_title
 */
add_action( 'prime2g_after_title', 'prime2g_postmeta_top', 4 );
if ( ! function_exists( 'prime2g_postmeta_top' ) ) {
function prime2g_postmeta_top() {

if ( is_page() || get_post_type() == 'product' ) return;

$byline	=	get_theme_mod( 'prime2g_entry_byline_usage', '' );

if ( $byline === 'remove_byline' ) return;

echo '<div class="authorship postmetas">';
	if ( $byline !== 'date_only' ) echo prime2g_posted_by();
	if ( $byline !== 'author_only' ) prime2g_posted_on();
echo '</div>';

}
}


/**
 *	Post meta at bottom of entries
 *	Hooked to prime2g_after_post
 */
add_action( 'prime2g_after_post', 'prime2g_postmeta_bottom', 7 );
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
 *	Filter added and hooked @since ToongeePrime Theme 1.0.45
 */
add_action( 'prime2g_archive_post_top', 'prime2g_archive_postmeta', 5, 2 );
if ( ! function_exists( 'prime2g_archive_postmeta' ) ) {
function prime2g_archive_postmeta( $postObject = null, $echo = true ) {

$byline	=	get_theme_mod( 'prime2g_entry_byline_usage', '' );

if ( $byline === 'remove_byline' ) return;

$metas	=	'<div class="the_metas">';
$metas	.=	( $byline !== 'date_only' ) ? prime2g_posted_by( 'By', '', $postObject ) : '';
$metas	.=	( $byline !== 'author_only' ) ? prime2g_posted_on( ', on ', false ) : '';
$metas	.=	'</div>';

if ( $echo ) echo $metas;
else return $metas;

}
}



/**
 *	Post meta at bottom of archive entries
 *	Hooked to prime2g_archive_post_footer
 */
add_action( 'prime2g_archive_post_footer', 'prime2g_archive_postbase', 10, 1 );
if ( ! function_exists( 'prime2g_archive_postbase' ) ) {
function prime2g_archive_postbase( $echo = true ) {

$div	=	'<div class="entry_taxonomies">';
$div	.=	prime2g_post_taxonomies( 'category', '', '', 'post_categories', false );
$div	.=	'</div>';

if ( $echo ) echo $div;
else return $div;

}
}



/**
 *	Tell Post Author
 */
if ( ! function_exists( 'prime2g_posted_by' ) ) {
function prime2g_posted_by( $text = 'Posted by', $more = 'More entries by', $postObject = null ) {

/**
 *	@https://developer.wordpress.org/reference/functions/get_the_author_posts_link/
 */
global $post;

$post	=	$postObject ?: $post;

$id		=	(int) $post->post_author;

$author	=	get_the_author_meta( 'display_name', $id );
$slug	=	get_the_author_meta( 'user_nicename', $id );

$text	=	__( $text, PRIME2G_TEXTDOM );
$more	=	__( $more, PRIME2G_TEXTDOM );

// if ( ! is_object( $authordata ) ) { return ''; }

$href	=	esc_url( get_author_posts_url( $id, $slug ) );

$link	=	'<span class="post_author vcard">' . $text . ' <a href="' . $href . '" title="' . $more . ' ' . $author . '" rel="author">' . $author . '</a></span>';

return apply_filters( 'get_the_author_posts_link', $link );

}
}



/**
 *	Tell Post Date
 */
if ( ! function_exists( 'prime2g_posted_on' ) ) {
function prime2g_posted_on( $text = ', on ', $echo = true ) {

$text	=	__( $text, PRIME2G_TEXTDOM );
$more	=	__( 'More entries posted on', PRIME2G_TEXTDOM );
$date	=	get_the_date();

/**
 *	Creating Date URL:
 */
$year	=	get_the_date('Y');
$month	=	get_the_date('m');
$day	=	get_the_date('j');

$dateUrl	=	esc_url( home_url( '/' . $year . '/' . $month . '/' . $day . '/' ) );

if ( 'date_only' === get_theme_mod( 'prime2g_entry_byline_usage' ) ) {
	$add_pre	=	'';
} else {
	$add_pre	=	__( $text, PRIME2G_TEXTDOM );
}

	$time_string	=	'<time class="entry_date" datetime="%1$s">%2$s</time>';

	$time_string	=	sprintf(
		$time_string,
		esc_attr__( $date ),
		esc_html__( $date )
	);
	$info	=	'<span class="posted_on">';
	$info	.=	$add_pre ?  : '';
	$info	.=	'<a href="' . $dateUrl . '" title="'. $more . ' ' . $date .'">' . $time_string . '</a>';
	$info	.=	'</span>';

if ( $echo ) echo $info;
else return $info;

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
function prime2g_post_taxonomies( $taxonomy, $count = '', $text = 'Categories:', $class = 'post_categories', $echo = true ) {

$taxonomies	=	get_the_terms( get_the_ID(), $taxonomy );
$before		=	'<span><a href="';
$mid		=	'" title="' . __( 'See more entries here', PRIME2G_TEXTDOM ) . '">';
$after		=	'</a></span> ';

if ( ! empty( $taxonomies ) ) {

	$taxons	=	'<div class="' . $class . ' post_taxonomies"><span class="taxo_heading">'. __( $text, PRIME2G_TEXTDOM ) . '</span> ';

	if( $count == 1 ) {

		$cat	=	$taxonomies[0];
		$taxons	.=	$before . esc_url( get_category_link( $cat->term_id ) ) . $mid . esc_html( $cat->name ) . $after;
		
	}
	else {

		foreach( $taxonomies as $cat ) {

		$taxons	.=	$before . esc_url( get_category_link( $cat->term_id ) ) . $mid . esc_html( $cat->name ) . $after;

		}

	}

	$taxons	.=	'</div>';

if ( $echo ) echo $taxons;
else return $taxons;

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
		$title	=	'<span class="vcard">' . __( get_the_author() . '\'s Posts', PRIME2G_TEXTDOM ) . '</span>';
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
		$title	=	__( 'Entries for the year ' . get_the_date( 'Y' ), PRIME2G_TEXTDOM );
	}
	if ( is_month() ) {
		$title	=	__( 'Entries for ' . get_the_date( 'F, Y' ), PRIME2G_TEXTDOM );
	}
	if ( is_day() ) {
		$title	=	__( 'Entries posted on ' . get_the_date( 'F j, Y' ), PRIME2G_TEXTDOM );
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
		echo "<div class=\"archive-description\"><$tag>" . __( $descr, PRIME2G_TEXTDOM ) . "</$tag></div>";
	}
}
}



/**
 *	Post Excerpt, trimmed
 *	@ https://developer.wordpress.org/reference/hooks/get_the_excerpt/
 */
if ( ! function_exists( 'prime2g_post_excerpt' ) ) {
function prime2g_post_excerpt( $length = 25, $post = null, $readmore = '&hellip; Keep reading' ) {

	$excerpt_length = apply_filters( 'excerpt_length', $length );

	$text = wp_trim_words( get_the_excerpt( $post ), $excerpt_length, prime2g_read_more_excerpt_link( $readmore, $length ) );

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
		esc_html__( $text . ' %s', PRIME2G_TEXTDOM ),
		the_title( '<span class="screen-reader-text">', '</span>', false )
	);
return $readMore;
}
}



/**
 *	Filter the excerpt more link
 *	Added $text and $length @since ToongeePrime Theme 1.0.50
 */
add_filter( 'excerpt_more', 'prime2g_read_more_excerpt_link' );
if ( ! function_exists( 'prime2g_read_more_excerpt_link' ) ) {
function prime2g_read_more_excerpt_link( $text = '&hellip; Keep reading', $length = 25 ) {
	if ( ! is_admin() && $length != 0 ) {
		return ' <a class="more-link" href="' . esc_url( get_permalink() ) . '" title="' . get_the_title() . '">' . __( $text, PRIME2G_TEXTDOM ) . '</a>';
	}
}
}



/**
 *	Continue reading link
 *	Filter the excerpt more link
 */
add_filter( 'the_content_more_link', 'prime2g_read_more_link' );
if ( ! function_exists( 'prime2g_read_more_link' ) ) {
function prime2g_read_more_link( $text = 'Read more' ) {
	if ( ! is_admin() ) {
		return '<div class="more-link-container"><a class="more-link" href="' . esc_url( get_permalink() ) . '#more-' . esc_attr( get_the_ID() ) . '">' . prime2g_read_more_text( $text ) . '</a></div>';
	}
}
}



/**
 *	Add a title to posts and pages that are without titles
 */
add_filter( 'the_title', 'prime2g_post_no_title' );
if ( ! function_exists( 'prime2g_post_no_title' ) ) {
function prime2g_post_no_title( $title ) {
	return '' === $title ? esc_html_x( 'Not Titled', 'Added to posts and pages that are without titles', PRIME2G_TEXTDOM ) : $title;
}
}


/**
 *	HOOK TITLE TO THEME
 *	@since ToongeePrime Theme 1.0.55
 */
add_action( 'prime2g_page_title_hook', 'prime2g_hook_the_page_title', 10, 1 );
if ( ! function_exists( 'prime2g_hook_the_page_title' ) ) {
function prime2g_hook_the_page_title( $title_in_headr ) {
	if ( $title_in_headr ) {
		prime2g_title_header( prime2g_title_header_classes() );
	}
	else {
		echo prime2g_title_or_logo();
	}
}
}


/**
 *	TITLING ENTRIES
 */
if ( ! function_exists( 'prime2g_title_header' ) ) {
function prime2g_title_header( $header_classes = '' ) {

if ( function_exists( 'define_2gRMVTitle' ) ) return;

$is_singular	=	is_singular();
$hClass			=	$is_singular ? ' entry-header' : ' archive-header';
?>

<div class="page_title site_width prel<?php echo $header_classes . $hClass; ?>">

<?php
	#	Theme Hook @since ToongeePrime Theme 1.0.50:
	#	Moved outside $is_singular 1.0.51:
	prime2g_before_title();

	if ( $is_singular ) {

		if ( is_front_page() ) { ?>
		<h1 class="entry-title page-title title">
	<?php _e( get_theme_mod( 'prime2g_front_page_title', 'Welcome to ' . get_bloginfo( 'name' ) ), PRIME2G_TEXTDOM ); ?>
		</h1>
	<?php
		}
		else {
			if ( ! empty( single_post_title( '', false ) ) ) {
					$prod_class	=	'';
				if ( function_exists( 'is_product' ) && is_product() ) {
					$prod_class	=	' product_title';
				}
				the_title( "<h1 class=\"entry-title page-title title$prod_class\">", "</h1>" );
			}
		}

	#	Theme Hook:
	prime2g_after_title();
	}
	elseif ( is_home() ) { ?>
		<h1 class="entry-title page-title title"><?php _e( get_theme_mod( 'prime2g_posts_home_title', get_bloginfo( 'name' ) ), PRIME2G_TEXTDOM ); ?></h1>
		<div class="archive-description"><p><?php _e( get_theme_mod( 'prime2g_posts_home_description', 'Posts Homepage' ), PRIME2G_TEXTDOM ); ?></p></div>
	<?php
	}
	elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		$shopTitle	=	get_theme_mod( 'prime2g_shop_page_title' );
		if ( $shopTitle == '' ) $shopTitle = 'Shop Homepage';
	?>
		<h1 class="entry-title woocommerce-products-header__title page-title title"><?php _e( $shopTitle, PRIME2G_TEXTDOM ); ?></h1>
		<div class="archive-description"><p><?php _e( get_theme_mod( 'prime2g_shop_page_description', prime2g_woo_shop_description() ), PRIME2G_TEXTDOM ); ?></p></div>
	<?php
	}
	elseif ( is_404() ) {
		_e( '<h1 class="entry-title page-title title">Sorry, what you are looking for can\'t be found</h1>', PRIME2G_TEXTDOM );
	}
	elseif ( is_search() ) { ?>
		<h1 class="entry-title page-title title">
			<?php
			printf(
				/* translators: %s: Search term */
				esc_html__( 'Search results for "%s"', PRIME2G_TEXTDOM ),
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

<?php
	#	Theme Hook: @since ToongeePrime Theme 1.0.55
	if ( is_archive() ) prime2g_after_archive_title();
?>

</div><!-- .page_title -->
<?php
}
}
