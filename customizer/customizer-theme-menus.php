<?php defined( 'ABSPATH' ) || exit;

/**
 *	Theme Menus
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

if ( ! function_exists( 'prime2g_customizer_theme_menus' ) ) {

function prime2g_customizer_theme_menus( $wp_customize ) {

	$wp_customize->selective_refresh->add_partial(
		'prime2g_set_cta_menu_item',
		array(
			'selector'		=>	'#prime_cta_menu',
			'settings'		=>	[ 'prime2g_set_cta_menu_item' ],
			'container_inclusive'	=>	true,
			'render_callback'		=>	'prime2g_cta_menu',
			'fallback_refresh'		=>	true,
		)
	);

	/**
	 *	Main Menu Position
	 */
	$wp_customize->add_setting( 'prime2g_menu_position',
		array( 'type' => 'theme_mod', 'default' => 'top', 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control( 'prime2g_menu_position',
		array(
			'label'		=>	__( 'Main Menu Position', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_menu_position',
			'section'	=>	'prime2g_theme_menus_section',
			'choices'	=>	array(
				'top'	=>	__( 'Top of Header', PRIME2G_TEXTDOM ),
				'bottom'=>	__( 'Bottom of Header', PRIME2G_TEXTDOM ),
				'fixed'	=>	__( 'Fixed At Site-Top', PRIME2G_TEXTDOM ),
				'menu_on_header'	=>	__( 'On The Header', PRIME2G_TEXTDOM )
			),
		)
	);

	/**
	 *	Logo Beside Menu
	 */
	$wp_customize->add_setting( 'prime2g_logo_with_menu',
		array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control( 'prime2g_logo_with_menu',
		array(
			'label'		=>	__( 'Show Logo by Main Menu', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_logo_with_menu',
			'section'	=>	'prime2g_theme_menus_section'
		)
	);

	/**
	 *	Footer Menu
	 */
	$wp_customize->add_setting( 'prime2g_theme_add_footer_menu',
		array( 'type' => 'theme_mod', 'default' => '1', 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control( 'prime2g_theme_add_footer_menu',
		array(
			'label'		=>	__( 'Footer Menu', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_theme_add_footer_menu',
			'section'	=>	'prime2g_theme_menus_section'
		)
	);

if ( defined( 'CHILD2G_VERSION' ) && CHILD2G_VERSION >= '2.1' ) {

	/**
	 *	CTA Menu Button
	 */
	$wp_customize->add_setting( 'prime2g_set_cta_menu_item',
		array( 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control( 'prime2g_set_cta_menu_item',
		array(
			'label'		=>	__( 'Activate CTA Menu Button', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_set_cta_menu_item',
			'section'	=>	'prime2g_theme_menus_section'
		)
	);

	$wp_customize->add_setting( 'prime2g_cta_menu_url',
		array( 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'esc_url' )
	);
	$wp_customize->add_control( 'prime2g_cta_menu_url',
		array(
			'label'		=>	__( 'CTA Button Link', PRIME2G_TEXTDOM ),
			'type'		=>	'url',
			'settings'	=>	'prime2g_cta_menu_url',
			'section'	=>	'prime2g_theme_menus_section',
			'active_callback'	=>	function() { return get_theme_mod( 'prime2g_set_cta_menu_item' ); }
		)
	);

	$wp_customize->add_setting( 'prime2g_cta_button_text',
		array(
		'type' => 'theme_mod', 'transport' => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field', 'default' => 'Contact Us'
		)
	);
	$wp_customize->add_control( 'prime2g_cta_button_text',
		array(
			'label'		=>	__( 'CTA Button Text', PRIME2G_TEXTDOM ),
			'settings'	=>	'prime2g_cta_button_text',
			'section'	=>	'prime2g_theme_menus_section',
			'active_callback'	=>	function() { return get_theme_mod( 'prime2g_set_cta_menu_item' ); }
		)
	);

	$wp_customize->add_setting( 'prime2g_cta_button_classes',
		array(
		'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( 'prime2g_cta_button_classes',
		array(
			'label'		=>	__( 'CTA Button Classes', PRIME2G_TEXTDOM ),
			'settings'	=>	'prime2g_cta_button_classes',
			'section'	=>	'prime2g_theme_menus_section',
			'active_callback'	=>	function() { return get_theme_mod( 'prime2g_set_cta_menu_item' ); }
		)
	);

	$wp_customize->add_setting( 'prime2g_cta_link_target',
		array(
		'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( 'prime2g_cta_link_target',
		array(
			'label'		=>	__( 'Open CTA Link in New Tab', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_cta_link_target',
			'section'	=>	'prime2g_theme_menus_section',
			'active_callback'	=>	function() { return get_theme_mod( 'prime2g_set_cta_menu_item' ); }
		)
	);

}

if ( defined( 'CHILD2G_VERSION' ) && CHILD2G_VERSION >= '2.2' ) {

	/**
	 *	@since ToongeePrime Theme 1.0.55
	 */
	$wp_customize->add_setting( 'prime2g_use_site_top_menu',
		array(
		'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( 'prime2g_use_site_top_menu',
		array(
			'label'		=>	__( 'Activate Site Top Menu', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_use_site_top_menu',
			'section'	=>	'prime2g_theme_menus_section'
		)
	);

	$wp_customize->add_setting( 'prime2g_extra_menu_locations',
		array(
		'type' => 'theme_mod', 'default' => 0, 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( 'prime2g_extra_menu_locations',
		array(
			'label'		=>	__( 'Extra Menu Locations (Reload Customizer)', PRIME2G_TEXTDOM ),
			'type'		=>	'number',
			'settings'	=>	'prime2g_extra_menu_locations',
			'section'	=>	'prime2g_theme_menus_section'
		)
	);

}

}

}
