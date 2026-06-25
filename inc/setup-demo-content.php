<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Runs once on theme activation via after_switch_theme.
 * Creates pages, menus, sample content, and general settings.
 * Re-run by deleting the option: delete_option('nsp_demo_content_created')
 */
function nsp_setup_demo_content() {
    if ( get_option( 'nsp_demo_content_created' ) ) {
        return;
    }

    // ------------------------------------------------------------------ //
    // 1. PAGES
    // ------------------------------------------------------------------ //
    $pages = [
        'home' => [
            'title'    => 'Home',
            'template' => '',
            'slug'     => 'home',
        ],
        'about' => [
            'title'    => 'About',
            'template' => 'page-templates/tpl-about.php',
            'slug'     => 'about',
        ],
        'services' => [
            'title'    => 'Services',
            'template' => '',
            'slug'     => 'services',
        ],
        'projects' => [
            'title'    => 'Projects',
            'template' => '',
            'slug'     => 'projects',
        ],
        'team' => [
            'title'    => 'Team',
            'template' => '',
            'slug'     => 'team',
        ],
        'pricing' => [
            'title'    => 'Pricing',
            'template' => 'page-templates/tpl-pricing.php',
            'slug'     => 'pricing',
        ],
        'faq' => [
            'title'    => 'FAQ',
            'template' => 'page-templates/tpl-faq.php',
            'slug'     => 'faq',
        ],
        'testimonials' => [
            'title'    => 'Testimonials',
            'template' => 'page-templates/tpl-testimonial.php',
            'slug'     => 'testimonials',
        ],
        'booking' => [
            'title'    => 'Book Appointment',
            'template' => 'page-templates/tpl-booking.php',
            'slug'     => 'booking',
        ],
        'contact' => [
            'title'    => 'Contact',
            'template' => 'page-templates/tpl-contact.php',
            'slug'     => 'contact',
        ],
        'blog' => [
            'title'    => 'Blog',
            'template' => '',
            'slug'     => 'blog',
        ],
    ];

    $created_pages = [];

    foreach ( $pages as $key => $page ) {
        $existing = get_page_by_path( $page['slug'] );
        if ( $existing ) {
            $created_pages[ $key ] = $existing->ID;
            continue;
        }

        $id = wp_insert_post( [
            'post_title'   => $page['title'],
            'post_name'    => $page['slug'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
        ] );

        if ( ! is_wp_error( $id ) ) {
            if ( $page['template'] ) {
                update_post_meta( $id, '_wp_page_template', $page['template'] );
            }
            $created_pages[ $key ] = $id;
        }
    }

    // Set static front page & blog page.
    if ( ! empty( $created_pages['home'] ) ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $created_pages['home'] );
    }
    if ( ! empty( $created_pages['blog'] ) ) {
        update_option( 'page_for_posts', $created_pages['blog'] );
    }

    // ------------------------------------------------------------------ //
    // 2. SERVICES (custom post type)
    // ------------------------------------------------------------------ //
    $services = [
        [
            'title'       => 'Home Cleaning',
            'excerpt'     => 'Professional home cleaning services tailored to your needs.',
            'content'     => '<p>We provide top-quality home cleaning services using eco-friendly products. Our trained staff ensures every corner of your home is spotless.</p>',
            'short_desc'  => 'Expert home cleaning for a spotless living space.',
            'features'    => "Full house cleaning\nKitchen deep clean\nBathroom sanitization\nDusting & vacuuming",
        ],
        [
            'title'       => 'Office Cleaning',
            'excerpt'     => 'Keep your workplace clean, healthy, and productive.',
            'content'     => '<p>Our office cleaning service maintains a hygienic environment for your team and clients, handled efficiently outside working hours.</p>',
            'short_desc'  => 'Reliable office cleaning for a healthy workspace.',
            'features'    => "Desk & surface cleaning\nFloor mopping & vacuuming\nWashroom sanitization\nGarbage removal",
        ],
        [
            'title'       => 'Pest Control',
            'excerpt'     => 'Effective pest control solutions to protect your property.',
            'content'     => '<p>Our licensed pest control team eliminates insects, rodents, and other pests using safe and proven methods.</p>',
            'short_desc'  => 'Safe and effective pest elimination.',
            'features'    => "Inspection & assessment\nInsect & rodent control\nPrevention treatment\nFollow-up visit",
        ],
        [
            'title'       => 'AC Cleaning & Repair',
            'excerpt'     => 'Extend the life of your AC with professional maintenance.',
            'content'     => '<p>Regular AC servicing improves air quality and energy efficiency. Our technicians handle all brands and models.</p>',
            'short_desc'  => 'Full AC servicing and repair solutions.',
            'features'    => "Filter cleaning\nCoil cleaning\nRefrigerant check\nGeneral servicing",
        ],
        [
            'title'       => 'Carpet Cleaning',
            'excerpt'     => 'Deep carpet cleaning that removes stains, dust, and allergens.',
            'content'     => '<p>We use steam and dry cleaning techniques to restore the look and freshness of your carpets and rugs.</p>',
            'short_desc'  => 'Restore your carpets to like-new condition.',
            'features'    => "Stain removal\nSteam cleaning\nOdor elimination\nDrying & finishing",
        ],
        [
            'title'       => 'Car Washing',
            'excerpt'     => 'Full interior and exterior car wash at your location.',
            'content'     => '<p>Our mobile car wash team comes to you, providing thorough interior and exterior cleaning with premium products.</p>',
            'short_desc'  => 'Premium mobile car wash service.',
            'features'    => "Exterior hand wash\nInterior vacuum\nDashboard polish\nWindow cleaning",
        ],
    ];

    foreach ( $services as $svc ) {
        if ( nsp_post_exists( $svc['title'], 'service' ) ) continue;

        $id = wp_insert_post( [
            'post_title'   => $svc['title'],
            'post_excerpt' => $svc['excerpt'],
            'post_content' => $svc['content'],
            'post_status'  => 'publish',
            'post_type'    => 'service',
        ] );

        if ( ! is_wp_error( $id ) ) {
            update_post_meta( $id, '_nsp_service_short_desc', $svc['short_desc'] );
            update_post_meta( $id, '_nsp_service_features',   $svc['features'] );
        }
    }

    // ------------------------------------------------------------------ //
    // 3. PROJECTS (custom post type)
    // ------------------------------------------------------------------ //
    $projects = [
        [
            'title'      => 'Residence Cleaning',
            'excerpt'    => 'Complete residence cleaning for a family home in Dammam.',
            'content'    => '<p>A comprehensive residence cleaning project covering all rooms, upholstery, and outdoor areas of a family home.</p>',
            'client'     => 'Al-Rashidi Family',
            'location'   => 'Dammam, Saudi Arabia',
            'completion' => '2024-03-15',
            'type'       => 'Residence Cleaning',
            'cleaner'    => 'Ahmed Al-Farsi',
        ],
        [
            'title'      => 'Room Cleaning',
            'excerpt'    => 'Detailed room cleaning for a Dammam property.',
            'content'    => '<p>Complete room cleaning service with dusting, floor care, surface sanitizing, and detailed finishing.</p>',
            'client'     => 'Gulf Tech Solutions',
            'location'   => 'Dammam, Saudi Arabia',
            'completion' => '2024-05-20',
            'type'       => 'Room Cleaning',
            'cleaner'    => 'Mohammed Al-Otaibi',
        ],
        [
            'title'      => 'Office Cleaning',
            'excerpt'    => 'Professional office cleaning for a Dammam business property.',
            'content'    => '<p>Complete office cleaning service covering workstations, meeting rooms, common areas, floors, and high-touch surfaces.</p>',
            'client'     => 'Dammam Business Office',
            'location'   => 'Dammam, Saudi Arabia',
            'completion' => '2024-07-01',
            'type'       => 'Office Cleaning',
            'cleaner'    => 'Khalid Al-Zahrani',
        ],
        [
            'title'      => 'TV Lounge Room',
            'excerpt'    => 'Detailed TV lounge room cleaning for a Dammam property.',
            'content'    => '<p>Complete TV lounge room cleaning service covering seating areas, tables, floors, entertainment units, and high-touch surfaces.</p>',
            'client'     => 'Dammam Residence',
            'location'   => 'Dammam, Saudi Arabia',
            'completion' => '2024-09-10',
            'type'       => 'TV Lounge Room Cleaning',
            'cleaner'    => 'Omar Al-Ghamdi',
        ],
    ];

    foreach ( $projects as $proj ) {
        if ( nsp_post_exists( $proj['title'], 'project' ) ) continue;

        $id = wp_insert_post( [
            'post_title'   => $proj['title'],
            'post_excerpt' => $proj['excerpt'],
            'post_content' => $proj['content'],
            'post_status'  => 'publish',
            'post_type'    => 'project',
        ] );

        if ( ! is_wp_error( $id ) ) {
            update_post_meta( $id, '_nsp_project_client',     $proj['client'] );
            update_post_meta( $id, '_nsp_project_location',   $proj['location'] );
            update_post_meta( $id, '_nsp_project_completion', $proj['completion'] );
            update_post_meta( $id, '_nsp_project_type',       $proj['type'] );
            update_post_meta( $id, '_nsp_project_cleaner',    $proj['cleaner'] );
        }
    }

    // ------------------------------------------------------------------ //
    // 4. TEAM MEMBERS (custom post type)
    // ------------------------------------------------------------------ //
    $team = [
        [
            'title'      => 'Ahmed Al-Farsi',
            'content'    => '<p>Ahmed leads our residential cleaning division with over 10 years of experience in home and villa cleaning services.</p>',
            'position'   => 'Head of Residential Cleaning',
            'experience' => '10 Years',
            'speciality' => 'Deep Home Cleaning',
            'projects'   => '320',
            'email'      => 'ahmed@newsuperprime.com',
            'phone'      => '+966501234567',
            'skills'     => "Home Cleaning|95\nStain Removal|88\nCustomer Service|92",
        ],
        [
            'title'      => 'Mohammed Al-Otaibi',
            'content'    => '<p>Mohammed is a certified pest control specialist with extensive knowledge of chemical and biological treatment methods.</p>',
            'position'   => 'Pest Control Specialist',
            'experience' => '8 Years',
            'speciality' => 'Pest & Rodent Control',
            'projects'   => '240',
            'email'      => 'mohammed@newsuperprime.com',
            'phone'      => '+966502345678',
            'skills'     => "Pest Control|97\nInspection|90\nChemical Safety|85",
        ],
        [
            'title'      => 'Khalid Al-Zahrani',
            'content'    => '<p>Khalid is our lead HVAC technician, certified to service all major AC brands and large commercial installations.</p>',
            'position'   => 'Senior AC Technician',
            'experience' => '12 Years',
            'speciality' => 'AC Repair & Maintenance',
            'projects'   => '410',
            'email'      => 'khalid@newsuperprime.com',
            'phone'      => '+966503456789',
            'skills'     => "AC Servicing|98\nElectrical Repair|85\nHVAC Systems|92",
        ],
        [
            'title'      => 'Sara Al-Qahtani',
            'content'    => '<p>Sara manages our corporate client relations and oversees quality control across all commercial cleaning projects.</p>',
            'position'   => 'Quality Control Manager',
            'experience' => '7 Years',
            'speciality' => 'Quality Assurance',
            'projects'   => '180',
            'email'      => 'sara@newsuperprime.com',
            'phone'      => '+966504567890',
            'skills'     => "Quality Control|94\nTeam Management|90\nClient Relations|96",
        ],
    ];

    foreach ( $team as $member ) {
        if ( nsp_post_exists( $member['title'], 'team' ) ) continue;

        $id = wp_insert_post( [
            'post_title'   => $member['title'],
            'post_content' => $member['content'],
            'post_status'  => 'publish',
            'post_type'    => 'team',
        ] );

        if ( ! is_wp_error( $id ) ) {
            update_post_meta( $id, '_nsp_team_position',   $member['position'] );
            update_post_meta( $id, '_nsp_team_experience', $member['experience'] );
            update_post_meta( $id, '_nsp_team_speciality', $member['speciality'] );
            update_post_meta( $id, '_nsp_team_projects',   $member['projects'] );
            update_post_meta( $id, '_nsp_team_email',      $member['email'] );
            update_post_meta( $id, '_nsp_team_phone',      $member['phone'] );
            update_post_meta( $id, '_nsp_team_skills',     $member['skills'] );
        }
    }

    // ------------------------------------------------------------------ //
    // 5. TESTIMONIALS (custom post type)
    // ------------------------------------------------------------------ //
    $testimonials = [
        [
            'title'   => 'Faisal Al-Harbi',
            'content' => 'New Super Prime transformed our office. The team was professional, punctual, and thorough. Highly recommend their corporate cleaning service!',
            'role'    => 'CEO, Al-Harbi Group',
            'rating'  => 5,
        ],
        [
            'title'   => 'Noura Al-Shammari',
            'content' => 'I booked a home deep clean before a family gathering and was blown away by the results. Every room was spotless. Will definitely use again!',
            'role'    => 'Homeowner, Dammam',
            'rating'  => 5,
        ],
        [
            'title'   => 'Tariq Al-Dosari',
            'content' => 'Their pest control team was knowledgeable and used safe products suitable for homes with children. Problem solved on the first visit.',
            'role'    => 'Property Manager, Khobar',
            'rating'  => 5,
        ],
        [
            'title'   => 'Huda Al-Mutairi',
            'content' => 'The AC servicing was quick and efficient. My unit went from barely cooling to running like new. Excellent value for money.',
            'role'    => 'Apartment Owner, Dammam',
            'rating'  => 4,
        ],
    ];

    foreach ( $testimonials as $testi ) {
        if ( nsp_post_exists( $testi['title'], 'testimonial' ) ) continue;

        $id = wp_insert_post( [
            'post_title'   => $testi['title'],
            'post_content' => $testi['content'],
            'post_status'  => 'publish',
            'post_type'    => 'testimonial',
        ] );

        if ( ! is_wp_error( $id ) ) {
            update_post_meta( $id, '_nsp_testimonial_role',   $testi['role'] );
            update_post_meta( $id, '_nsp_testimonial_rating', $testi['rating'] );
        }
    }

    // ------------------------------------------------------------------ //
    // 6. PRICING PLANS (custom post type)
    // ------------------------------------------------------------------ //
    $plans = [
        [
            'title'    => 'One Service',
            'price'    => 'SAR 499',
            'features' => "Choose any one cleaning service\nFixed quote before work starts\nSingle team visit\nBook when needed, no membership",
            'featured' => '0',
        ],
        [
            'title'    => 'Add More Services',
            'price'    => 'SAR 999',
            'features' => "Combine any 2 to 3 services\nBetter value than separate bookings\nCoordinated same-day schedule\nOne invoice for all services",
            'featured' => '1',
        ],
        [
            'title'    => 'All Services Bundle',
            'price'    => 'SAR 1499',
            'features' => "Add all required services together\nWhole home or office solution\nPriority scheduling\nCustom scope after inspection",
            'featured' => '0',
        ],
    ];

    foreach ( $plans as $plan ) {
        if ( nsp_post_exists( $plan['title'], 'pricing' ) ) continue;

        $id = wp_insert_post( [
            'post_title'  => $plan['title'],
            'post_status' => 'publish',
            'post_type'   => 'pricing',
        ] );

        if ( ! is_wp_error( $id ) ) {
            update_post_meta( $id, '_nsp_pricing_price',    $plan['price'] );
            update_post_meta( $id, '_nsp_pricing_features', $plan['features'] );
            update_post_meta( $id, '_nsp_pricing_featured', $plan['featured'] );
            update_post_meta( $id, '_nsp_pricing_cta_url',  home_url( '/booking/' ) );
        }
    }

    // ------------------------------------------------------------------ //
    // 7. FAQs (custom post type)
    // ------------------------------------------------------------------ //
    $faqs = [
        [
            'title'   => 'How do I book a cleaning service?',
            'content' => '<p>You can book through our website by visiting the Book Appointment page and filling in your details, or by calling us directly. We\'ll confirm your booking within 24 hours.</p>',
        ],
        [
            'title'   => 'Are your cleaning products safe for children and pets?',
            'content' => '<p>Yes. We use eco-friendly, non-toxic cleaning products that are safe for children, pets, and people with allergies. We can also use products you supply upon request.</p>',
        ],
        [
            'title'   => 'Do I need to be home during the cleaning?',
            'content' => '<p>Not necessarily. Many of our clients provide access and leave during the service. Our team is fully vetted and insured for your peace of mind.</p>',
        ],
        [
            'title'   => 'How long does a typical home cleaning take?',
            'content' => '<p>A standard home cleaning takes 2–4 hours depending on the size of the property. A deep clean may take 4–8 hours. We\'ll give you an estimate when you book.</p>',
        ],
        [
            'title'   => 'Do you offer a satisfaction guarantee?',
            'content' => '<p>Absolutely. If you\'re not fully satisfied with any area of your clean, contact us within 24 hours and we\'ll return to re-clean that area at no extra charge.</p>',
        ],
        [
            'title'   => 'What areas do you serve?',
            'content' => '<p>We currently serve the Eastern Region of Saudi Arabia, including Dammam, Khobar, Dhahran, Jubail, Qatif, Al-Ahsa, Ras Tanura, Hafr Al-Batin, and surrounding cities. Contact us to confirm coverage in your specific location.</p>',
        ],
    ];

    foreach ( $faqs as $faq ) {
        if ( nsp_post_exists( $faq['title'], 'faq' ) ) continue;

        wp_insert_post( [
            'post_title'   => $faq['title'],
            'post_content' => $faq['content'],
            'post_status'  => 'publish',
            'post_type'    => 'faq',
        ] );
    }

    // ------------------------------------------------------------------ //
    // 8. BLOG POSTS (standard posts)
    // ------------------------------------------------------------------ //
    $posts = [
        [
            'title'    => '5 Benefits of Regular Professional Home Cleaning',
            'excerpt'  => 'Discover why scheduling regular professional cleaning improves your health, saves time, and keeps your home in perfect condition.',
            'content'  => '<p>Many homeowners underestimate the benefits of hiring professional cleaners on a regular basis. From reducing allergens to extending the life of your furnishings, here are five compelling reasons to schedule recurring cleaning.</p><h2>1. Improved Air Quality</h2><p>Dust, pet dander, and mould spores accumulate quickly. Professional cleaning removes these pollutants, helping everyone in the home breathe easier.</p><h2>2. Saves You Time</h2><p>Delegating cleaning frees up hours every week for family, work, or relaxation.</p><h2>3. Consistent Results</h2><p>Trained cleaners follow systematic processes that ensure nothing is missed, delivering consistent results every visit.</p><h2>4. Protects Your Investment</h2><p>Regular cleaning prevents the build-up of grime that can damage surfaces, carpets, and appliances over time.</p><h2>5. Reduces Stress</h2><p>A clean, organised home has a proven positive effect on mental well-being.</p>',
            'category' => 'Cleaning Tips',
        ],
        [
            'title'    => 'Signs You Have a Pest Problem (And What to Do About It)',
            'excerpt'  => 'Spotting pest activity early can save you from costly damage. Learn the warning signs and how professional pest control can help.',
            'content'  => '<p>Pests are experts at hiding, but they always leave clues. Knowing what to look for can help you act before a minor problem becomes a major infestation.</p><h2>Common Warning Signs</h2><ul><li>Droppings or urine trails near food storage areas</li><li>Gnaw marks on furniture, wiring, or walls</li><li>Unusual sounds at night (scratching, rustling)</li><li>Visible nests or burrows near the property</li><li>Unexplained bites or skin irritation</li></ul><h2>What to Do</h2><p>If you spot two or more of these signs, contact a licensed pest control company immediately. Early treatment is far less costly than dealing with a full infestation.</p>',
            'category' => 'Pest Control',
        ],
        [
            'title'    => 'How Often Should You Service Your Air Conditioner?',
            'excerpt'  => 'Regular AC maintenance extends the unit\'s lifespan, lowers energy bills, and keeps the air in your home clean and healthy.',
            'content'  => '<p>In hot climates like Saudi Arabia, air conditioners run almost year-round. Without regular maintenance, performance drops, energy costs rise, and breakdowns become more likely.</p><h2>Recommended Service Schedule</h2><p>For residential units: at least once every 6 months, ideally before summer and winter. For commercial or heavy-use units: every 3 months.</p><h2>What a Service Includes</h2><ul><li>Cleaning or replacing air filters</li><li>Cleaning evaporator and condenser coils</li><li>Checking refrigerant levels</li><li>Inspecting electrical components</li><li>Testing thermostat calibration</li></ul><h2>The Cost of Skipping Service</h2><p>A neglected AC unit can use up to 25% more electricity and is far more likely to fail during peak summer demand — exactly when you need it most.</p>',
            'category' => 'AC Maintenance',
        ],
    ];

    foreach ( $posts as $post ) {
        $cat_id = 0;
        $term   = get_term_by( 'name', $post['category'], 'category' );
        if ( $term ) {
            $cat_id = $term->term_id;
        } else {
            $new_cat = wp_insert_term( $post['category'], 'category' );
            if ( ! is_wp_error( $new_cat ) ) {
                $cat_id = $new_cat['term_id'];
            }
        }

        if ( nsp_post_exists( $post['title'], 'post' ) ) continue;

        wp_insert_post( [
            'post_title'    => $post['title'],
            'post_excerpt'  => $post['excerpt'],
            'post_content'  => $post['content'],
            'post_status'   => 'publish',
            'post_type'     => 'post',
            'post_category' => $cat_id ? [ $cat_id ] : [],
        ] );
    }

    // ------------------------------------------------------------------ //
    // 9. PROJECT CATEGORIES (taxonomy terms)
    // ------------------------------------------------------------------ //
    $project_cats = [ 'Residential', 'Commercial', 'Specialty Services' ];
    foreach ( $project_cats as $cat ) {
        if ( ! term_exists( $cat, 'project_category' ) ) {
            wp_insert_term( $cat, 'project_category' );
        }
    }

    // ------------------------------------------------------------------ //
    // 10. NAVIGATION MENUS
    // ------------------------------------------------------------------ //

    // Primary Menu: Home · About · Services · Projects · Team · Blog · Contact
    $primary_id  = false;
    $primary_obj = wp_get_nav_menu_object( 'Primary Menu' );
    if ( $primary_obj ) {
        $primary_id = $primary_obj->term_id;
    } else {
        $primary_id = wp_create_nav_menu( 'Primary Menu' );
    }

    if ( $primary_id && ! is_wp_error( $primary_id ) ) {
        if ( empty( wp_get_nav_menu_items( $primary_id ) ) ) {
            $primary_items = [
                'home'     => 'Home',
                'about'    => 'About',
                'services' => 'Services',
                'projects' => 'Projects',
                'team'     => 'Team',
                'blog'     => 'Blog',
                'contact'  => 'Contact',
            ];
            foreach ( $primary_items as $key => $label ) {
                if ( ! empty( $created_pages[ $key ] ) ) {
                    wp_update_nav_menu_item( $primary_id, 0, [
                        'menu-item-title'     => $label,
                        'menu-item-object'    => 'page',
                        'menu-item-object-id' => $created_pages[ $key ],
                        'menu-item-type'      => 'post_type',
                        'menu-item-status'    => 'publish',
                    ] );
                }
            }
        }
    }

    // Footer Menu: About · Services · FAQ · Pricing · Contact · Blog
    $footer_id  = false;
    $footer_obj = wp_get_nav_menu_object( 'Footer Menu' );
    if ( $footer_obj ) {
        $footer_id = $footer_obj->term_id;
    } else {
        $footer_id = wp_create_nav_menu( 'Footer Menu' );
    }

    if ( $footer_id && ! is_wp_error( $footer_id ) ) {
        if ( empty( wp_get_nav_menu_items( $footer_id ) ) ) {
            $footer_items = [
                'about'    => 'About',
                'services' => 'Services',
                'faq'      => 'FAQ',
                'pricing'  => 'Pricing',
                'contact'  => 'Contact',
                'blog'     => 'Blog',
            ];
            foreach ( $footer_items as $key => $label ) {
                if ( ! empty( $created_pages[ $key ] ) ) {
                    wp_update_nav_menu_item( $footer_id, 0, [
                        'menu-item-title'     => $label,
                        'menu-item-object'    => 'page',
                        'menu-item-object-id' => $created_pages[ $key ],
                        'menu-item-type'      => 'post_type',
                        'menu-item-status'    => 'publish',
                    ] );
                }
            }
        }
    }

    // Assign menus to their registered theme locations.
    $locations = (array) get_theme_mod( 'nav_menu_locations', [] );
    if ( $primary_id && ! is_wp_error( $primary_id ) ) {
        $locations['primary'] = (int) $primary_id;
    }
    if ( $footer_id && ! is_wp_error( $footer_id ) ) {
        $locations['footer'] = (int) $footer_id;
    }
    set_theme_mod( 'nav_menu_locations', $locations );

    // ------------------------------------------------------------------ //
    // 11. GENERAL SETTINGS
    // ------------------------------------------------------------------ //

    // Pretty permalinks (/%postname%/)
    update_option( 'permalink_structure', '/%postname%/' );

    // Site identity defaults (only overwrite WordPress defaults, not user-set values)
    if ( in_array( get_option( 'blogname' ), [ 'My Site', '', 'My Blog' ], true ) ) {
        update_option( 'blogname', 'New Super Prime' );
    }
    if ( in_array( get_option( 'blogdescription' ), [ 'Just another WordPress site', '' ], true ) ) {
        update_option( 'blogdescription', 'Professional Cleaning Services' );
    }

    // Timezone
    update_option( 'timezone_string', 'Asia/Riyadh' );

    // Date / time formats
    update_option( 'date_format', 'F j, Y' );
    update_option( 'time_format', 'g:i a' );

    // Discussion: disable comments on pages by default
    update_option( 'default_comment_status', 'closed' );
    update_option( 'default_ping_status', 'closed' );

    // ------------------------------------------------------------------ //
    // 12. FLUSH REWRITE RULES
    // ------------------------------------------------------------------ //
    flush_rewrite_rules();

    update_option( 'nsp_demo_content_created', '1' );
}
add_action( 'after_switch_theme', 'nsp_setup_demo_content' );

/**
 * Helper: check if a post with this title already exists for a given post type.
 */
function nsp_post_exists( string $title, string $post_type ): bool {
    global $wpdb;
    $exists = $wpdb->get_var( $wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_title = %s AND post_type = %s AND post_status != 'trash' LIMIT 1",
        $title,
        $post_type
    ) );
    return (bool) $exists;
}
