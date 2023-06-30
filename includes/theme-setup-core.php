<?php defined( 'ABSPATH' ) || exit;

/**
 *	MAIN THEME SETUP
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0
 */

/**
 *	Add a pingback url auto-discovery header for single posts, pages, or attachments
 */
add_action( 'wp_head', 'toongeeprime_pingback_header' );
function toongeeprime_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}


/**
 *	Comment form defaults
 */
add_filter( 'comment_form_defaults', 'toongeeprime_comment_form_defaults' );
function toongeeprime_comment_form_defaults( $defaults ) {

	// Height of comment form
	$defaults[ 'comment_field' ] = preg_replace( '/rows="\d+"/', 'rows="5"', $defaults[ 'comment_field' ] );

	return $defaults;
}



/**
 *		SETUP THE THEME
 */
add_action( 'after_setup_theme', 'toongeeprime_theme_setup' );
if ( ! function_exists( 'toongeeprime_theme_setup' ) ) {

function toongeeprime_theme_setup() {

	$theStyles	=	new ToongeePrime_Styles();

		/**
		 *	@since ToongeePrime Theme 1.0.50
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 *	Make theme available for translation
		 *	Translations can be filed in the /languages/ directory
		 */
		load_theme_textdomain( PRIME2G_TEXTDOM, get_template_directory() . '/languages' );

		add_theme_support( 'title-tag' );

		# Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		/**
		 *	Custom background
		 */
		$bgcolor	=	$theStyles->siteBG;
		add_theme_support(
			'custom-background',
			array(
				'default-image'			=>	'',
				'default-preset'		=>	'custom',
				'default-position-x'	=>	'center',
				'default-position-y'	=>	'top',
				'default-size'			=>	'cover',
				'default-repeat'		=>	'no-repeat',
				'default-attachment'	=>	'fixed',
				'default-color'			=>	$bgcolor,
			)
		);

		/**
		 *	Post-formats support
		 */
		add_theme_support(
			'post-formats',
			array( 'link', 'aside', 'gallery', 'image', 'quote', 'status', 'video', 'audio', 'chat', )
		);

		/**
		 *	Support Post Thumbnails
		 *
		 *	@link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 2000, 9999 );

		/**
		 *	Switch default core markup for search form, comment form, and comments to output valid HTML5
		 */
		add_theme_support(
		'html5',
		array( 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
		);

		# Support selective refresh for widgets
		add_theme_support( 'customize-selective-refresh-widgets' );

		# Support Block Styles
		add_theme_support( 'wp-block-styles' );

		# Support full and wide align images
		add_theme_support( 'align-wide' );

		/**
		 *	'editor-styles' @since ToongeePrime Theme Theme 1.0.55
		 */
		add_theme_support( 'editor-styles' );

		# Add custom editor font sizes
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => esc_html__( 'Extra small', PRIME2G_TEXTDOM ),
					'shortName' => esc_html_x( 'XS', 'Font size', PRIME2G_TEXTDOM ),
					'size'      => 16,
					'slug'      => 'extra-small',
				),
				array(
					'name'      => esc_html__( 'Small', PRIME2G_TEXTDOM ),
					'shortName' => esc_html_x( 'S', 'Font size', PRIME2G_TEXTDOM ),
					'size'      => 18,
					'slug'      => 'small',
				),
				array(
					'name'      => esc_html__( 'Normal', PRIME2G_TEXTDOM ),
					'shortName' => esc_html_x( 'M', 'Font size', PRIME2G_TEXTDOM ),
					'size'      => 20,
					'slug'      => 'normal',
				),
				array(
					'name'      => esc_html__( 'Large', PRIME2G_TEXTDOM ),
					'shortName' => esc_html_x( 'L', 'Font size', PRIME2G_TEXTDOM ),
					'size'      => 24,
					'slug'      => 'large',
				),
				array(
					'name'      => esc_html__( 'Extra large', PRIME2G_TEXTDOM ),
					'shortName' => esc_html_x( 'XL', 'Font size', PRIME2G_TEXTDOM ),
					'size'      => 40,
					'slug'      => 'extra-large',
				),
				array(
					'name'      => esc_html__( 'Huge', PRIME2G_TEXTDOM ),
					'shortName' => esc_html_x( 'XXL', 'Font size', PRIME2G_TEXTDOM ),
					'size'      => 96,
					'slug'      => 'huge',
				),
				array(
					'name'      => esc_html__( 'Gigantic', PRIME2G_TEXTDOM ),
					'shortName' => esc_html_x( 'XXXL', 'Font size', PRIME2G_TEXTDOM ),
					'size'      => 144,
					'slug'      => 'gigantic',
				),
			)
		);

		# Editor color palette
		$black     = '#000000';
		$dark_gray = '#28303D';
		$gray      = '#39414D';
		$green     = '#D1E4DD';
		$blue      = '#D1DFE4';
		$purple    = '#D1D1E4';
		$red       = '#E4D1D1';
		$orange    = '#E4DAD1';
		$yellow    = '#EEEADD';
		$white     = '#FFFFFF';

		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => esc_html__( 'Black', PRIME2G_TEXTDOM ),
					'slug'  => 'black',
					'color' => $black,
				),
				array(
					'name'  => esc_html__( 'Dark gray', PRIME2G_TEXTDOM ),
					'slug'  => 'dark-gray',
					'color' => $dark_gray,
				),
				array(
					'name'  => esc_html__( 'Gray', PRIME2G_TEXTDOM ),
					'slug'  => 'gray',
					'color' => $gray,
				),
				array(
					'name'  => esc_html__( 'Green', PRIME2G_TEXTDOM ),
					'slug'  => 'green',
					'color' => $green,
				),
				array(
					'name'  => esc_html__( 'Blue', PRIME2G_TEXTDOM ),
					'slug'  => 'blue',
					'color' => $blue,
				),
				array(
					'name'  => esc_html__( 'Purple', PRIME2G_TEXTDOM ),
					'slug'  => 'purple',
					'color' => $purple,
				),
				array(
					'name'  => esc_html__( 'Red', PRIME2G_TEXTDOM ),
					'slug'  => 'red',
					'color' => $red,
				),
				array(
					'name'  => esc_html__( 'Orange', PRIME2G_TEXTDOM ),
					'slug'  => 'orange',
					'color' => $orange,
				),
				array(
					'name'  => esc_html__( 'Yellow', PRIME2G_TEXTDOM ),
					'slug'  => 'yellow',
					'color' => $yellow,
				),
				array(
					'name'  => esc_html__( 'White', PRIME2G_TEXTDOM ),
					'slug'  => 'white',
					'color' => $white,
				),
			)
		);

		add_theme_support(
			'editor-gradient-presets',
			array(
				array(
					'name'     => esc_html__( 'Purple to yellow', PRIME2G_TEXTDOM ),
					'gradient' => 'linear-gradient(160deg, ' . $purple . ' 0%, ' . $yellow . ' 100%)',
					'slug'     => 'purple-to-yellow',
				),
				array(
					'name'     => esc_html__( 'Yellow to purple', PRIME2G_TEXTDOM ),
					'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $purple . ' 100%)',
					'slug'     => 'yellow-to-purple',
				),
				array(
					'name'     => esc_html__( 'Green to yellow', PRIME2G_TEXTDOM ),
					'gradient' => 'linear-gradient(160deg, ' . $green . ' 0%, ' . $yellow . ' 100%)',
					'slug'     => 'green-to-yellow',
				),
				array(
					'name'     => esc_html__( 'Yellow to green', PRIME2G_TEXTDOM ),
					'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $green . ' 100%)',
					'slug'     => 'yellow-to-green',
				),
				array(
					'name'     => esc_html__( 'Red to yellow', PRIME2G_TEXTDOM ),
					'gradient' => 'linear-gradient(160deg, ' . $red . ' 0%, ' . $yellow . ' 100%)',
					'slug'     => 'red-to-yellow',
				),
				array(
					'name'     => esc_html__( 'Yellow to red', PRIME2G_TEXTDOM ),
					'gradient' => 'linear-gradient(160deg, ' . $yellow . ' 0%, ' . $red . ' 100%)',
					'slug'     => 'yellow-to-red',
				),
				array(
					'name'     => esc_html__( 'Purple to red', PRIME2G_TEXTDOM ),
					'gradient' => 'linear-gradient(160deg, ' . $purple . ' 0%, ' . $red . ' 100%)',
					'slug'     => 'purple-to-red',
				),
				array(
					'name'     => esc_html__( 'Red to purple', PRIME2G_TEXTDOM ),
					'gradient' => 'linear-gradient(160deg, ' . $red . ' 0%, ' . $purple . ' 100%)',
					'slug'     => 'red-to-purple',
				),
			)
		);


		/**
		 *	WooCommerce Support
		 */
		add_theme_support( 'woocommerce',
			array(
				'thumbnail_image_width'	=>	250,
				'single_image_width'	=>	750,
				'product_grid'			=>	array(
					'default_rows'		=>	3,
					'min_rows'			=>	2,
					'max_rows'			=>	12,
					'default_columns'	=>	4,
					'min_columns'		=>	2,
					'max_columns'		=>	6,
				),
			)
		);
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-slider' );


		# Support responsive embedded content
		add_theme_support( 'responsive-embeds' );

		# Support custom line height controls
		add_theme_support( 'custom-line-height' );

		# Support experimental link color control
		add_theme_support( 'experimental-link-color' );

		# Support experimental cover block spacing
		add_theme_support( 'custom-spacing' );
}

}

