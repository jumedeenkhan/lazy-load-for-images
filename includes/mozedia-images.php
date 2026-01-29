<?php
namespace MozediaLazyLoad;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mozedia_Images {

	private static $first_skipped = false;

	public static function apply( $html, $o ) {

		if ( empty( $o['images'] ) ) {
			return $html;
		}

		return preg_replace_callback(
			'/<img\b[^>]*>/i',
			function ( $m ) use ( $o ) {

				$img = $m[0];

				if ( strpos( $img, ' src=' ) === false ) {
					return $img;
				}

				if ( ! empty( $o['skip_first'] ) && ! self::$first_skipped ) {
					self::$first_skipped = true;
					return $img;
				}

				if ( Helpers::hasExcludedAttribute( $img ) ) {
					return $img;
				}

				$noscript = '<noscript>' . $img . '</noscript>';

				if ( ! empty( $o['use_native'] ) ) {

					if ( strpos( $img, 'loading=' ) === false ) {
						$img = preg_replace( '/<img/i', '<img loading="lazy"', $img, 1 );
					}

					$noscript = '';
				}

				if ( strpos( $img, 'class=' ) !== false ) {
					$img = preg_replace(
						'/class=(["\'])(.*?)\1/i',
						'class=$1$2 mll-lazy$1',
						$img,
						1
					);
				} else {
					$img = preg_replace( '/<img/i', '<img class="mll-lazy"', $img, 1 );
				}

				$placeholder = apply_filters(
					'mozedia_svg_placeholder',
					'data:image/svg+xml,%3Csvg%20xmlns=\'http://www.w3.org/2000/svg\'%20viewBox=\'0%200%201%201\'%3E%3C/svg%3E'
				);

				if ( empty( $o['use_native'] ) ) {
					$img = preg_replace(
						'/\ssrc=(["\'])(.*?)\1/i',
						' src="' . esc_attr( $placeholder ) . '" data-src=$1$2$1',
						$img,
						1
					);
				}

				$img = preg_replace(
					'/\ssrcset=(["\'])(.*?)\1/i',
					' data-srcset=$1$2$1',
					$img
				);

				$img = preg_replace(
					'/\ssizes=(["\'])(.*?)\1/i',
					' data-sizes=$1$2$1',
					$img
				);

				return $img . $noscript;
			},
			$html
		);
	}
}
