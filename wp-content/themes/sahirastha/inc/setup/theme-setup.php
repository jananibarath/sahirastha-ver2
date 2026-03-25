<?php

function sahirastha_theme_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');

    register_nav_menus([
        'primary' => __('Primary Menu', 'sahirastha'),
    ]);
}
add_action('after_setup_theme', 'sahirastha_theme_setup');

function sahirastha_enqueue_assets(): void
{
    wp_enqueue_style(
        'sahirastha-style',
        get_stylesheet_uri(),
        [],
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'sahirastha_enqueue_assets');
