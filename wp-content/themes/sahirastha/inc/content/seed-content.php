<?php
/**
 * Seed content map sourced from /source drafts.
 */

function sahirastha_block_heading($text, $level = 2) {
    return '<!-- wp:heading {"level":' . (int) $level . '} --><h' . (int) $level . '>' . esc_html($text) . '</h' . (int) $level . '><!-- /wp:heading -->';
}

function sahirastha_block_paragraph($text) {
    return '<!-- wp:paragraph --><p>' . esc_html($text) . '</p><!-- /wp:paragraph -->';
}

function sahirastha_block_list($items) {
    $html = '<!-- wp:list --><ul>';
    foreach ($items as $item) {
        $html .= '<li>' . esc_html($item) . '</li>';
    }
    $html .= '</ul><!-- /wp:list -->';

    return $html;
}

function sahirastha_seed_pages_map() {
    return [
        'home' => [
            'title' => 'Home',
            'content' => implode("\n", [
                sahirastha_block_heading('From scattered records to a clear financial recovery route', 1),
                sahirastha_block_paragraph('Sahirastha helps individuals, families, legal heirs, widows, and NRIs handle old shares, IEPF matters, insurance claim issues, provident-fund balances, mutual funds, and dormant bank deposits.'),
                sahirastha_block_paragraph('Many cases do not fail because money does not exist. They stall because records are old, paperwork is incomplete, or no one is sure which route applies first.'),
                sahirastha_block_heading('What we handle'),
                sahirastha_block_list([
                    'Shares and securities, including IEPF-linked matters',
                    'Insurance claims and payout issues',
                    'Provident fund, mutual fund, and dormant bank deposit recovery',
                    'NRI, legal-heir, and post-death documentation-heavy cases',
                ]),
                sahirastha_block_heading('How we work'),
                sahirastha_block_paragraph('We begin with classification. First identify the asset and blocker. Then organize records and move the matter through the correct route.'),
                sahirastha_block_paragraph('We do not promise guaranteed outcomes or instant timelines. We focus on process discipline and practical next steps.'),
            ]),
        ],
        'services' => [
            'title' => 'Services',
            'content' => implode("\n", [
                sahirastha_block_heading('Explore Our Services', 1),
                sahirastha_block_paragraph('Find the right path to recover stuck financial assets.'),
                sahirastha_block_paragraph('Start with the category closest to your issue. If you are unsure, this page helps narrow the route quickly.'),
                sahirastha_block_heading('Service clusters'),
                sahirastha_block_heading('Shares & Securities', 3),
                sahirastha_block_paragraph('For issues around shares, dividends, old physical certificates, IEPF claims, transmission after death, and holder-record corrections.'),
                sahirastha_block_heading('Insurance Claims & Recovery', 3),
                sahirastha_block_paragraph('For unpaid maturity amounts, death claims, short-settled or rejected claims, nominee issues, lost policy papers, and KYC or bank mismatch problems.'),
                sahirastha_block_heading('PF, Mutual Funds & Bank Deposits', 3),
                sahirastha_block_paragraph('For old provident-fund balances, unclaimed mutual-fund holdings, and dormant or inoperative bank accounts and deposits.'),
                sahirastha_block_heading('Who this page helps'),
                sahirastha_block_list([
                    'Individuals and families with old or incomplete records',
                    'Legal heirs and widows handling post-death matters',
                    'NRIs managing Indian financial trails from abroad',
                ]),
                sahirastha_block_paragraph('Detailed service pages for each cluster will be expanded in subsequent phases.'),
            ]),
        ],
        'process' => [
            'title' => 'Process',
            'content' => implode("\n", [
                sahirastha_block_heading('How Sahirastha Works', 1),
                sahirastha_block_paragraph('Most people begin with uncertainty, not a neat label. The process is built to move from confusion to a practical route.'),
                sahirastha_block_list([
                    'Step 1: Start with the broad facts and available clues.',
                    'Step 2: Review records such as statements, policy papers, share certificates, PF details, and claim correspondence.',
                    'Step 3: Classify the likely route and institution path.',
                    'Step 4: Assess complexity including mismatch, succession, missing documents, and NRI execution requirements.',
                    'Step 5: Clarify scope and fee logic before execution.',
                    'Step 6: Execute with document preparation and institution follow-up.',
                    'Step 7: Move toward outcome or practical closure.',
                ]),
                sahirastha_block_paragraph('You do not need a perfect file before first review. Many valid matters begin with partial records.'),
            ]),
        ],
        'about' => [
            'title' => 'About / Why Sahirastha',
            'content' => implode("\n", [
                sahirastha_block_heading('Why Sahirastha Exists', 1),
                sahirastha_block_paragraph('Sahirastha is a founder-led, process-disciplined service built for old, document-heavy financial recovery matters.'),
                sahirastha_block_paragraph('The work sits between generic information and real execution. Many delays happen because the route is misunderstood, not because entitlement is fake.'),
                sahirastha_block_heading('What makes the approach different'),
                sahirastha_block_list([
                    'Route clarity before blind filing',
                    'Comfort with messy and incomplete records',
                    'Founder-led accountability and practical communication',
                    'Honest limits: no false certainty on every case',
                ]),
                sahirastha_block_paragraph('Not every matter is immediately executable. A serious review should distinguish clean, repairable, and weak files early.'),
            ]),
        ],
        'pricing' => [
            'title' => 'Pricing',
            'content' => implode("\n", [
                sahirastha_block_heading('Pricing That Matches the Work Involved', 1),
                sahirastha_block_paragraph('Sahirastha does not use one flat number for every case. Pricing follows route, record quality, and scope.'),
                sahirastha_block_heading('How pricing is approached'),
                sahirastha_block_list([
                    'Review the broad facts and available documents first.',
                    'Identify whether the matter is procedural, correction-heavy, succession-linked, or cross-asset.',
                    'Explain likely scope and fee logic before execution begins.',
                ]),
                sahirastha_block_paragraph('No guaranteed recovery language is used. Complexity, institution process, and documentation quality affect movement.'),
            ]),
        ],
        'faq' => [
            'title' => 'FAQ',
            'content' => implode("\n", [
                sahirastha_block_heading('Frequently Asked Questions', 1),
                sahirastha_block_heading('Do I need to know the exact service before contacting Sahirastha?', 3),
                sahirastha_block_paragraph('No. Many cases begin with symptoms like unpaid money, old papers, or post-death confusion. Classification comes first.'),
                sahirastha_block_heading('Do I need all documents before first review?', 3),
                sahirastha_block_paragraph('No. Partial records are common. Early review helps identify what is missing and what can still be worked.'),
                sahirastha_block_heading('Can one case involve multiple assets?', 3),
                sahirastha_block_paragraph('Yes. Real family matters often overlap across shares, insurance, PF, mutual funds, and bank deposits.'),
                sahirastha_block_heading('Can NRIs, widows, and legal heirs use the same service?', 3),
                sahirastha_block_paragraph('Yes. The core approach remains route clarity and document discipline, with extra execution layers where required.'),
            ]),
        ],
        'case-stories-testimonials' => [
            'title' => 'Case Stories / Testimonials',
            'content' => implode("\n", [
                sahirastha_block_heading('What cases like this usually look like', 1),
                sahirastha_block_paragraph('These are anonymised case-story patterns intended to show typical situations. They are not named testimonials, payout claims, or guaranteed outcomes.'),
                sahirastha_block_heading('Story: Physical certificates and stopped dividends', 3),
                sahirastha_block_paragraph('An elderly holder had old physical certificates, outdated address records, and stopped dividends. The case required sequence-based correction and record regularisation before recovery steps could move.'),
                sahirastha_block_heading('Story: Post-death shares and possible IEPF trail', 3),
                sahirastha_block_paragraph('A family found old share papers after a parent’s death but lacked a clean folio map. The work started by separating ownership evidence, entitlement, and likely IEPF-related steps.'),
                sahirastha_block_heading('Story: Old PF trails across multiple employers', 3),
                sahirastha_block_paragraph('A claimant with job changes had fragmented PF records. The first step was tracing and classification, not random filing.'),
            ]),
        ],
        'for-nris' => [
            'title' => 'For NRIs',
            'content' => implode("\n", [
                sahirastha_block_heading('Recover Old Indian Financial Assets Without Guessing the Route From Abroad', 1),
                sahirastha_block_paragraph('If you live outside India and are dealing with old shares, IEPF matters, insurance policies, PF balances, mutual-fund folios, or dormant bank deposits, start with classification first.'),
                sahirastha_block_heading('Who this pathway is for'),
                sahirastha_block_list([
                    'NRIs with old Indian records that no longer match current details',
                    'Families abroad handling post-death claims',
                    'People unsure whether their issue belongs under shares, IEPF, insurance, PF, mutual funds, or bank deposits',
                ]),
                sahirastha_block_heading('What usually delays NRI cases'),
                sahirastha_block_list([
                    'Route confusion before asset classification',
                    'Old records not matching current identity, bank, or KYC details',
                    'Weak paper trail and institution ambiguity',
                    'Extra document layers in family or succession matters',
                ]),
                sahirastha_block_paragraph('Not every case can be solved quickly. Outcomes depend on record quality, entitlement clarity, and institution requirements.'),
            ]),
        ],
    ];
}
