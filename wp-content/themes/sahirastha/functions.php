<?php

declare(strict_types=1);

$setup_files = [
    'inc/setup/theme-setup.php',
    'inc/setup/seed.php',
    'inc/setup/contact.php',
    'inc/setup/seo.php',
];

foreach ($setup_files as $file) {
    $path = get_template_directory() . '/' . $file;
    if (file_exists($path)) {
        require_once $path;
    }
}
