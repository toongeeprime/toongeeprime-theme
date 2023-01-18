<?php defined( 'ABSPATH' ) || exit;

/**
 *	Theme's WooCommerce Customizations
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

if ( ! function_exists( 'prime2g_customizer_woocommerce_edits' ) ) {

function prime2g_customizer_woocommerce_edits( $wp_customize ) {

	// Settings and Controls:
	$wp_customize->add_setting(
		'prime2g_shop_page_title',
		array(
			'type'		=>	'theme_mod',
			'default'	=>	'Shop Homepage',
			'transport'	=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'prime2g_shop_page_title',
		array(
			'label'		=>	__( 'Shop Page Title', PRIME2G_TEXTDOM ),
			'type'		=>	'text',
			'settings'	=>	'prime2g_shop_page_title',
			'section'	=>	'prime2g_woocommerce_edits_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	__( 'Shop Homepage', PRIME2G_TEXTDOM ),
			),
			'active_callback'	=>	'is_shop',
		)
	);


	$descr	=	prime2g_woo_shop_description();
	$wp_customize->add_setting(
		'prime2g_shop_page_description',
		array(
			'type'		=>	'theme_mod',
			'default'	=>	__( $descr, PRIME2G_TEXTDOM ),
			'transport'	=>	'postMessage',
			'sanitize_callback'	=>	'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'prime2g_shop_page_description',
		array(
			'label'		=>	__( 'Shop Page Description', PRIME2G_TEXTDOM ),
			'type'		=>	'text',
			'settings'	=>	'prime2g_shop_page_description',
			'section'	=>	'prime2g_woocommerce_edits_section',
			'input_attrs'	=>	array(
				'placeholder'	=>	__( $descr, PRIME2G_TEXTDOM ),
			),
			'active_callback'	=>	'is_shop'
		)
	);

}

}

