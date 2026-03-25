<?php

declare(strict_types=1);

$phone = sahirastha_contact_phone();
$email = sahirastha_contact_email();
$address = sahirastha_contact_address();
?>
</main>
<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <h2>Sahirastha</h2>
            <p>Founder-led support for recovery and claim handling across shares, insurance, PF, mutual funds, and dormant bank deposits.</p>
        </div>
        <div>
            <h2>Contact</h2>
            <p><a href="tel:<?php echo esc_attr(sahirastha_phone_href($phone)); ?>"><?php echo esc_html($phone); ?></a></p>
            <p><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
            <p><?php echo esc_html($address); ?></p>
        </div>
    </div>
</footer>
<a class="whatsapp-float" href="<?php echo esc_url(sahirastha_whatsapp_url()); ?>" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
    WhatsApp
</a>
<?php wp_footer(); ?>
</body>
</html>
