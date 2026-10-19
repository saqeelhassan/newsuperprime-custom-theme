# Accessibility fixes

Colors are solid, shared across English and RTL. Background changes are shown after the slash; other backgrounds remain unchanged. Palette changes also update the six critical stylesheets to preserve first paint.

| Selector | Old text / background | New text / background | Old ratio | New ratio |
|---|---|---|---:|---:|
| .nsp-eyebrow, service-card p, process p | `#708076` / `#ffffff` | `#607067` / `#ffffff` | 4.17:1 | 5.24:1 |
| eyebrow/process introduction on pale section | `#708076` / `#f6f9f7` | `#607067` / `#f6f9f7` | 3.93:1 | 4.94:1 |
| .nsp-booking-trigger (white text) | `#ffffff` / `#188c3a` | `#ffffff` / `#147d32` | 4.33:1 | 5.24:1 |
| .nsp-booking-process-eyebrow | `#188c3a` / `#f6f9f7` | `#147d32` / `#f6f9f7` | 4.08:1 | 4.94:1 |
| catalog benefit eyebrow | `#188c3a` / `#edf5ed` | `#147d32` / `#edf5ed` | 3.89:1 | 4.71:1 |
| catalog benefit paragraph | `#63796a` / `#edf5ed` | `#586e5f` / `#edf5ed` | 4.22:1 | 4.96:1 |
| header navigation and footer button (white text) | `#ffffff` / `#0277fb` | `#ffffff` / `#006de8` | 4.17:1 | 4.82:1 |
| language/current and top booking button (white text) | `#ffffff` / `#02aaf9` | `#ffffff` / `#007bb5` | 2.59:1 | 4.67:1 |
| homepage subtitle on pale section | `#007bff` / `#f6f9f7` | `#006de0` / `#f6f9f7` | 3.75:1 | 4.65:1 |
| .inner-text .inner-decs (white text) | `#ffffff` / `#3592fc` | `#ffffff` / `#176bca` | 3.15:1 | 5.26:1 |
| .nsp-small-accent | `#f38b1c` / `#f8faf8` | `#a34c05` / `#f8faf8` | 2.35:1 | 5.57:1 |
| hero booking hover text | `#ffffff` / `#f38b1c` | `#173b2a` / `#f38b1c` | 2.46:1 | 5.03:1 |
| preview overview heading | `#7e9286` / `#ffffff` | `#607067` / `#ffffff` | 3.31:1 | 5.24:1 |
| preview description selected | `#73887b` / `#f3faf3` | `#607067` / `#f3faf3` | 3.57:1 | 4.93:1 |
| preview selected package label | `#8a9d90` / `#ffffff` | `#607067` / `#ffffff` | 2.87:1 | 5.24:1 |
| booking package/step text | `#188c3a` / `#edf9f0` | `#147d32` / `#edf9f0` | 4.00:1 | 4.84:1 |

Baseline axe findings with exact selectors, text/background colors and measured ratios: [baseline.json](baseline.json). Dialog findings: [dialog-baseline.json](dialog-baseline.json). Source rules are in `assets/css/service-catalog.css`, `home.css`, `style.css`, `booking.css`, `service-preview.css` and `special-offers.css`. Shared palette tokens were changed in place. The small `accessibility.css` supplies focus outlines, dark orange text, and popup/sticky state overrides; it is also appended to critical CSS at render time.

Controls now have names; decorative Font Awesome icons are hidden from assistive technology. Mobile menu divs are native buttons with original typography preserved. Project arrows describe their destination, pagination arrows have screen-reader text, linked project images use localized project titles, and booking progress dots have an appropriate image role. New labels use the newsuperprime gettext domain and Arabic labels follow the theme language selection.

[Upload manifest](upload-files.txt) lists production files for this task. [Patch](changes.diff) compares files to this task’s baseline where a snapshot exists. Keep local font originals, image backups, node_modules and build cache off the server.

Validation: all 13 existing runnable tests passed; the new axe test passed 23 page/dialog/hover checks across English/Arabic and 375px/1440px. All 85 PHP files passed syntax checks. Axe covers WCAG 2 A/AA and WCAG 2.1 AA rules, not every manual accessibility requirement.

Before pushing, include the untracked production CSS/font/JS/PHP files from the earlier performance rounds as well as this upload manifest. Deploy into the existing active theme directory. Purge page cache after upload. Check a real Contact Form 7 submission on the server (CF7 is unavailable locally), keyboard navigation, and a mobile Arabic booking. WhatsApp navigation was intercepted during tests; no customer message was sent.
