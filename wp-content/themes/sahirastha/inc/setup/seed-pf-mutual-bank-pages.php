<?php
/**
 * Idempotent PF, Mutual Funds, and Dormant Bank Deposits page repair seed.
 */

add_action('after_switch_theme', 'sahirastha_seed_pf_mutual_bank_pages');
add_action('admin_init', 'sahirastha_seed_pf_mutual_bank_pages');

function sahirastha_seed_pf_mutual_bank_pages(): void {
	if (! current_user_can('manage_options')) {
		return;
	}

	$map = sahirastha_pf_mutual_bank_page_content_map();

	foreach ($map as $slug => $page) {
		$post_id = sahirastha_find_existing_service_page($slug, $page['title']);
		$data    = [
			'post_title'   => $page['title'],
			'post_name'    => $slug,
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_content' => $page['content'],
		];

		if ($post_id > 0) {
			$data['ID'] = $post_id;
			wp_update_post($data);
		} else {
			wp_insert_post($data);
		}
	}
}

function sahirastha_find_existing_service_page(string $slug, string $title): int {
	$existing = get_page_by_path($slug, OBJECT, 'page');
	if ($existing instanceof WP_Post) {
		return (int) $existing->ID;
	}

	$fallback = get_page_by_title($title, OBJECT, 'page');
	if ($fallback instanceof WP_Post) {
		return (int) $fallback->ID;
	}

	return 0;
}
