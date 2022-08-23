<?php

if (!defined('ABSPATH'))
    exit;

class Feedback_List_Table extends WP_List_Table
{
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();

        $perPage = 25;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args(array(
            'total_items' => $totalItems,
            'per_page' => $perPage
        ));

        $data = array_slice($data, (($currentPage - 1) * $perPage), $perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    public function get_columns()
    {
        $columns = array(
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'time' => 'Date'
        );

        return $columns;
    }

    public function get_hidden_columns()
    {
        return [];
    }

    public function get_sortable_columns()
    {
        return [];
    }

    private function table_data()
    {
        global $wpdb;

        $table_name = PFS::get_table_name();
        $data = $wpdb->get_results("SELECT * FROM `{$table_name}` WHERE 1 ORDER BY `time` DESC", ARRAY_A);
        return $data;
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'time':
                return date('d.m.Y H:i', $item[$column_name]);

            default:
                return $item[$column_name];
        }
    }
}