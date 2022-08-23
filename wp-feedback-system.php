<?php

// ToDo add phone verification on frontend using library inputmask
// ToDo add validation on frontend
// ToDo add localization

if (!defined('ABSPATH'))
    exit;

/**
 * Plugin Name: WP Feedback System
 * Description: Feedback system for your blog
 * Version: 1.0.2
 * Author: sergpost33
 * Text Domain: pfs
 * Domain Path: /languages
 * License: GPLv2 or later
 */

define('PFS_VERSION', '1.0.2');
define('PFS__PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PFS__PLUGIN_URL', plugin_dir_url(__FILE__));

// WP_List_Table is not loaded automatically
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

require_once(PFS__PLUGIN_DIR . 'pfs.class.php');
require_once(PFS__PLUGIN_DIR . 'feedback-list-table.class.php');

register_activation_hook(__FILE__, ['PFS', 'plugin_activation']);

add_shortcode('feedback_system', ['PFS', 'shortcode_form']);

add_action('wp_enqueue_scripts', ['PFS', 'enqueue_scripts']);

add_action('wp_ajax_pfs_add_feedback', ['PFS', 'add_feedback']);
add_action('wp_ajax_nopriv_pfs_add_feedback', ['PFS', 'add_feedback']);

add_action('admin_menu', ['PFS', 'add_admin_page']);
