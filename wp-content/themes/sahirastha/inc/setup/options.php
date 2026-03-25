<?php
/**
 * Theme options.
 */

function sahirastha_get_whatsapp_url() {
    $default = 'https://wa.me/919000000000';
    $value = get_option('sahirastha_whatsapp_url', $default);

    return esc_url($value);
}

function sahirastha_register_settings() {
    register_setting('general', 'sahirastha_whatsapp_url', [
        'type'              => 'string',
        'sanitize_callback' => 'esc_url_raw',
        'default'           => 'https://wa.me/919000000000',
    ]);

    add_settings_field(
        'sahirastha_whatsapp_url',
        __('Sahirastha WhatsApp URL', 'sahirastha'),
        'sahirastha_whatsapp_field_render',
        'general'
    );
}
add_action('admin_init', 'sahirastha_register_settings');

function sahirastha_whatsapp_field_render() {
    $value = get_option('sahirastha_whatsapp_url', 'https://wa.me/919000000000');
    echo '<input type="url" class="regular-text" name="sahirastha_whatsapp_url" value="' . esc_attr($value) . '" />';
}
