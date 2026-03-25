<?php

declare(strict_types=1);

function sahirastha_require_seed_map(string $relative_path): array
{
    $path = get_template_directory() . '/' . ltrim($relative_path, '/');
    if (!file_exists($path)) {
        return [];
    }

    $data = require $path;
    return is_array($data) ? $data : [];
}

function sahirastha_upsert_page(array $page, int $parent_id = 0): int
{
    $slug = $page['slug'];
    $existing = get_page_by_path($slug, OBJECT, 'page');

    $payload = [
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_title' => $page['title'],
        'post_name' => $slug,
        'post_content' => $page['content'],
        'post_parent' => $parent_id,
    ];

    if ($existing instanceof WP_Post) {
        $payload['ID'] = $existing->ID;
        return (int) wp_update_post($payload, true);
    }

    return (int) wp_insert_post($payload, true);
}

function sahirastha_seed_pages(): void
{
    $core_pages = sahirastha_require_seed_map('inc/content/core-pages-seed.php');

    $top = [
        'home' => sahirastha_upsert_page($core_pages['home'] ?? ['title' => 'Home', 'slug' => 'home', 'content' => '']),
        'services' => sahirastha_upsert_page($core_pages['services'] ?? ['title' => 'Services', 'slug' => 'services', 'content' => '']),
        'shares-securities' => sahirastha_upsert_page(['title' => 'Shares & Securities', 'slug' => 'shares-securities', 'content' => '']),
        'insurance-claims-recovery' => sahirastha_upsert_page(['title' => 'Insurance Claims & Recovery', 'slug' => 'insurance-claims-recovery', 'content' => '']),
        'pf-mutual-funds-bank-deposits' => sahirastha_upsert_page(['title' => 'PF, Mutual Funds & Bank Deposits', 'slug' => 'pf-mutual-funds-bank-deposits', 'content' => '']),
    ];

    foreach ($core_pages as $key => $page) {
        if (in_array($key, ['home', 'services'], true)) {
            continue;
        }

        sahirastha_upsert_page($page);
    }

    foreach (sahirastha_require_seed_map('inc/content/shares-pages.php') as $page) {
        sahirastha_upsert_page($page, $top[$page['parent']] ?? 0);
    }

    foreach (sahirastha_require_seed_map('inc/content/insurance-services.php') as $page) {
        sahirastha_upsert_page($page, $top[$page['parent']] ?? 0);
    }

    $pf_pages = sahirastha_require_seed_map('inc/content/pf-mutual-bank-content.php');
    $external_pf_seed = get_template_directory() . '/inc/setup/seed-pf-mutual-bank-pages.php';
    if (file_exists($external_pf_seed)) {
        require_once $external_pf_seed;
        if (function_exists('sahirastha_pf_mutual_bank_pages')) {
            $pf_pages = sahirastha_pf_mutual_bank_pages();
        }
    }

    foreach ($pf_pages as $page) {
        sahirastha_upsert_page($page, $top[$page['parent']] ?? 0);
    }

    update_option('show_on_front', 'page');
    update_option('page_on_front', $top['home']);
}

function sahirastha_seed_menu(): void
{
    $menu_name = 'Primary Menu';
    $menu = wp_get_nav_menu_object($menu_name);
    $menu_id = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu($menu_name);

    $slugs = ['home', 'services', 'process', 'about', 'pricing', 'faq', 'case-stories', 'for-nris'];

    foreach ($slugs as $slug) {
        $page = get_page_by_path($slug, OBJECT, 'page');
        if (!$page instanceof WP_Post) {
            continue;
        }

        $existing = wp_get_nav_menu_items($menu_id);
        $exists = false;
        if (is_array($existing)) {
            foreach ($existing as $item) {
                if ((int) $item->object_id === (int) $page->ID) {
                    $exists = true;
                    break;
                }
            }
        }

        if (!$exists) {
            wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-object-id' => $page->ID,
                'menu-item-object' => 'page',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish',
            ]);
        }
    }

    $locations = get_theme_mod('nav_menu_locations', []);
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}
