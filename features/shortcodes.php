<?php defined( 'ABSPATH' ) || exit;

/**
 *	SHORTCODES
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.49
 */

/**
 *	Show Contacts & Social Media Icons set in Theme's Customizer
 */
add_shortcode( 'prime2g_social_and_contacts', 'prime2g_social_and_contacts_shortcode' );
function prime2g_social_and_contacts_shortcode( $atts ) {
$atts	=	shortcode_atts( array( 'showaddress'	=>	'' ), $atts );
extract( $atts );

$address	=	false;
if ( $showaddress === 'yes' )  $address = true;

return prime2g_theme_mod_social_and_contacts( $address );
}


/**
 *	Insert a Template Part
 *	@since ToongeePrime Theme 1.0.50
 */
add_shortcode( 'prime_insert_template_part', 'prime2g_insert_template_part_shortcode' );
function prime2g_insert_template_part_shortcode( $atts ) {
$atts	=	shortcode_atts( [ 'id' => '1', 'device' => '' ], $atts );
extract( $atts );

$isMobile	=	wp_is_mobile();
$devices	=	prime2g_devices_array();

if ( in_array( $device, $devices->desktops ) && $isMobile ) return;
if ( in_array( $device, $devices->mobiles ) && ! $isMobile ) return;

$part	=	prime2g_insert_template_part( $id, false );

if ( ! $part && current_user_can( 'edit_others_posts' ) ) {
	return __( 'Invalid Template Part', PRIME2G_TEXTDOM );
}

return $part;
}


/**
 *	@since ToongeePrime Theme 1.0.55
 */
add_shortcode( 'prime_site_footer_credits', 'prime2g_theme_footer_credit' );


add_shortcode( 'prime_site_logo', 'prime2g_sitelogo_shortcode' );
function prime2g_sitelogo_shortcode( $atts ) {
$atts	=	shortcode_atts( array( 'dark_logo' => '', 'source' => '' ), $atts );
extract( $atts );

$darkLogo	=	( $dark_logo === 'yes' ) ? true : false;
$src	=	( $source === 'yes' ) ? true : false;

return prime2g_siteLogo( $darkLogo, $src );
}


add_shortcode( 'prime_search_form', 'prime2g_searchform_shortcode' );
function prime2g_searchform_shortcode( $atts ) {
$atts	=	shortcode_atts( [
	'placeholder'=>	'Keywords',
	'required'	=>	'yes',
	'buttontext'=>	'Go',		//*** USE SINGLE QUOTE IN HTML
	'label'		=>	'Search here',
	'echo'		=>	'',
	'id'		=>	'',	// @since 1.0.78
	'livesearch'=>	''
], $atts );

return prime2g_wp_block_search_form( $atts );
}


add_shortcode( 'prime_video', 'prime2g_video_embed_shortcode' );
function prime2g_video_embed_shortcode( $atts ) {
$atts	=	shortcode_atts( [ 'url'	=>	'', 'id' => '', 'height' => '' ], $atts );
extract( $atts );

global $wp_embed;
$embedded	=	$wp_embed->autoembed( $url );
$vidID		=	$id ? ' id="'. $id .'"' : '';
$js	=	'';

if ( $height && $id ) {
$js		=	'<script>p2getEl( "#'. $id .' iframe" ).setAttribute( "height", "'. $height .'" );</script>';
}

return '<div'. $vidID .' class="prime2g_embedded_media shortcode video">'. $embedded . '</div>' . $js;
}


/**
 *	Gets Text Content Only, for better html usage
 *	@since 1.0.70
 */
add_shortcode( 'prime_get_titles_or_description', 'prime2g_get_title_or_description_shortcode' );
function prime2g_get_title_or_description_shortcode( $atts ) {
$atts	=	shortcode_atts( [ 'get' => 'sitetitle' ], $atts );
extract( $atts );

if ( $get === 'sitetitle' ) $text	=	get_bloginfo( 'name' );

if ( $get === 'description' ) $text	=	get_bloginfo( 'description' );

if ( $get === 'pagetitle' ) {
	global $post; $text	=	$post->post_title;
}

return $text;
}


add_shortcode( 'prime_site_title_and_description', 'prime2g_title_and_description_shortcode' );
function prime2g_title_and_description_shortcode( $atts ) {
$atts	=	shortcode_atts( [
	'description' => 'yes',
	'descriptiononly' => '',
	'innerelement' => 'span',
	'class' => 'page_title prel site_width',
	'h1class' => 'prel'
], $atts );
extract( $atts );

$desc		=	( $description === 'yes' ) ? true : false;
$descOnly	=	( $descriptiononly === 'yes' ) ? true : false;
$el_start	=	$innerelement ? "<{$innerelement}>" : "";
$el_end		=	$innerelement ? "</{$innerelement}>" : "";
$name		=	get_bloginfo( 'name' );

$title	=	"<div class=\"{$class}\">";
$title	.=	( ! $descOnly ) ? "<h1 class=\"{$h1class}\" title=\"{$name}\">{$el_start}{$name}{$el_end}</h1>" : '';
$title	.=	( $descOnly || $desc ) ? '<p id="site_description">'. get_bloginfo( 'description' ) .'</p>' : '';
$title	.=	"</div>";

return $title;
}


add_shortcode( 'prime_map', 'prime2g_map_shortcode' );
function prime2g_map_shortcode( $atts ) {
$atts	=	shortcode_atts( [
'address'	=>	'',
'map'		=>	'google',
'height'	=>	'400px',
'zoom'		=>	'15',
'maptype'	=>	'roadmap',
'id'		=>	'google-maps-display'
], $atts );
extract( $atts );

$address	=	str_replace( ' ', '+', $address );

if ( $address ) {

$embed	=	'<div id="'. $id .'" class="prime_map" style="max-width:100%;overflow:hidden;color:red;width:100%;height:'. $height .';">
<div style="height:100%;width:100%;max-width:100%;">';

if ( $map === 'google' ) {
$embed	.=	'<iframe style="height:100%;width:100%;border:0;" frameborder="0"
src="https://www.google.com/maps/embed/v1/place?q='. $address .'&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8&zoom='. $zoom .'&maptype='. $maptype .'">
</iframe>
<a class="auth-map-data embed-ded-maphtml" rel="nofollow" href="https://www.bootstrapskins.com/themes">premium bootstrap themes</a>
<style>#'. $id .' img.text-marker{max-width:none!important;background:none!important;}#'. $id .' img{max-width:none}</style>';
}

$embed	.=	'</div>
</div><!-- .prime_map -->';

}
else {
$embed	=	'<strong><p>NO ADDRESS FOR MAP</p></strong>';
}

return $embed;
}


add_shortcode( 'prime_nav_menu', 'prime2g_get_nav_menu_shortcode' );
function prime2g_get_nav_menu_shortcode( $atts ) {
$atts	=	shortcode_atts(
[ 'menu' => '', 'class' => 'shortcode_menu', 'id' => '', 'title_attrs' => 'yes', 'device' => '' ],
$atts
);
extract( $atts );

$isMobile	=	wp_is_mobile();
$devices	=	prime2g_devices_array();

if ( in_array( $device, $devices->desktops ) && $isMobile ) return;
if ( in_array( $device, $devices->mobiles ) && ! $isMobile ) return;

$id		=	$id ? ' id="'. $id .'"' : '';
$title_attrs	=	( $title_attrs === 'yes' ) ? true : false;

$items	=	null;
$menu_array	=	wp_get_nav_menu_items( $menu );

if ( $menu_array ) {
foreach ( $menu_array as $item ) {
	$title_attrs	=	$title_attrs ? ' title="'. $item->title .'"' : '';
	$items[]	=	'<li><a href="'. $item->url .'"'. $title_attrs .'>'. $item->title .'</a></li>';
}
}

$none	=	current_user_can( 'edit_theme_options' ) ? 'No Menu Item Found' : '';

$result	=	$items ? $items : $none;

if ( is_array( $result ) ) {
	$result	=	implode( '', $result );
	$result	=	'<ul'. $id .' class="'. $class .'">'. $result .'</ul>';
}

return $result;
}


/**
 *	ADD IN-POST CONTENT TO THEME PARTS
 */
add_shortcode( 'prime_add_to_theme', 'prime2g_add_content_to_theme' );
function prime2g_add_content_to_theme( $atts, $content, $tag ) {
$atts	=	shortcode_atts( array( 'place' => 'after post', 'priority' => '10' ), $atts );
extract( $atts );

$output	=	do_shortcode( $content );

#	Add by theme/WP hooks
#	Tested hooks:
$hook	=	$place;
if ( $place === 'after post' ) $hook	=	'prime2g_after_post';
if ( $place === 'base' ) $hook	=	'prime2g_site_base_strip';
if ( $place === 'footer' ) $hook	=	'wp_footer';

add_action( $hook, function() use( $output ) { echo $output; }, (int) $priority );
}

/* @since ToongeePrime Theme 1.0.55 END */


/**
 *	In-post Redirection by JavaScript
 *	@since ToongeePrime Theme 1.0.51
 */
add_shortcode( 'prime_redirect_to', 'prime2g_redirect_shortcode' );
function prime2g_redirect_shortcode( $atts ) {
$home		=	get_home_url();
$loggedin	=	is_user_logged_in();

$atts	=	shortcode_atts( array( 'url' => $home, 'users' => '' ), $atts );
extract( $atts );

if ( $users === 'logged out' ) {
	if ( ! $loggedin ) {
		echo '<script id="prime_redirect_shortcode">window.location = "'. $url .'";</script>';
	}
}

if ( $users === 'logged in' ) {
	if ( $loggedin ) {
		echo '<script id="prime_redirect_shortcode">window.location = "'. $url .'";</script>';
	}
}

if ( empty( $users ) ) {
	echo '<script id="prime_redirect_shortcode">window.location = "'. $url .'";</script>';
}
}


/**
 *	Login Form
 *	@since 1.0.73
 */
add_shortcode( 'prime_login_form', 'prime2g_login_form_shortcode' );
function prime2g_login_form_shortcode( $atts ) {
$atts	=	shortcode_atts( [
'redirect_to'	=>	'',
'wrapper_id'=>	'',
'classes'	=>	'',
'form_id'	=>	'custom_login_page_form',
'username_label'	=>	'Username/Email',
'password_label'	=>	'Password',
'button_text'=>	'Log in',
'text_above'=>	'',
'text_below'=>	''
],
$atts );

add_action( 'wp_footer', function() {
	echo '<style id="loginFormCSS">' . prime2g_login_page_css() . '</style>';
	echo prime2g_custom_login_js();
} );

return prime2g_login_form( $atts );
}

