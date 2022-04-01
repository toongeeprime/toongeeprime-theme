<?php defined( 'ABSPATH' ) || exit;

/**
 *	GENERAL CUSTOM FIELDS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	HELPERS
 */

if ( ! function_exists( 'prime2g_include_post_types' ) ) {
	function prime2g_include_post_types( array $addTo = [ 'post', 'page' ] ) {
		return $addTo;
	}
}

if ( ! function_exists( 'prime2g_exclude_post_types' ) ) {
	function prime2g_exclude_post_types( array $pTypes = [ 'page' ] ) {
		return ( ! in_array( get_post_type(), $pTypes ) );
	}
}
/*****	Helpers End	*****/


/**
 *	METABOXES
 */

/**
 *	DISPLAY SUBTITLE
 */
add_action( 'prime2g_after_title', 'post_subtitle' );

if ( ! function_exists( 'post_subtitle' ) ) {
function post_subtitle() {

$postSubtitle	=	post_custom( 'post_subtitle' );
if ( $postSubtitle )
	echo "<h3 class=\"post-subtitle\">$postSubtitle</h3>";

}
}


/**
 *	Fields Set 1
 */
add_action( 'add_meta_boxes', 'prime2g_reg_fieldset_1' );
if ( ! function_exists( 'prime2g_add_meta_boxes' ) ) {
function prime2g_reg_fieldset_1() {
	add_meta_box(
		'prime2g_fieldsbox_1',
		__( 'Subtitle', 'toongeeprime-theme' ),
		'toongeeprime_cFields_callback',
		prime2g_include_post_types(),
		'side',
		'high'
	);
}
}


/**
 *	Save meta box content
 *	@param int $post_id Post ID
 */
add_action( 'save_post', 'prime2g_save_metas_1' );
if ( ! function_exists( 'prime2g_save_metas_1' ) ) {
function prime2g_save_metas_1( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( $parent_id = wp_is_post_revision( $post_id ) ) {
		$post_id = $parent_id;
	}
	$fields = [
		'post_subtitle',
		'remove_sidebar',
		'page_width',
	];
	foreach( $fields as $field ) {
		if ( array_key_exists( $field, $_POST ) ) {
		update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
		}
	}
}
}



//Custom Fields Admin Form
function toongeeprime_cFields_callback( $post ) {
$pid = get_the_ID();
?>
<div class="prime2g_box">

	<style scoped>
		#prime2g_fieldsbox_1{box-shadow:0px 3px 5px #ccc;}
		#prime2g_fieldsbox_1:hover{box-shadow:0px 3px 5px #aaa;}
		.prime2g_box{display:grid;gap:10px;}
		.prime2g_field{display:contents;}
		.prime2g_box label{font-weight:bold;}
		.hide{display:none;}
	</style>

<?php if ( prime2g_exclude_post_types() ) { ?>

	<div class="meta-options prime2g_field">
		<label class="hide" for="post_subtitle">Post Subtitle</label>
<input id="post_subtitle" type="text" class="prime2g_admintext" name="post_subtitle" placeholder="A Subtitle for this Entry"
value="<?php echo esc_attr( get_post_meta( $pid, 'post_subtitle', true ) ); ?>"
/>
	</div>

<?php } ?>

	<div class="meta-options prime2g_field">
		<label for="remove_sidebar">Remove Sidebar?</label>
		<select id="remove_sidebar" class="prime2g_options" name="remove_sidebar">
			<option>--- Keep Sidebar ---</option>
			<option value="remove" <?php if( get_post_meta( $pid, 'remove_sidebar', true ) == 'remove' ) echo 'selected'; ?>>Remove Sidebar</option>
		</select>
	</div>

	<div class="meta-options prime2g_field">
		<label for="page_width">Page Width</label>
		<select id="page_width" class="prime2g_options" name="page_width">
			<option value="default_width">Default Width</option>
			<option value="width_960px" <?php if( get_post_meta( $pid, 'page_width', true ) == 'width_960px' ) echo 'selected'; ?>>Narrow</option>
			<option value="width_1250px" <?php if( get_post_meta( $pid, 'page_width', true ) == 'width_1250px' ) echo 'selected'; ?>>Wide</option>
			<option value="width_100vw" <?php if( get_post_meta( $pid, 'page_width', true ) == 'width_100vw' ) echo 'selected'; ?>>Full Width</option>
			<option value="width_stretch" <?php if( get_post_meta( $pid, 'page_width', true ) == 'width_stretch' ) echo 'selected'; ?>>Stretched</option>
		</select>
	</div>

</div>
<?php
}


add_filter( 'body_class', 'akw_template_options_body_classes' );
function akw_template_options_body_classes( $classes ) {
// Template vars
$page_width	=	post_custom( 'page_width' );

// Add Template Classes
if( $page_width && is_singular() && $page_width != 'default_width' ) {
	$classes[] = $page_width;
}

return $classes;
}


