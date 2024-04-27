<?php defined( 'ABSPATH' ) || exit;

/**
 *	MEDIA or POSTS GALLERY
 *	@since ToongeePrime Theme 1.0.80
 */

/**
 *	@since 1.0.84
 *		If using a content source other than posts or $gallery_image_ids,
 *		set shortcode param $gallery_content to 'other'
 *		then use $looptemplate to provide the content
 */
function prime2g_gallery_post_template( $entry, $looptemplate, $img_url, $snum, array $classes = [ 'gItem', 'gallery_media' ] ) {
	$classes[]	=	'item_'. $snum;

	if ( $entry instanceof WP_Post ) {
		if ( ! $looptemplate ) {
			$link	=	get_permalink( $entry );
			$template	=	'<div class="'. implode( ' ', $classes ) .'">
			<a href="'. $link .'" title="'. $entry->post_title .'"><img src="'. $img_url .'" /></a>
			</div>';
		}
		else {
			$template	=	function_exists( 'looptemplate' ) ? $looptemplate :
			prime2g_get_archive_loop_post_object( [
				'post' => $entry, 'entryClasses' => $classes,
				'footer' => false, 'metas' => false, 'excerpt' => false, 'edit_link' => false
			] );
		}
	}
	else {
		$template	=	$looptemplate ? $looptemplate( [ 'entry' => $entry, 'entryClasses' => $classes ] ) : __( '<p class="gallery_media gallery_thumb item_1">No template provided</p>', PRIME2G_TEXTDOM );
	}
return $template;
}




add_shortcode( 'prime2g_media_gallery', 'prime2g_media_or_posts_gallery' );
function prime2g_media_or_posts_gallery( $atts = [] ) {
$atts	=	array_merge( prime2g_get_posts_output_default_options(),
[
'image_size'	=>	'large',
'get'			=>	'posts',
'gallery_title'	=>	'Media Gallery',
'gallery_image_ids'	=>	'',
'gallery_template'	=>	'1',
'default_gallery_css'	=>	'yes',
'hide_gallery'		=>	'',		//	@since 1.0.83
'gallery_content'	=>	''		//	@since 1.0.84
],
$atts
);

extract( $atts );

$hide_gallery	=	$hide_gallery === 'yes' ? true : false;
$hide_galleryJS	=	$hide_gallery ? 'true' : 'false';	//	string for js

//	Providing Image IDs will supersede
$use_img_ids	=	! empty( $gallery_image_ids );
$otherContentSource	=	$gallery_content === 'other' ?: false;

if ( $use_img_ids ) {

	$urls	=	prime2g_media_urls_by_ids( $gallery_image_ids, $image_size );
	$num	=	count( $urls );

}
else if ( $otherContentSource ) {

	//	:array @$looptemplate required if $otherContentSource
	//	must return urls array using param 'get' => 'image_urls'
	$urls	=	$looptemplate ? $looptemplate( [ 'get' => 'image_urls', 'size' => $image_size ] ) :
				__( '<p>No template for images</p>', PRIME2G_TEXTDOM );
	$num	=	is_array( $urls ) ? count( $urls ) : 1;

}
else {

	$query	=	prime2g_get_posts_output( $atts );	//	$get === 'posts' :array
	if ( ! is_array( $query ) ) {
		return current_user_can( 'edit_posts' ) ? __( 'Cannot display posts, please review shortcode', PRIME2G_TEXTDOM ) : '';
	}
	$urls	=	[];
	foreach ( $query as $post ) {
		$urls[]	=	wp_get_attachment_image_url( get_post_thumbnail_id( $post ), $image_size ) ?: prime2g_get_placeholder_url();
	}
	$num	=	$count;

}

$prevw	=	'<div class="previewScroll slimscrollbar scrollX" style="padding:var(--min-pad) 0;">
<div class="p2_media_gallery_btns">';

for ( $p = 0; $p < $num; $p++ ) {
	if ( isset( $urls[$p] ) ) {
		$pp	=	$p+1;
		$media_item_div2	=	'<div class="gItem centered preview_thumb thumb_'. $pp .' item_'. $pp .'" style="background-image:url('. $urls[$p] .');"></div>';

		if ( $gallery_template === '2' ) {
			if ( $use_img_ids ) {
				$prevw	.=	$media_item_div2;
			}
			else {
				$post	=	$otherContentSource ? $p : $query[$p];
				$prevw	.=	prime2g_gallery_post_template( $post, $looptemplate, $urls[$p], $pp, [ 'gItem', 'preview_thumb', 'thumb_'. $pp ] );
			}
		}
		else {
			$prevw	.=	$media_item_div2;
		}
	}
}

$prevw	.=	'</div>
</div><!-- .scrollX -->';


$lightbox	=	'<div class="p2_media_gallery_wrap g_hide">
<div class="p2_media_gallery prel">';

$lightbox	.=	$gallery_title ? '<h2 id="p2_gallery_title">'. $gallery_title .'</h2>' : '';

if ( $hide_gallery ) {
$lightbox	.=	'<div class="p-abso" onclick="p2GalleryOff();" style="display:inline-block;top:10px;right:10px;z-index:1000;">
<i class="bi bi-x-lg" style="font-size:1.5rem;"></i></div>';
}

$lightbox	.=	'<div class="gallery_screen prel slimscrollbar">';

for ( $g = 0; $g < $num; $g++ ) {
	if ( isset( $urls[$g] ) ) {
		$gg	=	$g+1;

		$media_item_div	=	'<div class="gItem gallery_media item_'. $gg .'"><img src="'. $urls[$g] .'" /></div>';

		if ( $gallery_template === '1' ) {
			if ( $use_img_ids ) {
				$lightbox	.=	$media_item_div;
			}
			else {
				$post	=	$otherContentSource ? $g : $query[$g];
				$lightbox	.=	prime2g_gallery_post_template( $post, $looptemplate, $urls[$g], $gg );
			}
		}
		else {
			$lightbox	.=	$media_item_div;
		}
	}
}

$lightbox	.=	'</div><!-- .gallery_screen -->';


$lightbox	.=	'<div id="dataStrip" class="flex w100pc">
<div>
<span id="elNum" class="dataCounts">1</span> of <span id="allNum" class="dataCounts"></span>
</div>
</div>';


$lightbox	.=	'<div class="thumbsScroll slimscrollbar scrollX"><div class="thumbs_strip flex prel">';

for ( $u = 0; $u < $num; $u++ ) {
	if ( isset( $urls[$u] ) ) {
		$uu	=	$u+1;
		$media_item_div3	=	'<div class="gItem gallery_thumb thumb_'. $uu .' item_'. $uu .'" style="background-image:url('. $urls[$u] .');"></div>';

		if ( $gallery_template === '3' ) {
			if ( $use_img_ids ) {
				$lightbox	.=	$media_item_div3;
			}
			else {
				$post	=	$otherContentSource ? $u : $query[$u];
				$lightbox	.=	prime2g_gallery_post_template( $post, $looptemplate, $urls[$u], $uu, [ 'gItem', 'gallery_thumb', 'thumb_'. $uu ] );
			}
		}
		else {
			$lightbox	.=	$media_item_div3;
		}
	}
}

$lightbox	.=	'</div><!-- .thumbs_strip --></div>

</div><!-- .p2_media_gallery -->

<i class="p-abso dirBtn left bi bi-chevron-left" onclick="p2SwipeGallery( \'left\' );"></i>
<i class="p-abso dirBtn right bi bi-chevron-right" onclick="p2SwipeGallery( \'right\' );"></i>

</div>';

wp_reset_postdata();	// leave here at the end!

if ( $default_gallery_css === 'yes' ) echo prime2g_media_gallery_css( $gallery_template );

add_action( 'wp_footer', function() use( $hide_galleryJS ) { echo prime2g_media_gallery_js( $hide_galleryJS ); } );

$imgIDsClass	=	$use_img_ids ? 'imageIDs' : '';

return '<section id="" class="gallery_box prel template_'. $gallery_template .' '. $imgIDsClass .'">'
. $prevw . $lightbox .
'</section>';
}


