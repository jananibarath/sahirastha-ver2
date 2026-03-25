<?php

declare(strict_types=1);

add_action('after_setup_theme', static function (): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');

    register_nav_menus([
        'primary' => __('Primary Menu', 'sahirastha'),
        'footer' => __('Footer Menu', 'sahirastha'),
    ]);
});

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_style('sahirastha-main', get_template_directory_uri() . '/assets/css/main.css', [], '1.0.0');
});
