<?php

declare(strict_types=1);

function sahirastha_seed_pages(): array
{
    $contact_card = sprintf(
        '<h2>Contact</h2><p><strong>%s</strong><br>%s<br>Phone: <a href="tel:%s">%s</a><br>Email: <a href="mailto:%s">%s</a></p>',
        esc_html(sahirastha_contact_name()),
        esc_html(sahirastha_contact_address()),
        esc_attr(sahirastha_phone_href(sahirastha_contact_phone())),
        esc_html(sahirastha_contact_phone()),
        esc_attr(sahirastha_contact_email()),
        esc_html(sahirastha_contact_email())
    );

    return [
        'home' => ['title' => 'Home', 'content' => '<h1>Recover Stuck Financial Assets with Expert Help</h1><p>Sahirastha helps individuals, families, legal heirs, widows, and NRIs recover unclaimed or blocked financial assets in India, including shares, IEPF, insurance, provident fund, mutual funds, and dormant bank deposits.</p><p><a href="/contact/">Request a Case Review</a> | <a href="/services/">Explore Services</a></p><h2>Problems We Solve</h2><ul><li>IEPF claims and unclaimed dividends</li><li>Transmission after death and holder record corrections</li><li>Insurance maturity, death claim, and payout blockers</li><li>Old PF, mutual fund, and dormant bank deposit recovery</li><li>NRI and cross-border document execution</li></ul><h2>How to Start</h2><p>You do not need to diagnose the case before contacting us. Start with available records. We classify the issue first and then move it through the correct route.</p>' . $contact_card],
        'services' => ['title' => 'Services', 'content' => '<h1>Explore Our Services</h1><p>Start with the category closest to your issue. If unsure, begin with a case review.</p><h2>Shares &amp; Securities</h2><ul><li><a href="/iepf-claims/">IEPF Claims</a></li><li><a href="/duplicate-lost-share-documents/">Duplicate / Lost Share Documents</a></li><li><a href="/transmission-of-shares/">Transmission of Shares</a></li><li><a href="/physical-shares-to-demat/">Physical Shares to Demat</a></li><li><a href="/transmission-cum-demat/">Transmission-cum-Demat</a></li><li><a href="/name-signature-address-correction-shares/">Name / Signature / Address Correction</a></li></ul><h2>Insurance Claims &amp; Recovery</h2><ul><li><a href="/insurance-unclaimed-maturity-survival-benefits/">Unclaimed Maturity &amp; Survival Benefits</a></li><li><a href="/insurance-death-claim-support/">Death Claim Support</a></li><li><a href="/insurance-rejected-claims/">Rejected Claims</a></li><li><a href="/insurance-short-settled-claims/">Short-Settled Claims</a></li><li><a href="/insurance-lost-policy-bond/">Lost Policy Bond</a></li><li><a href="/insurance-nominee-issues/">Nominee Issues</a></li><li><a href="/insurance-policy-loan-complications/">Policy Loan Complications</a></li><li><a href="/insurance-record-mismatch/">Old LIC / Insurer Record Mismatch</a></li><li><a href="/insurance-survival-benefit-not-received/">Survival Benefit Not Received</a></li><li><a href="/insurance-address-kyc-bank-mismatch/">Address / KYC / Bank Mismatch</a></li></ul><h2>PF, Mutual Funds &amp; Bank Deposits</h2><ul><li><a href="/unclaimed-provident-fund/">Unclaimed Provident Fund</a></li><li><a href="/unclaimed-mutual-funds/">Unclaimed Mutual Funds</a></li><li><a href="/dormant-inoperative-bank-deposits/">Dormant / In-operative Bank Deposits</a></li></ul><p><a href="/for-nris/">For NRIs</a></p>'],
        'process' => ['title' => 'Process', 'content' => '<h1>How Sahirastha Works</h1><ol><li>Start with the broad facts and records available.</li><li>Review the existing trail, including incomplete papers.</li><li>Classify the correct route before filing.</li><li>Identify blockers such as mismatch, succession, or missing records.</li><li>Clarify scope and fee logic.</li><li>Execute with structured filing and follow-up.</li><li>Move toward recovery, regularisation, or closure clarity.</li></ol><p><a href="/contact/">Request a Case Review</a></p>'],
        'about-why-sahirastha' => ['title' => 'About / Why Sahirastha', 'content' => '<h1>About Sahirastha</h1><p>Sahirastha is a founder-led practice focused on difficult recovery and claim-support matters. The work is classification-first, practical, and document-led.</p><p>Many clients come with scattered records, unclear routes, and post-death complexity. We help bring structure, identify the right path, and reduce avoidable delays caused by wrong filing sequences.</p>' . $contact_card],
        'pricing' => ['title' => 'Pricing', 'content' => '<h1>Pricing Approach</h1><p>Pricing depends on case route, record quality, and execution complexity. Simple cases and succession-heavy multi-asset matters are not treated as the same.</p><ul><li>Initial case review and route classification</li><li>Scope and documentation assessment</li><li>Execution support pricing based on work involved</li></ul><p><a href="/contact/">Request a case review for scope clarity</a>.</p>'],
        'faq' => ['title' => 'FAQ', 'content' => '<h1>Frequently Asked Questions</h1><h2>What if I am not sure which service fits my case?</h2><p>Start with consultation. The first step is classification, not guesswork.</p><h2>Can NRIs start without complete papers?</h2><p>Yes. Partial records are common. We help identify missing pieces and route requirements.</p><h2>Do you guarantee recovery?</h2><p>No. Outcomes depend on entitlement, records, and institution-side processing.</p><h2>Can one family have multiple parallel routes?</h2><p>Yes. A single family may require separate routes for shares, insurance, PF, and dormant deposits.</p>'],
        'contact' => ['title' => 'Contact', 'content' => '<h1>Contact Sahirastha</h1><p>Share your case details for route clarity and next-step guidance.</p>' . $contact_card . '<h2>Send a Message</h2>[sahirastha_contact_form]'],
        'case-stories-testimonials' => ['title' => 'Case Stories / Testimonials', 'content' => '<h1>Case Situations We Commonly Handle</h1><p>This page presents anonymised issue-types, not public testimonials or performance claims.</p><ul><li>Post-death share holdings requiring transmission and IEPF follow-through.</li><li>Matured insurance amount pending due to stale bank and KYC records.</li><li>Old PF balances spread across multiple employers and legacy member IDs.</li><li>NRI family reconstructing records across insurance, bank deposits, and mutual funds.</li></ul>' ],
        'for-nris' => ['title' => 'For NRIs', 'content' => '<h1>Recover Old Indian Financial Assets From Abroad</h1><p>If you live outside India and are dealing with shares, IEPF, insurance, PF, mutual funds, or dormant bank deposits, Sahirastha helps identify the correct route and organise the file for remote execution.</p><h2>Common NRI Situations</h2><ul><li>Old Indian records no longer match current KYC, address, or bank details.</li><li>Family-managed paperwork is incomplete after years.</li><li>Post-death claims where entitlement and records require reconstruction.</li></ul><p><a href="/contact/">Request a Case Review</a></p>'],
        'iepf-claims' => ['title' => 'IEPF Claims', 'content' => '<h1>Recover Shares and Dividends Transferred to IEPF</h1><p>When dividends remain unclaimed for years, related shares and proceeds may move to IEPF. Sahirastha helps classify status, organise records, and guide filing and verification steps.</p><h2>Typical blockers</h2><ul><li>Post-death entitlement and transmission requirements</li><li>Outdated bank, address, signature, or folio details</li><li>Incomplete share records and legacy documentation</li></ul>'],
        'duplicate-lost-share-documents' => ['title' => 'Duplicate / Lost Share Documents', 'content' => '<h1>Duplicate / Lost Share Documents</h1><p>Support for missing or damaged share certificates and related record reconstruction before transfer, demat, transmission, or claim action.</p>'],
        'transmission-of-shares' => ['title' => 'Transmission of Shares', 'content' => '<h1>Transmission of Shares</h1><p>For nominees, legal heirs, and families handling transfer of share ownership after death with institution-specific documentation.</p>'],
        'physical-shares-to-demat' => ['title' => 'Physical Shares to Demat', 'content' => '<h1>Physical Shares to Demat</h1><p>Convert legacy physical share holdings into demat where records permit, with correction support where needed.</p>'],
        'transmission-cum-demat' => ['title' => 'Transmission-cum-Demat', 'content' => '<h1>Transmission-cum-Demat</h1><p>Combined route where post-death ownership transfer and demat conversion need coordinated handling.</p>'],
        'name-signature-address-correction-shares' => ['title' => 'Name / Signature / Address Correction', 'content' => '<h1>Name / Signature / Address Correction</h1><p>Resolve holder detail mismatches that block share servicing, transmission, dividend receipt, or claim progress.</p>'],
        'insurance-unclaimed-maturity-survival-benefits' => ['title' => 'Unclaimed Maturity & Survival Benefits', 'content' => '<h1>Recover Unclaimed Insurance Maturity and Survival Benefits</h1><p>For matured or survival payouts not received due to stale records, cheque failures, KYC gaps, or entitlement uncertainty.</p>'],
        'insurance-death-claim-support' => ['title' => 'Death Claim Support', 'content' => '<h1>Insurance Death Claim Support</h1><p>Structured support for families, nominees, and legal heirs navigating document-heavy insurance death-claim routes.</p>'],
        'insurance-rejected-claims' => ['title' => 'Rejected Claims', 'content' => '<h1>Insurance Rejected Claims</h1><p>Review rejection reasons, identify documentary and route gaps, and prepare a disciplined follow-up strategy.</p>'],
        'insurance-short-settled-claims' => ['title' => 'Short-Settled Claims', 'content' => '<h1>Insurance Short-Settled Claims</h1><p>Assess whether a claim appears underpaid and support representation with record-backed clarification.</p>'],
        'insurance-lost-policy-bond' => ['title' => 'Lost Policy Bond', 'content' => '<h1>Lost Policy Bond</h1><p>Support for policy record reconstruction and insurer-side requirements where policy bond documents are unavailable.</p>'],
        'insurance-nominee-issues' => ['title' => 'Nominee Issues', 'content' => '<h1>Insurance Nominee Issues</h1><p>Handle cases involving missing, disputed, or outdated nomination details affecting payout release.</p>'],
        'insurance-policy-loan-complications' => ['title' => 'Policy Loan Complications', 'content' => '<h1>Policy Loan Complications</h1><p>Clarify how policy-loan status affects maturity or claim payouts and prepare route-specific documentation.</p>'],
        'insurance-record-mismatch' => ['title' => 'Old LIC / Insurer Record Mismatch', 'content' => '<h1>Old LIC / Insurer Record Mismatch</h1><p>Resolve identity, address, bank, and servicing detail mismatches that delay legitimate claim movement.</p>'],
        'insurance-survival-benefit-not-received' => ['title' => 'Survival Benefit Not Received', 'content' => '<h1>Survival Benefit Not Received</h1><p>For money-back or periodic insurance benefits that were due but not credited correctly.</p>'],
        'insurance-address-kyc-bank-mismatch' => ['title' => 'Address / KYC / Bank Mismatch Blocking Payout', 'content' => '<h1>Address / KYC / Bank Mismatch Blocking Payout</h1><p>Fix servicing and compliance mismatches that prevent payout release in otherwise valid insurance cases.</p>'],
        'unclaimed-provident-fund' => ['title' => 'Unclaimed Provident Fund', 'content' => '<h1>Recover Provident Fund Stuck Across Old Jobs</h1><p>For old PF balances across past employers, legacy member IDs, transfer gaps, or post-death PF claims requiring structured reconstruction.</p>'],
        'unclaimed-mutual-funds' => ['title' => 'Unclaimed Mutual Funds', 'content' => '<h1>Unclaimed Mutual Funds</h1><p>Support for old folios, inactive payout instructions, KYC mismatch, post-death entitlement, and forgotten investment records.</p>'],
        'dormant-inoperative-bank-deposits' => ['title' => 'Dormant / In-operative Bank Deposits', 'content' => '<h1>Dormant / In-operative Bank Deposits</h1><p>Recover dormant balances and long-ignored deposits through branch-side reactivation and claim documentation.</p>'],
    ];
}

function sahirastha_seed_site_content(): void
{
    if (get_option('sahirastha_seed_version') === '1.0.0') {
        return;
    }

    $pages = sahirastha_seed_pages();
    $ids = [];

    foreach ($pages as $slug => $page) {
        $existing = get_page_by_path($slug);
        $page_data = [
            'post_title'   => $page['title'],
            'post_name'    => $slug,
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_content' => $page['content'],
        ];

        if ($existing instanceof WP_Post) {
            $page_data['ID'] = $existing->ID;
            $ids[$slug] = wp_update_post($page_data, true);
        } else {
            $ids[$slug] = wp_insert_post($page_data, true);
        }
    }

    if (! is_wp_error($ids['home'] ?? null)) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', (int) $ids['home']);
    }

    $menu_name = 'Primary Menu';
    $menu = wp_get_nav_menu_object($menu_name);
    $menu_id = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu($menu_name);

    $menu_pages = ['home', 'services', 'process', 'pricing', 'faq', 'for-nris', 'contact'];

    foreach ($menu_pages as $slug) {
        if (empty($ids[$slug]) || is_wp_error($ids[$slug])) {
            continue;
        }

        $already = wp_get_nav_menu_items($menu_id);
        $exists = false;
        if (is_array($already)) {
            foreach ($already as $item) {
                if ((int) $item->object_id === (int) $ids[$slug]) {
                    $exists = true;
                    break;
                }
            }
        }

        if (! $exists) {
            wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title'     => $pages[$slug]['title'],
                'menu-item-object'    => 'page',
                'menu-item-object-id' => $ids[$slug],
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
            ]);
        }
    }

    $locations = get_theme_mod('nav_menu_locations', []);
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);

    update_option('sahirastha_seed_version', '1.0.0');
}
add_action('after_switch_theme', 'sahirastha_seed_site_content');
