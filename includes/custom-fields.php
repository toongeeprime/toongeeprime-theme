<?php defined( 'ABSPATH' ) || exit;

/**
 *	GENERAL CUSTOM FIELDS
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	DETERMINE POST TYPES FOR CUSTOM FIELDS
 *	@since ToongeePrime Theme 1.0.70
 */
if ( ! function_exists( 'prime2g_fields_in_post_types' ) ) {
function prime2g_fields_in_post_types() {
return (object) [
	'prime_fields1'		=>	[ 'post', 'page' ],
	'settings_fields'	=>	[ 'post', 'page' ],
	'extras_fields'		=>	[ 'post', 'page', 'prime_template_parts' ],
	'fields1_excludes'	=>	[ 'page' ]
];
}
}


/* DISPLAY SUBTITLE */
add_action( 'prime2g_after_title', 'prime2g_post_subtitle', 2 );
if ( ! function_exists( 'prime2g_post_subtitle' ) ) {
function prime2g_post_subtitle( $post = null ) {
if ( ! $post instanceof WP_Post ) { global $post; }
$postSubtitle	=	$post->post_subtitle;
if ( $postSubtitle )
	echo "<h3 class=\"post-subtitle\">$postSubtitle</h3>";
}
}


/**
 *	METABOXES CSS
 *	@since ToongeePrime Theme 1.0.58
 */
function prime2g_custom_mbox_css() {
if ( ! defined( 'PRIME_ADD_CMETABOX_CSS' ) ) { ?>
#prime2g_settings_fields{box-shadow:0px 3px 5px #ccc;}
#prime2g_settings_fields:hover{box-shadow:0px 3px 5px #aaa;}
.prime2g_meta_box{display:grid;gap:10px;}
.prime2g_meta_box input,.prime2g_meta_box select,.prime2g_meta_box textarea{border-radius:0;}
.prime2g_field{display:contents;}
.prime2g_meta_box label{font-weight:bold;}
.hide{display:none;}
.checkboxes label{font-weight:normal;}
.hr{border-bottom:1px solid;margin:15px 0;display:block;}
<?php
define( 'PRIME_ADD_CMETABOX_CSS', true );
}
}


/**
 *	SAVE ALL THEME CUSTOM FIELDS
 *	@param int $post_id Post ID
 */
add_action( 'save_post', 'prime2g_save_theme_custom_fields' );
if ( ! function_exists( 'prime2g_save_theme_custom_fields' ) ) {
function prime2g_save_theme_custom_fields( $post_id ) {
if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

if ( $parent_id	=	wp_is_post_revision( $post_id ) ) {
	$post_id	=	$parent_id;
}
$fields	=	[
	'post_subtitle', 'remove_sidebar', 'remove_header', 'page_width', 'video_url',
	'disable_autop', 'use_main_nav_location', 'prevent_caching', 'font_url', 'enqueue_jquery'
];
foreach( $fields as $field ) {
	if ( array_key_exists( $field, $_POST ) ) {
	update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
	}
}

}
}



/**
 *	METABOXES
 *	Fields Set 1
 */
add_action( 'add_meta_boxes', 'prime2g_meta_fieldset_1' );
if ( ! function_exists( 'prime2g_meta_fieldset_1' ) ) {
function prime2g_meta_fieldset_1() {
	add_meta_box(
		'prime2g_prime_fields1', __( 'Page Options', PRIME2G_TEXTDOM ),
		'prime2g_cFields_metadivs', prime2g_fields_in_post_types()->prime_fields1, 'side', 'high'
	);
}
}


#	Custom Fieldset 1
function prime2g_cFields_metadivs( $post ) { ?>
<div class="prime2g_meta_box">

<style>
	#prime2g_prime_fields1{box-shadow:0px 3px 5px #ccc;}
	#prime2g_prime_fields1:hover{box-shadow:0px 3px 5px #aaa;}
	<?php prime2g_custom_mbox_css(); ?>
</style>

<?php if ( prime2g_fields_in_post_types()->fields1_excludes ) { ?>

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
		<option value="post_narrow" <?php if ( $post->page_width === 'post_narrow' ) echo 'selected'; ?>>Narrow</option>
		<option value="post_wide" <?php if ( $post->page_width === 'post_wide' ) echo 'selected'; ?>>Wide</option>
		<option value="post_w100vw" <?php if ( $post->page_width === 'post_w100vw' ) echo 'selected'; ?>>Full Width</option>
		<option value="post_wstretch" <?php if ( $post->page_width === 'post_wstretch' ) echo 'selected'; ?>>Stretched</option>
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
		<option value="remove" <?php if ( $post->remove_sidebar === 'remove' ) echo 'selected'; ?>>Remove Sidebar</option>
	</select>
</div>

<?php } ?>

<div class="meta-options prime2g_field">
	<label for="remove_header">Remove Default Header?</label>
	<select id="remove_header" class="prime2g_options" name="remove_header">
		<option>--- Keep Header ---</option>
		<option value="remove" <?php if ( $post->remove_header === 'remove' ) echo 'selected'; ?>>Remove Header Completely</option>
		<option value="header_image_css" <?php if ( $post->remove_header === 'header_image_css' ) echo 'selected'; ?>>Use Header Image CSS</option>
	</select>
</div>


<hr class="hr" />

<h3>Advanced</h3>

<div class="meta-options prime2g_field">
	<label for="disable_autop">Content Auto P</label>
	<select id="disable_autop" class="prime2g_options" name="disable_autop">
		<option>--- Leave Active ---</option>
		<option value="disable" <?php if ( $post->disable_autop === 'disable' ) echo 'selected'; ?>>Disable</option>
	</select>
</div>

<!-- @since 1.0.70 -->
<div class="meta-options prime2g_field">
	<label for="enqueue_jquery">Enqueue jQuery?</label>
	<select id="enqueue_jquery" class="prime2g_options" name="enqueue_jquery">
		<option>--- No ---</option>
		<option value="yes" <?php if ( $post->enqueue_jquery === 'yes' ) echo 'selected'; ?>>Yes</option>
	</select>
</div>

<?php
/**
 *	@since 1.0.55
 */
if ( prime_child_min_version( '2.2' ) && get_theme_mod( 'prime2g_extra_menu_locations' ) ) {
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
 *	@since 1.0.50
 */
add_action( 'add_meta_boxes', 'prime2g_template_part_boxes' );
function prime2g_template_part_boxes() {
add_meta_box(
	'prime2g_fieldsbox_2', __( 'Shortcode', PRIME2G_TEXTDOM ),
	'prime2g_cFields_metadivs2', 'prime_template_parts', 'side', 'high'
);
}

function prime2g_cFields_metadivs2( $post ) {

if ( $post->post_type === 'prime_template_parts' ) {
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



/**
 *	SETTINGS
 *	cache control, ++
 *	@since 1.0.58
 */
add_action( 'add_meta_boxes', 'prime2g_mBox_for_settings' );
function prime2g_mBox_for_settings() {
$cache_on	=	! empty( get_theme_mod( 'prime2g_activate_chache_controls' ) );
if ( ! $cache_on ) return;	# Until other settings are added

$pType_obj	=	get_post_type_object( get_post_type() );
$pType_name	=	$pType_obj->labels->singular_name;

add_meta_box(
	'prime2g_settings_fields', __( $pType_name . ' Settings', PRIME2G_TEXTDOM ),
	'prime2g_settings_control_callback', prime2g_fields_in_post_types()->settings_fields, 'side', 'high'
);
}

function prime2g_settings_control_callback( $post ) {
$pType_obj	=	get_post_type_object( $post->post_type );
$pType_name	=	$pType_obj->labels->singular_name;
?>
<div class="prime2g_meta_box">
<style>
	#prime2g_settings_fields{box-shadow:0px 3px 5px #ccc;}
	#prime2g_settings_fields:hover{box-shadow:0px 3px 5px #aaa;}
	<?php prime2g_custom_mbox_css(); ?>
</style>

<div class="meta-options prime2g_field">
	<label for="prevent_caching">Cache This <?php echo $pType_name; ?></label>
	<select id="prevent_caching" name="prevent_caching">
		<option>-- Yes, Keep Cache System --</option>
		<option value="prevent" <?php if ( $post->prevent_caching === 'prevent' ) echo 'selected'; ?>>Prevent Caching</option>
	</select>
</div>

</div>
<?php
}





/**
 *	@since 1.0.60
 */
add_action( 'add_meta_boxes', 'prime2g_theme_extras_fieldset' );
if ( ! function_exists( 'prime2g_theme_extras_fieldset' ) ) {
function prime2g_theme_extras_fieldset() {
add_meta_box(
	'prime2g_extras_fields', __( 'Style Extras', PRIME2G_TEXTDOM ),
	'prime2g_field_extras_callback', prime2g_fields_in_post_types()->extras_fields, 'normal', 'high'
);
}
}

function prime2g_field_extras_callback( $post ) { ?>
<div class="prime2g_meta_box">
<style>
	#prime2g_extras_fields{box-shadow:0px 3px 5px #ccc;}
	#prime2g_extras_fields:hover{box-shadow:0px 3px 5px #aaa;}
	<?php prime2g_custom_mbox_css(); ?>
</style>

<div class="meta-options prime2g_field">
	<label for="font_url">Google Font URL</label>
	<input type="url" id="font_url" name="font_url" value="<?php echo esc_url( $post->font_url ); ?>">
</div>

</div>
<?php
}
