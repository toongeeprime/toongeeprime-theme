<?php defined( 'ABSPATH' ) || exit;

/**
 *	HOMEPAGE SLIDESHOW
 *
 *	@package WordPress
 *	@since ToongeePrime Theme Theme 1.0.70
 */

function p2c_hIsSlide() { return is_home() && 'slideshow' === get_theme_mod( 'prime2g_home_main_headline_type' ); }

if ( ! function_exists( 'prime2g_homepage_slideshow_customizer' ) ) {
function prime2g_homepage_slideshow_customizer( $wp_customize ) {

if ( ! prime2g_use_extras() ) return;

$simple_text	=	[ 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field' ];

	$wp_customize->add_setting( 'prime2g_home_main_headline_type', $simple_text );
	$wp_customize->add_control( 'prime2g_home_main_headline_type',
	array(
		'label'		=>	__( 'Main Headline(s) Media Type', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_home_main_headline_type',
		'section'	=>	'prime2g_theme_archives_section',
		'choices'	=>	array(
			''		=>	__( 'Default', PRIME2G_TEXTDOM ),
			'slideshow'	=>	__( 'Slideshow', PRIME2G_TEXTDOM )
		)
	) );

	$wp_customize->add_setting( 'prime2g_slideshow_post_type',
	[ 'type' => 'theme_mod', 'default' => 'post', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control( 'prime2g_slideshow_post_type',
	array(
		'label'		=>	__( 'Slideshow\' Post Type', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_slideshow_post_type',
		'section'	=>	'prime2g_theme_archives_section',
		'choices'	=>	prime2g_posttypes_names_array(),
		'active_callback'	=>	'p2c_hIsSlide'
	) );

	$wp_customize->add_setting( 'prime2g_slideshow_taxonomy',
	[ 'type' => 'theme_mod', 'default' => 'category', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control( 'prime2g_slideshow_taxonomy',
	array(
		'label'		=>	__( 'Slideshow\' Taxonomy (Advanced)', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_slideshow_taxonomy',
		'section'	=>	'prime2g_theme_archives_section',
		'input_attrs'	=>	[ 'placeholder'	=>	__( 'category', PRIME2G_TEXTDOM ) ],
		'active_callback'	=>	'p2c_hIsSlide'
	) );

	$wp_customize->add_setting( 'prime2g_slideshow_tax_term_slug',
	[ 'type' => 'theme_mod', 'default' => 'headlines', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control( 'prime2g_slideshow_tax_term_slug',
	array(
		'label'		=>	__( 'Slideshow\' Taxonomy Term (Advanced)', PRIME2G_TEXTDOM ),
		'settings'	=>	'prime2g_slideshow_tax_term_slug',
		'section'	=>	'prime2g_theme_archives_section',
		'input_attrs'	=>	[ 'placeholder'	=>	__( 'headlines', PRIME2G_TEXTDOM ) ],
		'active_callback'	=>	'p2c_hIsSlide'
	) );

	$wp_customize->add_setting( 'prime2g_slideshow_posts_count',
	[ 'type' => 'theme_mod', 'default' => '3', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control( 'prime2g_slideshow_posts_count',
	array(
		'label'		=>	__( 'How many posts in Slideshow?', PRIME2G_TEXTDOM ),
		'type'		=>	'number',
		'settings'	=>	'prime2g_slideshow_posts_count',
		'section'	=>	'prime2g_theme_archives_section',
		'input_attrs'	=>	[ 'min'	=>	'2', 'max' => '20' ],
		'active_callback'	=>	'p2c_hIsSlide'
	) );

	$wp_customize->add_setting( 'prime2g_slideshow_timer_speed',
	[ 'type' => 'theme_mod', 'default' => '5', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control( 'prime2g_slideshow_timer_speed',
	array(
		'label'		=>	__( 'Slideshow Speed (Seconds)', PRIME2G_TEXTDOM ),
		'type'		=>	'number',
		'settings'	=>	'prime2g_slideshow_timer_speed',
		'section'	=>	'prime2g_theme_archives_section',
		'input_attrs'	=>	[ 'min'	=>	'2', 'max' => '60' ],
		'active_callback'	=>	'p2c_hIsSlide'
	) );

}
}



/*
	$wp_customize->add_setting( 'prime2g_slideshow_posts_count',
	[ 'type' => 'theme_mod', 'default' => '5', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control( 'prime2g_slideshow_posts_count',
	array(
		'label'		=>	__( 'How many posts in Slideshow?', PRIME2G_TEXTDOM ),
		'type'		=>	'select',
		'settings'	=>	'prime2g_slideshow_posts_count',
		'section'	=>	'prime2g_theme_archives_section',
		'choices'	=>	[
			'3' => '3', '4' => '4', '5' => '5', '6' => '6',
			'8' => '8', '9' => '9', '10' => '10', '12' => '12'
		],
		'active_callback'	=>	'p2c_hIsSlide'
	) );
*/

