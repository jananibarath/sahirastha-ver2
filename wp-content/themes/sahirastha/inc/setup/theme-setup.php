<?php

declare(strict_types=1);

if (! defined('SAHIRASTHA_WHATSAPP_NUMBER')) {
    define('SAHIRASTHA_WHATSAPP_NUMBER', '919845808333');
}

if (! defined('SAHIRASTHA_CONTACT_EMAIL')) {
    define('SAHIRASTHA_CONTACT_EMAIL', 'janani.barath@gmail.com');
}

add_action('after_setup_theme', static function (): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('wp-block-styles');
    add_theme_support('editor-styles');

    register_nav_menus([
        'primary' => __('Primary Menu', 'sahirastha'),
    ]);
});
