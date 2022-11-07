<?php defined( 'ABSPATH' ) || exit;

/**
 *	TAXONOMY IMAGE FIELD CLASS
 *	@ https://pluginrepublic.com/adding-an-image-upload-field-to-categories/
 */
class PRIME_TAXO_IMAGE_FLD {
public function __construct() {}


public function init() {
$taxonz	=	prime2g_taxonomies_with_archive_image();

	foreach( $taxonz as $taxx ) {
		add_action( $taxx . '_add_form_fields', array( $this, 'add_taxon_image' ), 10, 2 );
		add_action( 'created_' . $taxx, array( $this, 'save_taxon_image' ), 10, 2 );
		add_action( 'edited_' . $taxx, array( $this, 'updated_taxon_image' ), 10, 2 );
		add_action( $taxx . '_edit_form_fields', array( $this, 'update_taxon_image' ), 10, 2 );
	}
	add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
	add_action( 'admin_footer', array( $this, 'add_script' ) );
}


public function load_media() { wp_enqueue_media(); }


public function add_taxon_image( $taxonomy ) { ?>
<div class="form-field term-group">
	<label for="thumbnail_id"><?php _e( 'Term Image', PRIME2G_TEXTDOM ); ?></label>
	<input type="hidden" id="thumbnail_id" name="thumbnail_id" class="custom_media_url" value="">
<div id="taxon-image-wrapper"></div>
	<p>
		<input type="button" class="button button-secondary akw_tax_media_button" id="akw_tax_media_button" name="akw_tax_media_button" value="<?php _e( 'Add Image', PRIME2G_TEXTDOM ); ?>" />
		<input type="button" class="button button-secondary akw_tax_media_remove" id="akw_tax_media_remove" name="akw_tax_media_remove" value="<?php _e( 'Remove Image', PRIME2G_TEXTDOM ); ?>" />
	</p>
</div>
<?php
}


public function save_taxon_image( $term_id, $tt_id ) {
	if ( isset( $_POST['thumbnail_id'] ) && '' !== $_POST['thumbnail_id'] ) {
		$image	=	$_POST['thumbnail_id'];
		add_term_meta( $term_id, 'thumbnail_id', $image, true );
	}
}


public function update_taxon_image( $term, $taxonomy ) { ?>
<tr class="form-field term-group-wrap">
	<th scope="row">
		<label for="thumbnail_id"><?php _e( 'Term Image', PRIME2G_TEXTDOM ); ?></label>
	</th>
<td>
<?php $image_id	=	get_term_meta( $term->term_id, 'thumbnail_id', true ); ?>
	<input type="hidden" id="thumbnail_id" name="thumbnail_id" value="<?php echo $image_id; ?>">
<div id="taxon-image-wrapper">
	<?php if ( $image_id ) { echo wp_get_attachment_image( $image_id, 'thumbnail' ); } ?>
</div>
	<p>
		<input type="button" class="button button-secondary akw_tax_media_button" id="akw_tax_media_button" name="akw_tax_media_button" value="<?php _e( 'Add Image', PRIME2G_TEXTDOM ); ?>" />
		<input type="button" class="button button-secondary akw_tax_media_remove" id="akw_tax_media_remove" name="akw_tax_media_remove" value="<?php _e( 'Remove Image', PRIME2G_TEXTDOM ); ?>" />
	</p>
</td>
</tr>
<?php
}


public function updated_taxon_image( $term_id, $tt_id ) {
if ( isset( $_POST['thumbnail_id'] ) && '' !== $_POST['thumbnail_id'] ) {
	$image	=	$_POST['thumbnail_id'];
	update_term_meta( $term_id, 'thumbnail_id', $image );
} else {
	update_term_meta( $term_id, 'thumbnail_id', '' );
}
}


public function add_script() { ?>
<script id="akawey_taxonomyImageField">
jQuery(document).ready( function($){
function ct_media_upload(button_class){
var _custom_media = true,
_orig_send_attachment = wp.media.editor.send.attachment;
$('body').on('click', button_class, function(e){
var button_id = '#'+$(this).attr('id');
var send_attachment_bkp = wp.media.editor.send.attachment;
var button = $(button_id);
_custom_media = true;
	wp.media.editor.send.attachment = function(props, attachment){
		if ( _custom_media ){
			$('#thumbnail_id').val(attachment.id);
			$('#taxon-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
			$('#taxon-image-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
		}
		else{
			return _orig_send_attachment.apply( button_id, [props, attachment] );
		}
	}
	wp.media.editor.open(button);
return false;
});
}
ct_media_upload('.akw_tax_media_button.button'); 
$('body').on('click','.akw_tax_media_remove',function(){
	$('#thumbnail_id').val('');
	$('#taxon-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
});
// Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-taxon-ajax-response
$(document).ajaxComplete(function(event, xhr, settings){
var queryStringArr = settings.data.split('&');
	if ( $.inArray('action=add-tag', queryStringArr) !== -1 ){
	var xml = xhr.responseXML;
	$response = $(xml).find('term_id').text();
		if ($response!=""){
		// Clear the thumb image
			$('#taxon-image-wrapper').html('');
		}
	}
});
});
</script>
<?php
}

}

$PRIME_TAXO_IMAGE_FLD	=	new PRIME_TAXO_IMAGE_FLD();
$PRIME_TAXO_IMAGE_FLD->init();
