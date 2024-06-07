<?php defined( 'ABSPATH' ) || exit;

/**
 *	THEME'S WP PATTERNS FUNCTIONS
 *	@https://developer.wordpress.org/themes/patterns/registering-patterns/
 *	@since ToongeePrime Theme 1.0.94 looking forward to WP 6.6
 */

// add_filter( 'should_load_remote_block_patterns', '__return_false' );	// do not load remote patterns

/**
 *	REGISTER PATTERNS CATEGORY
 */
add_action( 'init', 'prime2g_register_pattern_categories' );
function prime2g_register_pattern_categories() {
register_block_pattern_category( 'prime2g/page-patterns', [
	'label'			=>	__( 'ToongeePrime: Page Patterns', PRIME2G_TEXTDOM ),
	'description'	=>	__( 'Patterns for Custom Page Templates', PRIME2G_TEXTDOM )
] );
}



/* UNREGISTERING PATTERS:
add_action( 'init', 'themeslug_unregister_patterns', 999 );
function themeslug_unregister_patterns() {
	unregister_block_pattern( 'themeslug/hero' );
}
*/

