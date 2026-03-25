<?php

declare(strict_types=1);
?>
</main>
<?php
$whatsapp_number = (string) get_option('sahirastha_whatsapp_number', '919999999999');
$wa_url = 'https://wa.me/' . preg_replace('/\D+/', '', $whatsapp_number);
?>
<a class="sahirastha-whatsapp" href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener">WhatsApp</a>
<?php wp_footer(); ?>
</body>
</html>
