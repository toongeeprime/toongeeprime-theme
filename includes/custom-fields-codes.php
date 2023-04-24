<?php defined( 'ABSPATH' ) || exit;

/**
 *	CSS, JS codes & Google Fonts
 *	via CUSTOM FIELDS
 *	- for enabled Templates
 */


/**
 *	Fields Set 2
 */
add_action( 'add_meta_boxes', 'prime2g_reg_fieldset_2' );
if ( ! function_exists( 'prime2g_reg_fieldset_2' ) ) {
function prime2g_reg_fieldset_2() {
	add_meta_box(
	'prime2g_fieldsbox_2',
	__( 'Page Codes (Advanced)', PRIME2G_TEXTDOM ),
	'toongeeprime_cFields_callback_2',
	prime2g_include_post_types(),
	'normal',
	'high'
);
}
}


/**
 *	Save meta box content
 */
add_action( 'save_post', 'prime2g_save_metas_2' );
if ( ! function_exists( 'prime2g_save_metas_2' ) ) {
function prime2g_save_metas_2( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( $parent_id	=	wp_is_post_revision( $post_id ) ) {
		$post_id	=	$parent_id;
	}
	$fields	=	[
		'prime_page_css',
		'prime_page_js',
	];
	foreach ( $fields as $field ) {
		if ( array_key_exists( $field, $_POST ) ) {
			update_post_meta( $post_id, $field, wp_strip_all_tags( $_POST[ $field ] ) );
		}
	}
}
}


/**
 *	Custom Fields Form
 */
function toongeeprime_cFields_callback_2( $post ) { ?>
<div class="prime2g_meta_box">
	<style scoped>
		#prime2g_fieldsbox_2{box-shadow:0px 3px 5px #ccc;}
		#prime2g_fieldsbox_2:hover{box-shadow:0px 3px 5px #aaa;}
	</style>

    <div class="meta-options prime2g_field">
		<label for="prime_page_css">CSS</label>
<textarea id="prime_page_css" class="toongeeprime_admintextarea" name="prime_page_css" rows="5" placeholder="Do not include <style> tags">
<?php echo $post->prime_page_css; ?>
</textarea>
	</div>

	<div class="meta-options prime2g_field">
		<label for="prime_page_js">JavaScript</label>
<textarea id="prime_page_js" class="toongeeprime_admintextarea" name="prime_page_js" rows="5" placeholder="Do not include <script> tags">
<?php echo $post->prime_page_js; ?>
</textarea>
	</div>
</div>
<?php
}




/**
 *	Get and embed Codes for custom a post type design
 */
add_action( 'prime2g_before_post', 'prime2g_pageCSS', 2 );
function prime2g_pageCSS() {
$style	=	post_custom( 'prime_page_css' );

	if ( $style ) {
		echo '<style id="prime2g_pageCSS" type="text/css">' . $style . '</style>';
	}
}


add_action( 'prime2g_after_post', 'prime2g_pageJS', 50 );
function prime2g_pageJS() {
$script	=	post_custom( 'prime_page_js' );

	if ( $script ) {
		echo '<script id="prime2g_pageJS" type="text/javascript">' . $script . '</script>';
	}
}


