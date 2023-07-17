<?php defined( 'ABSPATH' ) || exit;
/**
 *	NEWS REEL
 *
 *	@package WordPress
 *	@since ToongeePrime Theme Theme 1.0.50
 */

function prime2g_theme_newsreel_active() { return get_theme_mod( 'prime2g_theme_news_reel' ); }

if ( ! function_exists( 'prime2g_theme_news_reel' ) ) {
function prime2g_theme_news_reel( $wp_customize ) {

	$wp_customize->selective_refresh->add_partial(
		'prime2g_theme_news_reel',
		array(
			'selector'		=>	'#prime2g_news_reel_frame',
			'settings'		=>	[ 'prime2g_theme_news_reel', 'prime2g_news_reel_width' ],
			'container_inclusive'	=>	false,
			'render_callback'		=>	'prime2g_news_reel',
			'fallback_refresh'		=>	true,
		)
	);

	$wp_customize->add_setting(
		'prime2g_theme_news_reel',
		[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control(
		'prime2g_theme_news_reel',
		array(
			'label'		=>	__( 'Activate News Reel', PRIME2G_TEXTDOM ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_theme_news_reel',
			'section'	=>	'prime2g_media_features_section'
		)
	);

	$wp_customize->add_setting(
		'prime2g_theme_news_reel_title',
		array(
			'type'		=>	'theme_mod',
			'default'	=>	'Latest News',
			'transport'	=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'prime2g_theme_news_reel_title',
		array(
			'label'		=>	__( 'News Reel Title', PRIME2G_TEXTDOM ),
			'settings'	=>	'prime2g_theme_news_reel_title',
			'section'	=>	'prime2g_media_features_section',
			'active_callback'	=>	'prime2g_theme_newsreel_active'
		)
	);

	#	Don't refresh the following + no JS @ 'transport' => 'postMessage'
	$wp_customize->add_setting(
		'prime2g_theme_news_reel_post_type',
		[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control(
		'prime2g_theme_news_reel_post_type',
		array(
			'label'		=>	__( 'News Reel Post Type', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_theme_news_reel_post_type',
			'section'	=>	'prime2g_media_features_section',
			'choices'	=>	prime2g_posttypes_names_array(),
			'active_callback'	=>	'prime2g_theme_newsreel_active'
		)
	);

	$wp_customize->add_setting(
		'prime2g_theme_news_reel_category',
		[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control(
		'prime2g_theme_news_reel_category',
		array(
			'label'		=>	__( 'News Reel Category', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_theme_news_reel_category',
			'section'	=>	'prime2g_media_features_section',
			'choices'	=>	prime2g_categs_and_ids_array(),
			'active_callback'	=>	function() {
				return ( prime2g_theme_newsreel_active() &&
				'post' === get_theme_mod( 'prime2g_theme_news_reel_post_type' ) );
			}
		)
	);

	$wp_customize->add_setting(
		'prime2g_theme_news_reel_taxonomy',
		[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control(
		'prime2g_theme_news_reel_taxonomy',
		array(
			'label'		=>	__( 'Reel Taxonomy Slug (Advanced)', PRIME2G_TEXTDOM ),
			'settings'	=>	'prime2g_theme_news_reel_taxonomy',
			'section'	=>	'prime2g_media_features_section',
			'active_callback'	=> function() {
				return ( ! empty( get_theme_mod( 'prime2g_theme_news_reel_taxonomy' ) ) &&
				'post' !== get_theme_mod( 'prime2g_theme_news_reel_post_type' ) );
			}
		)
	);

	$wp_customize->add_setting(
		'prime2g_theme_news_reel_tax_term_id',
		[ 'type' => 'theme_mod', 'transport' => 'postMessage', 'sanitize_callback' => 'sanitize_text_field' ]
	);
	$wp_customize->add_control(
		'prime2g_theme_news_reel_tax_term_id',
		array(
			'label'		=>	__( 'Reel Taxonomy Term ID (Advanced)', PRIME2G_TEXTDOM ),
			'type'		=>	'number',
			'settings'	=>	'prime2g_theme_news_reel_tax_term_id',
			'section'	=>	'prime2g_media_features_section',
			'active_callback'	=> function() {
				return ( ! empty( get_theme_mod( 'prime2g_theme_news_reel_taxonomy' ) ) &&
				'post' !== get_theme_mod( 'prime2g_theme_news_reel_post_type' ) );
			}
		)
	);

	$wp_customize->add_setting(
		'prime2g_theme_news_reel_posts_count',
		array(
			'type'		=>	'theme_mod',
			'default'	=>	'5',
			'transport'	=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'prime2g_theme_news_reel_posts_count',
		array(
			'label'		=>	__( 'How many entries in Reel?', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_theme_news_reel_posts_count',
			'section'	=>	'prime2g_media_features_section',
			'choices'	=>	array(
				'3' => '3', '4' => '4', '5' => '5', '6' => '6',
				'7' => '7', '8' => '8', '9' => '9', '10' => '10',
			),
			'active_callback'	=>	'prime2g_theme_newsreel_active'
		)
	);

	$wp_customize->add_setting(
		'prime2g_news_reel_width',
		array(
			'type'		=>	'theme_mod',
			'default'	=>	'site_width',
			'transport'	=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'prime2g_news_reel_width',
		array(
			'label'		=>	__( 'Reel Width', PRIME2G_TEXTDOM ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_news_reel_width',
			'section'	=>	'prime2g_media_features_section',
			'choices'	=>	array(
				'site_width'=>	__( 'Normal', PRIME2G_TEXTDOM ),
				'stretch'	=>	__( 'Stretched', PRIME2G_TEXTDOM ),
			),
			'active_callback'	=>	'prime2g_theme_newsreel_active'
		)
	);
}
}

