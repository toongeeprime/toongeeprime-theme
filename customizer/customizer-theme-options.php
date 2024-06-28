<?php defined( 'ABSPATH' ) || exit;

/**
 *	Theme's Main Options
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( ! function_exists( 'prime2g_customizer_theme_options' ) ) {
function prime2g_customizer_theme_options( $wp_customize ) {

$styleHere	=	! is_multisite() || ! prime2g_designing_at_networkhome();
$theStyles	=	new ToongeePrime_Styles();
$simple_text=	[ 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' ];
$postMsg_text	=	[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ];

	/**
	 *	THEME WIDTHS
	 */
	$dWidth	=	$theStyles->siteWidth;

	$wp_customize->add_setting( 'prime2g_site_width', array_merge( $simple_text, [ 'default' => $dWidth ] ) );
	$wp_customize->add_control( 'prime2g_site_width', array(
		'label'		=>	__( 'Site\'s Width', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_site_width',
		'section'	=>	'prime2g_theme_options_section',
		'choices'	=>	array(
			'1100px'	=>	__( 'Default', PRIME2G_TEXTDOM ),
			'960px'		=>	__( 'Narrow', PRIME2G_TEXTDOM ),
			'1250px'	=>	__( 'Wide', PRIME2G_TEXTDOM ),
			'100vw'		=>	__( 'Full Width', PRIME2G_TEXTDOM )
		),
		'active_callback'	=>	function() use($styleHere) { return $styleHere; }
	) );

	/**
	 *	STYLING ADJUSTMENTS
	 */
	$wp_customize->add_setting( 'prime2g_site_style_extras', $simple_text );
	$wp_customize->add_control( 'prime2g_site_style_extras', array(
		'label'		=>	__( 'Extra Styling Adjustments', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_site_style_extras',
		'section'	=>	'prime2g_theme_options_section',
		'choices'	=>	array(
			''	=>	__( 'None', PRIME2G_TEXTDOM ),
			'stretch_head'	=>	__( 'Stretch Header', PRIME2G_TEXTDOM ),
			'stretch_foot'	=>	__( 'Stretch Footer', PRIME2G_TEXTDOM ),
			'stretch_hf'	=>	__( 'Stretch Header &amp; Footer', PRIME2G_TEXTDOM )
		),
		'active_callback'	=>	function() use($styleHere) { return $styleHere; }
	) );

	/**
	 *	PAGE TITLE POSITION
	 */
	$wp_customize->add_setting( 'prime2g_title_location', array_merge( $simple_text, [ 'default' => 'content' ] ) );
	$wp_customize->add_control( 'prime2g_title_location', array(
		'label'		=>	__( 'Page Title Location', PRIME2G_TEXTDOM ),
		'type'		=>	'radio',
		'settings'	=>	'prime2g_title_location',
		'section'	=>	'prime2g_theme_options_section',
		'choices'	=>	array(
			'content'	=>	__( 'In Content', PRIME2G_TEXTDOM ),
			'header'	=>	__( 'In Header (Replaces site title or logo)', PRIME2G_TEXTDOM ),
		),
		'active_callback'	=>	function() use($styleHere) { return $styleHere; }
	) );

	/**
	 *	BREADCRUMBS
	 */
	$wp_customize->add_setting( 'prime2g_theme_breadcrumbs', $simple_text );
	$wp_customize->add_control( 'prime2g_theme_breadcrumbs', array(
		'label'		=>	__( 'Show Breadcrumbs (Not on Homepage)', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_theme_breadcrumbs',
		'section'	=>	'prime2g_theme_options_section'
	) );

/**
 *	@since 1.0.55
 */
	/**
	 *	SIDEBAR IN SINGULAR
	 */
	$sidebarChoices	=	[
		''		=>	__( 'Content: Right', PRIME2G_TEXTDOM ),
		'left'	=>	__( 'Content: Left', PRIME2G_TEXTDOM )
	];
	$sidebarExtras	=	[
		'site_right'	=>	__( 'Site: Right', PRIME2G_TEXTDOM ),
		'site_left'		=>	__( 'Site: Left', PRIME2G_TEXTDOM ),
		'sticky_right'	=>	__( 'Sticky: Right', PRIME2G_TEXTDOM ),
		'sticky_left'	=>	__( 'Sticky: Left', PRIME2G_TEXTDOM )
	];

	$sidebarOptions	=	prime2g_use_extras() && prime_child_min_version( '2.4' ) ?
	array_merge( $sidebarChoices, $sidebarExtras ) : $sidebarChoices;

	$wp_customize->add_setting( 'prime2g_sidebar_position', $simple_text );
	$wp_customize->add_control( 'prime2g_sidebar_position', array(
		'label'		=>	__( 'Sidebar Position (Sitewide)', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_sidebar_position',
		'section'	=>	'prime2g_theme_options_section',
		'choices'	=>	$sidebarOptions,
		'active_callback'	=>	function() use($styleHere) { return $styleHere; }
	) );

	$wp_customize->add_setting( 'prime2g_sticky_sidebar_toggler', $simple_text );
	$wp_customize->add_control( 'prime2g_sticky_sidebar_toggler', array(
		'label'		=>	__( 'Add Sidebar Toggler (Desktop)', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_sticky_sidebar_toggler',
		'section'	=>	'prime2g_theme_options_section',
		'active_callback'	=>	function() {
			return in_array( get_theme_mod( 'prime2g_sidebar_position' ), [ 'sticky_right', 'sticky_left' ] );
		}
	) );

	$wp_customize->add_setting( 'prime2g_theme_add_footer_credits', array_merge( $simple_text, [ 'default' => 1 ] ) );
	$wp_customize->add_control( 'prime2g_theme_add_footer_credits', array(
		'label'		=>	__( 'Footer Credits', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_theme_add_footer_credits',
		'section'	=>	'prime2g_theme_options_section'
	) );

if ( prime_child_min_version( '2.0' ) ) {

	$wp_customize->add_setting( 'prime2g_theme_add_footer_logo', array_merge( $simple_text, [ 'default' => '1' ] ) );
	$wp_customize->add_control( 'prime2g_theme_add_footer_logo', array(
		'label'		=>	__( 'Footer Logo', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_theme_add_footer_logo',
		'section'	=>	'prime2g_theme_options_section'
	) );

	/**
	 *	FOOTER COLUMNS
	 */
	$wp_customize->selective_refresh->add_partial( 'prime2g_footer_columns_num', array(
		'selector'	=>	'#sitebasebar',
		'settings'	=>	'prime2g_footer_columns_num',
		'container_inclusive'	=>	true,
		'render_callback'		=>	'prime2g_footer_widgets',
		'fallback_refresh'		=>	false
	) );

	$wp_customize->add_setting( 'prime2g_footer_columns_num', array_merge( $postMsg_text, [ 'default' => '4' ] ) );
	$wp_customize->add_control( 'prime2g_footer_columns_num', array(
		'label'		=>	__( 'Footer Columns', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_footer_columns_num',
		'section'	=>	'prime2g_theme_options_section',
		'choices'	=>	array(
			'1'	=>	'1', '2'	=>	'2',
			'3'	=>	'3', '4'	=>	'4',
			'5'	=>	'5', '6'	=>	'6',
		)
	) );

}
#	@since 1.0.55 end	#

	/**
	 *	FOOTER CREDITS
	 */
	$wp_customize->add_setting( 'prime2g_footer_credit_power', array_merge( $postMsg_text, [ 'default' => 'Powered by' ] ) );
	$wp_customize->add_control( 'prime2g_footer_credit_power', array(
		'label'		=>	__( 'Powered by text (Footer)', PRIME2G_TEXTDOM ),
		'type'		=>	'text',
		'settings'	=>	'prime2g_footer_credit_power',
		'section'	=>	'prime2g_theme_options_section',
		'input_attrs'	=>	array(
			'placeholder'	=>	'Powered by',
			'maxlength'		=>	'125'
		)
	) );

	$wp_customize->add_setting( 'prime2g_footer_credit_name', array_merge( $postMsg_text, [ 'default' => 'ToongeePrime Theme' ] ) );
	$wp_customize->add_control( 'prime2g_footer_credit_name', array(
		'label'		=>	__( 'Credit goes to', PRIME2G_TEXTDOM ),
		'type'		=>	'text',
		'settings'	=>	'prime2g_footer_credit_name',
		'section'	=>	'prime2g_theme_options_section',
		'input_attrs'	=>	array(
			'placeholder'	=>	'ToongeePrime Theme',
			'maxlength'		=>	'125'
		)
	) );

	$wp_customize->add_setting( 'prime2g_footer_credit_url',
	[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'default' => 'https://akawey.com/', 'sanitize_callback' => 'esc_url' ]
	);
	$wp_customize->add_control( 'prime2g_footer_credit_url', array(
		'label'		=>	__( 'Credit Link', PRIME2G_TEXTDOM ),
		'type'		=>	'url',
		'settings'	=>	'prime2g_footer_credit_url',
		'section'	=>	'prime2g_theme_options_section',
		'input_attrs'	=>	array(
			'placeholder'	=>	'https://akawey.com/',
			'maxlength'		=>	'125'
		)
	) );

	/**
	 *	@since 1.0.48.50
	 */
	$wp_customize->add_setting( 'prime2g_footer_credit_append', $postMsg_text );
	$wp_customize->add_control( 'prime2g_footer_credit_append', array(
		'label'		=>	__( 'Append to credit', PRIME2G_TEXTDOM ),
		'type'		=>	'text',
		'settings'	=>	'prime2g_footer_credit_append',
		'section'	=>	'prime2g_theme_options_section',
		'input_attrs'	=>	array(
			'placeholder'	=>	'All rights reserved.',
			'maxlength'		=>	'125'
		)
	) );

}
}

