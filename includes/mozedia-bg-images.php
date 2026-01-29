<?php
namespace MozediaLazyLoad;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mozedia_BG_Images {

	public static function apply( $html, $o ) {

		if ( empty( $o['background_images'] ) ) {
			return $html;
		}

		$allowed_tags = 'div|figure|section|aside|li|span|a';

		return preg_replace_callback(
			'/<(' . $allowed_tags . ')\b[^>]*>/i',
			function ( $m ) {

				$tag = $m[0];

				if ( Helpers::hasExcludedAttribute( $tag ) ) {
					return $tag;
				}

				$has_lazy = strpos( $tag, 'mozedia-lazyload' ) !== false;
				$has_mll  = strpos( $tag, 'mll-lazy' ) !== false;
				$has_bg   = strpos( $tag, 'data-bg=' ) !== false;
				$bg_url   = '';

				if ( $has_bg && preg_match( '/data-bg=(["\'])(.*?)\1/i', $tag, $m_bg ) ) {
					$bg_url = esc_url( $m_bg[2] );
				}

				if (
					empty( $bg_url ) &&
					preg_match( '/background-image\s*:\s*url\((["\']?)(.*?)\1\)/i', $tag, $bg )
				) {
					$bg_url = esc_url( $bg[2] );
					$tag = preg_replace(
						'/background-image\s*:\s*url\((["\']?)(.*?)\1\)\s*;?/i',
						'',
						$tag
					);
				}

				if ( empty( $bg_url ) ) {
					return $tag;
				}

				if ( ! $has_bg ) {
					$tag = rtrim( $tag, '>' ) . ' data-bg="' . $bg_url . '">';
				}

				$classes = [ 'mozedia-lazyload', 'mll-lazy' ];

				if ( preg_match( '/class=(["\'])(.*?)\1/i', $tag, $cm ) ) {

					$current = array_filter( explode( ' ', $cm[2] ) );

					foreach ( $classes as $cls ) {
						if ( ! in_array( $cls, $current, true ) ) {
							$current[] = $cls;
						}
					}

					$tag = preg_replace(
						'/class=(["\'])(.*?)\1/i',
						'class=$1' . implode( ' ', $current ) . '$1',
						$tag,
						1
					);
				} else {
					$tag = rtrim( $tag, '>' ) . ' class="mozedia-lazyload mll-lazy">';
				}

				$tag = preg_replace('/style=(["\'])(\s*;?\s*)\1/i', '', $tag);

				return $tag;
			},
			$html
		);
	}
}
