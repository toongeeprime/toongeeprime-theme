<?php defined( 'ABSPATH' ) || exit;

/**
 *	Singular Entries
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

if ( ! function_exists( 'prime2g_customizer_singular_entries' ) ) {

function prime2g_customizer_singular_entries( $wp_customize ) {

$simple_text	=	[ 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' ];
$postMsg_text	=	[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ];

$remove_sidebar_choices	=	[
	''		=>	__( 'Keep Sidebar', PRIME2G_TEXTDOM ),
	'posts'	=>	__( 'Remove but Exclude Pages', PRIME2G_TEXTDOM ),
	'and_pages'	=>	__( 'Also Remove in Pages', PRIME2G_TEXTDOM ),
	'pages_only'=>	__( 'Remove in "Pages" only', PRIME2G_TEXTDOM )
];

if ( function_exists( 'is_product' ) ) {
$remove_sidebar_choices	=	array_merge( $remove_sidebar_choices,
[
	'products_only'	=>	__( 'Remove in "Products" only', PRIME2G_TEXTDOM )
]
);
}

	$wp_customize->add_setting( 'prime2g_remove_sidebar_in_singular', $simple_text );
	$wp_customize->add_control( 'prime2g_remove_sidebar_in_singular', array(
		'label'		=>	__( 'Remove Sidebar in Single Entries', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_remove_sidebar_in_singular',
		'section'	=>	'prime2g_singular_entries_section',
		'choices'	=>	$remove_sidebar_choices
	) );

	$wp_customize->add_setting( 'prime2g_entry_byline_usage', $simple_text );
	$wp_customize->add_control( 'prime2g_entry_byline_usage', array(
		'label'		=>	__( 'Bylines', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_entry_byline_usage',
		'section'	=>	'prime2g_singular_entries_section',
		'choices'	=>	array(
			''		=>	__( 'Author and Date', PRIME2G_TEXTDOM ),
			'author_only'	=>	__( 'Author Only', PRIME2G_TEXTDOM ),
			'date_only'		=>	__( 'Date Only', PRIME2G_TEXTDOM ),
			'remove_byline'	=>	__( 'Remove Byline', PRIME2G_TEXTDOM )
		)
	) );

	/** @since 1.0.89 **/
	function p2g_s_ert() { return ! empty( get_theme_mod( 'prime2g_show_est_read_time' ) ); }

	$wp_customize->add_setting( 'prime2g_show_est_read_time', $simple_text );
	$wp_customize->add_control( 'prime2g_show_est_read_time', array(
		'label'		=>	__( 'Show Estimated Read Time (E.R.T.)', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_show_est_read_time',
		'section'	=>	'prime2g_singular_entries_section',
		'active_callback'	=>	function() { return is_singular( 'post' ); }
	) );

	$wp_customize->add_setting( 'prime2g_est_read_time_placement', array_merge( $simple_text, [ 'default' => 'prime2g_after_title' ] ) );
	$wp_customize->add_control( 'prime2g_est_read_time_placement', array(
		'label'		=>	__( 'E.R.T. Placement', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_est_read_time_placement',
		'section'	=>	'prime2g_singular_entries_section',
		'active_callback'	=>	'p2g_s_ert',
		'choices'	=>	array(
			'prime2g_before_title'	=>	__( 'Before Title', PRIME2G_TEXTDOM ),
			'prime2g_after_title'	=>	__( 'After Title', PRIME2G_TEXTDOM ),
			'prime2g_before_post'	=>	__( 'Before Content', PRIME2G_TEXTDOM )
		)
	) );

	$wp_customize->add_setting( 'prime2g_est_read_time_prepend', array_merge( $postMsg_text, [ 'default' => 'Est. read time: ' ] ) );
	$wp_customize->add_control( 'prime2g_est_read_time_prepend', array(
		'label'		=>	__( 'E.R.T. Text Prepend', PRIME2G_TEXTDOM ),
		'type'		=>	'text',
		'settings'	=>	'prime2g_est_read_time_prepend',
		'section'	=>	'prime2g_singular_entries_section',
		'active_callback'	=>	'p2g_s_ert',
		'input_attrs'	=>	[ 'placeholder' => 'Est. read time: ' ]
	) );
	/** @since 1.0.89 End **/

	$wp_customize->add_setting( 'prime2g_use_theme_css_js_custom_fields', array_merge( $postMsg_text, [ 'default' => 0 ] ) );
	$wp_customize->add_control( 'prime2g_use_theme_css_js_custom_fields', array(
		'label'		=>	__( 'Use Legacy CSS Field', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_use_theme_css_js_custom_fields',
		'section'	=>	'prime2g_singular_entries_section'
	) );

}

}
