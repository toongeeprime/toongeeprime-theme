<?php defined( 'ABSPATH' ) || exit;

/**
 *	Customizer for Theme Archives
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( ! function_exists( 'prime2g_customizer_theme_archives' ) ) {

function prime2g_customizer_theme_archives( $wp_customize ) {

function prime2g_categs_array() {
$categs	=	get_categories();
$ids	=	array_column( $categs, 'term_id' );
$names	=	array_column( $categs, 'name' );

return array_combine( $ids, $names );
}


	/**
	 *	POSTS HOME TITLE
	 */
	$siteTitle	=	get_bloginfo( 'name' );
	$wp_customize->add_setting(
		'prime2g_posts_home_title',
		array(
			'type'				=>	'theme_mod',
			'transport'			=>	'refresh',
			'default'			=>	$siteTitle,
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'prime2g_posts_home_title',
		array(
			'label'		=>	__( 'Posts Homepage Title', 'toongeeprime-theme' ),
			'type'		=>	'text',
			'settings'	=>	'prime2g_posts_home_title',
			'section'	=>	'prime2g_theme_archives_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	$siteTitle,
			),
			'active_callback'	=>	'is_home',
		)
	);

	$wp_customize->add_setting(
		'prime2g_posts_home_description',
		array(
			'type'				=>	'theme_mod',
			'default'			=>	'Posts Homepage',
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'prime2g_posts_home_description',
		array(
			'label'		=>	__( 'Posts Homepage Description', 'toongeeprime-theme' ),
			'type'		=>	'text',
			'settings'	=>	'prime2g_posts_home_description',
			'section'	=>	'prime2g_theme_archives_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	$siteTitle,
			),
			'active_callback'	=>	'is_home',
		)
	);


	/**
	 *	HOMEPAGE HEADLINES
	 */
	$wp_customize->add_setting(
		'prime2g_theme_show_headlines',
		array(
			'type'		=>	'theme_mod',
		)
	);
	$wp_customize->add_control(
		'prime2g_theme_show_headlines',
		array(
			'label'		=>	__( 'Show Headlines Section?', 'toongeeprime-theme' ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_theme_show_headlines',
			'section'	=>	'prime2g_theme_archives_section',
			'choices'	=>	array(
				'show'	=>	__( 'Yes', 'toongeeprime-theme' ),
			),
			'active_callback'	=>	'is_home',
		)
	);

	$wp_customize->add_setting(
		'prime2g_headlines_category',
		array(
			'type'				=>	'theme_mod',
			'default'			=>	1,
		)
	);
	$wp_customize->add_control(
		'prime2g_headlines_category',
		array(
			'label'		=>	__( 'Headlines Category', 'toongeeprime-theme' ),
			'type'		=>	'select',
			'settings'	=>	'prime2g_headlines_category',
			'section'	=>	'prime2g_theme_archives_section',
			'choices'	=>	prime2g_categs_array(),
			'active_callback'	=>	'is_home',
		)
	);



	/**
	 *	HEADER STICKY POSTS
	 */
	$wp_customize->add_setting(
		'prime2g_theme_show_stickies',
		array(
			'type'		=>	'theme_mod',
		)
	);
	$wp_customize->add_control(
		'prime2g_theme_show_stickies',
		array(
			'label'		=>	__( 'Show Sticky Posts at the Top of Archives?', 'toongeeprime-theme' ),
			'type'		=>	'checkbox',
			'settings'	=>	'prime2g_theme_show_stickies',
			'section'	=>	'prime2g_theme_archives_section',
			'choices'	=>	array(
				'show'	=>	__( 'Yes', 'toongeeprime-theme' ),
			),
		)
	);

	$wp_customize->add_setting(
		'prime2g_theme_sticky_heading',
		array(
			'type'				=>	'theme_mod',
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'prime2g_theme_sticky_heading',
		array(
			'label'		=>	__( 'Sticky Posts Heading', 'toongeeprime-theme' ),
			'settings'	=>	'prime2g_theme_sticky_heading',
			'section'	=>	'prime2g_theme_archives_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	'Featured Posts',
			),
		)
	);

}

}
