<?php defined( 'ABSPATH' ) || exit;
/**
 *	GENERAL CUSTOM FIELDS
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */
/**
 *	DETERMINE POST TYPES FOR CUSTOM FIELDS
 *	@since 1.0.70
 */
if ( ! function_exists( 'prime2g_fields_in_post_types' ) ) {
function prime2g_fields_in_post_types() {
return (object) [
	'prime_fields1'		=>	[ 'post', 'page', 'landing_page' ],
	'settings_fields'	=>	[ 'post', 'page' ],
	'extras_fields'		=>	[ 'post', 'page', 'prime_template_parts' ],
	'fields1_excludes'	=>	[ 'page' ]
];
}
}


/**
 *	DO OUTPUTS
 */
add_action( 'prime2g_after_title', 'prime2g_post_subtitle', 2 );
if ( ! function_exists( 'prime2g_post_subtitle' ) ) {
function prime2g_post_subtitle( $post = null ) {
if ( ! $post instanceof WP_Post ) { global $post; }
$postSubtitle	=	$post->post_subtitle;
if ( $postSubtitle )
	echo "<h3 class=\"post-subtitle\">$postSubtitle</h3>";
}
}

add_action( 'wp_footer', 'prime2g_pageJS', 100 );
function prime2g_pageJS() {
$script	=	post_custom( 'prime_page_js' );
if ( $script ) { echo '<script id="prime2g_pageJS">'. $script .'</script>'; }
}




/**
 *	METABOXES CSS
 *	@since 1.0.58, include <style> tags @since 1.0.73
 */
function prime2g_custom_mbox_css() {
if ( ! defined( 'PRIME_ADD_CMETABOX_CSS' ) ) {
define( 'PRIME_ADD_CMETABOX_CSS', true ); ?>
<style id="prime2gMetaBoxCSS">
.prime2g_postbox{box-shadow:0px 3px 5px #ccc;}
.prime2g_postbox:hover{box-shadow:0px 3px 5px #aaa;}
.prime2g_meta_box{display:grid;gap:10px;}
.prime2g_meta_box input,.prime2g_meta_box select,.prime2g_meta_box textarea{border-radius:0;}
.prime2g_field{display:contents;}
.prime2g_meta_box label{font-weight:bold;}
.hide{display:none;}
.checkboxes label{font-weight:normal;}
.hr{border-bottom:1px solid;margin:15px 0;display:block;}
<?php echo prime2g_admin_metabox_css(); ?>
</style>
<?php
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
	'post_subtitle', 'remove_sidebar', 'remove_header', 'remove_footer', 'page_width', 'video_url',
	'prime_page_js', 'font_url', 'use_main_nav_location'
];
foreach( $fields as $field ) {
	if ( array_key_exists( $field, $_POST ) ) {
		update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
	}
}

/**
 *	Fixed Select Field issues with JS and below code
 *	Changed some fields to checkboxes
 *	@since 1.0.89
 */
$checkboxes	=	[
	'exclude_from_search', 'disable_autop', 'prevent_caching', 'enqueue_jquery', 'page_is_public'
];
foreach( $checkboxes as $field ) {
	delete_post_meta( $post_id, $field );
	if ( isset( $_POST[ $field ] ) ) { add_post_meta( $post_id, $field, $_POST[ $field ] ); }
	// else { delete_post_meta( $post_id, $field ); }
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
$obj	=	get_post_type_object( get_post_type() );
$name	=	$obj->labels->singular_name;
	add_meta_box(
		'prime2g_prime_fields1', __( $name . ' Options', PRIME2G_TEXTDOM ),
		'prime2g_fields_side_box', prime2g_fields_in_post_types()->prime_fields1, 'side', 'high'
	);
}
}


#	Custom Fieldset 1
function prime2g_fields_side_box( $post ) {
$obj	=	get_post_type_object( $post->post_type );
$pType	=	$obj->labels->singular_name;
?>
<div class="prime2g_meta_box">
<?php prime2g_custom_mbox_css(); ?>

<?php if ( prime2g_fields_in_post_types()->fields1_excludes ) { ?>

	<div class="meta-options prime2g_field">
		<label for="post_subtitle"><?php _e( $pType . ' Subtitle', PRIME2G_TEXTDOM ); ?></label>
<input id="post_subtitle" type="text" class="prime2g_text" name="post_subtitle" placeholder="A Subtitle for this Entry" 
value="<?php echo esc_attr( $post->post_subtitle ); ?>"
/>
	</div>

<?php } ?>

<div class="meta-options prime2g_field">
	<label for="page_width">Page Width</label>
	<select id="page_width" class="prime2g_input" name="page_width">
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
	<select id="remove_sidebar" class="prime2g_input" name="remove_sidebar">
		<option>--- Keep Sidebar ---</option>
		<option value="remove" <?php if ( $post->remove_sidebar === 'remove' ) echo 'selected'; ?>>Remove Sidebar</option>
	</select>
</div>

<?php } ?>

<div class="meta-options prime2g_field">
	<label for="remove_header">Remove Default Header?</label>
	<select id="remove_header" class="prime2g_input" name="remove_header">
		<option value="">--- Keep Header ---</option>
		<option value="remove" <?php if ( $post->remove_header === 'remove' ) echo 'selected'; ?>>Remove Header Completely</option>
		<option value="header_image_css" <?php if ( $post->remove_header === 'header_image_css' ) echo 'selected'; ?>>Use Header Image CSS</option>
	</select>
</div>

<?php //	@since 1.0.90
if ( prime_child_min_version( '2.4' ) ) { ?>

<div class="meta-options prime2g_field">
	<label for="remove_footer">Remove Site Footer?</label>
	<select id="remove_footer" class="prime2g_input" name="remove_footer">
		<option>--- Keep Footer ---</option>
		<option value="remove" <?php if ( $post->remove_footer === 'remove' ) echo 'selected'; ?>>Remove Site Footer</option>
	</select>
</div>

<?php } ?>


<?php
# @since 1.0.92
if ( get_theme_mod( 'prime2g_site_is_private' ) && $post->ID != get_theme_mod( 'prime2g_privatesite_homepage_id' ) ) { ?>

<div class="meta-options prime2g_field select">
	<label for="page_is_public">
	<input type="checkbox" id="page_is_public" class="prime2g_input" name="page_is_public" value="<?php echo $post->page_is_public; ?>" <?php echo '1' === $post->page_is_public ? ' checked="checked"' : ''; ?> />
	<?php _e( 'Make this '. $pType .' public', PRIME2G_TEXTDOM ); ?>?</label>
</div>

<?php
}

#	@since 1.0.89
if ( ! in_array( $post->ID, prime2g_customizer_pages_ids() ) ) { ?>

<div class="meta-options prime2g_field select">
	<label for="exclude_from_search">
	<input type="checkbox" id="exclude_from_search" class="prime2g_input" name="exclude_from_search" value="<?php echo $post->exclude_from_search; ?>" <?php echo '1' === $post->exclude_from_search ? ' checked="checked"' : ''; ?> />
	Exclude this from Search?</label>
</div>

<?php } ?>


<hr class="hr" />

<h3>Advanced</h3>

<div class="meta-options prime2g_field select">
	<label for="disable_autop">
	<input type="checkbox" id="disable_autop" class="prime2g_input" name="disable_autop" value="<?php echo $post->disable_autop; ?>" <?php echo '1' === $post->disable_autop ? ' checked="checked"' : ''; ?> />
	Disable Content Auto P?</label>
</div>

<?php
/*
<!-- @since 1.0.70 -->
<div class="meta-options prime2g_field select">
	<label for="enqueue_jquery">
	<input type="checkbox" id="enqueue_jquery" class="prime2g_input" name="enqueue_jquery" value="<?php echo $post->enqueue_jquery; ?>" <?php echo '1' === $post->enqueue_jquery ? ' checked="checked"' : ''; ?> />
	Enqueue jQuery?</label>
</div>
*/

/**
 *	@since 1.0.55
 */
if ( prime_child_min_version( '2.2' ) && get_theme_mod( 'prime2g_extra_menu_locations' ) ) {
$nav_menus	=	get_registered_nav_menus(); ?>

<div class="meta-options prime2g_field">
	<label for="use_main_nav_location">Select Menu Location</label>
	<select id="use_main_nav_location" class="prime2g_input" name="use_main_nav_location">
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
 *	Add data about post in this box
 *	@since 1.0.50
 */
add_action( 'add_meta_boxes', 'prime2g_postdata_metaboxes' );
function prime2g_postdata_metaboxes() {
$obj	=	get_post_type_object( get_post_type() );
$name	=	$obj->labels->singular_name;
add_meta_box(
	'prime2g_postdata_box', __( $name . ' Data', PRIME2G_TEXTDOM ),
	'prime2g_post_data_metabox', null, 'side', 'high'
);
}

function prime2g_post_data_metabox( $post ) {

if ( $post->post_type === 'prime_template_parts' ) {
if ( $post->post_status === 'publish' ) { ?>
	<div class="meta-options">
		<h3>Use this shortcode:</h3>
		<p class="p2gClipCopyThis">[prime_insert_template_part id="<?php echo get_the_ID(); ?>"]</p>
	</div>
<?php
}
else { ?>
	<div class="meta-options"> <h4>Publish this Part to get the shortcode</h4> </div>
<?php
}
}
else { ?>
	<style id="hidePostDataBox">#prime2g_postdata_box{display:none!important;}</style>
<?php
}

Prime2gJSBits::copy_to_clipboard(true);
}



/**
 *	SETTINGS
 *	cache control, ++?
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
<?php prime2g_custom_mbox_css(); ?>

<div class="meta-options prime2g_field select">
	<label for="prevent_caching">
	<input type="checkbox" id="prevent_caching" class="prime2g_input" name="prevent_caching" value="<?php echo $post->prevent_caching; ?>" <?php echo '1' === $post->prevent_caching ? ' checked="checked"' : ''; ?> />
	Cache This <?php echo $pType_name; ?>?</label>
</div>

</div>
<?php
}



/*	@since 1.0.60	*/
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
<?php prime2g_custom_mbox_css(); ?>

<div class="meta-options prime2g_field">
	<label for="font_url">Google Font URL</label>
	<input type="url" id="font_url" name="font_url" value="<?php echo esc_url( $post->font_url ); ?>" placeholder="https://fonts.googleapis.com/css?family=Nerko+One:300,400,500&display=swap">
</div>

<div class="meta-options prime2g_field">
	<label for="prime_page_js">JavaScript</label>
<textarea id="prime_page_js" class="prime2g_textarea" name="prime_page_js" rows="5" placeholder="Do not include <script> tags">
<?php echo $post->prime_page_js; ?>
</textarea>
</div>

</div>
<?php
}


