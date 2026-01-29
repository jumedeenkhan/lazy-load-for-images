<?php
/**
 * Plugin Name: Smart LazyLoad
 * Plugin URI:  https://www.mozedia.com/lazy-load-wordpress/
 * Description: A lightweight, pure JavaScript solution to lazy load images, iframes, and videos without jQuery or external libraries.
 * Version: 2.0.0
 * Author: Jumedeen Khan
 * Author URI:  https://www.mozedia.com/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 5.8
 * Requires PHP: 7.2
 * Tested up to: 6.9
 * Text Domain: lazy-load-for-images
 */

/**
 * Prevent direct access to this file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin core constants.
 *
 * These constants are used throughout the plugin
 * to manage paths, URLs, versioning, and references.
 */
define( 'MLL_VERSION', '2.0.0' );
define( 'MLL_PATH', plugin_dir_path( __FILE__ ) );
define( 'MLL_URL', plugin_dir_url( __FILE__ ) );
define( 'MLL_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Load the main plugin bootstrap file.
 */
require_once MLL_PATH . 'includes/mozedia-lazyload.php';

/**
 * Load plugin translations.
 */
add_action( 'plugins_loaded', 'mll_load_textdomain' );

/**
 * Initialize the plugin text domain.
 */
function mll_load_textdomain() {
	load_plugin_textdomain( 'lazy-load-for-images', false, dirname( MLL_BASENAME ) . '/languages' );
}

/**
 * Initialize the Smart LazyLoad plugin.
 */
MozediaLazyLoad\Plugin::instance();
