<?php

declare(strict_types=1);

const SAHIRASTHA_THEME_OPTION_SEEDED = 'sahirastha_seeded_v2';
const SAHIRASTHA_WHATSAPP_URL_OPTION = 'sahirastha_whatsapp_url';

add_action('after_switch_theme', static function (): void {
    sahirastha_seed_site_content();
});

function sahirastha_seed_site_content(): void
{
    if (!function_exists('wp_insert_post')) {
        return;
    }

    if (get_option(SAHIRASTHA_WHATSAPP_URL_OPTION) === false) {
        add_option(SAHIRASTHA_WHATSAPP_URL_OPTION, 'https://wa.me/919999999999');
    }

    $menuPages = [];
    $frontPageId = 0;

    foreach (sahirastha_seeded_pages() as $page) {
        $existing = get_page_by_path($page['slug'], OBJECT, 'page');
        $postarr = [
            'post_type' => 'page',
            'post_status' => 'publish',
            'post_title' => $page['title'],
            'post_name' => $page['slug'],
            'post_content' => $page['content'],
        ];

        if ($existing instanceof WP_Post) {
            $postarr['ID'] = $existing->ID;
            $pageId = (int) wp_update_post($postarr, true);
        } else {
            $pageId = (int) wp_insert_post($postarr, true);
        }

        if (!is_wp_error($pageId) && $page['menu']) {
            $menuPages[$page['title']] = $pageId;
        }

        if ($page['slug'] === 'home' && !is_wp_error($pageId)) {
            $frontPageId = $pageId;
        }
    }

    if ($frontPageId > 0) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $frontPageId);
    }

    sahirastha_seed_menus($menuPages);
    update_option(SAHIRASTHA_THEME_OPTION_SEEDED, gmdate('c'));
}

function sahirastha_seed_menus(array $menuPages): void
{
    $location = 'primary';
    $menuName = 'Primary Menu';
    $menu = wp_get_nav_menu_object($menuName);
    $menuId = $menu ? (int) $menu->term_id : wp_create_nav_menu($menuName);

    if ($menuId <= 0) {
        return;
    }

    $existingItems = wp_get_nav_menu_items($menuId) ?: [];
    $existingObjectIds = [];
    foreach ($existingItems as $item) {
        $existingObjectIds[(int) $item->object_id] = true;
    }

    foreach ($menuPages as $title => $pageId) {
        if (isset($existingObjectIds[(int) $pageId])) {
            continue;
        }

        wp_update_nav_menu_item($menuId, 0, [
            'menu-item-object-id' => $pageId,
            'menu-item-object' => 'page',
            'menu-item-type' => 'post_type',
            'menu-item-title' => $title,
            'menu-item-status' => 'publish',
        ]);
    }

    $locations = get_theme_mod('nav_menu_locations');
    if (!is_array($locations)) {
        $locations = [];
    }
    $locations[$location] = $menuId;
    set_theme_mod('nav_menu_locations', $locations);
}

add_action('wp_footer', static function (): void {
    $whatsapp = get_option(SAHIRASTHA_WHATSAPP_URL_OPTION, 'https://wa.me/919999999999');
    if (!is_string($whatsapp) || $whatsapp === '') {
        return;
    }
    echo '<a class="sahirastha-whatsapp" href="' . esc_url($whatsapp) . '" target="_blank" rel="noopener noreferrer">WhatsApp</a>';
});
