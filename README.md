# New Super Prime — WordPress Theme

Converted from the Clinox HTML template by Themexriver. A cleaning-services business theme for WordPress 6.x.

---

## Requirements

- WordPress 6.0+
- PHP 7.4+
- **Contact Form 7** plugin (for booking and contact forms)

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
