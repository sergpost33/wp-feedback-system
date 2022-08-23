<?php

if (!defined('ABSPATH'))
    exit;

class PFS
{
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

    public static function enqueue_scripts()
    {
        wp_enqueue_style('pfs', plugins_url('/assets/css/pfs.css', __FILE__));
        wp_enqueue_script('pfs', plugins_url('/assets/js/pfs.js', __FILE__), ['jquery']);
        wp_localize_script('pfs', 'PFS', ['ajax_url' => admin_url('admin-ajax.php')]);
    }

    public static function add_feedback()
    {
        global $wpdb;

        parse_str($_POST['data'], $data);

        if (!wp_verify_nonce($data['_pfsnonce'], '_new_feedback')) {
            wp_send_json_error('Security Alert!');
        }

        // Server-side validation
        $errors = [];

        if (empty($data['pfs_name'])) {
            $errors['pfs_name'] = 'Name is empty';
        }

        if (empty($errors['pfs_name']) && strlen($data['pfs_name']) > 50) {
            $errors['pfs_name'] = 'Name is too large';
        }

        if (empty($data['pfs_email'])) {
            $errors['pfs_email'] = 'Email is empty';
        }

        if (empty($errors['pfs_email']) && !is_email($data['pfs_email'])) {
            $errors['pfs_email'] = 'Email is incorrect';
        }

        if (empty($errors['pfs_email']) && strlen($data['pfs_email']) > 50) {
            $errors['pfs_email'] = 'Email is too large';
        }

        if (empty($data['pfs_phone'])) {
            $errors['pfs_phone'] = 'Phone is empty';
        }

        if (empty($errors['pfs_phone']) && strlen($data['pfs_phone']) > 25) {
            $errors['pfs_phone'] = 'Phone is too large';
        }

        if (!empty($errors)) {
            wp_send_json_error(['errors' => $errors, 'message' => 'One or more fields have errors']);
        } else {
            $wpdb->insert(self::get_table_name(), [
                "name" => $data['pfs_name'],
                "email" => $data['pfs_email'],
                "phone" => $data['pfs_phone'],
                "time" => time()
            ]);

            wp_send_json_success(['message' => 'Feedback sent!']);
        }
    }

    public static function shortcode_form($attributes)
    {
        $form_data['header'] = !empty($attributes['header']) ? $attributes['header'] : 'Feedback System';
        $form_data['submit_text'] = !empty($attributes['submit_text']) ? $attributes['submit_text'] : 'Submit';

        return self::get_view('form.php', $form_data);
    }

    private static function get_view($file, $data)
    {
        extract($data);

        ob_start();
        include(PFS__PLUGIN_DIR . '/views/' . $file);
        return ob_get_clean();
    }

    private static function get_table_name()
    {
        global $wpdb;
        return $wpdb->prefix . "pfs_feedbacks";
    }
}
