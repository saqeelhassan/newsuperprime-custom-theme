# Round 3 performance handoff

No prices, service text, design choices, booking calculations, server settings, plugin installation or CDN was changed. All 13 runnable test scripts pass. See [test-results.txt](test-results.txt) and the additional [page checks](page-checks.txt).

## Task 1 — Font Awesome subsets

The scan includes PHP, JS HTML strings, and CSS pseudo-element codepoints. [Exact style/icon lists](icon-styles.json), [glyphs and sizes](font-sizes.json), [text diff](task-1.patch).

| Style | Named icons | Full WOFF2 | Subset WOFF2 |
|---|---:|---:|---:|
| fal / light | 9 | 187,176 bytes | 3,096 bytes |
| far / regular | 8 | 171,228 bytes | 2,784 bytes |
| fas/fa / solid | 14 | 138,752 bytes | 2,648 bytes |
| fab / brands | 6 | 78,120 bytes | 1,304 bytes |
| Total | 37 style/icon pairs | 575,276 bytes | **9,832 bytes** |

All four styles are required; none qualified for the optional 0–2-icon consolidation. No style was switched. FontTools `pyftsubset` (`python -m fontTools.subset`) produced the final WOFF2 files from the local full fonts, with the audited Unicode lists and `.notdef` outline retained. CSS pseudo-elements' extra matching Unicode codepoints are included in non-brand subsets. WOFF2 files have versioned CSS URLs. Original `*.full.woff2` files are kept locally and ignored by Git; **never upload them**. Existing font copyright/license notices remain.

## Task 2 — self-hosted text fonts

[Diff](task-2.patch), [download sources](webfont-files.json).

- Poppins: normal 400, 500, 600 and 700.
- DM Sans: normal 400, 500, 600 and 700; italic 400 for testimonials. Its normal weights share a variable Latin WOFF2 resource.
- Six downloaded Latin WOFF2 files total **83,520 bytes**. Weights 800/900 were excluded after the final CSS audit showed no surviving text use; remaining 900 declarations are Font Awesome, not text fonts.
- `assets/css/fonts.css` declares local faces with `font-display: swap` and the Latin Unicode range. Google Fonts CSS enqueue and Google Fonts preconnects are removed. Font licenses are saved alongside the files.
- English pages preload only DM Sans normal and Poppins 700. Arabic retains the existing local Noto Sans Arabic definitions and no inappropriate Latin preload is added to Arabic pages.

## Task 3 — hero/LCP

[Diff](task-3.patch); the explicit Ripples image setting is also visible in [the main-script diff](task-6.patch).

The first slide URL is now server-rendered in the hero section's `background-image`, preloaded in the head as an image with high fetch priority, and marked `loading="eager" fetchpriority="high"` on its image tag. Hidden slides retain their prior lazy-loading behavior. Ripples initializes with the same URL. Slide changes update the static section background when Ripples is unavailable or reduced motion is enabled; active WebGL continues using `ripples('set', 'imageUrl', ...)`.

The existing optimizer was re-run. The current first four hero photos are 340×250 assets, already below the 1920px maximum, so this round did not resize/upscale or change image files. The optimizer's existing 1920px default and compression remain in effect.

## Task 4 — jQuery audit

The frontend enqueue already places WordPress `jquery-core` and `jquery-migrate` in the footer. Admin and login use separate WordPress hooks and were not changed. The tested pages contain neither head jQuery script tags nor inline head code that requires jQuery. The new stylesheet-ready Promise uses plain JavaScript.

**Migrate is retained intentionally:** Waypoints uses the removed jQuery `.load(function)` event shorthand. Filterizr's bundled image loader uses jQuery `.bind()`/`.unbind()`. Ripples' `.bind()` occurrence is native `Function.bind`, not a jQuery deprecation. Removing Migrate would require a separate vendor compatibility update and is not justified by the current audit. No jQuery version rollback.

## Task 5 — CSS

[Diff](task-5.patch), [exact safelist and purge results](css-purge-report.json).

| Stylesheet | Before | After |
|---|---:|---:|
| Bootstrap | 154,875 bytes | 46,061 bytes |
| Main style.css | 325,659 bytes | 157,968 bytes |

Templates use Bootstrap containers, responsive row/column grid, gutters, flex/display/alignment/justification utilities, positioning, text/clearfix helpers, nav/navbar list styling, and FAQ accordion/Collapse styles. JavaScript Collapse is actually used, so Bootstrap JS remains. Bootstrap Modal, Tab, Dropdown, Tooltip and Popover widgets are not used by the rendered theme. Popper remains unqueued.

PurgeCSS scanned all theme PHP/JS and 35 rendered page snapshots before replacing files. The before/after sizes and safelist were shown before applying. It preserves all requested dynamic prefixes/states plus WordPress/CF7, grid/flex, sticky/search/mobile menus, Filterizr, quantity controls, ripple and attribute-driven states. Booking's separately compiled scoped Tailwind stylesheet is not purged. Local originals remain in `.booking-build-cache/round3-before/`; the full stylesheet sources are also available in the previous Git version. Do not rerun a purge from reduced CSS when adding new template features: rebuild from full sources and refresh snapshots/tests.

### Critical styles

Six critical files separate Home, Catalog and Inner pages, each in English and Arabic. URI placeholders are replaced with the deployed theme URI by PHP, so there are no hard-coded localhost asset URLs. Their raw sizes are about **79–91 KB**, approximately **13–14 KB individually gzipped**; see [sizes](critical-css-sizes.json). They include first-screen rules, header/mobile/sticky/search states, hidden-state rules and popup controls that may appear on the first screen. This intentionally favors reliable interactive styling over a smaller header-only extraction.

Theme stylesheets use `media="print"` with an onload switch to `all`, plus original blocking links in `<noscript>`. Plugin-owned styles are not rewritten. Main layout-measuring plugins and the catalog controller wait for the deferred theme styles to apply; this avoids initializing Slick against unstyled dimensions. Booking calculations and handoff logic were not changed. The JavaScript-disabled CSS fallback was separately checked.

Delayed-stylesheet checks found and fixed two issues before completion: closed search/scroll controls briefly occupying layout, and hidden mobile catalog slides temporarily expanding. Their positioning/hidden rules are now critical. Sixteen checks delay external CSS by 1.2 seconds and compare first-screen dimensions and paint properties before/after load. The sampled header/hero/booking dimensions stay within one pixel; sampled fonts, colors and border styles match exactly. This is a local first-screen regression check, not a production Lighthouse/CLS score or a guarantee about arbitrary future content.

`tools/purge-theme-css.cjs` generates candidates; `--apply` explicitly replaces files. `tools/build-critical-css.cjs` rebuilds critical styles from actual pages, languages and responsive widths, preserving stylesheet/rule order. Rebuild critical CSS after changing header/hero styles or adding first-screen components, then rerun delayed-CSS checks.

WordPress 6.0/6.1 lack the HTML Tag Processor, so they retain ordinary blocking stylesheet loading; the critical/non-blocking path runs on WP 6.2+. This preserves the theme's older WordPress compatibility.

## Task 6 — WOW on mobile

[Diff](task-6.patch). WOW uses `mobile:false`. Below 768px the initializer explicitly shows `.wow` elements and skips WOW setup. A media rule also forces visibility and disables their CSS animations, including when resizing from desktop. Desktop behavior remains; ripple reduced-motion behavior remains separate.

## Task 7 — tests and deployment

All 13 runnable CJS/PHP tests pass, including package admin, migration, booking/WhatsApp, preview, offers, catalog/category/directory, real WebGL ripple, prior performance checks, and Round 3 checks. `hide-offers.cjs` is an imported helper rather than a standalone suite.

The extra matrix covers Home, Services, a published single service and Contact in English and Arabic at **375px and 1440px**, plus special offers → preview → wizard at both widths/languages. A real saved package reaches review and produces the WhatsApp request URL; navigation is intercepted and no message is sent. Contact fallback form fields/validation are exercised. CF7 is not installed locally, so actual CF7 AJAX validation, mail delivery and any production anti-spam integration remain for a live manual check. No production PageSpeed score is claimed.

Upload all **29 runtime files** in [upload-files.txt](upload-files.txt), preserving paths. This includes the four subset icon fonts, six text fonts and their licenses, six critical CSS files, the reduced/core font stylesheets, PHP includes, two scripts, and the hero template. No image files changed in this round. Development tools, tests, reports, `.booking-build-cache/`, `node_modules/`, `assets/img-original/` and `*.full.woff2` must not be deployed. Deploy as a consistent theme release, with new assets present before activating the new PHP includes. Purge existing page caches afterwards; asset CSS/JS versions use file modification times.

Manually verify production CF7 delivery, a real WhatsApp handoff, Arabic/mobile navigation, visual image/font quality, hero water/fallback behavior and any custom editor content not represented locally. Then run cold-cache production Lighthouse at mobile and desktop widths.
