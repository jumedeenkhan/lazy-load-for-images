<?php
namespace MozediaLazyLoad;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mozedia_Iframes {

	public static function apply( $html, $o ) {

		if ( empty( $o['iframes'] ) ) {
			return $html;
		}

		return preg_replace_callback(
			'/<iframe[^>]+src=(["\'])(.*?)\1[^>]*><\/iframe>/i',
			function ( $m ) use ( $o ) {

				$iframe = $m[0];
				$src    = esc_url_raw( $m[2] );

				if ( Helpers::isIframeExcluded( $iframe ) ) {
					return $iframe;
				}

				$placeholder = apply_filters( 'mozedia_lazyload_placeholder', 'about:blank' );
				$noscript    = '<noscript>' . $iframe . '</noscript>';

				if ( ! empty( $o['youtube_thumbnail'] ) && Helpers::is_youtube( $src ) ) {

					$id = Helpers::get_youtube_id( $src );

					if ( $id ) {
						$parsed = wp_parse_url( $src );
						$query  = ! empty( $parsed['query'] ) ? $parsed['query'] : '';
						$alt    = __( 'YouTube video player', 'lazy-load-for-images' );

						return Helpers::youtube_placeholder( $id, $query, $alt ) . $noscript;
					}
				}

				if ( ! empty( $o['use_native'] ) && strpos( $iframe, 'loading=' ) === false ) {
					$iframe = preg_replace( '/<iframe/i', '<iframe loading="lazy"', $iframe, 1 );
				}

				if ( strpos( $iframe, 'class=' ) !== false ) {
					$iframe = preg_replace(
						'/class=(["\'])(.*?)\1/i',
						'class=$1$2 mll-lazy$1',
						$iframe,
						1
					);
				} else {
					$iframe = preg_replace(
						'/<iframe/i',
						'<iframe class="mll-lazy"',
						$iframe,
						1
					);
				}

				$iframe = preg_replace(
					'/\ssrc=(["\'])(.*?)\1/i',
					' src=$1' . esc_attr( $placeholder ) . '$1 data-src=$1$2$1',
					$iframe,
					1
				);

				return $iframe . $noscript;
			},
			$html
		);
	}
}
