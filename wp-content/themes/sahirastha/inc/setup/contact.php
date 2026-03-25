<?php

declare(strict_types=1);

function sahirastha_contact_name(): string
{
    return 'Janani Barath';
}

function sahirastha_contact_phone(): string
{
    return '+91 9845808333';
}

function sahirastha_phone_href(string $phone): string
{
    return preg_replace('/[^0-9+]/', '', $phone) ?: '';
}

function sahirastha_contact_email(): string
{
    return 'janani.barath@gmail.com';
}

function sahirastha_contact_address(): string
{
    return 'No. 9, 11th Main Road, Vasanth Nagar, Bangalore - 560001';
}

function sahirastha_whatsapp_url(): string
{
    return 'https://wa.me/919845808333';
}

function sahirastha_contact_form_shortcode(): string
{
    $notice = '';
    if (! empty($_POST['sahirastha_contact_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['sahirastha_contact_nonce'])), 'sahirastha_contact_form')) {
        $name = sanitize_text_field(wp_unslash($_POST['contact_name'] ?? ''));
        $email = sanitize_email(wp_unslash($_POST['contact_email'] ?? ''));
        $message = sanitize_textarea_field(wp_unslash($_POST['contact_message'] ?? ''));
        if ($name && is_email($email) && $message) {
            $subject = 'Sahirastha case review enquiry';
            $body = "Name: {$name}\nEmail: {$email}\n\n{$message}";
            $headers = ['Reply-To: ' . $email];
            wp_mail(sahirastha_contact_email(), $subject, $body, $headers);
            $notice = '<p class="form-notice success">Thank you. Your message has been sent.</p>';
        } else {
            $notice = '<p class="form-notice error">Please complete all fields with a valid email address.</p>';
        }
    }

    ob_start();
    echo wp_kses_post($notice);
    ?>
    <form class="sahirastha-contact-form" method="post">
        <p><label>Name<br><input type="text" name="contact_name" required></label></p>
        <p><label>Email<br><input type="email" name="contact_email" required></label></p>
        <p><label>Message<br><textarea name="contact_message" rows="6" required></textarea></label></p>
        <?php wp_nonce_field('sahirastha_contact_form', 'sahirastha_contact_nonce'); ?>
        <p><button type="submit">Request a Case Review</button></p>
    </form>
    <?php
    return (string) ob_get_clean();
}
add_shortcode('sahirastha_contact_form', 'sahirastha_contact_form_shortcode');
