<?php

add_action('admin_menu', 'setup_export_menu');
add_action('save_post', 'json_export');
add_action('init', 'handle_export');


function setup_export_menu()
{
    add_submenu_page('edit.php?post_type=books', 'Export', 'Export', 'manage_options', 'export-books', 'export');
}

function export()
{
    @include('Forms/export_form.html');
}

function handle_export()
{
    if (isset($_GET['export_all_posts'])) {
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename=exported_books.json');

        $args = array(
            "post_type" => "books",
            'orderby' => 'ID',
            #"posts_per_page" => -1 #all ->necessary?
        );

        $query = new WP_Query($args);
        $posts = array();


        while ($query->have_posts()) {
            $item = $query->the_post();

            $post_author_id = get_the_author_meta('ID');
            $post_author = get_the_author();
            $post_type = get_post_type(get_the_ID());
            $post_title = get_the_title();
            $post_content = get_the_content();
            $post_name = get_post_field('post_name', $item);
            $post_status = get_post_status($item);

            #$query->the_post();# -> uncomment to get less..dont know why...
            $posts[] = array(
                'post_author_id' => $post_author_id,
                'post_author' => $post_author,
                'post_type' => $post_type,
                'post_title' => $post_title,
                'post_content' => $post_content,
                'post_name' => $post_name,
                'post_status' => $post_status
            );
        }

        $response['books'] = $posts;

        wp_reset_postdata();

        $data = json_encode($response);
        die($data);
    }
}


