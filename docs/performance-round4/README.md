# Round 4 mobile performance

Implemented locally. Production has not been updated for this round.

| Measurement | Before | After |
|---|---:|---:|
| English homepage HTML, uncompressed | 318,142 B | 231,602 B |
| Inline first-screen CSS | 87,085 B | 1,462 B |
| Inline font faces | present | 0 |
| Main theme CSS | 157,968 B source | 113,758 B production |
| Ten theme scripts, combined | 69,264 B source | 39,059 B production |

The main CSS source remains unchanged. Its production output is purged and minified. The eight requested scripts plus tracking and Collapse have editable sources and generated minified files.

## Task diffs and decisions

1. [Ripple diff](task-1.patch). No plugin download or WebGL capability probe below 992px, on coarse/touch pointers, with reduced motion, four or fewer logical cores, or Save Data. Capable desktop devices load the plugin after `load` and browser idle, with a timer fallback. IntersectionObserver and visibilitychange pause/hide and resume it. Resizing to mobile restores static slide images, including subsequent slide changes. Texture boundaries are cached until resize/image change; resizing is debounced. Sticky-header dimensions are no longer read on every scroll. No automatic random-drop interval existed. Only the homepage exposes the optional plugin URL; other hero instances remain static slides.
2. [Fonts and critical CSS diff](task-2.patch). The previous ~85KB inline block was mostly layout CSS, not a base64 DM Sans font. Active font-face rules now live only in `assets/css/fonts.css`; no font is embedded as a data URI. DM Sans normal 400/500/600/700, DM Sans italic 400, and Poppins 400/500/600/700 remain. Italic is actually used by testimonials. Existing Arabic font faces were converted to WOFF2 without changing their glyphs or weight mappings. Icon font faces were centralized too. Only accessibility essentials remain inline. The remaining first-screen CSS is a **cacheable render-blocking stylesheet**, 31–41KB raw / 6.9–8KB gzip depending on page/language. This intentionally trades one CSS request for much smaller HTML while preventing an unstyled first paint. The 16 delayed-CSS checks pass. See [page sizes](page-sizes.json).
3. [Tracking diff](task-3.patch). The theme provides `GTM-5Z27DP4H`, whose public container contains Ads destination `AW-18239638628`. Live Site Kit provides `GT-5R437B2G`, whose public Google-tag configuration contains GA4 destination `G-HTV63ZN03F`. No destination overlap was found in those public configurations. Both configurations are preserved. The early dataLayer/gtag queue remains available; executable Google scripts load on first scroll/pointerdown/keydown/touchstart or after four seconds. Site Kit's script tag is made inert until the same gate releases it, while its inline queue setup remains unchanged. Script loading is deduplicated by endpoint and destination ID. No new analytics configuration or CDN was introduced. [Tracking audit](tracking-audit.json).
4. [Collapse diff](task-4.patch). Only FAQ Collapse uses Bootstrap JS. Desktop dropdowns use the existing theme handler; booking/preview/offers use native dialogs. The small native Collapse handler preserves accordion exclusivity, expanded/collapsed classes, ARIA state, reduced-motion behavior and the 350ms height animation. Bootstrap JS and Popper are not loaded. Bootstrap CSS remains.
5. [CSS diff](task-5.patch). PurgeCSS scans PHP templates/template-parts and editable JS sources, then cssnano writes `assets/css/style.min.css`. WordPress/editor content tags and dynamic states are protected. The exact safelist and rejected selectors are in [build-report.json](build-report.json). Prefixes include `slick-`, `wow`, `animated`, `active`, `show`, `open`, `is-`, `nsp-`, `rtl`, `mfp-`, `modal`, `collaps`, `fade`, `tw-`, WordPress/CF7 classes, layout utilities and theme-added menu/filter/sticky states; data/ARIA/hidden selectors are preserved. This source had already been purged in the preceding round, so nearly all remaining savings come from minification.
6. [JS/build diff](task-6.patch). `npm run build` writes the requested `.min.js` assets and CSS output. Enqueues use those files and filemtime versions. The generated Ripples file also has an editable patched source. `package.json` and the lockfile pin local build/test dependencies. No build tool executes in visitors' browsers.
7. [jQuery audit](task-7.txt). Core jQuery and Migrate were already in frontend footer group 1. Migrate stays: Waypoints uses the removed `.load(fn)` shorthand. Removing it would break counters. Admin and login are untouched.
8. [Image diff](task-8.patch). The existing and original `ab1.jpg` are **501×591**, already below a 930px maximum. Upscaling cannot create genuine 2× detail, so the original is preserved at 42,610 B. A 465px derivative is 36,926 B. The image now has 465w/501w srcset, responsive sizes, and intrinsic dimensions. The optimizer caps this image at 930px without enlargement. A true 930px variant needs a higher-resolution original.
9. [Validation diff](task-9.patch). Lighthouse identified two mobile-only offer-popup issues missed by earlier desktop checks: counter contrast and small dot targets. Mobile dots retain their visible shape but have 24px controls; the counter has a darker solid text color. Desktop styling is unchanged. A flaky test assertion now waits for the native dialog's queued close event instead of asserting during the Escape event.

The enqueue changes appear in several diffs because those tasks share that file. Each patch compares the final relevant files with this round's starting snapshot.

## Validation

All **17** runnable tests in `tests/` passed, including the new ripple/tracking cases and read-only Site Kit filter check. The accessibility test passed **23** WCAG A/AA page/dialog/hover checks. The PHP syntax check passed **86** files. Mobile checks cover 320px/375px/430px and English/Arabic; delayed-CSS layout checks cover 375px/1440px in both languages. WhatsApp navigation is intercepted; no booking message or contact form is sent. A real CF7 delivery check remains a server-side manual check because CF7 is not installed locally.

Clean Chrome 155, new profile, extensions disabled, default Lighthouse mobile simulation, English local homepage:

| Performance | TBT | LCP | CLS | Accessibility |
|---:|---:|---:|---:|---:|
| 70 | 101 ms | 6.95 s | 0 | 100 |

See the [full Lighthouse report](lighthouse-mobile.html), [JSON](lighthouse-mobile.json), and [metrics](lighthouse-metrics.json). These are local simulated results, not live PageSpeed scores. LCP remains above the good threshold. The report still identifies first-screen render delay and render-blocking CSS; the existing load/fade preloader behavior is preserved. Local responses and live gzip/server latency/Site Kit can differ. No server configuration was changed.

## Build and upload

Install local tooling with `npm ci`, then run `npm run build`. Regenerate first-screen CSS with `npm run build:critical` against the local WordPress installation; this needs Playwright/Microsoft Edge. `node tools/lighthouse-mobile.cjs` runs clean Chrome and stores its report here. Build and commit generated files alongside source changes.

[Production upload list](upload-files.txt) contains every changed/new runtime file. Keep source files, package files, tools and tests in the repository; they do not need to execute on the server. Deploy generated minified CSS/JS, centralized fonts, all referenced WOFF2 files, the six critical files, and the new image derivative together with the PHP changes. Purge the page cache after deployment. Existing image originals, full font backups, node_modules, browser profiles and build cache remain excluded.

After upload, check a real CF7 submission, GA4 DebugView/Ads Tag Assistant after interaction and timeout, mobile menu and service filtering, popup package selection through WhatsApp review, desktop ripples, mobile static slides, and an Arabic page.
