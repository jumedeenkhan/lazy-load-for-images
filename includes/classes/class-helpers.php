<?php
namespace MozediaLazyLoad;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper utility methods used across the plugin.
 */
class Helpers {

	/**
	 * Check whether a given URL belongs to YouTube.
	 *
	 * @param string $src Media source URL.
	 * @return bool
	 */
	public static function is_youtube( $src ) {
		
		if ( empty( $src ) || ! is_string( $src ) ) {
			return false;
		}

		return ( strpos( $src, 'youtube.com' ) !== false || strpos( $src, 'youtu.be' ) !== false );
	}

	/**
	 * Extract the YouTube video ID from a URL.
	 *
	 * @param string $src YouTube URL.
	 * @return string|false
	 */
	public static function get_youtube_id( $src ) {
		
		if ( empty( $src ) || ! is_string( $src ) ) {
			return false;
		}
		
		if ( preg_match( '~youtu\.be/([^\?&]+)~', $src, $m ) ) {
			return $m[1];
		}

		if ( preg_match( '~v=([^\?&]+)~', $src, $m ) ) {
			return $m[1];
		}

		if ( preg_match( '~/embed/([^\?&]+)~', $src, $m ) ) {
			return $m[1];
		}

		return false;
	}

	/**
	 * Generate a lazy-load YouTube placeholder markup.
	 *
	 * @param string $video_id YouTube video ID.
	 * @param string $query    Optional query parameters.
	 * @param string $alt      Alternative text for accessibility.
	 * @return string
	 */
	public static function youtube_placeholder( $video_id, $query = '', $alt = '' ) {
		
		$embed_url = 'https://www.youtube.com/embed/' . $video_id;

		return sprintf(
			'<div class="mll-youtube-player" data-src="%2$s" data-id="%1$s" data-query="%3$s" data-alt="%4$s"></div>',
			esc_attr( $video_id ),
			esc_url( $embed_url ),
			esc_attr( $query ),
			esc_attr( $alt )
		);
	}

	/**
	 * Check for excluded lazy load attributes.
	 *
	 * @param string $image HTML tag string.
	 * @return bool
	 */
	public static function hasExcludedAttribute( $image ) {

		foreach ( self::getExcludedAttributes() as $excluded_attribute ) {
			if ( strpos( $image, $excluded_attribute ) !== false ) {
				return true;
			}
		}

		return false;
	}
	
	/**
	 * Checks if iframe is excluded from lazyload.
	 *
	 * @param string $iframe HTML tag string.
	 * @return bool
	 */
	public static function isIframeExcluded( $iframe ) {

		foreach ( Helpers::getExcludedPatterns() as $excluded_pattern ) {
			if ( strpos( $iframe, $excluded_pattern ) !== false ) {
				return true;
			}
		}

		return false;
	}
	
	/**
	 * Get list of attributes excluded from lazy loading.
	 *
	 * @return array
	 */
	public static function getExcludedAttributes() {
		
		/**
		 * Filters attributtes excluded
		 */
		return apply_filters(
			'mozedia_lazyload_excluded_attributes',
			[
				'no-lazyload',
				'data-no-lazy',
				'data-src=',
				'data-srcset=',
				'data-lazy-original=',
				'data-lazy-src=',
				'data-lazysrc=',
				'data-lazyload=',
				'data-bgposition=',
				'lazy-slider-img=',
				'class="ls-l',
				'class="ls-bg',
				'class="hero-image',
				'soliloquy-image',
				'loading="eager"',
				'data-large_image',
				'data-skip-lazy',
				'skip-lazy',
			]
		);
	}

	/**
	 * Gets iframes patterns excluded from lazyload
	 *
	 * @return array
	 */
	public static function getExcludedPatterns() {
		/**
		 * Filters the patterns excluded
		 */
		return apply_filters(
			'mozedia_lazyload_iframe_excluded_patterns',
			[
				'no-lazyload',
				'data-no-lazy=',
				'loading="eager"',
				'data-skip-lazy',
				'skip-lazy',
				'google_ads_iframe_',
				'recaptcha/api/fallback',
				'gform_ajax_frame',
			]
		);
	}
}
