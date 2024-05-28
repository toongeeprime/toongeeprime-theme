<?php defined( 'ABSPATH' ) || exit;

/**
 *	Customizer Site Performance
 *
 *	@package WordPress
 *	File created @since ToongeePrime Theme 1.0.59
 */

if ( ! function_exists( 'prime2g_customizer_site_performance' ) ) {

function prime2g_customizer_site_performance( $wp_customize ) {

$postMsg_text	=	[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ];
$postMsgChecked	=	array_merge( $postMsg_text, [ 'default' => 1 ] );

	/**
	 *	CACHE CONTROLS
	 *	@since 1.0.56
	 */
function prime2g_a_c_ctrls() { return ! empty( get_theme_mod( 'prime2g_activate_chache_controls' ) ); }

$network	=	is_multisite();
$route		=	'';

if ( $network ) {
	switch_to_blog( 1 );
	$route	=	get_theme_mod( 'prime2g_route_caching_to_networkhome' );
	restore_current_blog();
}


if ( $network && get_current_blog_id() === 1 ) {
	$wp_customize->add_setting( 'prime2g_route_caching_to_networkhome', $postMsg_text );
	$wp_customize->add_control( 'prime2g_route_caching_to_networkhome', array(
		'label'		=>	__( 'Route Caching Controls to Network Home?', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_route_caching_to_networkhome',
		'section'	=>	'prime2g_site_performance_section'
	) );
}


if ( ! $network || $network && ( empty( $route ) || $route && get_current_blog_id() === 1 ) ) {

	/**
	 *	THEME SEO
	 *	@since 1.0.81
	 */
	$wp_customize->add_setting( 'prime2g_use_theme_seo', $postMsgChecked );
	$wp_customize->add_control( 'prime2g_use_theme_seo', array(
		'label'		=>	__( "Use Theme's SEO Settings", PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_use_theme_seo',
		'section'	=>	'prime2g_site_performance_section'
	) );

	/**
	 *	DISABLING CSS
	 *	@since 1.0.85
	 */
	$wp_customize->add_setting( 'prime2g_disable_blocks_css', $postMsg_text );
	$wp_customize->add_control( 'prime2g_disable_blocks_css', array(
		'label'		=>	__( "Disbale Blocks CSS (if not using Blocks)", PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_disable_blocks_css',
		'section'	=>	'prime2g_site_performance_section'
	) );

if ( class_exists( 'Jetpack' ) ) {
	$wp_customize->add_setting( 'prime2g_disable_jetpack_css', $postMsg_text );
	$wp_customize->add_control( 'prime2g_disable_jetpack_css', array(
		'label'		=>	__( "Disbale Jetpack CSS", PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_disable_jetpack_css',
		'section'	=>	'prime2g_site_performance_section'
	) );
}

if ( class_exists( 'woocommerce' ) ) {
	$wp_customize->add_setting( 'prime2g_disable_wc_blocks_css', $postMsg_text );
	$wp_customize->add_control( 'prime2g_disable_wc_blocks_css', array(
		'label'		=>	__( "Disbale WooCommerce Blocks CSS", PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_disable_wc_blocks_css',
		'section'	=>	'prime2g_site_performance_section'
	) );
}
else {
	//	WooCommerce Adds jQuery Migrate
	//	@since 1.0.89
	$wp_customize->add_setting( 'prime2g_deregister_jq_migrate', $postMsgChecked );
	$wp_customize->add_control( 'prime2g_deregister_jq_migrate', array(
		'label'		=>	__( "Deregister jQuery Migrate", PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_deregister_jq_migrate',
		'section'	=>	'prime2g_site_performance_section'
	) );
}


$time_units	=	[ MINUTE_IN_SECONDS => __( 'Minutes', PRIME2G_TEXTDOM ), HOUR_IN_SECONDS => __( 'Hours', PRIME2G_TEXTDOM ),
DAY_IN_SECONDS => __( 'Days', PRIME2G_TEXTDOM ), WEEK_IN_SECONDS => __( 'Weeks', PRIME2G_TEXTDOM ),
MONTH_IN_SECONDS => __( 'Months', PRIME2G_TEXTDOM ), YEAR_IN_SECONDS => __( 'Years', PRIME2G_TEXTDOM ) ];

	$wp_customize->add_setting( 'prime2g_activate_chache_controls', $postMsg_text );
	$wp_customize->add_control( 'prime2g_activate_chache_controls', array(
		'label'		=>	__( 'Activate Cache Controls', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_activate_chache_controls',
		'section'	=>	'prime2g_site_performance_section'
	) );

	$wp_customize->add_setting( 'prime2g_chache_time_singular', $postMsg_text );
	$wp_customize->add_control( 'prime2g_chache_time_singular', array(
		'label'		=>	__( 'Cache Time: Single Entries', PRIME2G_TEXTDOM ),
		'type'		=>	'number',
		'settings'	=>	'prime2g_chache_time_singular',
		'section'	=>	'prime2g_site_performance_section',
		'input_attrs'	=>	[ 'min' => '1' ],
		'active_callback'	=> 'prime2g_a_c_ctrls'
	) );

	$wp_customize->add_setting( 'prime2g_chache_seconds_singular', $postMsg_text );
	$wp_customize->add_control( 'prime2g_chache_seconds_singular', array(
		'label'		=>	__( 'Cache Unit: Single Entries', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_chache_seconds_singular',
		'section'	=>	'prime2g_site_performance_section',
		'choices'	=>	$time_units,
		'active_callback'	=> 'prime2g_a_c_ctrls'
	) );

	$wp_customize->add_setting( 'prime2g_chache_time_feeds', $postMsg_text );
	$wp_customize->add_control( 'prime2g_chache_time_feeds', array(
		'label'		=>	__( 'Cache Time: Archives', PRIME2G_TEXTDOM ),
		'type'		=>	'number',
		'settings'	=>	'prime2g_chache_time_feeds',
		'section'	=>	'prime2g_site_performance_section',
		'input_attrs'	=>	[ 'min' => '1' ],
		'active_callback'	=> 'prime2g_a_c_ctrls'
	) );

	$wp_customize->add_setting( 'prime2g_chache_seconds_feeds', $postMsg_text );
	$wp_customize->add_control( 'prime2g_chache_seconds_feeds', array(
		'label'		=>	__( 'Cache Unit: Archives', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_chache_seconds_feeds',
		'section'	=>	'prime2g_site_performance_section',
		'choices'	=>	$time_units,
		'active_callback'	=> 'prime2g_a_c_ctrls'
	) );

	$wp_customize->add_setting( 'prime2g_allow_chache_data_clearing', $postMsg_text );
	$wp_customize->add_control( 'prime2g_allow_chache_data_clearing', array(
		'label'		=>	__( 'Allow Cache Data Clearing (Advanced)', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_allow_chache_data_clearing',
		'section'	=>	'prime2g_site_performance_section',
		'active_callback'	=> 'prime2g_a_c_ctrls'
	) );

	//	@since 1.0.91
	$wp_customize->add_setting( 'prime2g_write_htaccess_chache_rules', $postMsg_text );
	$wp_customize->add_control( 'prime2g_write_htaccess_chache_rules', array(
		'label'		=>	__( 'Set Cache rules at Server (Advanced)', PRIME2G_TEXTDOM ),
		'type'		=>	'checkbox',
		'settings'	=>	'prime2g_write_htaccess_chache_rules',
		'section'	=>	'prime2g_site_performance_section',
		'active_callback'	=> 'prime2g_a_c_ctrls'
	) );

}

}

}

