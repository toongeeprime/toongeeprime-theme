<?php defined( 'ABSPATH' ) || exit;

/**
 *	CUSTOM FIELDS' JavaScript
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.73
 */

add_action( 'admin_footer', 'prime2g_metabox_javascript' );
function prime2g_metabox_javascript() {
global $pagenow, $typenow;
if ( in_array( $pagenow, [ 'post-new.php', 'post.php' ] ) ) { ?>
<script id="prime2g_metaboxesJS">
let p2gBoxIDs	=	[
'#prime2g_prime_fields1', '#prime2g_postdata_box', '#prime2g_settings_fields', '#prime2g_extras_fields', '#prime2g_media_cfields'
];
p2gBoxIDs.forEach( pb => {
box	=	p2getEl( pb );
if ( box ) { box.classList.add( 'prime2g_postbox' ); }
} );
</script>
<?php
}
}


