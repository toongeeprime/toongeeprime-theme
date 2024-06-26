<?php defined( 'ABSPATH' ) || exit;
/**
 *	Theme Menus
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

if ( ! function_exists( 'prime2g_customizer_theme_menus' ) ) {
function prime2g_customizer_theme_menus( $wp_customize ) {

$child_is23		=	prime_child_min_version( '2.3' );
$postMsg_text	=	[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ];
$simple_text	=	[ 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' ];

	$wp_customize->selective_refresh->add_partial(
	'prime2g_set_cta_menu_item', array(
		'selector'		=>	'#prime_cta_menu',
		'settings'		=>	[ 'prime2g_set_cta_menu_item' ],
		'container_inclusive'	=>	true,
		'render_callback'		=>	'prime2g_cta_menu',
		'fallback_refresh'		=>	true
	) );

	/**
	 *	Main Menu Position
	 */
	$wp_customize->add_setting( 'prime2g_menu_position',
		array( 'type' => 'theme_mod', 'default' => 'top', 'sanitize_callback' => 'sanitize_text_field' )
	);
	$wp_customize->add_control( 'prime2g_menu_position', array(
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
	) );

	/**
	 *	Logo Beside Menu
	 */
	$wp_customize->add_setting( 'prime2g_logo_with_menu', $simple_text );
	$wp_customize->add_control( 'prime2g_logo_with_menu', array(
		'label'		=>	__( 'Show Logo with Main Menu', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_logo_with_menu',
		'section'	=>	'prime2g_theme_menus_section'
	) );

	/**
	 *	Footer Menu
	 */
	$wp_customize->add_setting( 'prime2g_theme_add_footer_menu',
		[ 'type' => 'theme_mod', 'default' => '1', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control( 'prime2g_theme_add_footer_menu', array(
		'label'		=>	__( 'Footer Menu', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_theme_add_footer_menu',
		'section'	=>	'prime2g_theme_menus_section'
	) );

if ( $child_is23 ) {
	/**
	 *	STICKY MENU
	 */
	$wp_customize->add_setting( 'prime2g_use_sticky_menu', $simple_text );
	$wp_customize->add_control( 'prime2g_use_sticky_menu', array(
		'label'		=>	__( 'Add Pop-in Sticky Menu (Desktop)', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_use_sticky_menu',
		'section'	=>	'prime2g_theme_menus_section',
		'active_callback'	=>	function() { return '' === get_theme_mod( 'prime2g_main_menu_type' ); }
	) );
}

if ( prime_child_min_version( '2.1' ) ) {
	/**
	 *	CTA Menu Button
	 */
	function p2g_set_ctami() { return ! empty( get_theme_mod( 'prime2g_set_cta_menu_item' ) ); }

	$wp_customize->add_setting( 'prime2g_set_cta_menu_item', $postMsg_text );
	$wp_customize->add_control( 'prime2g_set_cta_menu_item', array(
		'label'		=>	__( 'Activate CTA Menu Button', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_set_cta_menu_item',
		'section'	=>	'prime2g_theme_menus_section'
	) );

	$wp_customize->add_setting( 'prime2g_cta_menu_url',
		array( 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'esc_url' )
	);
	$wp_customize->add_control( 'prime2g_cta_menu_url', array(
		'label'		=>	__( 'CTA Button Link', PRIME2G_TEXTDOM ),
		'type'		=>	'url',
		'settings'	=>	'prime2g_cta_menu_url',
		'section'	=>	'prime2g_theme_menus_section',
		'active_callback'	=>	'p2g_set_ctami'
	) );

	$wp_customize->add_setting( 'prime2g_cta_button_text', array(
	'type' => 'theme_mod', 'transport' => 'postMessage',
	'sanitize_callback' => 'sanitize_text_field', 'default' => 'Contact Us'
	) );
	$wp_customize->add_control( 'prime2g_cta_button_text', array(
		'label'		=>	__( 'CTA Button Text', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_cta_button_text',
		'section'	=>	'prime2g_theme_menus_section',
		'active_callback'	=>	'p2g_set_ctami'
	) );

	$wp_customize->add_setting( 'prime2g_cta_button_classes', $postMsg_text );
	$wp_customize->add_control( 'prime2g_cta_button_classes', array(
		'label'		=>	__( 'CTA Button Classes', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_cta_button_classes',
		'section'	=>	'prime2g_theme_menus_section',
		'active_callback'	=>	'p2g_set_ctami'
	) );

	$wp_customize->add_setting( 'prime2g_cta_link_target', $postMsg_text );
	$wp_customize->add_control( 'prime2g_cta_link_target', array(
		'label'		=>	__( 'Open CTA Link in New Tab', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_cta_link_target',
		'section'	=>	'prime2g_theme_menus_section',
		'active_callback'	=>	'p2g_set_ctami'
	) );
}

/**
 *	@since 1.0.55
 */
if ( prime_child_min_version( '2.2' ) ) {
	$wp_customize->add_setting( 'prime2g_use_site_top_menu', $simple_text );
	$wp_customize->add_control( 'prime2g_use_site_top_menu', array(
		'label'		=>	__( 'Activate Site Top Menu', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_use_site_top_menu',
		'section'	=>	'prime2g_theme_menus_section'
	) );

	$wp_customize->add_setting( 'prime2g_extra_menu_locations',
	[ 'type' => 'theme_mod', 'default' => 0, 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control( 'prime2g_extra_menu_locations', array(
		'label'		=>	__( 'Extra Menu Locations (Reload Customizer)', PRIME2G_TEXTDOM ),
		'type'		=>	'number',
		'settings'	=>	'prime2g_extra_menu_locations',
		'section'	=>	'prime2g_theme_menus_section'
	) );
}

/**
 *	@since 1.0.57
 */
if ( $child_is23 ) {
	# Theme 1.0.86
	$wp_customize->add_setting( 'prime2g_mobile_submenu_collapsing', array_merge( $simple_text, [ 'default' => 'click' ] ) );
	$wp_customize->add_control( 'prime2g_mobile_submenu_collapsing', array(
		'label'		=>	__( 'Mobile Sub-menu Opening', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_mobile_submenu_collapsing',
		'section'	=>	'prime2g_theme_menus_section',
		'choices'	=>	array(
			''		=>	__( 'Open Flat', PRIME2G_TEXTDOM ),
			'click'	=>	__( 'Click/Tap to Open', PRIME2G_TEXTDOM ),
			// 'hover'	=>	__( 'Hover to Open', PRIME2G_TEXTDOM )	//	similar+confusing effect on mobile!
		)
	) );

	/**
	 *	MAIN MENU TYPE
	 */
	$wp_customize->add_setting( 'prime2g_main_menu_type', $simple_text );
	$wp_customize->add_control( 'prime2g_main_menu_type', array(
		'label'		=>	__( 'Main Menu Type', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_main_menu_type',
		'section'	=>	'prime2g_theme_menus_section',
		'choices'	=>	array(
			''		=>	__( 'Default', PRIME2G_TEXTDOM ),
			'togglers'	=>	__( 'Togglers', PRIME2G_TEXTDOM ),
			'mega_menu'	=>	__( 'Mega Menu', PRIME2G_TEXTDOM )	# Theme 1.0.76
		)
	) );

	/**
	 *	TOGGLE MENU
	 */
	$wp_customize->add_setting( 'prime2g_toggle_menu_template_part_id', $simple_text );
	$wp_customize->add_control( 'prime2g_toggle_menu_template_part_id', array(
		'label'		=>	__( 'Toggle Menu Template Part ID', PRIME2G_TEXTDOM ),
		'type'		=>	'number',
		'settings'	=>	'prime2g_toggle_menu_template_part_id',
		'section'	=>	'prime2g_theme_menus_section',
		'input_attrs'	=>	[ 'placeholder'	=>	'12345' ],
		'active_callback'	=>	function() { return 'togglers' === get_theme_mod( 'prime2g_main_menu_type' ); }
	) );

	/**
	 *	MEGA MENU
	 */
	#	Theme 1.0.78
	function p2IsmegMenu() { return 'mega_menu' === get_theme_mod( 'prime2g_main_menu_type' ); }

	$wp_customize->add_setting( 'prime2g_mega_menu_width', $simple_text );
	$wp_customize->add_control( 'prime2g_mega_menu_width', array(
		'label'		=>	__( 'Mega Menu Width (on Desktop)', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_mega_menu_width',
		'section'	=>	'prime2g_theme_menus_section',
		'active_callback'	=>	'p2IsmegMenu',
		'choices'	=>	array(
			''		=>	__( 'Default', PRIME2G_TEXTDOM ),
			'page_width'	=>	__( 'Page Width', PRIME2G_TEXTDOM ),
			'full_width'	=>	__( 'Full Width', PRIME2G_TEXTDOM )
		)
	) );
	#	Theme 1.0.78 End

	#	Theme 1.0.76
	$wp_customize->add_setting( 'prime2g_mega_menu_template_part_id', $simple_text );
	$wp_customize->add_control( 'prime2g_mega_menu_template_part_id', array(
		'label'		=>	__( 'Mega Menu Template Part ID', PRIME2G_TEXTDOM ),
		'type'		=>	'number',
		'settings'	=>	'prime2g_mega_menu_template_part_id',
		'section'	=>	'prime2g_theme_menus_section',
		'input_attrs'	=>	[ 'placeholder'	=>	'12345' ],
		'active_callback'	=>	'p2IsmegMenu'
	) );

	$wp_customize->add_setting( 'prime2g_mobile_menu_template_part_id', $simple_text );
	$wp_customize->add_control( 'prime2g_mobile_menu_template_part_id', array(
		'label'		=>	__( 'Mobile Menu Template Part ID', PRIME2G_TEXTDOM ),
		'type'		=>	'number',
		'settings'	=>	'prime2g_mobile_menu_template_part_id',
		'section'	=>	'prime2g_theme_menus_section',
		'input_attrs'	=>	[ 'placeholder'	=>	'12345' ],
		'active_callback'	=>	'p2IsmegMenu'
	) );
}

}
}


