<?php defined( 'ABSPATH' ) || exit;

/**
 *	PARTS IN THE LOOP
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */


/**
 *	Showing Sticky Posts
 */
add_action( 'prime2g_after_header', 'prime2g_show_sticky_posts' );
if ( ! function_exists( 'prime2g_show_sticky_posts' ) ) {
function prime2g_show_sticky_posts() {

// if sticky posts are to be shown
if ( 'show' == get_theme_mod( 'prime2g_theme_show_stickies' ) && ( is_home() || is_category() ) ) {

	// Get sticky posts
	$stickies = get_posts( array( 'include' => get_option( 'sticky_posts' ) ) );

	echo '<section id="stickies" class="stickies">';

	// The Heading
	echo '<h1 class="sticky_heading">' . get_theme_mod( 'prime2g_theme_sticky_heading' ) . '</h1>';

		echo '<div class="grid prel">';

		// Show only 4 posts
		for( $count=0; $count <= 3; $count++ ) {
			if ( array_key_exists( $count, $stickies ) )
				prime2g_post_object_template( $stickies[$count], 'medium' );
		}

		echo '</div>';
	echo '</section>';

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

$prevText	=	__( $prev, 'toongeeprime-theme' );
$nextText	=	__( $next, 'toongeeprime-theme' );

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

$prev	=	__( $prev, 'toongeeprime-theme' );
$next	=	__( $next, 'toongeeprime-theme' );

echo '<nav class="navigation archive prev_next">';

	posts_nav_link( $spepr, '<p class="nav-previous">' . $prev . '</p>', '<p class="nav-next">' . $next . '</p>' );

echo '</nav>';

}

}



/**
 *	Archive Post Entry Template
 */
if ( ! function_exists( 'prime2g_archive_loop' ) ) {

function prime2g_archive_loop( $size = 'large', $excerpt = true, $length = 25, $metas = true, $footer = true, $tag = 'h2' ) { ?>

<article id="entry-<?php echo get_the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry_img">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php
			if ( has_post_thumbnail() ) {
				echo '<div class="thumbnail" style="background-image:url(';
				the_post_thumbnail_url( $size );
				echo ');"></div>';
			}
			else {
				if ( child2g_has_placeholder() ) {
					echo '<div class="thumbnail" style="background-image:url(';
					child2g_placeholder_url();
					echo ');"></div>';
				}
				else {
					echo '<div class="thumbnail">'. get_the_title() .'</div>';
				}
			}
			?>
		</a>
	</div>
	<div class="entry_text">
		<?php
		if ( $metas ) prime2g_archive_post_top();

		echo "<a href=\"". get_the_permalink() ."\" title=\"Read this entry\"><$tag class=\"entry_title\">". get_the_title() ."</$tag></a>";

		if ( $excerpt && ! is_attachment() ) echo prime2g_post_excerpt( $length );

		if ( $footer ) prime2g_archive_post_footer();
		?>
	</div>

</article>

<?php
}

}




/**
 *	Post Object Template
 */
if ( ! function_exists( 'prime2g_post_object_template' ) ) {
function prime2g_post_object_template( $object, $size = 'large' ) {

$id		=	$object->ID;
$title	=	$object->post_title;

echo '<article id="entry-'. $id .'" class="'. implode( ' ', get_post_class( '', $id ) ) .'">';
echo '<div>';
echo '<a href="'. get_permalink( $id ) .'" title="'. $title .'">';

	if ( get_the_post_thumbnail_url( $id ) ) {
		echo '<div class="thumbnail" style="background-image:url(';
		echo get_the_post_thumbnail_url( $id, $size );
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

echo '</a></div><div class="entry_text">';
echo '<a href="'. get_permalink( $id ) .'" title="Read this entry"><h2 class="entry_title">'. $title .'</h2></a>';
prime2g_archive_post_footer();
echo '</div>';
echo '</article>';

}
}




/**
 *	Search Results Entry Template
 */
if ( ! function_exists( 'prime2g_search_loop' ) ) {

function prime2g_search_loop() { ?>

<article id="entry-<?php echo get_the_ID(); ?>" <?php post_class( 'search grid' ); ?>>

	<div>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
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
					echo '<div class="thumbnail">'. get_the_title() .'</div>';
				}
			}
			?>
		</a>
	</div>
	<div class="entry_text">

		<a href="<?php the_permalink(); ?>" title="Read this entry"><h3 class="search_result_title"><?php the_title(); ?></h3></a>
		<?php echo prime2g_post_excerpt(); ?>

	</div>

</article>

<?php
}

}



