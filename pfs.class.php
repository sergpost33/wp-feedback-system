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
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;");
    }

    public static function plugin_deactivation()
    {

    }

    private static function get_table_name()
    {
        global $wpdb;
        return $wpdb->prefix . "pfs_feedbacks";
    }
}
