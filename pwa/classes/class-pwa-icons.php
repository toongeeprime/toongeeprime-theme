<?php defined( 'ABSPATH' ) || exit;

/**
 *	PWA Icons Class
 *
 *	@package WordPress
 *	@since ToongeePrime Theme 1.0.55
 */

#	TO DO @ customizer: screenshots

class Prime2g_PWA_Icons {
	/**
	 *	Instantiate as there's no __construct
	 */
	private static $instance;

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance	=	new self();
		}
		return self::$instance;
	}


	public function mainIcon() {

		if ( is_multisite() ) {
		$iconURL	=	$this->get_main_icon();

		switch_to_blog( 1 );
		if ( get_theme_mod( 'prime2g_route_apps_to_networkhome' ) ) {
			$iconURL	=	$this->get_main_icon();
		}
		restore_current_blog();
		}
		else {
			$iconURL	=	$this->get_main_icon();
		}

		return [
			'src'		=>	$iconURL,
			'sizes'		=>	'144x144',
			'type'		=>	'image/png',
			'purpose'	=>	'any'
		];

	}


	private function get_main_icon() {

		if ( $icon_id = get_theme_mod( 'prime2g_pwapp_primaryicon' ) ) {
			$iconURL	=	wp_get_attachment_image_url( $icon_id, [ 144, 144 ] );
		}
		elseif ( $icon_id = get_option( 'site_icon' ) ) {
			$iconURL	=	wp_get_attachment_image_url( $icon_id, [ 144, 144 ] );
		}
		else {
			$iconURL	=	PRIME2G_PWA_IMAGE . 'default.png';
		}

	return $iconURL;
	}


	public function icons(): array {

	$iconsData	=	$iKeys	=	$iconsSet	=	[];
	$iconID		=	get_option( 'site_icon' );
	$site_icon	=	get_post( $iconID );

	if ( is_object( $site_icon ) ) {

		$icons		=	[ 'pwa-small-icon',  'pwa-big-icon',  'thumbnail', 'large' ];
		$meta_data	=	wp_get_attachment_metadata( $iconID );
		$sizesN		=	$meta_data ? count( $meta_data ) : 0;

		if ( ! is_array( $meta_data ) ) return [];

		for ( $ii = 0; $ii < $sizesN; $ii++ ) {
			if ( isset( array_keys( $meta_data[ 'sizes' ] )[ $ii ], $icons[ $ii ] ) ) {
				$iconsSet[]	=	$icons[ $ii ];
				$iKeys[]	=	array_keys( $meta_data[ 'sizes' ] )[ $ii ];
			}
		}

		// Merge icons and Meta data sizes
		$sizes	=	array_unique( array_merge( [ 'full' ], $iconsSet, $iKeys ) );

		if ( ! is_array( $sizes ) ) return [];

		foreach ( $sizes as $size ) {
			$url_data	=	wp_get_attachment_image_src( $iconID, $size );
			if ( ! is_array( $url_data ) ) continue;

			$image	=	array(
				'file'		=>	$url_data[0],
				'width'		=>	$url_data[1],
				'height'	=>	$url_data[2]
			);

			if ( isset( $meta_data[ 'sizes' ][ $size ] ) ) {
				$image[ 'mime-type' ]	=	$meta_data[ 'sizes' ][ $size ][ 'mime-type' ];
			}
			else {
				$image[ 'mime-type' ]	=	$site_icon->post_mime_type;
			}

			$iconsData[]	=	array(
				'src'		=>	$image[ 'file' ],
				'sizes'		=>	$image[ 'width' ] . 'x' . $image[ 'height' ],
				'type'		=>	$image[ 'mime-type' ]
			);
		}

	return $iconsData;
	}

	return [];
	}

/*
$data[ 'screenshots' ][]	=	array(
	'src'	=>	$image[ 'file' ],
	"sizes"	=>	$image[ 'width' ] . 'x' . $image[ 'height' ],
	"type"	=>	$image[ 'mime-type' ],
	"purpose"	=>	"maskable"
);
*/
}
