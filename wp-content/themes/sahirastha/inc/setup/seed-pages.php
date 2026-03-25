<?php

function sahirastha_upsert_page(string $slug, string $title, string $content): int
{
    $existing = get_page_by_path($slug, OBJECT, 'page');

    $payload = [
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_name' => $slug,
        'post_title' => $title,
        'post_content' => $content,
    ];

    if ($existing instanceof WP_Post) {
        $payload['ID'] = $existing->ID;
        return (int) wp_update_post($payload, true);
    }

    return (int) wp_insert_post($payload, true);
}

function sahirastha_seed_insurance_pages(): void
{
    if (!is_admin() || !current_user_can('manage_options')) {
        return;
    }

    $services = sahirastha_get_insurance_services_data();
    if ($services === []) {
        return;
    }

    $seedVersion = 'insurance_phase_v1';
    if (get_option('sahirastha_seed_version') === $seedVersion) {
        return;
    }

    foreach ($services as $service) {
        $pageId = sahirastha_upsert_page(
            (string) $service['slug'],
            (string) $service['title'],
            sahirastha_build_insurance_service_content($service, $services)
        );

        if ($pageId > 0) {
            update_post_meta($pageId, '_sahirastha_service_cluster', 'insurance');
        }
    }

    $servicesPageId = sahirastha_upsert_page(
        'services',
        'Services',
        sahirastha_build_services_page_insurance_section($services)
    );

    if ($servicesPageId > 0) {
        update_post_meta($servicesPageId, '_sahirastha_services_updated_for_phase', $seedVersion);
    }

    update_option('sahirastha_seed_version', $seedVersion);
}
add_action('admin_init', 'sahirastha_seed_insurance_pages');
