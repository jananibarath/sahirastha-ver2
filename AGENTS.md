# AGENTS.md

## Project
This repository builds the real WordPress website for Sahirastha, a founder-led Indian asset-recovery and claim-support business.

Sahirastha helps people with:
- shares and securities
- IEPF claims
- insurance claims and payout issues
- provident fund
- mutual funds
- dormant / in-operative bank deposits

Primary goal:
- drive serious case-review / consultation enquiries

Secondary goal:
- help visitors identify the correct service route without guessing

## Brand position
The site must feel:
- serious
- calm
- practical
- trustworthy
- founder-led
- clear
- not flashy
- not generic corporate finance
- not like an investment advisory portal

Avoid:
- hype
- fake scale
- filler copy
- generic consultant language
- stock-finance design clichés
- decorative clutter

## Source of truth
All content must come only from the cleaned source files in `/source/`.

Do not invent:
- business claims
- recovery rates
- customer counts
- turnaround promises
- legal certainty
- testimonials
- statistics
- vague filler copy

If a source file marks content as placeholder or draft-only, do not publish it as final public content.

## Hard non-negotiables
1. Build a real working WordPress theme. Do not produce a shell.
2. Theme must live in `/wp-content/themes/sahirastha/`.
3. The theme must be Gutenberg-friendly.
4. Important marketing copy must remain editable in WordPress page content / blocks, not buried in PHP templates.
5. Implement real page creation / seeding logic inside theme code. Template files alone are not enough.
6. Create real pages, real menus, and assign the homepage properly.
7. Menu items must point to real pages.
8. WhatsApp must be a floating bottom-right button, not a menu item.
9. Keep the build lightweight and maintainable.
10. Do not add a page builder or plugin dependency unless absolutely necessary.
11. Mobile responsiveness is mandatory.
12. Do not spend time generating planning markdown, abstract notes, or documentation instead of implementation.

## Content publishing rules
- Prefer omission over invention.
- If copy is fully available in source, seed it.
- If copy is not available in source, do not fabricate a full public-facing page.
- Do not publish fake testimonials.
- Do not publish unverified statistics.
- Do not write “guaranteed recovery” or similar language.
- Preserve the founder-led, classification-first tone.

## Known source constraints
- Homepage section with hard numbers is not publish-ready until numbers are verified.
- Draft testimonial / case-story models are not publishable as real testimonials.
- Only the NRI pathway is clearly available in the uploaded pathway source. Do not invent additional standalone pathway pages unless source text exists.

## Information architecture priorities
Build in this order:
1. foundation theme + seeded core pages + homepage assignment + menu assignment + WhatsApp CTA
2. shares service pages
3. insurance service pages
4. PF / mutual fund / bank deposit pages
5. responsive QA, link cleanup, SEO basics, accessibility cleanup

## Expected early pages
Early real pages should include:
- Home
- Services
- Process
- About / Why Sahirastha
- Pricing
- FAQ
- Case Stories / Testimonials
- For NRIs

Only create Contact in the current phase if its source copy is available or clearly derived from existing approved CTA copy without invention.

## Service structure
Top-level clusters:
- Shares & Securities
- Insurance Claims & Recovery
- PF, Mutual Funds & Bank Deposits

Do not collapse the whole business into one vague generic service page.

## Implementation standard
A task is incomplete if it does not leave behind:
- actual theme files
- actual seeded pages
- linked navigation
- assigned homepage
- working header/footer
- working floating WhatsApp button
- editable page content
- responsive styling
- updated internal links for the pages created in that phase

## Forbidden shortcuts
- no lorem ipsum
- no fake stats
- no fake testimonials
- no giant “under construction” service grids
- no hardcoded longform homepage body copy in PHP where editable page content should be used
- no docs-only output when implementation was requested
- no generic stock-finance hero language

## Theme architecture guidance
Use a modular structure.
Recommended areas:
- `inc/setup/` for theme setup, menus, options, seeding
- `inc/content/` for seed mapping helpers
- `template-parts/` for reusable components
- `assets/css/` and `assets/js/` for front-end assets

Seed logic must be idempotent:
- rerunning it should update / reuse known pages
- it must not create duplicate pages or duplicate menu items

Keep the WhatsApp URL configurable in one obvious place.

## Before finishing any phase
Check all of these:
- Are the pages real and published?
- Is Home assigned as front page?
- Does the menu point only to real pages?
- Is WhatsApp floating at bottom-right?
- Are fake stats and fake testimonials absent?
- Is the copy editable in WordPress?
- Does the site behave properly on mobile?
