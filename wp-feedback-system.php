<?php

if (!defined('ABSPATH'))
    exit;

/**
 * Plugin Name: WP Feedback System
 * Description: Feedback system for your blog
 * Version: 1.0.0
 * Author: sergpost33
 * Text Domain: pfs
 * Domain Path: /languages
 * License: GPLv2 or later
 */

define('PFS_VERSION', '1.0.1');
define('PFS__PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PFS__PLUGIN_URL', plugin_dir_url(__FILE__));

require_once(PFS__PLUGIN_DIR . 'pfs.class.php');

register_activation_hook( __FILE__, array( 'PFS', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'PFS', 'plugin_deactivation' ) );