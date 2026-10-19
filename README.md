# New Super Prime — WordPress Theme

Converted from the Clinox HTML template by Themexriver. A cleaning-services business theme for WordPress 6.x.

---

## Requirements

- WordPress 6.0+
- PHP 7.4+
- **Contact Form 7** plugin (for booking and contact forms)

## Service catalog page

Browse Services uses **Service Categories**, rather than individual-service tabs:
**Home Cleaning** (9 related services), **Pest Control** (8 treatments), and
**Office & Commercial Cleaning** (1 service). **All Services** shows all 18.
Selecting a category updates service cards, specialized services, the featured
banner, and package offers. Package cards show up to eight matching offers.

Manage groups in **Services → Service Categories**, then assign categories when
editing a service. New categories appear automatically once assigned to a
published service; parent categories also include their child-category services.
Run `php tools/setup-service-categories.php` to restore the initial assignments
explicitly, or `node tests/service-categories.cjs` for live filtering checks.

The active directory contains the requested 18 cleaning and pest-control services,
in the order defined in `inc/service-directory.php`. Each has a detail page and
booking packages. The Services navigation links directly to the catalog; individual services
appear on that page instead of in a navigation dropdown. Existing carpet and office entries were renamed while
preserving their URLs and packages. AC cleaning, car washing, and home shifting
entries are retained as drafts. New service packages use clearly marked demo
prices; edit them under **Services → Edit → Booking Packages**.

For another local installation, run `php tools/update-service-directory.php` to
apply this service directory setup. This explicit, repeatable command preserves
existing packages; it does not run automatically during frontend requests.
`node tests/service-directory.cjs` checks the live directory and menu.

The Services page (`/services/`) and the service archive use the catalog layout:
search and service filters, a featured banner, service cards, package offers,
the first-booking benefit, specialized services, project cards, booking steps,
and city selection. It keeps the theme palette and supports Arabic/RTL.
You can also assign **Service Catalog** as the template for another page.

Content comes from published **Services** and their **Booking Packages**.
Add a featured image, short description, and packages in the service editor.
Without package prices, cards show **Price on request** and quote links.
Clicking a service image, title, card, or booking button opens a service-details
popup with its image, overview, selectable packages, perks, and a fixed price /
**Book Service** footer. The footer continues into the existing five-step wizard
with the selected package. Services without packages offer a contact quote link.
Package buttons preselect that package in the popup, and selecting a
service area prefills the booking city. Project cards use **Projects** content;
add featured images there to replace the illustrative service-image fallbacks.

Files: `template-parts/services/catalog.php`, `inc/service-catalog.php`,
`assets/css/service-catalog.css`, and `assets/js/service-catalog.js`.
Run `node tests/service-catalog.cjs` with Playwright and Microsoft Edge installed
against the local WordPress site to check search, filters, booking, and RTL.
The preview uses `template-parts/booking/preview.php`,
`assets/css/service-preview.css`, and `assets/js/service-preview.js`.
Run `node tests/service-preview.cjs` for package selection, wizard handoff,
keyboard focus, mobile layout, empty packages, and homepage service clicks.

## WhatsApp booking setup

### Automatic special-offer popup

The four screenshot offers are available across the website in an automatic
popup slider: Pest Control / Complete Flat **199 SAR**, Sofa Deep Cleaning /
5 Seater Sofa **149 SAR**, Sofa Deep Cleaning / 7 Seater Sofa **199 SAR**, and
Bed Bug Treatment / Complete Flat **199 SAR**. Perks and payment/warranty notes
follow the supplied offer copy.

The popup appears only on a new visitor's first visit, shortly after loading.
A site-specific localStorage flag remembers the first display across pages and
future visits, with a one-year cookie fallback if storage is blocked. Clearing
browser site data or using another browser counts as a new visitor. It skips
opening if a booking dialog is already active. Arrows, dots, keyboard arrows,
and swipe select an offer. Booking carries the exact package into the service
preview and wizard, including on regular pages such as About and Contact.
The existing 10% first-booking benefit still applies in the wizard review.

Edit the matching packages under **Services → Edit → Booking Packages**; their
saved price is used by both the popup and booking. Offer associations, Arabic
labels, and terms are in `inc/special-offers.php`. Run
`php tools/setup-special-offers.php` to install/reset the four screenshot offer
packages explicitly. Other packages are preserved. No prices are written on page
visits. Run `node tests/special-offers.cjs` for the live popup checks; other page
tests suppress this marketing modal through `tests/hide-offers.cjs`.

Service detail pages now offer a five-step **Book Service** modal. These requests
are sent to WhatsApp **966559357772**; they are not saved in WordPress or charged.
Contact Form 7 is not required for this wizard. The wizard currently uses English
labels, including when the surrounding site uses Arabic.

Go to **Services → Add New** (or edit a service). Add a title, description,
featured image, and category. In **Booking Packages**, click **Add package**,
fill in the fields below, and **Publish / Update** the service. Use **Remove
package** to remove a row. The frontend **Book Service** modal reads these saved
packages automatically. ACF Pro is not required.

Published services also appear in the homepage service carousel, using their
featured image and short description. Each **Book Now** button opens that
service's booking modal directly. The carousel shows three cards on desktop,
two on tablets, and one on phones, with arrows and swipe navigation.

The homepage Featured Services section shares
`template-parts/services/featured.php` with the Services catalog, so card styling,
package prices, and the service preview stay consistent on both pages.

The homepage hero also shares `template-parts/services/hero.php` with the catalog.
Its service dots change the image of the existing water ripple canvas using the
plugin's `imageUrl` setting. Reduced-motion preferences or unavailable WebGL use
static slide images. Run `node tests/home-hero.cjs` to check the real canvas,
slide switching, booking popup, and reduced-motion fallback in Microsoft Edge.

| Field | Input | Value |
|---|---|---|
| `package_name` | Text | Required package label |
| `package_price` | Number | Required nonnegative SAR price, up to two decimals |
| `package_description` | Textarea | Plain text description |
| `package_perk` | Text | Plain text perk |

Packages are stored in `_nsp_booking_packages` post meta. If native packages have
never been saved for a service, the editor and frontend fall back to its existing
ACF `service_packages` repeater, when available. After saving the native editor,
it becomes the source for this service; removing all rows keeps the package list
empty instead of restoring old ACF packages. Invalid package submissions preserve
the previously saved list and display an admin notice.
Missing packages displays an unavailable message without inventing prices.
The dedicated service page templates resolve packages from their matching service
CPT entry through the existing service URL mapping. A new `single-service.php`
also supports direct CPT detail URLs.

Implementation:

- `inc/booking.php`: escaped trigger data, package normalization, conditional assets.
- `inc/booking-admin.php`: native package editor, validation, and save handler.
- `assets/js/booking-admin.js`: add/remove rows in the service editor.
- `template-parts/booking/modal.php`: native dialog with five steps and Tailwind utilities.
- `assets/js/booking.js`: state, validation, GPS, review, and encoded WhatsApp request.
- `assets/css/booking.css`: compiled, scoped Tailwind utilities without Preflight.

Use `<?php nsp_booking_button( get_the_ID() ); ?>` inside a service loop to render
another trigger. Native dialog provides focus containment and Escape dismissal;
closing clears customer input. GPS requires HTTPS or localhost and permission.
Choose a city, then either capture GPS or enter both street and neighborhood.
Dates use Saudi Arabia time; availability is confirmed by the team.
The fixed 10% First Booking Benefit applies to every request, as specified; no
customer history is collected to determine first-booking eligibility.

To rebuild CSS after changing utility classes (Node/npm required):

```sh
npm exec --yes --package=tailwindcss@3.4.17 -- tailwindcss -c tailwind.booking.config.cjs -i assets/css/booking.source.css -o assets/css/booking.css --minify
```

Deploy the compiled CSS with the theme; no Tailwind CDN or build process runs in
the visitor's browser. Package prices are client-visible request estimates; the
team confirms the request and price in WhatsApp.

Browser checks are in `tests/booking.cjs`. With PHP on PATH, Playwright installed
(`npm install --no-save playwright@1.64.1`), and Microsoft Edge installed, run
`node tests/booking.cjs`. Tests render the PHP modal with WordPress helper stubs;
they simulate GPS and intercept WhatsApp navigation without sending a request.
Run `php tests/booking-admin.php` for WordPress package-save checks and
`node tests/booking-admin.cjs` for admin row controls. These checks create a
temporary draft service and remove it afterwards; use a local development site.

---

## Installation

1. Zip the `newsuperprime-theme/` folder:
   ```
   zip -r newsuperprime-theme.zip newsuperprime-theme/
   ```
2. In WP Admin → Appearance → Themes → Add New → Upload Theme.
3. Upload the zip and click **Activate**.
4. On activation the theme will:
   - Register all Custom Post Types (Service, Project, Team, Testimonial, Pricing, FAQ).
   - Create the taxonomy `project_category` with terms: Residential, Commercial, Specialty Services.
   - Create stub pages: About, Services, Projects, Team, Testimonials, Pricing, FAQ, Blog, Booking, Contact.
   - Flush rewrite rules.
5. Install and activate **Contact Form 7** to enable the booking/contact forms.

---

## Required Plugins

| Plugin | Purpose |
|---|---|
| Contact Form 7 | Booking form, contact form, estimate form |

After installing CF7:
1. Create a form with fields: Name, Email, Phone, Service (select), Message.
2. Note the form ID (from the shortcode `[contact-form-7 id="X"]`).
3. Go to WP Admin → Settings (or run this in MySQL/WP CLI):
   - `update_option('nsp_cf7_contact_id', X);`
   - `update_option('nsp_cf7_booking_id', X);`
   - `update_option('nsp_cf7_estimate_id', X);`

---

## Adding Demo Content

### Services (CPT: service)
Go to **Services → Add New**. Fill in:
- Title: e.g. "Pest Control Services"
- Content: Description
- Meta box fields: Short Description, Features (one per line)
- Featured Image (390×320)

### Projects (CPT: project)
Go to **Projects → Add New**. Fill in:
- Title, Content (description)
- Assign a **Project Category** term
- Meta box: Client, Location, Completion Date, Project Type, Cleaner, Gallery (comma-separated attachment IDs)
- Featured Image (370×420)

### Team (CPT: team)
Go to **Team → Add New**. Fill in:
- Title: Member name
- Content: Biography
- Meta box: Position, Experience, Projects Completed, Email, Phone, social URLs
- Skills: one per line in format `Label|Percent` (e.g. `Commercial|92`)
- Featured Image (370×440)

### Testimonials (CPT: testimonial)
Go to **Testimonials → Add New**. Fill in:
- Title: Client name
- Content: Review text
- Meta box: Role (e.g. "CEO, Gatko"), Photo attachment ID, Rating (1-5)

### Blog Posts
Go to **Posts â†’ Add New**. Fill in the normal WordPress title/content for English, then use the **Arabic Blog Content** meta box for:
- Arabic Title
- Arabic Excerpt / Short Description
- Arabic Content

### Pricing (CPT: pricing)
Use this section for service-combination pricing, not memberships.
Go to **Pricing Plans → Add New**. Fill in:
- Title: Service option name (e.g. "One Service", "Add More Services", "All Services Bundle")
- Meta box: Price (e.g. `SAR 499`), included services/features (one per line), CTA URL, Featured checkbox

### FAQ (CPT: faq)
Go to **FAQs → Add New**. Fill in:
- Title: The question
- Content: The answer

---

## Menus

Go to **Appearance → Menus** and create two menus:
- **Primary Menu** — assign to the "Primary Menu" location
- **Footer Menu** — assign to the "Footer Menu" location

---

## Page Templates

| Page | Template to Assign |
|---|---|
| About | About Page |
| Testimonials | Testimonials Page |
| Pricing | Pricing Page |
| FAQ | FAQ Page |
| Booking | Booking Page |
| Contact | Contact Page |

Assign via **Page Attributes → Template** when editing each page.

---

## Customizer Fields

Go to **Appearance → Customize → New Super Prime Options**:

### Topbar / Contact Info
| Field | Default |
|---|---|
| Phone 1 | +966 593657772 |
| Phone 2 | +966 559357772 |
| Email | info@newsuperprime.sa |
| Address | 22 Albert St, Melbourne, Australia |
| Opening Hours | 10.00pm - 08.00am, Friday Off |

### Social Links
| Field | Default |
|---|---|
| Facebook URL | # |
| Twitter URL | # |
| Behance URL | # |
| YouTube URL | # |

### Footer
| Field | Default |
|---|---|
| Copyright Text | Copyright © 2024 New Super Prime. All rights reserved. |
| Footer Logo URL | (uses default white logo from assets) |
| Footer About Text | Lorem ipsum… |

### CTA / Promo Section
| Field | Default |
|---|---|
| Promo Headline | Get Our Services, It's Affordable… |
| Promo Button URL | /contact/ |

### 404 Page
| Field | Default |
|---|---|
| 404 Title | Page Not Found |
| 404 Message | The page you are looking for… |
| 404 Button URL | / |

---

## Custom Image Sizes

| Handle | Width | Height | Crop |
|---|---|---|---|
| nsp-blog-thumb | 80 | 80 | Yes |
| nsp-blog-feed | 730 | 430 | Yes |
| nsp-project | 370 | 420 | Yes |
| nsp-team | 370 | 440 | Yes |
| nsp-service | 390 | 320 | Yes |
| nsp-banner | 1920 | 520 | Yes |

---

## Sidebars / Widget Areas

| ID | Location |
|---|---|
| blog-sidebar | Right column on blog and single post pages |
| footer-1 | Footer column 1 |
| footer-2 | Footer column 2 |
| footer-3 | Footer column 3 |
| footer-4 | Footer column 4 |

### Custom Widgets
- **NSP: Recent Posts** — displays posts with thumbnail (80×80), title, date
- **NSP: Newsletter** — email subscription form (stores to DB option `nsp_newsletter_subscribers`; TODO: wire up Mailchimp)

---

## Known TODOs / Static Blocks

| File | Location | Issue |
|---|---|---|
| `front-page.php` | Estimate form | Needs CF7 shortcode wired via `nsp_cf7_estimate_id` option |
| `page-templates/tpl-booking.php` | Booking form | Needs CF7 shortcode wired via `nsp_cf7_booking_id` option |
| `template-parts/sections/contact.php` | Contact form | Needs CF7 shortcode wired via `nsp_cf7_contact_id` option |
| `inc/widgets.php` | NSP_Newsletter_Widget | Email stored in DB only; Mailchimp integration is TODO |
| `single-team.php` | Skills section | Progress bar animation driven by `data-percent` attribute in `assets/js/script.js` — works as-is |
| `archive-project.php` | Filter buttons | Uses filterizr with `data-category` as term slugs; the source JS used integers 1/2/3. If the bundled `script.js` still expects integers, update or override the filterizr init call in `script.js` to use slugs |
| `page-templates/tpl-about.php` | Team slider | Team slider requires at least 1 team CPT post; shows static fallback otherwise |
| `screenshot.png` | Theme screenshot | Generated as 1200×900 placeholder. Replace with a real screenshot of the live site |
| `assets/js/gmap3.min.js` + API key | Google Maps | The API key in `inc/enqueue.php` is from the original template. Replace with your own Google Maps API key |

---

## File Structure

```
newsuperprime-theme/
├── style.css                          Theme header
├── functions.php                      Thin loader for inc/ files
├── header.php                         Doctype, <head>, wp_head, body open, header chrome
├── footer.php                         Footer markup, wp_footer, </body></html>
├── sidebar.php                        Blog sidebar (widgets or fallback)
├── searchform.php                     Custom search form markup
├── front-page.php                     Home page (set as front page)
├── index.php                          Blog feed (fallback + blog listing)
├── single.php                         Single blog post
├── page.php                           Generic page
├── archive.php                        Category / tag / date archives
├── search.php                         Search results
├── 404.php                            404 error page
├── comments.php                       Comments list + form
├── single-service.php                 Single service CPT
├── archive-service.php                Services listing
├── single-project.php                 Single project CPT
├── archive-project.php                Projects listing with filterizr
├── taxonomy-project_category.php      Project category taxonomy (delegates to archive-project)
├── single-team.php                    Single team member CPT
├── archive-team.php                   Team grid
├── page-templates/
│   ├── tpl-about.php                  About page template
│   ├── tpl-pricing.php                Pricing page template
│   ├── tpl-faq.php                    FAQ page template
│   ├── tpl-testimonial.php            Testimonials page template
│   ├── tpl-booking.php                Booking page template
│   └── tpl-contact.php               Contact page template
├── template-parts/
│   ├── header/
│   │   ├── loader.php                 Preloader + scroll-up button
│   │   ├── navbar-inner.php           Inner-page header (with topbar)
│   │   ├── navbar-home.php            Home page header (transparent/sticky)
│   │   └── breadcrumb.php             Calls nsp_breadcrumb()
│   ├── content/
│   │   └── content-pricing.php       Pricing cards section (reused on home + pricing page)
│   └── sections/
│       ├── promo.php                  Style-1 CTA/promo band
│       ├── promo-2.php                Style-2 CTA/promo band
│       ├── sponsor.php                Sponsor logo slider
│       ├── faq.php                    Home FAQ accordion
│       └── contact.php               Contact form + info + map
├── inc/
│   ├── theme-setup.php                Theme supports, nav menus, image sizes, activation hook
│   ├── enqueue.php                    All CSS/JS enqueues (same order as source)
│   ├── post-types.php                 CPT: service, project, team, testimonial, pricing, faq
│   ├── taxonomies.php                 Taxonomies: project_category, service_category
│   ├── meta-boxes.php                 Native meta boxes + save handlers (no ACF)
│   ├── customizer.php                 Theme Customizer settings
│   ├── widgets.php                    Sidebars + custom widgets (Recent Posts, Newsletter)
│   ├── nav-walker.php                 NSP_Nav_Walker — mirrors source navbar class names
│   ├── template-tags.php              nsp_site_logo(), nsp_star_rating(), nsp_team_skills(), etc.
│   ├── breadcrumb.php                 nsp_breadcrumb() + nsp_breadcrumb_trail()
│   └── helpers.php                    nsp_asset(), nsp_e(), nsp_get_services(), nsp_pagination()
├── assets/                            Copied verbatim from source (css/, js/, img/, fonts/)
├── languages/
│   └── newsuperprime.pot              Translation template placeholder
└── screenshot.png                     1200×900 placeholder (replace with real screenshot)
```


### Automatic service categories after deployment

Push/deploy the theme normally. On the first WordPress request, `inc/service-category-migration.php` creates Cleaning, Pest Control, AC Services, Commercial, Relocation and Maintenance, then assigns matching existing service posts (including older service names). All remains the catalog-wide filter, not a taxonomy term.

The migration preserves content, prices and manually assigned categories. A version marker prevents repeated database work; changes to the service directory trigger another pass. Failures are logged and retried. This migration does not create missing service posts or import the local database. Purge the server/page cache after deployment to show the new filters.


### Frontend performance deployment

See [the performance report](docs/performance/README.md) for asset-loading decisions, per-task diffs, image sizes, CSS audit, passing tests and exact upload/exclusion lists. It describes the current conditional asset loading and supersedes the older all-libraries-on-every-page implementation notes.


### Round 2 performance review

See [the Round 2 report](docs/performance-round2/README.md) for exact icon usage, per-task diffs, Bootstrap/Popper decisions, reduced animation coverage, image handling, tests and the 14-file upload list. The proposed main stylesheet cleanup is not applied and requires confirmation.


### Round 3 performance deployment

See [the Round 3 report](docs/performance-round3/README.md) for icon font subsets, self-hosted text fonts, hero preload, jQuery audit, PurgeCSS safelist, critical CSS, mobile WOW behavior, test evidence and the complete 29-file runtime upload list. Original `*.full.woff2` fonts are local backups and must not be deployed.

### Mobile navigation checks

Mobile menus support Escape dismissal, keyboard focus containment and focus return,
with a 44px close-control hit area and independent menu scrolling. Run
`node tests/mobile.cjs` for English/Arabic checks at 320px, 375px and 430px on
Home, Services and Contact. `node tests/accessibility.cjs` runs axe WCAG A/AA
checks; install axe-core locally alongside the existing Playwright setup.


### Round 4 mobile performance

See [the Round 4 report](docs/performance-round4/README.md) for ripple device gates,
centralized WOFF2 fonts, delayed tracking, native FAQ Collapse, minified production
assets, responsive About images, per-task diffs, Lighthouse results and upload list.
Run `npm ci` then `npm run build` after editing theme JS or the main CSS source.
