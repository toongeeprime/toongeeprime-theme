<?php defined( 'ABSPATH' ) || exit;
/**
 *	PWA Icons Class
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

class Prime2g_PWA_Images {

	private static $instance;
	private $same_version;	# @since 1.0.97

	public function __construct() {
		if ( ! isset( self::$instance ) ) {
			$this->same_version	=	prime2g_app_option( 'images_version' );

			#	Let images run before updating version
			$this->mainIcon();
			$this->site_icons();
			$this->screenshots();

		if ( ! $this->same_version )
			prime2g_app_option( [ 'name'=>'images_version', 'update'=>true ] );

		}
	return self::$instance;
	}


	function mainIcon() {
	$icon_data	=	prime2g_app_option( 'mainIcon' );

	if ( false === $icon_data || ! $this->same_version ) {
		if ( is_multisite() ) {
			$iconURL	=	$this->get_main_icon();
			switch_to_blog( 1 );
			if ( get_theme_mod( 'prime2g_route_apps_to_networkhome' ) )
				$iconURL	=	$this->get_main_icon();
			restore_current_blog();
		}
		else {
			$iconURL	=	$this->get_main_icon();
		}

		$iconData	=	(object) [
			'src'		=>	$iconURL,
			'sizes'		=>	'144x144',
			'type'		=>	'image/png',
			'purpose'	=>	'any'
		];
	prime2g_app_option( [ 'name'=>'mainIcon', 'update'=>true, 'value'=>$iconData ] );
	$icon_data	=	prime2g_app_option( 'mainIcon' );
	}

	return $icon_data;
	}


	function screenshots() {
	$shots	=	prime2g_app_option( 'screenshots' );

	if ( false === $shots || ! $this->same_version ) {
	$screenshots	=	$this->get_screenshots();
		if ( is_multisite() ) {
			switch_to_blog( 1 );
			if ( get_theme_mod( 'prime2g_route_apps_to_networkhome' ) )
				$screenshots	=	$this->get_screenshots();
			restore_current_blog();
		}
	prime2g_app_option( [ 'name'=>'screenshots', 'update'=>true, 'value'=>$screenshots ] );
	$shots	=	prime2g_app_option( 'screenshots' );
	}

	return $shots;
	}


	#	Site icon variants
	function site_icons(): array {
	$icons_data	=	prime2g_app_option( 'site_icons' );

	if ( false === $icons_data || ! $this->same_version ) {
	$iconID		=	get_option( 'site_icon' );
	$site_icon	=	get_post( $iconID );
	$iconsData	=	$sizeKeys	=	$iconKeys	=	[];

	if ( is_object( $site_icon ) ) {
		$app_isizes	=	[ 'pwa-small-icon', 'pwa-big-icon' ];
		$meta_data	=	wp_get_attachment_metadata( $iconID );
		$sizesN		=	$meta_data ? count( $meta_data ) : 0;
		if ( ! is_array( $meta_data ) ) return [];

		for ( $ii = 0; $ii < $sizesN; $ii++ ) {
			if ( isset( array_keys( $meta_data[ 'sizes' ] )[ $ii ], $app_isizes[ $ii ] ) ) {
				$iconKeys[]	=	$app_isizes[ $ii ];
				$sizeKeys[]	=	array_keys( $meta_data[ 'sizes' ] )[ $ii ];
			}
		}

		//	Merge icons and Meta data sizes
		$sizes	=	array_unique( array_merge( $iconKeys, $sizeKeys ) );
		if ( ! is_array( $sizes ) ) return [];

		foreach ( $sizes as $size ) {
			$src_data	=	wp_get_attachment_image_src( $iconID, $size );
			if ( ! is_array( $src_data ) ) continue;

			//	ARRAY data
			$image	=	[
				'url'	=>	$src_data[0],
				'width'	=>	$src_data[1],
				'height'=>	$src_data[2]
			];

			$image[ 'mime-type' ]	=	isset( $meta_data[ 'sizes' ][ $size ] ) ?
				$meta_data[ 'sizes' ][ $size ][ 'mime-type' ] : $site_icon->post_mime_type;

			$iconsData[]	=	(object)[
				'src'		=>	$image[ 'url' ],
				'sizes'		=>	$image[ 'width' ] . 'x' . $image[ 'height' ],
				'type'		=>	$image[ 'mime-type' ]
			];
			// 'purpose'	=>	'maskable'
		}
	}
	prime2g_app_option( [ 'name'=>'site_icons', 'update'=>true, 'value'=>$iconsData ] );
	$icons_data	=	prime2g_app_option( 'site_icons' );
	}
	return $icons_data;
	}


	private function get_main_icon() {
		if ( $icon_id = get_theme_mod( 'prime2g_pwapp_primaryicon' ) ) {
			$iconURL	=	wp_get_attachment_image_url( $icon_id, [ 144, 144 ] );
		}
		elseif ( $icon_id = get_option( 'site_icon' ) ) {
			$iconURL	=	wp_get_attachment_image_url( $icon_id, [ 144, 144 ] );
		}
		elseif ( file_exists( get_stylesheet_directory() . '/images/pwa-default-icon.png' ) ) {	# file_exists needs abs path
			$iconURL	=	CHILD2G_IMAGE . 'pwa-default-icon.png';
		}
		else {
			$iconURL	=	PRIME2G_PWA_IMAGE . 'default.png';
		}
	return $iconURL;
	}


	private function get_screenshots(): array {
	$imagesData	=	[];
	$mod_ends	=	[ '1', '2', '3', 'narrow', 'wide' ];

	foreach ( $mod_ends as $id ) {
	$img_id		=	get_theme_mod( "prime2g_pwa_screenshot_{$id}" );
	$img_descr	=	get_theme_mod( "prime2g_pwa_screenshot_descr_{$id}", '' );
	$img_post	=	get_post( $img_id );

	if ( is_object( $img_post ) ) {
		$meta_data	=	wp_get_attachment_metadata( $img_id );
		if ( ! is_array( $meta_data ) ) continue;

		$src_data	=	wp_get_attachment_image_src( $img_id, 'full' );
		if ( is_array( $src_data ) ) {

			//	ARRAY data
			$image	=	[
				'src'	=>	$src_data[0],
				'width'	=>	$src_data[1],
				'height'=>	$src_data[2],
				'mime-type'	=>	$img_post->post_mime_type
			];

			$form_factor	=	in_array( $id, [ 'narrow', 'wide' ] ) ? [ 'form_factor' => $id ] : [];

			$imagesData[]	=	(object) array_merge( [
				'src'		=>	$image[ 'src' ],
				'sizes'		=>	$image[ 'width' ] . 'x' . $image[ 'height' ],
				'type'		=>	$image[ 'mime-type' ],
				'label'		=>	$img_descr
			], $form_factor );
		}
	}
	}
	return $imagesData;
	}

}

