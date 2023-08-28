<?php defined( 'ABSPATH' ) || exit;

/**
 *	GENERAL CUSTOM FIELDS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	DISPLAY SUBTITLE
 */
add_action( 'prime2g_after_title', 'prime2g_post_subtitle', 2 );

if ( ! function_exists( 'prime2g_post_subtitle' ) ) {
function prime2g_post_subtitle( $post = null ) {
if ( ! $post instanceof WP_Post ) {
global $post;
}

$postSubtitle	=	$post->post_subtitle;
if ( $postSubtitle )
	echo "<h3 class=\"post-subtitle\">$postSubtitle</h3>";

}
}


/**
 *	METABOXES
 *	Fields Set 1
 */
add_action( 'add_meta_boxes', 'prime2g_reg_fieldset_1' );
if ( ! function_exists( 'prime2g_add_meta_boxes' ) ) {
function prime2g_reg_fieldset_1() {
	add_meta_box(
		'prime2g_fieldsbox_1',
		__( 'Page Options', PRIME2G_TEXTDOM ),
		'prime2g_cFields_metadivs',
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
	if ( $parent_id	=	wp_is_post_revision( $post_id ) ) {
		$post_id	=	$parent_id;
	}
	$fields	=	[
		'post_subtitle',
		'remove_sidebar',
		'remove_header',
		'page_width',
		'disable_autop',
		'use_main_nav_location',
	];
	foreach( $fields as $field ) {
		if ( array_key_exists( $field, $_POST ) ) {
		update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
		}
	}
}
}



//Custom Fields Admin Form
function prime2g_cFields_metadivs( $post ) { ?>
<div class="prime2g_meta_box">

	<style>
		#prime2g_fieldsbox_1{box-shadow:0px 3px 5px #ccc;}
		#prime2g_fieldsbox_1:hover{box-shadow:0px 3px 5px #aaa;}
		.prime2g_meta_box{display:grid;gap:10px;}
		.prime2g_meta_box input,.prime2g_meta_box select,.prime2g_meta_box textarea{border-radius:0;}
		.prime2g_field{display:contents;}
		.prime2g_meta_box label{font-weight:bold;}
		.hide{display:none;}
		.checkboxes{display:flex;gap:5px;}
		.checkboxes label{font-weight:normal;margin-top:-6px;}
		.hr{border-bottom:1px solid;margin:15px 0;display:block;}
	</style>

<?php if ( prime2g_exclude_post_types() ) { ?>

	<div class="meta-options prime2g_field">
		<label for="post_subtitle">Post Subtitle</label>
<input id="post_subtitle" type="text" class="prime2g_admintext" name="post_subtitle" placeholder="A Subtitle for this Entry"
value="<?php echo esc_attr( $post->post_subtitle ); ?>"
/>
	</div>

<?php } ?>

	<div class="meta-options prime2g_field">
		<label for="page_width">Page Width</label>
		<select id="page_width" class="prime2g_options" name="page_width">
			<option value="default_post_width">Default Width</option>
			<option value="post_narrow" <?php if ( $post->page_width == 'post_narrow' ) echo 'selected'; ?>>Narrow</option>
			<option value="post_wide" <?php if ( $post->page_width == 'post_wide' ) echo 'selected'; ?>>Wide</option>
			<option value="post_w100vw" <?php if ( $post->page_width == 'post_w100vw' ) echo 'selected'; ?>>Full Width</option>
			<option value="post_wstretch" <?php if ( $post->page_width == 'post_wstretch' ) echo 'selected'; ?>>Stretched</option>
		</select>
	</div>

<?php
$removeSidebar	=	get_theme_mod( 'prime2g_remove_sidebar_in_singular' );
if ( ( ! $removeSidebar || $removeSidebar === 'pages_only' ) && $post->post_type !== 'page'
	|| $post->post_type === 'page' && ! in_array( $removeSidebar, [ 'and_pages', 'pages_only' ] ) ) { ?>

	<div class="meta-options prime2g_field">
		<label for="remove_sidebar">Remove Sidebar?</label>
		<select id="remove_sidebar" class="prime2g_options" name="remove_sidebar">
			<option>--- Keep Sidebar ---</option>
			<option value="remove" <?php if ( $post->remove_sidebar == 'remove' ) echo 'selected'; ?>>Remove Sidebar</option>
		</select>
	</div>

<?php } ?>

	<div class="meta-options prime2g_field">
		<label for="remove_header">Remove Header?</label>
		<select id="remove_header" class="prime2g_options" name="remove_header">
			<option>--- Keep Header ---</option>
			<option value="remove" <?php if ( $post->remove_header == 'remove' ) echo 'selected'; ?>>Remove Header</option>
		</select>
	</div>


<hr class="hr" />

	<div class="meta-options prime2g_field">
		<label for="disable_autop">Content Auto P (Advanced)</label>
		<select id="disable_autop" class="prime2g_options" name="disable_autop">
			<option>--- Leave Active ---</option>
			<option value="disable" <?php if ( $post->disable_autop == 'disable' ) echo 'selected'; ?>>Disable</option>
		</select>
	</div>

<?php
/**
 *	@since ToongeePrime Theme 1.0.55
 */
if ( defined( 'CHILD2G_VERSION' ) && CHILD2G_VERSION >= '2.2' && get_theme_mod( 'prime2g_extra_menu_locations' ) ) {
$nav_menus	=	get_registered_nav_menus(); ?>

	<div class="meta-options prime2g_field">
		<label for="use_main_nav_location">Select Menu Location</label>
		<select id="use_main_nav_location" class="prime2g_options" name="use_main_nav_location">
			<option value="">--- Leave Default ---</option>
			<?php foreach ( $nav_menus as $slug => $name ) { ?>
			<option value="<?php echo $slug; ?>"
			<?php if ( $post->use_main_nav_location === $slug ) echo 'selected'; ?>>
			<?php echo $name; ?>
			</option>
			<?php } ?>
		</select>
	</div>
<?php } ?>

</div>
<?php

}






/**
 *	FOR THEME'S TEMPLATE PARTS
 *	@since ToongeePrime Theme 1.0.50
 */
add_action( 'add_meta_boxes', 'prime2g_template_part_boxes' );
function prime2g_template_part_boxes() {
	add_meta_box(
		'prime2g_fieldsbox_2',
		__( 'Shortcode', PRIME2G_TEXTDOM ),
		'prime2g_cFields_metadivs2',
		'prime_template_parts',
		'side',
		'high'
	);
}

function prime2g_cFields_metadivs2( $post ) {

if ( $post->post_type == 'prime_template_parts' ) {
if ( $post->post_status === 'publish' ) { ?>

	<div class="meta-options">
		<h3>Use this shortcode:</h3>
		<p>[prime_insert_template_part id="<?php echo get_the_ID(); ?>"]</p>
	</div>

<?php
}
else { ?>
	<div class="meta-options"> <h4>Publish this Part to get the shortcode</h4> </div>
<?php
}
}

}

