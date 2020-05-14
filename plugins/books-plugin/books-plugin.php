<?php

/**
 * @package books-plugin
 */
/*
Plugin Name: Books-Plugin
Plugin URI: github.com
Description: Code Challenge
Version: 1.0.0
Author: Johannes Velde
Author URI: johannes-velde.com
License: GPLv2 or later22
Text Domain: books-plugin
 */

defined('ABSPATH') or die("You don't have permissions");

class BooksPlugin
{
    //initialize functions
    function __construct()
    {
        add_action('init', array($this, 'custom_post_type'));
        include_once('import_books.php');
        include_once('export_books.php');

    }

    function activate()
    {
        $this->custom_post_type();
        flush_rewrite_rules();
    }

    function deactivate()
    {
        flush_rewrite_rules();
    }

    //@TODO
    function uninstall()
    {
        //delete CPT
        //flush rewrite rules
    }

    //Initialise CPT
    function custom_post_type()
    {
        //Using build-in function from WP --> https://developer.wordpress.org/reference/functions/register_post_type/
        register_post_type(
            'books',
            array(
                'labels' => array(
                    'name' => 'Books',
                    'singular_name' => 'Book',
                ),
                'description' => 'Book Description',
                'public' => true,
                'menu_position' => 20,
                'show_in_admin_bar' => true,
                #'supports' => array('title', 'editor', 'custom-fields')
            )
        );
    }

}

if (class_exists('BooksPlugin')) {
    $booksPlugin = new BooksPlugin();
}

//activation
register_activation_hook(__FILE__, array($booksPlugin, 'activate'));

//deactivation
register_deactivation_hook(__FILE__, array($booksPlugin, 'deactivate'));
