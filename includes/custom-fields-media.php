<?php defined( 'ABSPATH' ) || exit;

/**
 *	MEDIA FIELDS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme Theme 1.0.55
 */

add_action( 'add_meta_boxes', 'prime2g_mediafields_boxes' );
function prime2g_mediafields_boxes() {
if ( prime2g_video_features_active() ) {
add_meta_box(
	'prime2g_media_cfields', __( 'Media', PRIME2G_TEXTDOM ),
	'prime2g_mediacfields_metadivs',
	prime2g_posttypes_with_video_features(),
	'normal', 'high'
);
}
}

#	Field is saved @ custom-fields.php

function prime2g_mediacfields_metadivs( $post ) { ?>
<div class="prime2g_meta_box">
<style>
	#prime2g_media_cfields{box-shadow:0px 3px 5px #ccc;}
	#prime2g_media_cfields:hover{box-shadow:0px 3px 5px #aaa;}
	<?php prime2g_custom_mbox_css(); ?>
</style>
<div class="meta-options prime2g_field">
	<label for="video_url">Video URL</label>
	<input type="url" name="video_url" id="video_url" value="<?php echo esc_url( $post->video_url ); ?>" />
</div>
</div>
<?php
}


