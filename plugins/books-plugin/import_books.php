<?php

add_action('admin_menu', 'setup_import_menu');

function setup_import_menu()
{
    add_submenu_page('edit.php?post_type=books', 'Import', 'Import', 'manage_options', 'import-books', 'import');
}

function import()
{
    handle_import();
    @include('Forms/import_form.html');
}

function handle_import()
{
    if ($_FILES['importFile']['tmp_name']) {
        if (validate_json($_FILES) === JSON_ERROR_NONE) {

            $file = file_get_contents($_FILES["importFile"]["tmp_name"]);
            $array = json_decode($file, true);

            foreach ($array['books'] as $item) {
                if (!slug_exists($item['post_name'])) {
                    echo "INSERT: " . $item['post_name'] . "<br>";

                    wp_insert_post(array(
                        'post_name' => $item['post_name'],
                        "post_author" => $item['post_author_id'], # ! exist -> id = 1 (root)
                        "post_type" => $item['post_type'],
                        "post_content" => $item['post_content'],
                        'post_title' => $item['post_title'],
                        'post_status' => $item['post_status'],
                    ));
                } else {
                    echo "SKIPPED: " . $item['post_name'] . "<br>";
                }
            }
        } else {
            echo 'error validating json';
        }
    } else {
        echo 'No File added, please add some.';
    }
}

function validate_json($data = NULL)
{
    if (!empty($data)) {
        json_decode($data);
        return json_last_error();
    }
    return false;
}

function slug_exists($post_name)
{
    global $wpdb;
    if ($wpdb->get_row("SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "'")) {
        return true;
    } else {
        return false;
    }
}