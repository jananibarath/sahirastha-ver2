<?php

declare(strict_types=1);

function sahirastha_raw_content(string $filename): string
{
    $path = get_template_directory() . '/inc/content/raw/' . $filename;
    if (!file_exists($path)) {
        return '';
    }

    return (string) file_get_contents($path);
}

function sahirastha_extract_between(string $text, string $start, ?string $end = null): string
{
    $startPos = strpos($text, $start);
    if ($startPos === false) {
        return '';
    }
    $slice = substr($text, $startPos);
    if ($end !== null) {
        $endPos = strpos($slice, $end);
        if ($endPos !== false) {
            $slice = substr($slice, 0, $endPos);
        }
    }

    return trim($slice);
}

function sahirastha_lines_to_html(string $text, array $dropPatterns = []): string
{
    $text = preg_replace('/\R+/', "\n", trim($text)) ?? '';
    $lines = array_filter(array_map('trim', explode("\n", $text)), static fn(string $line): bool => $line !== '');

    $html = [];
    foreach ($lines as $line) {
        $skip = false;
        foreach ($dropPatterns as $pattern) {
            if (preg_match($pattern, $line) === 1) {
                $skip = true;
                break;
            }
        }
        if ($skip) {
            continue;
        }

        if (preg_match('/^(Section|Page \d+|SERVICE \d+|Service \d+|Pathway \d+|\d+\.|\d+\s*—)/i', $line) === 1) {
            $html[] = '<!-- wp:heading {"level":3} --><h3>' . esc_html($line) . '</h3><!-- /wp:heading -->';
            continue;
        }

        if (preg_match('/^(Headline|Subheadline|Support line|Primary CTA|Secondary CTA|Closing line|Intro paragraph|Section title|Page headline|Purpose|Page goal|Primary audience|Support CTA line|Optional trust line|Optional micro-copy|Content goal|Who this page is for|Who should start here|What this process covers|Publication Note)$/i', rtrim($line, ':')) === 1) {
            $html[] = '<!-- wp:heading {"level":4} --><h4>' . esc_html(rtrim($line, ':')) . '</h4><!-- /wp:heading -->';
            continue;
        }

        $html[] = '<!-- wp:paragraph --><p>' . esc_html($line) . '</p><!-- /wp:paragraph -->';
    }

    return implode("\n", $html);
}

function sahirastha_seeded_pages(): array
{
    $core = sahirastha_raw_content('sahirasta_core_site_pages_copy_master_service1_2_3_4_5_6_cleaned.txt');
    $shares = sahirastha_raw_content('sahirasta_service_pages_copy_master_shares_batch_complete_tightened.txt');
    $insurance = sahirastha_raw_content('sahirasta_insurance_service_pages_copy_master_service1_2_3_4_5_6_7_8_9_10_tightened.txt');
    $other = sahirastha_raw_content('sahirasta_service_pages_copy_master_other_asset_recovery_service1_2_3_tightened.txt');
    $home = sahirastha_raw_content('sahirasta_homepage_copy_sections_1_to_12_tightened.txt');
    $hub = sahirastha_raw_content('sahirasta_service_hub_copy_sections_1_to_12_tightened.txt');
    $nri = sahirastha_raw_content('sahirasta_pathway_pages_copy_master_service1.txt');

    return [
        ['title' => 'Home', 'slug' => 'home', 'menu' => true, 'content' => sahirastha_lines_to_html($home, ['/Section 3/i', '/Section 9/i', '/placeholder/i', '/must be replaced/i'])],
        ['title' => 'Services', 'slug' => 'services', 'menu' => true, 'content' => sahirastha_lines_to_html($hub)],
        ['title' => 'Process', 'slug' => 'process', 'menu' => true, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($core, 'Page 1: Process Page', 'Page 2: About / Why Sahirasta Page'))],
        ['title' => 'About / Why Sahirastha', 'slug' => 'about-why-sahirastha', 'menu' => true, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($core, 'Page 2: About / Why Sahirasta Page', 'Page 3: Pricing Page'))],
        ['title' => 'Pricing', 'slug' => 'pricing', 'menu' => true, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($core, 'Page 3: Pricing Page', 'Page 4: FAQ Page'))],
        ['title' => 'FAQ', 'slug' => 'faq', 'menu' => true, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($core, 'Page 4: FAQ Page', 'Page 5: Contact Page'))],
        ['title' => 'Contact', 'slug' => 'contact', 'menu' => true, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($core, 'Page 5: Contact Page', 'Page 6: Case Stories / Testimonials Page'))],
        ['title' => 'Case Stories / Testimonials', 'slug' => 'case-stories-testimonials', 'menu' => true, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($core, 'Page 6: Case Stories / Testimonials Page'))],
        ['title' => 'For NRIs', 'slug' => 'for-nris', 'menu' => true, 'content' => sahirastha_lines_to_html($nri)],

        ['title' => 'IEPF Claims', 'slug' => 'iepf-claims', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($shares, 'Service 1: IEPF Claims', 'Service 2: Duplicate / Lost Share Documents'))],
        ['title' => 'Duplicate / Lost Share Documents', 'slug' => 'duplicate-lost-share-documents', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($shares, 'Service 2: Duplicate / Lost Share Documents', 'Service 3: Transmission of Shares'))],
        ['title' => 'Transmission of Shares', 'slug' => 'transmission-of-shares', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($shares, 'Service 3: Transmission of Shares', 'Service 4: Physical Shares to Demat'))],
        ['title' => 'Physical Shares to Demat', 'slug' => 'physical-shares-to-demat', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($shares, 'Service 4: Physical Shares to Demat', 'Service 5: Transmission-cum-Demat'))],
        ['title' => 'Transmission-cum-Demat', 'slug' => 'transmission-cum-demat', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($shares, 'Service 5: Transmission-cum-Demat', 'Service 6: Name / Signature / Address Correction'))],
        ['title' => 'Name / Signature / Address Correction', 'slug' => 'name-signature-address-correction', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($shares, 'Service 6: Name / Signature / Address Correction'))],

        ['title' => 'Unclaimed Insurance Maturity and Survival Benefits', 'slug' => 'unclaimed-insurance-maturity-survival-benefits', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($insurance, 'Service 1: Unclaimed Maturity & Survival Benefits', 'Service 2: Death Claim Support'))],
        ['title' => 'Insurance Death Claim Support', 'slug' => 'insurance-death-claim-support', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($insurance, 'Service 2: Death Claim Support', 'Service 3: Rejected Claims'))],
        ['title' => 'Rejected Insurance Claims', 'slug' => 'rejected-insurance-claims', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($insurance, 'Service 3: Rejected Claims', 'Service 4: Short-Settled Claims'))],
        ['title' => 'Short-Settled Insurance Claims', 'slug' => 'short-settled-insurance-claims', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($insurance, 'Service 4: Short-Settled Claims', 'Service 5: Lost Policy Bond'))],
        ['title' => 'Lost Policy Bond Support', 'slug' => 'lost-policy-bond-support', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($insurance, 'Service 5: Lost Policy Bond', 'Service 6: Nominee Issues'))],
        ['title' => 'Insurance Nominee Issues', 'slug' => 'insurance-nominee-issues', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($insurance, 'Service 6: Nominee Issues', 'Service 7: Policy Loan Complications'))],
        ['title' => 'Insurance Policy Loan Complications', 'slug' => 'insurance-policy-loan-complications', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($insurance, 'Service 7: Policy Loan Complications', 'Service 8: Old LIC / Insurer Record Mismatch'))],
        ['title' => 'Old LIC or Insurer Record Mismatch', 'slug' => 'old-lic-or-insurer-record-mismatch', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($insurance, 'Service 8: Old LIC / Insurer Record Mismatch', 'Service 9: Survival Benefit Not Received'))],
        ['title' => 'Survival Benefit Not Received', 'slug' => 'survival-benefit-not-received', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($insurance, 'Service 9: Survival Benefit Not Received', 'Service 10: Address / KYC / Bank Mismatch Blocking Payout'))],
        ['title' => 'Address KYC Bank Mismatch Blocking Payout', 'slug' => 'address-kyc-bank-mismatch-blocking-payout', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($insurance, 'Service 10: Address / KYC / Bank Mismatch Blocking Payout'))],

        ['title' => 'Unclaimed Provident Fund', 'slug' => 'unclaimed-provident-fund', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($other, 'Service 1: Unclaimed Provident Fund', 'Service 2: Unclaimed Mutual Funds'))],
        ['title' => 'Unclaimed Mutual Funds', 'slug' => 'unclaimed-mutual-funds', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($other, 'Service 2: Unclaimed Mutual Funds', 'Service 3: Dormant / In-operative Bank Deposits'))],
        ['title' => 'Dormant / In-operative Bank Deposits', 'slug' => 'dormant-in-operative-bank-deposits', 'menu' => false, 'content' => sahirastha_lines_to_html(sahirastha_extract_between($other, 'Service 3: Dormant / In-operative Bank Deposits'))],
    ];
}
