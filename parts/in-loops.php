<?php defined( 'ABSPATH' ) || exit;

/**
 *	PARTS IN THE LOOP
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	Showing Sticky Posts
 *	Reworked @since ToongeePrime Theme 1.0.51
 */

add_action( 'prime2g_after_header', 'prime2g_show_sticky_posts' );
if ( ! function_exists( 'prime2g_show_sticky_posts' ) ) {
function prime2g_show_sticky_posts() {

// # if sticky posts are to be shown
if ( 'show' == get_theme_mod( 'prime2g_theme_show_stickies' ) && ( is_home() || is_category() || is_tag() || is_tax() ) ) {
	# Get sticky posts
	$posttype	=	get_theme_mod( 'prime2g_theme_stickies_post_type', 'post' );
	$count		=	get_theme_mod( 'prime2g_theme_stickies_count', '4' );

	$args	=	array(
		'post_type'			=>	$posttype,
		'posts_per_page'	=>	$count,
		'post__in'			=>	get_option( 'sticky_posts' ),
		'ignore_sticky_posts'	=>	1,
	);
	$stickies	=	new WP_Query( $args );
	$posts		=	$stickies->posts;

	if ( $stickies->have_posts() ) {
	$numClass	=	( in_array( $count, [ '3', '6', '9' ] ) ) ? ' by3' : '';

	echo '<section id="stickies" class="stickies">';

	# The Heading
	echo '<h1 class="sticky_heading">' . get_theme_mod( 'prime2g_theme_sticky_heading' ) . '</h1>';

		echo '<div class="grid prel'. $numClass .'">';

			foreach ( $posts as $post ) {
				prime2g_post_object_template( $post, 'medium' );
			}

		echo '</div>';
	echo '</section>';
	}
}

}
}



/**
 *	Previous and Next Post
 */
add_action( 'prime2g_after_post', 'prime2g_prev_next_post', 7, 3 );
if ( ! function_exists( 'prime2g_prev_next_post' ) ) {

// Empty argument was added coz somehow, it reads from the second var
function prime2g_prev_next_post( $empty = '', $prev = 'Previous Entry ', $next = 'Next Entry ', $taxonomy = 'category' )
{

if ( is_page() ) return;

$prevText	=	__( $prev, PRIME2G_TEXTDOM );
$nextText	=	__( $next, PRIME2G_TEXTDOM );

	the_post_navigation(
		array(
			'prev_text'	=>	'<p class="meta-nav">'. $prevText .'</p><p class="post-title">%title</p>',
			'next_text'	=>	'<p class="meta-nav">'. $nextText .'</p><p class="post-title">%title</p>',
			'taxonomy'	=>	$taxonomy,
			'class'		=>	'prev_next',
		)
	);

}
}



/**
 *	Previous and Next Archive Page
 */
if ( ! function_exists( 'prime2g_prev_next' ) ) {
function prime2g_prev_next( $spepr = ' ', $prev = '&laquo; Previous Page', $next = 'Next Page &raquo;' ) {

if ( get_theme_mod( 'prime2g_archive_pagination_type' ) === 'numbers' ) {	# @since ToongeePrime Theme 1.0.55
	global $wp_query;
	prime2g_pagination_nums( $wp_query );
}
else {

$prev	=	__( $prev, PRIME2G_TEXTDOM );
$next	=	__( $next, PRIME2G_TEXTDOM );
echo '<nav class="navigation archive prev_next">';
	posts_nav_link( $spepr, '<p class="nav-previous">' . $prev . '</p>', '<p class="nav-next">' . $next . '</p>' );
echo '</nav>';

}

}
}



/**
 *	Archive Post Entry Template
 */
if ( ! function_exists( 'prime2g_archive_loop' ) ) {
function prime2g_archive_loop( $size = 'large', $excerpt = true, $length = 25, $metas = true, $footer = true, $tag = 'h2' ) {

	echo prime2g_get_archive_loop( $size, $excerpt, $length, $metas, $footer, $tag );

}
}



/**
 *	Post Object Template
 */
if ( ! function_exists( 'prime2g_post_object_template' ) ) {
function prime2g_post_object_template( $object, $size = 'large', $excerpt = null, $length = 25, $metas = null ) {

$id		=	$object->ID;
$title	=	$object->post_title;
$link	=	get_permalink( $id );

echo '<article id="entry-'. $id .'" class="'. implode( ' ', get_post_class( '', $id ) ) .'">';
echo '<div class="entry_img">';
echo '<a href="'. $link .'" title="'. $title .'">';

	if ( has_post_thumbnail( $object ) ) {
		echo '<div class="thumbnail" style="background-image:url(';
		echo get_the_post_thumbnail_url( $object, $size );
		echo ');"></div>';
	}
	else {
		if ( child2g_has_placeholder() ) {
			echo '<div class="thumbnail" style="background-image:url(';
			child2g_placeholder_url();
			echo ');"></div>';
		}
		else {
			echo '<div class="thumbnail">'. $title .'</div>';
		}
	}

echo '</a></div>';
echo '<div class="entry_text">';
if ( $metas ) prime2g_archive_post_top( $object );
echo '<a href="'. $link .'" title="Read this entry"><h2 class="entry_title">'. $title .'</h2></a>';
if ( $excerpt ) echo prime2g_post_excerpt( $length, $object );
prime2g_archive_post_footer();
echo '</div>';
echo '</article>';

}
}




/**
 *	Search Results Entry Template
 */
if ( ! function_exists( 'prime2g_search_loop' ) ) {
function prime2g_search_loop() {
$title	=	get_the_title();
$link	=	get_permalink();
?>

<article id="entry-<?php echo get_the_ID(); ?>" <?php post_class( 'search grid' ); ?>>

	<div class="entry_img">
		<a href="<?php echo $link; ?>" title="<?php echo $title; ?>">
			<?php
			if ( has_post_thumbnail() ) {
				echo '<div class="thumbnail" style="background-image:url(';
				the_post_thumbnail_url( 'large' );
				echo ');"></div>';
			}
			else {
				if ( child2g_has_placeholder() ) {
					echo '<div class="thumbnail" style="background-image:url(';
					child2g_placeholder_url();
					echo ');"></div>';
				}
				else {
					echo '<div class="thumbnail">'. $title .'</div>';
				}
			}
			?>
		</a>
	</div>
	<div class="entry_text">

		<a href="<?php echo $link; ?>" title="Read this entry"><h3 class="search_result_title"><?php echo $title; ?></h3></a>
		<?php echo prime2g_post_excerpt(); ?>

	</div>

</article>

<?php
}
}




/**
 *	Split from prime2g_archive_loop()
 *	Archive Post Entry Template: returned
 *	@since ToongeePrime Theme 1.0.45
 */
if ( ! function_exists( 'prime2g_get_archive_loop' ) ) {
function prime2g_get_archive_loop( $size = 'large', $excerpt = true, $length = 25, $metas = true, $footer = true, $tag = 'h2' ) {
$title	=	get_the_title();
$link	=	get_permalink();

#	@since ToongeePrime Theme 1.0.55
global $post;

if ( is_array( $size ) ) {	# Leave var name for backwards compatibility

$imgSize	=	'large';
$excerpt	=	true;
$length		=	25;
$metas		=	true;
$footer		=	true;
$tag		=	'h2';
$readmore	=	' - Read more';

extract( $size );
}
else {
	$imgSize	=	$size;
	$readmore	=	'... Keep reading';
}
#	@since ToongeePrime Theme 1.0.55 end

$entry	=	'<article id="entry-' . get_the_ID() . '" class="' . implode( ' ', get_post_class() ) . '">';
$entry	.=	'<div class="entry_img">';

$entry	.=	prime2g_ft_image_in_loop( $title, $imgSize, $link, $post );

$entry	.=	'</div>';
$entry	.=	'<div class="entry_text">';

if ( $metas )
	$entry	.=	prime2g_archive_post_top_filter_part();

$entry	.=	'<a href="' . $link . '" title="Read this entry"><' . $tag . ' class="entry_title">' . $title . '</' . $tag . '></a>';

if ( $excerpt && ! is_attachment() )
	$entry	.=	prime2g_post_excerpt( $length, $post, $readmore );

	$entry	.=	prime2g_edit_entry_get( '<p class="edit-link edit-entry">', '</p>' );

if ( $footer )
	$entry	.=	prime2g_archive_post_footer_filter_part();

$entry	.=	'</div>';
$entry	.=	'</article>';

return $entry;

}
}



/**
 *	@since ToongeePrime Theme 1.0.55
 */
if ( ! function_exists( 'prime2g_ft_image_in_loop' ) ) {
function prime2g_ft_image_in_loop( string $title, string $size, string $link, object $post = null ) {

$thepost	=	$post ?: null;
$ftimg	=	'<a href="' . $link . '" title="' . $title . '">';

if ( has_post_thumbnail( $thepost ) ) {
	$ftimg	.=	'<div class="thumbnail" style="background-image:url(';
	$ftimg	.=	get_the_post_thumbnail_url( $thepost, $size );
	$ftimg	.=	');"></div>';
}
else {
	if ( child2g_has_placeholder() ) {
		$ftimg	.=	'<div class="thumbnail" style="background-image:url(';
		$ftimg	.=	child2g_placeholder_url( true );
		$ftimg	.=	');"></div>';
	}
	else {
		$ftimg	.=	'<div class="thumbnail">'. $title .'</div>';
	}
}

$ftimg	.=	'</a>';

return $ftimg;
}
}




/**
 *	Archive Post Template by post object
 *	@since ToongeePrime Theme 1.0.50
 *	Media field logic @since ToongeePrime Theme 1.0.55
 */
if ( ! function_exists( 'prime2g_get_archive_loop_post_object' ) ) {
function prime2g_get_archive_loop_post_object( array $args ) {
$post	=	null;
$size	=	'large';
$excerpt=	true;
$length	=	25;
$metas	=	true;
$footer	=	false;
$tag	=	'h2';
$readmore	=	' - Read more';
$entryClasses	=	'';
$switch_img_vid	=	false;

extract( $args );

if ( ! $post ) { global $post; }

if ( $switch_img_vid && prime2g_post_has_media_field( $post ) ) {

$title	=	$post->post_title;
$link	=	get_permalink( $post );

$entry	=	'<article id="entry-' . $post->ID . '" class="'. implode( ' ', get_post_class( $entryClasses, $post ) ) . '">';
$entry	.=	'<div class="entry_img">';

$entry	.=	prime2g_get_post_media_embed( '', $post );

$entry	.=	'</div>';
$entry	.=	'<div class="entry_text">';

if ( $metas )
	$entry	.=	prime2g_archive_post_top_filter_part( $post );

$entry	.=	'<a href="' . $link . '" title="Read this entry"><' . $tag . ' class="entry_title">' . $title . '</' . $tag . '></a>';

if ( $excerpt && ! is_attachment( $post->ID ) )
	$entry	.=	prime2g_post_excerpt( $length, $post, $readmore );

if ( $footer )
	$entry	.=	prime2g_archive_post_footer_filter_part();

	$entry	.=	prime2g_edit_entry_get( '<p class="edit-link edit-entry">', '</p>', $post );

$entry	.=	'</div>';
$entry	.=	'</article>';

}
else {
$data	=	[
	'imgSize' => $size, 'excerpt' => $excerpt, 'length' => $length,
	'metas' => $metas, 'footer' => $footer, 'tag' => $tag, 'readmore' => $readmore
];
	$entry	=	prime2g_get_archive_loop( $data );
}

return $entry;

}
}




/**
 *	Entry Titles-only Template
 *	@since ToongeePrime Theme 1.0.50
 */
if ( ! function_exists( 'prime2g_entry_titles_template' ) ) {
function prime2g_entry_titles_template( array $args ) {
$post	=	null;
$tag	=	'h3';
$class	=	'entry';
$class2	=	'entry_title';

extract( $args );

if ( ! $post ) { global $post; }

$title	=	$post->post_title;
$link	=	get_permalink( $post );

$div	=	'<div class="'. $class .'">
<a href="'. $link .'" title="'. $title .'"><'. $tag .' class="'. $class2 .'">'. $title .'</'. $tag .'></a>
</div>';

return $div;
}
}

