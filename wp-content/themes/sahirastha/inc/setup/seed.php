<?php

declare(strict_types=1);

require_once get_template_directory() . '/inc/setup/seed-pages.php';

function sahirastha_run_seed_once(): void
{
    $version = 'longform-restore-v1';
    if (get_option('sahirastha_seed_version') === $version) {
        return;
    }

    sahirastha_seed_pages();
    sahirastha_seed_menu();

    update_option('sahirastha_seed_version', $version);
}

add_action('after_switch_theme', 'sahirastha_run_seed_once');
add_action('admin_init', 'sahirastha_run_seed_once');
