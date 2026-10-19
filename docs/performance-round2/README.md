# Round 2 performance handoff

Design, content, prices and booking calculations are unchanged. No plugin, CDN or server configuration changes. `assets/css/style.css` is byte-for-byte unchanged.

## Tasks and diffs

| Task | Result | Diff |
|---|---|---|
| 1. Font Awesome | 224,349 → 2,932 bytes; 31 icon mappings, base style classes and four used font faces | [Task 1](task-1.patch) |
| 2. Slick | Existing Slick 1.8.0 minified locally: 88,438 → 43,111 bytes; enqueued as `slick.min.js` | [Task 2](task-2.patch), enqueue in Task 3 |
| 3. Bootstrap/Popper | Popper no longer enqueued; Bootstrap retained for FAQ Collapse | [Task 3](task-3.patch) |
| 4. Animate | 84,769 → 6,710 bytes; retained template and CSS-referenced keyframes | [Task 4](task-4.patch) |
| 5. Main CSS | No removal applied; reviewed selector-level proposal saves 3,030 bytes | [Proposal, not applied](task-5-proposal-not-applied.patch) |
| 6. Images | Additional 214,224 bytes saved; local static image dimensions and async/lazy attributes | [Task 6](task-6.patch), [image sizes](image-sizes.json) |
| 7. Tests | All runnable test scripts pass, including PHP/admin/migration and the new Round 2 checks | [Results](test-results.txt) |

## Exact icon audit

The audit searched theme PHP, JS and CSS, excluding the Font Awesome definition stylesheet itself (otherwise every icon definition would appear used), installed development dependencies, caches and generated reports. [icon-usage.json](icon-usage.json) lists exact source references. All remaining styles are needed: `fal`, `far`, `fas`/`fa`, and `fab`. In particular, light is used by header/mobile/menu/search/phone/calendar/user/arrow controls, so removing `fa-light-300.woff2` would change or break icons. No additional font style/file was removed in this round. The earlier unused Duotone removal remains in effect. Four WOFF2 faces retain `font-display: swap`.

Retained icon mappings:

```
fa-angle-left           fa-angle-right          fa-arrow-right
fa-arrow-up             fa-bars                 fa-calendar-alt
fa-calendar-check       fa-caret-right          fa-check-circle
fa-chevron-down         fa-chevron-up           fa-envelope
fa-facebook-f           fa-gift                 fa-instagram
fa-layer-group          fa-long-arrow-left      fa-long-arrow-right
fa-map-marker-alt       fa-phone-alt            fa-search
fa-shield-alt           fa-snapchat-ghost        fa-star
fa-tag                  fa-th-large             fa-tiktok
fa-times                fa-twitter              fa-user
fa-whatsapp
```

New icons added later need their mapping added to this reduced stylesheet. Font files retain their full existing glyph sets; no font subset has been created.

## Bootstrap and animations

Rendered Bootstrap functionality is Collapse in the homepage and FAQ accordions. Navigation uses the theme's own dropdown/mobile scripts. Booking and service/offers popups use native dialogs, not Bootstrap Modal. No rendered Bootstrap dropdown, tooltip, popover, tab or modal usage was found. Popper was removed from the loading graph; Bootstrap was not removed. Existing vendor source files remain available on disk.

Slick was minified from the exact local 1.8.0 source using Terser, rather than downloading a different release. The original unminified source remains available.

Retained Animate.css keyframes are `fadeInUp`, `fadeInRight`, `fadeInDown`, `bounceInLeft`, `slideOutLeft`, `bounce`, and `spin`, plus the `.animated` base. `fadeInDown` is needed for the sticky header; some names are referenced directly by CSS rather than WOW classes. Existing RTL overrides remain. jQuery `.fadeIn()`/`.fadeOut()` methods do not need the removed Animate.css classes. Existing `fadeInBottom` markup has no matching keyframes in the original file; this round did not introduce a replacement animation or change its behavior.

## Main CSS proposal — approval required

The broad initial audit counted about 8.3 KB of matching rules, but several rules share selectors with active buttons, blog layouts and other components. Removing those whole rules would be unsafe. The final proposal removes only obsolete selector branches and wholly obsolete rules while preserving shared declarations. Its measured total reduction is **3,030 bytes** (325,659 → 322,629 bytes), about 0.9%:

- Legacy blog variant 2 selector branches: about 1,612 bytes.
- Legacy service variant 2 selector branches: about 419 bytes.
- Legacy testimonial variant 2 selector branches: about 659 bytes.
- Cart-close rules: about 294 bytes.
- Serialization/whitespace accounts for the small remainder.

Review [the proposed diff](task-5-proposal-not-applied.patch) and [exact selectors](css-removal-candidates.json). It is **not applied**. No entire blog, team or portfolio section is proposed for deletion: current inner pages and homepage sections still use them. Removing more would need wider page/state coverage and a further review.

## Images and markup

The optimizer now uses a maximum width of 900 for `about` and `project`, including nested folders. It still starts from ignored originals and retains filenames/formats. Six project before/after images became smaller; About images were already below 900px. Compared with Round 1, JPG/PNG total size is **4,092,117 → 3,877,893 bytes** (209.2 KiB saved). Compared with the original unoptimized files, the result is 37.2% smaller.

`inc/image-performance.php` processes rendered frontend HTML with WordPress's HTML Tag Processor. It reads dimensions only from files inside the theme's `assets/img/` directory, with path validation and a request-local cache; no remote image metadata requests. It handles templates and generated output uniformly instead of duplicating attributes across every template.

Local static images receive missing intrinsic width/height attributes and `decoding="async"`. Offscreen images receive `loading="lazy"` unless an explicit loading choice already exists. Logos/header and hero markup are excluded from new lazy loading. The active hero stays eager; existing lazy attributes on hidden hero slides are preserved. Inner pages keep their first non-decorative content image eager. The two dynamically populated booking image slots have explicit dimensions matching their existing CSS layout. Existing image dimensions/loading choices are preserved.

The HTML processor is available in WP 6.2+. On older WP 6.0/6.1 the output is left untouched, preserving compatibility but skipping this markup optimization. No parser is applied to feeds, embeds, trackbacks, AJAX or REST responses.

## Upload and verify

[upload-files.txt](upload-files.txt) contains **14 runtime files** for this round: two stylesheets, `slick.min.js`, three PHP includes, two booking template parts and six images. No additional font upload or deletion is required in Round 2. `tools/optimize-images.cjs` is also changed but is a development tool, not required on the live server.

Do not deploy `assets/img-original/`, `node_modules/`, `.booking-build-cache/`, tests or local configuration. Diffs/reports are for review and do not need to be deployed. Upload relative to the theme root, then purge existing page caches. CSS/JS URLs use file modification versions. Image URLs intentionally retain their names, so existing browser image caches can remain until expiry.

Tests cover the real ripple canvas, Slick initialization, booking flow/WhatsApp encoding, service preview and offer handoff, catalog/category filtering, RTL/mobile, Filterizr, FAQ Collapse, core jQuery/Migrate, no Popper, all 31 icon mappings, four WOFF2 faces and image attributes. The test helper `hide-offers.cjs` is imported by tests rather than run as a standalone test.

CF7 is not installed in the local WordPress environment. Manually check actual CF7 submissions/mail delivery on production, both languages and mobile navigation, image/photo quality at desktop sizes, FAQ/sticky-header animations, and a real WhatsApp handoff. No actual booking message is sent by these tests. Production Lighthouse has not been measured in this local run.
