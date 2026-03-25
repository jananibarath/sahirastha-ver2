<?php

declare(strict_types=1);

function sahirastha_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_editor_style('assets/css/site.css');

    register_nav_menus([
        'primary' => __('Primary Menu', 'sahirastha'),
        'footer'  => __('Footer Menu', 'sahirastha'),
    ]);
}
add_action('after_setup_theme', 'sahirastha_setup');

function sahirastha_assets(): void
{
    wp_enqueue_style('sahirastha-site', get_template_directory_uri() . '/assets/css/site.css', [], '1.0.0');
}
add_action('wp_enqueue_scripts', 'sahirastha_assets');
