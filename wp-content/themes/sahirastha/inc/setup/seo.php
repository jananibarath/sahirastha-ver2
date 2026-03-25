<?php

declare(strict_types=1);

function sahirastha_meta_descriptions(): array
{
    return [
        'home' => 'Founder-led support to recover stuck financial assets in India across shares, IEPF, insurance, PF, mutual funds, and dormant bank deposits.',
        'services' => 'Explore Sahirastha service routes for shares, insurance, PF, mutual funds, dormant bank deposits, and NRI cases.',
        'process' => 'Understand how Sahirastha classifies, prepares, and executes document-heavy claim and recovery cases.',
        'about-why-sahirastha' => 'Learn why Sahirastha follows a calm, classification-first approach for difficult recovery and claim matters.',
        'pricing' => 'Sahirastha pricing approach for case review, scope clarity, and route-specific execution support.',
        'faq' => 'Answers to common questions about IEPF, insurance, PF, mutual funds, dormant deposits, and NRI case handling.',
        'contact' => 'Contact Janani Barath at Sahirastha for a case review on recovery and claim-support matters.',
        'case-stories-testimonials' => 'Illustrative case situations showing how Sahirastha handles complex claim and recovery routes.',
        'for-nris' => 'NRI pathway support for old Indian financial assets across shares, insurance, PF, mutual funds, and bank deposits.',
    ];
}

function sahirastha_page_meta_description(): string
{
    if (is_front_page()) {
        return sahirastha_meta_descriptions()['home'];
    }

    $post = get_post();
    if (! $post instanceof WP_Post) {
        return '';
    }

    $map = sahirastha_meta_descriptions();

    return $map[$post->post_name] ?? wp_strip_all_tags(get_the_excerpt($post));
}

function sahirastha_output_meta_tags(): void
{
    if (is_admin()) {
        return;
    }

    $description = sahirastha_page_meta_description();
    if ($description !== '') {
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    }

    $title = wp_get_document_title();
    $url = is_singular() ? get_permalink() : home_url(add_query_arg([], $GLOBALS['wp']->request ?? ''));

    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:site_name" content="Sahirastha">' . "\n";
    echo '<link rel="canonical" href="' . esc_url($url) . '">' . "\n";
}
add_action('wp_head', 'sahirastha_output_meta_tags', 1);

function sahirastha_structured_data(): void
{
    if (is_admin()) {
        return;
    }

    $business = [
        '@context' => 'https://schema.org',
        '@type' => 'ProfessionalService',
        'name' => 'Sahirastha',
        'telephone' => sahirastha_contact_phone(),
        'email' => sahirastha_contact_email(),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'No. 9, 11th Main Road, Vasanth Nagar',
            'addressLocality' => 'Bangalore',
            'postalCode' => '560001',
            'addressCountry' => 'IN',
        ],
    ];

    echo '<script type="application/ld+json">' . wp_json_encode($business, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';

    if (is_page('faq')) {
        $faq = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => [
                ['@type' => 'Question', 'name' => 'What if I am not sure which service fits my issue?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Start with a case review. Sahirastha classifies the issue first and then routes it to the correct service path.']],
                ['@type' => 'Question', 'name' => 'Can NRIs use Sahirastha services?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Yes. NRI cases are handled with a document-led process tailored for remote execution and institution-specific requirements.']],
            ],
        ];
        echo '<script type="application/ld+json">' . wp_json_encode($faq, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }
}
add_action('wp_head', 'sahirastha_structured_data', 2);
