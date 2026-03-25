<?php

declare(strict_types=1);

function sahirastha_pf_mutual_bank_pages(): array
{
    $path = get_template_directory() . '/inc/content/pf-mutual-bank-content.php';
    if (!file_exists($path)) {
        return [];
    }

    $pages = require $path;
    return is_array($pages) ? $pages : [];
}
