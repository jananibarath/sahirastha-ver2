<?php

declare(strict_types=1);

const SAHIRASTHA_CORE_SEED_VERSION = '2026-03-25-core-pages-depth-refresh-1';

add_action('after_switch_theme', 'sahirastha_seed_core_pages');
add_action('init', 'sahirastha_seed_core_pages');

function sahirastha_seed_core_pages(): void
{
    if (! is_admin() || get_option('sahirastha_core_seed_version') === SAHIRASTHA_CORE_SEED_VERSION) {
        return;
    }

    $pages = sahirastha_core_page_definitions();

    foreach ($pages as $slug => $page) {
        $content = sahirastha_build_page_blocks($page);
        $hash = md5($content);

        $existing = get_page_by_path($slug, OBJECT, 'page');
        if (! $existing instanceof WP_Post) {
            $post_id = wp_insert_post([
                'post_type' => 'page',
                'post_status' => 'publish',
                'post_title' => $page['title'],
                'post_name' => $slug,
                'post_content' => $content,
            ]);

            if (is_int($post_id) && $post_id > 0) {
                update_post_meta($post_id, '_sahirastha_seed_hash', $hash);
                update_post_meta($post_id, '_sahirastha_seed_managed', '1');
            }

            continue;
        }

        $should_update = sahirastha_should_refresh_page($existing, $hash);
        if (! $should_update) {
            continue;
        }

        wp_update_post([
            'ID' => $existing->ID,
            'post_title' => $page['title'],
            'post_content' => $content,
        ]);

        update_post_meta($existing->ID, '_sahirastha_seed_hash', $hash);
        update_post_meta($existing->ID, '_sahirastha_seed_managed', '1');
    }

    update_option('sahirastha_core_seed_version', SAHIRASTHA_CORE_SEED_VERSION);
}

function sahirastha_should_refresh_page(WP_Post $post, string $new_hash): bool
{
    $current_hash = (string) get_post_meta($post->ID, '_sahirastha_seed_hash', true);
    $managed = (string) get_post_meta($post->ID, '_sahirastha_seed_managed', true) === '1';

    if ($managed) {
        return $current_hash !== $new_hash;
    }

    $plain_text = trim(wp_strip_all_tags((string) $post->post_content));
    if ($plain_text === '') {
        return true;
    }

    $word_count = str_word_count($plain_text);
    $looks_legacy_thin = $word_count < 220 && str_contains($plain_text, 'Request a Case Review');

    return $looks_legacy_thin;
}

function sahirastha_build_page_blocks(array $page): string
{
    $blocks = [];
    $blocks[] = sahirastha_heading_block($page['hero_title'], 1);
    $blocks[] = sahirastha_paragraph_block($page['hero_subheadline']);
    $blocks[] = sahirastha_paragraph_block($page['hero_support']);
    $blocks[] = sahirastha_paragraph_block('Request a Case Review');

    foreach ($page['sections'] as $section) {
        $blocks[] = sahirastha_heading_block($section['title'], 2);

        if (! empty($section['paragraphs'])) {
            foreach ($section['paragraphs'] as $paragraph) {
                $blocks[] = sahirastha_paragraph_block($paragraph);
            }
        }

        if (! empty($section['items'])) {
            $blocks[] = sahirastha_list_block($section['items']);
        }

        if (! empty($section['faq'])) {
            foreach ($section['faq'] as $qa) {
                $blocks[] = sahirastha_heading_block($qa['q'], 3);
                $blocks[] = sahirastha_paragraph_block($qa['a']);
            }
        }
    }

    $blocks[] = sahirastha_heading_block('Final CTA', 2);
    $blocks[] = sahirastha_paragraph_block($page['final_cta']);
    $blocks[] = sahirastha_paragraph_block($page['final_support']);

    return implode("\n\n", $blocks);
}

function sahirastha_heading_block(string $text, int $level = 2): string
{
    return sprintf('<!-- wp:heading {"level":%d} --><h%d>%s</h%d><!-- /wp:heading -->', $level, $level, esc_html($text), $level);
}

function sahirastha_paragraph_block(string $text): string
{
    return sprintf('<!-- wp:paragraph --><p>%s</p><!-- /wp:paragraph -->', esc_html($text));
}

function sahirastha_list_block(array $items): string
{
    $list_items = array_map(static fn (string $item): string => '<li>' . esc_html($item) . '</li>', $items);
    return "<!-- wp:list --><ul>" . implode('', $list_items) . "</ul><!-- /wp:list -->";
}

function sahirastha_core_page_definitions(): array
{
    return [
        'about' => [
            'title' => 'About / Why Sahirastha',
            'hero_title' => 'Why Sahirastha Exists',
            'hero_subheadline' => 'Sahirastha was built for people dealing with old shares, IEPF matters, insurance claim issues, provident-fund balances, mutual fund problems, dormant bank deposits, and post-death paperwork that is stuck or hard to classify.',
            'hero_support' => 'This is a founder-led, process-disciplined service for practical route clarity in document-heavy financial recovery matters.',
            'sections' => [
                ['title' => 'Why This Page Exists', 'paragraphs' => ['People come here to decide whether the service is serious enough to trust when the case is already difficult.', 'The purpose is to explain why Sahirastha exists, what work it is built for, and why classification and process discipline come before blind filing.']],
                ['title' => 'What Sahirastha Is', 'paragraphs' => ['Sahirastha helps classify and move old, delayed, document-heavy recovery matters where the route is unclear.', 'The work sits between generic information and actual execution, especially when shares, insurance, PF, mutual funds, and bank deposits overlap.']],
                ['title' => 'What Makes Sahirastha Different', 'items' => ['Route clarity before filing.', 'Comfort with messy records and incomplete papers.', 'Founder-led accountability and honest assessment.', 'Intellectual honesty: not every case is ready or strong.']],
                ['title' => 'How Sahirastha Works with Clients', 'paragraphs' => ['Start with facts, review records, classify the route, and assess complexity.', 'Where workable, scope and fee logic are explained before execution begins.']],
                ['title' => 'What Sahirastha Does Not Claim', 'paragraphs' => ['Sahirastha is not a bank, insurer, registrar, EPFO, AMC, or regulator.', 'It does not promise guaranteed recovery, guaranteed timelines, or certainty in every old case.']],
                ['title' => 'FAQ', 'faq' => [
                    ['q' => 'Why approach Sahirastha instead of trying one more complaint?', 'a' => 'Many matters are stuck because route and documentation are unclear. Repeating the same confusion rarely helps.'],
                    ['q' => 'Can Sahirastha help with incomplete documents?', 'a' => 'Often yes. Many real cases begin with fragments and then move through structured reconstruction.'],
                    ['q' => 'Can NRIs, widows, and legal heirs use the same service?', 'a' => 'Yes. The same logic applies, though remote execution and post-death entitlement usually add complexity.'],
                ]],
            ],
            'final_cta' => 'If your case involves old records, unpaid amounts, or confusion across institutions, the next step is a clear review of facts, not more guesswork.',
            'final_support' => 'Start with what you know. Sahirastha can help identify the likely route before confusion gets more expensive.',
        ],
        'process' => [
            'title' => 'Process',
            'hero_title' => 'How Sahirastha Works - From a Scattered Financial Problem to a Clear Route',
            'hero_subheadline' => 'Sahirastha helps people move from uncertainty to a structured next step across shares, IEPF, insurance, PF, mutual funds, and dormant deposits.',
            'hero_support' => 'Many cases begin with an old paper, a blocked record, a death in the family, or a missed payout. This page explains what happens after the case comes in.',
            'sections' => [
                ['title' => 'Why This Page Exists', 'paragraphs' => ['People want to know what happens next and whether the issue can be understood without wasting months on the wrong route.', 'The process is designed for both clearly labeled cases and cases where the asset category is still unclear.']],
                ['title' => 'How the Process Works', 'items' => ['Start with broad facts and what is currently known.', 'Review available records, including partial or old documents.', 'Identify the likely route and correct category.', 'Assess complexity drivers and missing pieces.', 'Clarify scope and fee logic for workable matters.', 'Move into execution with disciplined document and institution handling.', 'Move toward outcome or closure with practical clarity.']],
                ['title' => 'What Affects Time and Complexity', 'items' => ['Age and quality of records.', 'Death-related entitlement and succession issues.', 'Name, signature, KYC, bank, or address mismatch.', 'NRI execution requirements.', 'Employer or institution-side gaps.', 'More than one asset type in the same case.']],
                ['title' => 'What Sahirastha Does and Does Not Do', 'paragraphs' => ['Sahirastha helps classify, structure, and move actionable matters.', 'It cannot waive legal requirements or promise recovery in every case. Good process is not false assurance.']],
                ['title' => 'Special Situations', 'paragraphs' => ['NRIs often need remote execution, attestation, and bank handling support.', 'Widows, legal heirs, and families often need more careful entitlement and documentation sequencing.', 'No-document or mixed-issue matters usually start with disciplined reconstruction.']],
            ],
            'final_cta' => 'You do not need perfect terminology or a perfect file to begin. Start with the facts you have.',
            'final_support' => 'If you know the category, use the relevant service page. If not, begin here and let the route be identified properly.',
        ],
        'pricing' => [
            'title' => 'Pricing',
            'hero_title' => 'Pricing That Matches the Work Involved',
            'hero_subheadline' => 'Sahirastha does not treat every financial recovery matter as identical. Pricing follows route, record reality, and execution effort.',
            'hero_support' => 'This page explains fee logic without pretending every case can fit into one flat number.',
            'sections' => [
                ['title' => 'Why This Page Exists', 'paragraphs' => ['Clients should not have to choose between vague promises and fake flat pricing.', 'In old financial matters, difficulty often sits below the surface and only appears after route classification.']],
                ['title' => 'How Pricing Is Usually Decided', 'items' => ['Understand facts, asset clues, and visible blockers.', 'Identify the likely route and whether it is straightforward or succession-heavy.', 'Assess scope based on records, claimant position, and execution burden.', 'Explain fee logic before execution begins.']],
                ['title' => 'What Often Increases Scope', 'items' => ['Incomplete or inconsistent records.', 'Name/signature/address/bank mismatch.', 'Death-related claimant issues and missing nomination.', 'NRI execution and cross-institution coordination.', 'Multiple folios, policies, accounts, or mixed asset classes.']],
                ['title' => 'What This Page Does Not Claim', 'paragraphs' => ['No guaranteed recovery, guaranteed timelines, or universal formula pricing.', 'Trust comes from being plain about complexity, scope, and limit.']],
                ['title' => 'FAQ', 'faq' => [
                    ['q' => 'Why no single fixed fee for every case?', 'a' => 'Because route, records, and execution burden vary sharply even within the same broad category.'],
                    ['q' => 'Is pricing based only on amount involved?', 'a' => 'No. Value matters, but complexity and work required matter as much or more.'],
                    ['q' => 'What if the case is document-weak?', 'a' => 'The honest answer should be given early, including what can be traced and what must be strengthened first.'],
                ]],
            ],
            'final_cta' => 'If you want route and fee logic explained before more time is lost, begin with the facts available.',
            'final_support' => 'Sahirastha can help separate a clean case from a repairable one and a heavy one from a routine one.',
        ],
        'faq' => [
            'title' => 'FAQ',
            'hero_title' => 'Frequently Asked Questions',
            'hero_subheadline' => 'Practical answers for old financial recovery matters involving shares, IEPF, insurance, PF, mutual funds, and dormant deposits.',
            'hero_support' => 'These answers are designed to reduce guesswork and help you start with the right route.',
            'sections' => [
                ['title' => 'Core Clarifications', 'faq' => [
                    ['q' => 'Do I need to know the exact asset type before contacting Sahirastha?', 'a' => 'No. Many people start with symptoms, not labels. Classification is part of the process.'],
                    ['q' => 'Can one case involve multiple asset types?', 'a' => 'Yes. Families often have overlapping shares, insurance, PF, and bank-deposit issues.'],
                    ['q' => 'Can incomplete files still be reviewed?', 'a' => 'Yes. Fragments can often begin traceability, even if claimability requires more documentation later.'],
                    ['q' => 'How long do such matters usually take?', 'a' => 'There is no universal timeline. Speed depends on route clarity, claimant position, record quality, institution overlap, and whether execution is from India or abroad.'],
                    ['q' => 'Why do cases get stuck even when money seems genuine?', 'a' => 'Because institutions still need clean claimant proof, matching records, and the correct procedural route before release.'],
                    ['q' => 'Will Sahirastha take up every case?', 'a' => 'No. Some cases are too early, too weak, or better handled directly through a clear institution route.'],
                ]],
            ],
            'final_cta' => 'If your case involves old records, unpaid amounts, post-death claims, or no clear route, start with route clarity.',
            'final_support' => 'Begin with what you know now, even if the file is incomplete.',
        ],
        'contact' => [
            'title' => 'Contact',
            'hero_title' => 'Contact Sahirastha',
            'hero_subheadline' => 'Start with the facts you have. You do not need a perfect file before reaching out.',
            'hero_support' => 'If money seems stuck, records are old, or the route itself is unclear, start here.',
            'sections' => [
                ['title' => 'Direct Contact Details', 'items' => [
                    'Name: Janani Barath',
                    'Address: No. 9, 11th Main Road, Vasanth Nagar, Bangalore - 560001',
                    'Phone / WhatsApp: +91 9845808333',
                    'Email: janani.barath@gmail.com',
                ]],
                ['title' => 'What to Send in Your First Message', 'paragraphs' => ['Share holder name, your relationship/capacity, and what asset the matter may involve (or say if unsure).', 'Describe the blocker in one practical line and list the clues/documents currently available.', 'Mention if the holder is deceased, whether you are handling from India or abroad, and whether multiple family members are involved.']],
                ['title' => 'If Your File Is Incomplete', 'paragraphs' => ['Incomplete files are common in old recovery work. Fragments can still support initial classification.', 'Traceability and claimability are different: a trail can be identified before entitlement is fully claim-ready.']],
                ['title' => 'What Happens After Contact', 'paragraphs' => ['The first step is classification: route, claimant position, record quality, and institutional sequence.', 'From there the matter is treated as clean, repairable, direct-handle, or heavy, based on facts.']],
                ['title' => 'FAQ', 'faq' => [
                    ['q' => 'Can NRIs start from abroad?', 'a' => 'Yes. NRI cases often need additional execution steps, but they can and should begin with factual classification.'],
                    ['q' => 'Can widows or legal heirs contact even if nomination is unclear?', 'a' => 'Yes. That is a common reason cases stall, and careful entitlement sequencing is needed.'],
                    ['q' => 'Will I be told if the case is too weak or too early?', 'a' => 'Yes. Serious handling includes saying when a case is premature, document-weak, or better handled directly.'],
                ]],
            ],
            'final_cta' => 'You do not need a perfect file before you begin. You need the case seen clearly.',
            'final_support' => 'Start with what you know now, even if the route is unclear or records are incomplete.',
        ],
        'case-stories' => [
            'title' => 'Case Stories / Testimonials',
            'hero_title' => 'What Cases Like This Usually Look Like',
            'hero_subheadline' => 'Old financial recovery matters usually arrive as fragments, not neat files.',
            'hero_support' => 'These anonymised stories show the patterns Sahirastha is built to help untangle.',
            'sections' => [
                ['title' => 'Publication Note', 'paragraphs' => ['These are anonymised case-story drafts designed to show realistic patterns without invented client names, payouts, or certainty language.']],
                ['title' => 'Case Patterns Across Categories', 'items' => ['Shares: physical certificates, stopped dividends, and outdated holder records.', 'IEPF/post-death: family uncertainty around claimant sequence and proof.', 'PF: multiple old employment trails and incomplete identifier continuity.', 'Insurance: maturity or death-claim delays caused by record mismatch and entitlement documentation.', 'Mixed-asset families: overlapping issues across shares, insurance, PF, and dormant deposits.']],
                ['title' => 'What These Stories Actually Show', 'paragraphs' => ['The visible problem is often unpaid money. The real problem is usually route misclassification and weak sequencing.', 'Sahirastha is not a magic-fix promise; it is a structured process that makes cases legible and actionable where possible.']],
                ['title' => 'Recurring Themes', 'items' => ['Old records and incomplete files.', 'Stopped payouts and post-death claims.', 'Record mismatch and claimant confusion.', 'Cross-institution trails treated incorrectly as routine complaints.']],
            ],
            'final_cta' => 'Your case does not need to match a story exactly. If the pattern feels familiar, start with route clarity.',
            'final_support' => 'Sahirastha can help identify the likely blocker and what needs to happen next.',
        ],
    ];
}
