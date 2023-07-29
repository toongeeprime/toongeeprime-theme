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
	 *	Instantiate
	 */
	private static $instance;

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance	=	new self();
		}
		return self::$instance;
	}


	public function mainIcon() {

		if ( $icon_id = get_theme_mod( 'prime2g_pwapp_primaryicon' ) ) {
			$iconURL	=	wp_get_attachment_image_url( $icon_id, [ 144, 144 ] );
		}
		elseif ( $icon_id = get_option( 'site_icon' ) ) {
			$iconURL	=	wp_get_attachment_image_url( $icon_id, [ 144, 144 ] );
		}
		else {
			$iconURL	=	PRIME2G_PWA_IMAGE . 'default.png';
		}

		return [
			'src'		=>	$iconURL,
			'sizes'		=>	'144x144',
			'type'		=>	'image/png',
			'purpose'	=>	'any'
		];

	}


	public function icons( $iconID = 0 ) {

		$iconsData	=	[];
		$iconID		=	$iconID ?: get_option( 'site_icon' );
		$site_icon	=	get_post( $iconID );

		if ( $site_icon ) {

		$icons		=	[ 'pwa-small-icon',  'pwa-big-icon',  'thumbnail', 'large' ];
		$meta_data	=	wp_get_attachment_metadata( $iconID );
		$sizesN		=	$meta_data ? count( $meta_data ) : 0;

		$iKeys	=	$iconsSet	=	[];

		for ( $ii = 0; $ii < $sizesN; $ii++ ) {
			if ( isset( array_keys( $meta_data[ 'sizes' ] )[ $ii ], $icons[ $ii ] ) ) {
				$iconsSet[]	=	$icons[ $ii ];
				$iKeys[]	=	array_keys( $meta_data[ 'sizes' ] )[ $ii ];
			}
		}

		// Merge icons and Meta data sizes
		$icons	=	array_unique( array_merge( [ 'full' ], $iconsSet, $iKeys ) );

		if ( ! $icons ) return [];

		foreach ( $icons as $icon ) {
			$url_data	=	wp_get_attachment_image_src( $iconID, $icon );
			if ( ! $url_data ) continue;

			$image	=	array(
				'file'		=>	$url_data[0],
				'width'		=>	$url_data[1],
				'height'	=>	$url_data[2]
			);

			if ( isset( $meta_data[ 'sizes' ][ $icon ] ) ) {
				$image[ 'mime-type' ]	=	$meta_data[ 'sizes' ][ $icon ][ 'mime-type' ];
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


	public function html_metadata( $iconID ) {
		$start		=	new Prime2g_Web_Manifest();
		$manifest	=	$start->get_manifest( $iconID );
		$iconURL	=	$this->mainIcon()[ 'src' ];

echo
'<meta name="pwa" content="toongeeprime-theme-web-app" />
<meta name="theme-color" content="'. esc_attr( $manifest['theme_color'] ) .'">
<meta name="apple-mobile-web-app-title" content="'. esc_attr( $manifest['name'] ) .'">
<meta name="application-name" content="'. esc_attr( $manifest['name'] ) .'">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<link rel="apple-touch-icon" sizes="144x144" href="'. esc_url( $iconURL ) .'" />
<meta name="apple-mobile-web-app-status-bar-style" content="default">' #"default", "black", "black-translucent" or "white"
. PHP_EOL;
// <meta name="apple-touch-startup-image" content="splash.png">

		// $linktags = '';
		// if ( isset( $manifest[ 'icons' ] ) && ! empty( $manifest[ 'icons' ] ) ) {
			// $linktags .= '<link rel="apple-touch-icon" sizes="192x192" href="'. esc_url(  ) .'">' . PHP_EOL;
		// }

		// if ( isset( $manifest[ 'splash_icon' ] ) && ! empty( $manifest[ 'splash_icon' ] ) ) {
			// $linktags .=  '<link rel="apple-touch-icon" sizes="512x512" href="'. esc_url(  ) .'">' . PHP_EOL;
		// }
	}

}

