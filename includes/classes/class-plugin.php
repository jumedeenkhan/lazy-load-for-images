<?php
namespace MozediaLazyLoad;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin bootstrap class.
 *
 * Responsible for initializing core components
 * and registering WordPress hooks.
 */
final class Plugin {

    /**
     * Holds the single plugin instance.
     *
     * @var Plugin|null
     */
    private static $instance;

    /**
     * Get the plugin instance.
     *
     * Ensures only one instance of the plugin
     * is loaded during runtime.
     *
     * @return Plugin
     */
    public static function instance() {
        if ( ! self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
	
    /**
     * Plugin constructor.
     *
     * Marked private to enforce singleton usage.
     */
	private function __construct() {
		$this->init();
	}

    /**
     * Initialize plugin components.
     *
     * Loads required class files and
     * registers core WordPress hooks.
     */
    private function init() {
        require_once MLL_PATH . 'includes/classes/class-settings.php';
        require_once MLL_PATH . 'includes/classes/class-helpers.php';
        require_once MLL_PATH . 'includes/classes/class-assets.php';
		require_once MLL_PATH . 'includes/classes/class-admin.php';	

		require_once MLL_PATH . 'includes/mozedia-images.php';
		require_once MLL_PATH . 'includes/mozedia-bg-images.php';
		require_once MLL_PATH . 'includes/mozedia-iframes.php';
        require_once MLL_PATH . 'includes/classes/class-content.php';

        Settings::init();
        Assets::init();
		Admin::init();
        Content::init();

        add_filter(
            'plugin_action_links_' . MLL_BASENAME,
            [ $this, 'settings_link' ]
        );
    }

    /**
     * Add Settings link on the Plugins page.
     *
     * @param array $links Existing plugin action links.
     * @return array Modified plugin action links.
     */
    public function settings_link( $links ) {
		$settings_link = sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url( 'options-general.php?page=mozedia_lazyload' ) ),
			esc_html__( 'Settings', 'lazy-load-for-images' )
		);

        array_unshift( $links, $settings_link );
        return $links;
    }
}
