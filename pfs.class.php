<?php

if (!defined('ABSPATH'))
    exit;

class PFS
{
    public static function init()
    {
        load_plugin_textdomain('pfs', false, 'wp-feedback-system/languages/');
    }

    // Try to create table for feedbacks, if it not exists
    public static function plugin_activation()
    {
        global $wpdb;
        $table_name = self::get_table_name();

        $wpdb->query("CREATE TABLE IF NOT EXISTS `{$table_name}` (
          `id` int(11) NOT NULL,
          `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
          `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
          `phone` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
          `time` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");


        $wpdb->query("ALTER TABLE `{$table_name}`
            ADD PRIMARY KEY (`id`);");

        $wpdb->query("ALTER TABLE `{$table_name}`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
    }

    public static function get_table_name()
    {
        global $wpdb;
        return $wpdb->prefix . "pfs_feedbacks";
    }

    public static function enqueue_scripts()
    {
        wp_enqueue_style('pfs', plugins_url('/assets/css/pfs.css', __FILE__));
        wp_enqueue_script('inputmask', '//cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8-beta.17/jquery.inputmask.min.js', ['jquery']);
        wp_enqueue_script('pfs', plugins_url('/assets/js/pfs.js', __FILE__), ['jquery']);
        wp_localize_script('pfs', 'PFS', ['ajax_url' => admin_url('admin-ajax.php')]);
    }

    public static function add_feedback()
    {
        global $wpdb;

        parse_str($_POST['data'], $data);

        if (!wp_verify_nonce($data['_pfsnonce'], '_new_feedback')) {
            wp_send_json_error(__("Security Alert!", "pfs"));
        }

        // Server-side validation
        $errors = [];

        if (empty($data['pfs_name'])) {
            $errors['pfs_name'] = __("Name is empty", "pfs");
        }

        if (empty($errors['pfs_name']) && strlen($data['pfs_name']) > 50) {
            $errors['pfs_name'] = __("Name is too large", "pfs");
        }

        if (empty($data['pfs_email'])) {
            $errors['pfs_email'] = __("Email is empty", "pfs");
        }

        if (empty($errors['pfs_email']) && !is_email($data['pfs_email'])) {
            $errors['pfs_email'] = __("Email is incorrect", "pfs");
        }

        if (empty($errors['pfs_email']) && strlen($data['pfs_email']) > 50) {
            $errors['pfs_email'] = __("Email is too large", "pfs");
        }

        if (empty($data['pfs_phone'])) {
            $errors['pfs_phone'] = __("Phone is empty", "pfs");
        }

        if (empty($errors['pfs_phone']) && strlen($data['pfs_phone']) > 25) {
            $errors['pfs_phone'] = __("Phone is too large", "pfs");
        }

        if (!empty($errors)) {
            wp_send_json_error(['errors' => $errors, 'message' => __("One or more fields have errors", "pfs")]);
        } else {
            $wpdb->insert(self::get_table_name(), [
                "name" => $data['pfs_name'],
                "email" => $data['pfs_email'],
                "phone" => $data['pfs_phone'],
                "time" => time()
            ]);

            wp_send_json_success(['message' => __("Feedback sent!", "pfs")]);
        }
    }

    public static function shortcode_form($attributes)
    {
        $form_data['header'] = !empty($attributes['header']) ? $attributes['header'] : __("Feedback System", "pfs");
        $form_data['submit_text'] = !empty($attributes['submit_text']) ? $attributes['submit_text'] : __("Submit", "pfs");

        return self::get_view('form.php', $form_data);
    }

    public static function add_admin_page()
    {

        add_menu_page(
            __("Feedbacks", "pfs"),
            __("Feedbacks", "pfs"),
            'edit_plugins',
            'feedbacks',
            [__CLASS__, 'handler_admin_page'],
            'dashicons-admin-comments',
            68
        );
    }

    public static function handler_admin_page()
    {
        $feedbackListTable = new Feedback_List_Table();
        $feedbackListTable->prepare_items();
        include(PFS__PLUGIN_DIR . '/views/admin/feedbacks_list.php');
    }

    public static function add_feedback_list_link($links)
    {
        $url = esc_url(add_query_arg(
            'page',
            'feedbacks',
            get_admin_url() . 'admin.php'
        ));

        $links[] = "<a href='$url'>" . __("Feedbacks", "pfs") . '</a>';

        return $links;
    }

    private static function get_view($file, $data)
    {
        extract($data);

        ob_start();
        include(PFS__PLUGIN_DIR . '/views/' . $file);
        return ob_get_clean();
    }
}
