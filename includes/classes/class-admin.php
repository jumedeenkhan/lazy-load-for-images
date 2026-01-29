<?php
namespace MozediaLazyLoad;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle admin-side assets for the plugin.
 */
class Admin {

	/**
	 * Register admin hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'admin_enqueue_scripts', [ __CLASS__, 'admin_assets' ] );
	}

	/**
	 * Enqueue admin assets for the settings page.
	 *
	 * @param string $hook Current admin page hook.
	 * @return void
	 */
	public static function admin_assets( $hook ) {

		// Only load on plugin settings page
		if ( strpos( $hook, 'mozedia_lazyload' ) === false ) {
			return;
		}

		wp_enqueue_script(
			'mll-admin-js',
			MLL_URL . 'assets/js/plugin-settings.js',
			[],
			MLL_VERSION,
			true
		);

		wp_enqueue_style(
			'mll-admin',
			MLL_URL . 'assets/css/plugin-settings.css',
			[],
			MLL_VERSION
		);
	}
}
