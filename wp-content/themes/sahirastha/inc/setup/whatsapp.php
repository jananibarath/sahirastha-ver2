<?php
/**
 * WhatsApp floating button.
 */

function sahirastha_render_whatsapp_button() {
    $url = sahirastha_get_whatsapp_url();

    if (empty($url)) {
        return;
    }

    echo '<a class="sahirastha-whatsapp" href="' . esc_url($url) . '" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">WhatsApp</a>';
}
add_action('wp_footer', 'sahirastha_render_whatsapp_button');
