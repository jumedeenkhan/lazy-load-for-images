<?php
namespace MozediaLazyLoad;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle plugin settings and admin configuration.
 */
class Settings {

	/**
	 * Get default plugin options.
	 *
	 * @return array
	 */
	public static function defaults() {
		return [
			'enabled'            => 1,
			'images'             => 1,
			'iframes'            => 0,
			'youtube_thumbnail'  => 0,
			'background_images'  => 0,
			'use_native'         => 0,
			'threshold'          => 300,
			'skip_first'         => 1,
			'inline_assets'      => 0,
			'disable_loggedin'   => 0,
		];
	}

	/**
	 * Retrieve saved options merged with defaults.
	 *
	 * @return array
	 */
	public static function get() {
		return wp_parse_args(
			get_option( 'mll_settings', [] ),
			self::defaults()
		);
	}

	/**
	 * Register admin hooks.
	 *
	 * @return void
	 */
	public static function init() {

		add_action( 'admin_menu', [ __CLASS__, 'menu' ] );
		add_action( 'admin_init', [ __CLASS__, 'register' ] );
	}

	/**
	 * Sanitize and normalize settings input.
	 *
	 * @param array $input Raw settings input.
	 * @return array Sanitized settings.
	 */
	public static function sanitize( $input ) {

		$defaults = self::defaults();
		$output   = [];

		// Checkbox fields (force 0 if missing)
		$checkboxes = [
			'enabled',
			'images',
			'iframes',
			'youtube_thumbnail',
			'background_images',
			'use_native',
			'skip_first',
			'inline_assets',
			'disable_loggedin',
		];

		foreach ( $checkboxes as $key ) {
			$output[ $key ] = isset( $input[ $key ] ) ? 1 : 0;
		}

		// Threshold value (number field)
		$output['threshold'] = isset( $input['threshold'] )
			? max( 0, absint( $input['threshold'] ) )
			: $defaults['threshold'];

		// Add success notice
		add_settings_error(
			'mll_settings',
			'mll_settings_saved',
			__( 'Settings saved.', 'lazy-load-for-images' ),
			'updated'
		);

		return $output;
	}

	/**
	 * Add plugin settings page to the admin menu.
	 *
	 * @return void
	 */
	public static function menu() {

		add_options_page(
			__( 'Mozedia Lazy Load', 'lazy-load-for-images' ),
			__( 'LazyLoad', 'lazy-load-for-images' ),
			'manage_options',
			'mozedia_lazyload',
			[ __CLASS__, 'page' ]
		);
	}

	/**
	 * Register settings with sanitize callback.
	 *
	 * @return void
	 */
	public static function register() {
		register_setting(
			'mll_settings_group',
			'mll_settings',
			[ __CLASS__, 'sanitize' ]
		);
	}
	
	/**
	 * Render the plugin settings page.
	 *
	 * @return void
	 */
	public static function page() {
		
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		
		require MLL_PATH . 'admin/settings-page.php';
	}
}
