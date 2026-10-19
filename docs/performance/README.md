# Frontend performance changes

No server configuration, CDN, plugin, prices, text, visual design or booking calculations were changed. These are local checks; a production Lighthouse score has not been measured.

## Per-task diffs

- [Task 1: performance hooks](task-1.patch)
- [Task 2: image tool and exclusions](task-2.patch), with [every image's before/after bytes](image-sizes.csv)
- [Task 3: conditional assets, core jQuery, footer/defer and compatibility fixes](task-3.patch)
- [Task 4: font sources and font files](task-4.patch)
- Task 5 uses Task 1's emoji removal; the live browser check confirms no emoji script, loader or stylesheet.
- Task 6 is the CSS audit below; `assets/css/style.css` was not modified.
- [Test updates](test-updates.patch) adjust obsolete expectations from earlier directory changes, without changing service content to satisfy tests.

## Image and font sizes

| Asset | Before | After | Reduction |
|---|---:|---:|---:|
| 326 JPG/PNG images (231 made smaller) | 6,170,696 bytes | 4,092,117 bytes | 33.7% |
| Main logo | 164,878 bytes | 28,519 bytes | 82.7% |
| English footer logo | about 149 KiB | about 28 KiB | 81% |
| Four required Font Awesome styles | 1,471,792 bytes TTF | 575,276 bytes WOFF2 | 60.9% |

Images retain their filenames and formats. Sharp used the supplied script's quality and size limits. Originals are in ignored `assets/img-original/`; subsequent runs start with those originals to avoid repeated lossy compression. Never upload that backup. SVG and GIF files are untouched. Exact image measurements are in `image-sizes.csv`.

Font Awesome light, regular, solid and brands are all used. They were converted using FontTools/Brotli with character maps verified against their TTF originals. The unused Duotone face and files were removed. The four retained font faces load WOFF2 only, with `font-display: swap`.

## Asset-loading decisions

| Asset | Where it loads / reason |
|---|---|
| WordPress jQuery + Migrate | All theme pages; core handles preserved, one jQuery copy, footer; left non-deferred for inline-code compatibility |
| Theme main JS and dropdowns | All pages: header, mobile menu, search, backgrounds, scroll controls |
| WOW and animate.css | All pages: shared breadcrumb and other templates use `.wow` |
| Bootstrap CSS | All pages: grid and shared layout classes |
| Bootstrap/Popper JS | Homepage and FAQ template; editor content using `data-bs-` |
| Slick JS + CSS | Homepage and About team carousel; editor content using slider markup; disabled sponsor section does not trigger loading |
| CounterUp + Waypoints | Homepage and About counters; counter markup in editor content |
| Appear | About skill progress and single-team skills; editor progress markup |
| Ripples | Homepage hero; its initializer remains in main JS and is guarded elsewhere |
| Service catalog CSS/JS | Services page, service archive, Service Catalog template, plus homepage because it shares hero/featured components |
| Booking + service preview | Site-wide: the shared headers have booking buttons, and special offers hand off to booking |
| Special offers | Site-wide when saved offers exist; new-visitor-only behavior preserved |
| ImagesLoaded + Filterizr | Project archive and project-category taxonomy only |
| Magnific Popup JS/CSS | Editor content using `.zoom-gallery` or video-popup markup; no current PHP template renders a gallery/video trigger |
| video.min.css | Only video-popup content; it contains demo/documentation styles and is unnecessary on current templates |
| Inputarrow | Editor content using `.quantity-input-2`; no current PHP template renders this control |
| Google Maps API + gmap3 | Not enqueued: Contact and other contact sections use a lazy-loaded map iframe, not `#googleMaps` |
| CF7 JS/CSS | Contact, Booking, About, legacy service templates, project archive/category/detail (these render forms), plus CF7 shortcodes/blocks in editor content |

`nsp_page_asset_features` is a filter for future custom templates that add these components. Existing theme CSS/JS use file modification times as versions. On WP 6.3+ theme scripts use the defer strategy; older WordPress falls back to ordinary footer loading. Core jQuery/Migrate and plugin-owned scripts retain their own execution strategy; no global async/defer rewrite is applied. Localized data remains before the deferred theme initializer. GTM's supplied asynchronous snippet remains unchanged.

Two compatibility fixes were necessary: the main theme script now uses a local jQuery `$` scope, and Ripples' browser loader uses `window.jQuery` instead of assuming a global `$`. No rollback to jQuery 2.1.4. Slick, Magnific, Waypoints/CounterUp, WOW, Inputarrow and Filterizr pass the relevant browser checks with jQuery 3.7.1 + Migrate.

Filterizr also had an existing slug/numeric mismatch documented in the old README. Project filter attributes now use numeric term IDs, with a valid numeric group for uncategorized projects. Initialization and preloader cleanup also handle scripts running after the load event.

## CSS audit — no CSS removal performed

`assets/css/style.css` is 325,659 bytes (318 KiB), about 14,250 lines. It combines several Clinox layout generations, shared inner-page styles, responsive rules and appended overrides. It contains roughly 321 spacing utility declarations (about 10 KiB), about 9 KiB of comments, 154 media queries, repeated header/banner/footer rules and an older Segoe Print font face. The first two layout generations precede the newer third layout and account for a substantial portion of the file; inner pages still depend on some of these rules.

It is not safe to purge whole sections based only on homepage coverage. Booking states, open mobile menus, sticky headers, Arabic, filters, hover/focus, before/after sliders, admin toolbar offsets and other templates use selectors that are absent from a single Lighthouse capture. Potential next work is lossless minification or carefully extracting per-template styles with visual regression coverage. Safelist JS-generated classes such as `slick-*`, `mfp-*`, `animated`, `sticky-on`, menu/search states, Filterizr classes, and all booking/popup states. No automatic unused-CSS deletion was applied.

## Validation and deployment

See [test results](test-results.txt). The seven requested suites cover booking/WhatsApp encoding, catalog, service preview, special offers, real ripple canvas, categories and service directory. `tests/performance.cjs` additionally checks script placement/defer/versioning, conditional assets, one core jQuery plus Migrate, emoji absence, initialized Slick carousels, actual project filtering, FAQ controls, Magnific/Inputarrow client fixtures, WOFF2 loading and Arabic mobile overflow.

The local installation has no active CF7 plugin, so production form submission, validation, mail delivery and any production anti-spam integration still need a manual check. WhatsApp requests in tests are intercepted; no real request was sent.

Upload the files in [upload-files.txt](upload-files.txt), preserving relative paths. Remove the obsolete Duotone files listed in [delete-from-server.txt](delete-from-server.txt). Developer-only files (docs, tests, image optimizer) do not need to be uploaded for runtime. Do not upload `assets/img-original/`, `node_modules/`, `.booking-build-cache/`, or local configuration files. Existing required WOFF2 files are included in the upload list because they were regenerated.

Purge existing page/CDN caches after upload and hard-refresh for verification. CSS/JS version changes invalidate their browser URLs automatically when modification times change. Image filenames intentionally stay the same, so previously cached images can remain in returning visitors' browsers until expiry. No Nginx, aaPanel, gzip or cache-header settings were changed.

Manual production checks: submit each CF7 form; review English/Arabic at mobile/tablet/desktop widths; open menus, header booking and offers; complete the booking review and confirm WhatsApp opens with the intended request; check logo/photo quality after compression; test map iframe, carousels, counters, FAQ and project filters. Then run mobile and desktop Lighthouse on the production URL with a cold cache.
