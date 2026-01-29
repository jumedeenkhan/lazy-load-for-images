<?php
namespace MozediaLazyLoad;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle content filtering and lazy loading logic.
 */
class Content {

	/**
	 * Register content filters.
	 *
	 * @return void
	 */
	public static function init() {

		$filters = [
			'the_content',
			'post_thumbnail_html',
			'get_avatar',
			'widget_text',
			'widget_text_content',
			'widget_block_content',
			//'do_shortcode',
			//'the_excerpt',
			//'comment_text',
		];

		foreach ( $filters as $filter ) {
			add_filter( $filter, [ __CLASS__, 'filter_html' ], 20 );
		}
	}

	/**
	 * Master HTML filter.
	 *
	 * @param string $html HTML content.
	 * @return string
	 */
	public static function filter_html( $html ) {

		if ( ! self::shouldLazyload() || empty( $html ) ) {
			return $html;
		}

		// Exclude content containing noscript tags
		if ( stripos( $html, '<noscript>' ) !== false ) {
			return $html;
		}

		$o = Settings::get();

		if ( empty( $o['enabled'] ) ) {
			return $html;
		}

		if ( ! empty( $o['disable_loggedin'] ) && is_user_logged_in() ) {
			return $html;
		}

		/**
		 * Apply lazy loading handlers
		 * (logic moved to separate files, behavior unchanged)
		 */
		if ( class_exists( '\MozediaLazyLoad\Mozedia_Images' ) ) {
			$html = Mozedia_Images::apply( $html, $o );
		}

		if ( class_exists( '\MozediaLazyLoad\Mozedia_BG_Images' ) ) {
			$html = Mozedia_BG_Images::apply( $html, $o );
		}

		if ( class_exists( '\MozediaLazyLoad\Mozedia_Iframes' ) ) {
			$html = Mozedia_Iframes::apply( $html, $o );
		}

		return $html;
	}

	/**
	 * Determine whether lazy loading should run.
	 *
	 * @return bool
	 */
	private static function shouldLazyload() {

		if ( is_admin() || is_feed() || is_preview() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
			return false;
		}

		if ( self::isPageBuilder() ) {
			return false;
		}

		if ( ! apply_filters( 'do_mozedia_lazyload', true ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Detect common page builder environments.
	 *
	 * @return bool
	 */
	private static function isPageBuilder() {

		$excluded_parameters = [
			'fl_builder',
			'et_fb',
			'ct_builder',
		];

		foreach ( $excluded_parameters as $excluded ) {
			if ( isset( $_GET[ $excluded ] ) ) {
				return true;
			}
		}

		return false;
	}
}
