<?php
/**
 * Sahirastha theme bootstrap.
 */

$includes = [
    'inc/setup/theme-setup.php',
    'inc/setup/enqueue.php',
    'inc/setup/options.php',
    'inc/setup/whatsapp.php',
    'inc/content/seed-content.php',
    'inc/setup/seeding.php',
];

foreach ($includes as $file) {
    $path = get_template_directory() . '/' . $file;
    if (file_exists($path)) {
        require_once $path;
    }
}
