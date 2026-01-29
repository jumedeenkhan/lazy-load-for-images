<?php
/**
 * Load LazyLoad core files.
 *
 * This file is responsible for including
 * the main plugin bootstrap and core logic.
 *
 * @package MozediaLazyLoad
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Include core functionality and plugin class.
 */
require_once MLL_PATH . 'includes/lazyload-core.php';
require_once MLL_PATH . 'includes/classes/class-plugin.php';
