<?php

function my_custom_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'my_custom_theme_setup');

function my_custom_theme_scripts() {
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'my_custom_theme_scripts');




function register_my_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Menu'),
        // Register additional menus here if needed
    ));
}
add_action('init', 'register_my_menus');








?>
