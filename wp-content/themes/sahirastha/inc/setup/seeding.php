<?php
/**
 * Idempotent seeding for core pages, menu, and homepage assignment.
 */

function sahirastha_seed_site_content() {
    if (!function_exists('wp_insert_post')) {
        return;
    }

    $map = sahirastha_seed_pages_map();
    $page_ids = [];

    foreach ($map as $slug => $page) {
        $existing = get_page_by_path($slug, OBJECT, 'page');
        $payload = [
            'post_title'   => $page['title'],
            'post_content' => $page['content'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_name'    => $slug,
        ];

        if ($existing) {
            $payload['ID'] = $existing->ID;
            $page_id = wp_update_post($payload, true);
        } else {
            $page_id = wp_insert_post($payload, true);
        }

        if (!is_wp_error($page_id)) {
            $page_ids[$slug] = $page_id;
        }
    }

    if (!empty($page_ids['home'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $page_ids['home']);
    }

    sahirastha_seed_primary_menu($page_ids);
}

function sahirastha_seed_primary_menu($page_ids) {
    $menu_name = 'Primary Menu';
    $menu_obj = wp_get_nav_menu_object($menu_name);
    $menu_id = $menu_obj ? (int) $menu_obj->term_id : wp_create_nav_menu($menu_name);

    if (!$menu_id) {
        return;
    }

    $locations = get_theme_mod('nav_menu_locations', []);
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);

    $desired = ['home', 'services', 'process', 'about', 'pricing', 'faq', 'case-stories-testimonials', 'for-nris'];

    $existing_items = wp_get_nav_menu_items($menu_id);
    $by_object_id = [];
    if (is_array($existing_items)) {
        foreach ($existing_items as $item) {
            $by_object_id[(int) $item->object_id] = (int) $item->ID;
        }
    }

    foreach ($desired as $slug) {
        if (empty($page_ids[$slug])) {
            continue;
        }
        $page_id = (int) $page_ids[$slug];
        if (isset($by_object_id[$page_id])) {
            continue;
        }

        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title'     => get_the_title($page_id),
            'menu-item-object'    => 'page',
            'menu-item-object-id' => $page_id,
            'menu-item-type'      => 'post_type',
            'menu-item-status'    => 'publish',
        ]);
    }
}

add_action('after_switch_theme', 'sahirastha_seed_site_content');
add_action('init', 'sahirastha_seed_site_content');
