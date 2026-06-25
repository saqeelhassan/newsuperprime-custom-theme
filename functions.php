<?php
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'NSP_THEME_VERSION', '1.0.13' );
define( 'NSP_THEME_DIR', get_template_directory() );
define( 'NSP_THEME_URI', get_template_directory_uri() );

require_once NSP_THEME_DIR . '/inc/lang.php';
require_once NSP_THEME_DIR . '/inc/theme-setup.php';
require_once NSP_THEME_DIR . '/inc/enqueue.php';
require_once NSP_THEME_DIR . '/inc/post-types.php';
require_once NSP_THEME_DIR . '/inc/taxonomies.php';
require_once NSP_THEME_DIR . '/inc/meta-boxes.php';
require_once NSP_THEME_DIR . '/inc/customizer.php';
require_once NSP_THEME_DIR . '/inc/widgets.php';
require_once NSP_THEME_DIR . '/inc/template-tags.php';
require_once NSP_THEME_DIR . '/inc/breadcrumb.php';
require_once NSP_THEME_DIR . '/inc/helpers.php';
require_once NSP_THEME_DIR . '/inc/nav-walker.php';
require_once NSP_THEME_DIR . '/inc/setup-demo-content.php';

/**
 * Defines all service pages: title, URL slug, and which page template to use.
 * Add new services here — the auto-creation script reads this list.
 */
function nsp_get_service_page_definitions() {
    return [
        [
            'title'    => 'Home Cleaning Service',
            'desc'     => 'Home cleaning, deep cleaning, villa and apartment cleaning services tailored to your needs.',
            'slug'     => 'home-cleaning-service',
            'template' => 'page-templates/tpl-service-home-cleaning.php',
        ],
        [
            'title'    => 'Carpet Cleaning Service',
            'desc'     => 'Upholstery, sofa, carpet and curtain cleaning that removes stains, dust, odors and allergens.',
            'slug'     => 'carpet-cleaning-service',
            'template' => 'page-templates/tpl-service-carpet-cleaning.php',
        ],
        [
            'title'    => 'Office Cleaning Service',
            'desc'     => 'Office cleaning, commercial cleaning and janitorial services for healthy workplaces.',
            'slug'     => 'office-cleaning-service',
            'template' => 'page-templates/tpl-service-office-cleaning.php',
        ],
        [
            'title'    => 'Car Wash Service',
            'desc'     => 'Complete interior and exterior car wash service at your location.',
            'slug'     => 'car-wash-service',
            'template' => 'page-templates/tpl-service-car-wash.php',
        ],
        [
            'title'    => 'Home Shifting Service',
            'desc'     => 'Home shifting, furniture transport, office relocation and general maintenance services.',
            'slug'     => 'home-shifting-service',
            'template' => 'page-templates/tpl-service-home-shifting.php',
        ],
        [
            'title'    => 'AC Maintenance Service',
            'desc'     => 'AC cleaning, HVAC maintenance and water tank cleaning support for homes and businesses.',
            'slug'     => 'ac-maintenance-service',
            'template' => 'page-templates/tpl-service-ac-maintenance.php',
        ],
        [
            'title'    => 'Pest Control Service',
            'desc'     => 'Pest control for cockroach control, bed bug control and safe property protection.',
            'slug'     => 'pest-control-service',
            'template' => 'page-templates/tpl-service-pest-control.php',
        ],
    ];
}

/**
 * Creates all service pages automatically when the theme is activated.
 * Safe to re-run: skips any page whose slug already exists.
 * Hooked to after_switch_theme so it fires exactly once on activation.
 */
function nsp_create_service_pages() {
    if ( ! get_page_by_path( 'services' ) ) {
        wp_insert_post( [
            'post_title'  => 'Services',
            'post_name'   => 'services',
            'post_status' => 'publish',
            'post_type'   => 'page',
        ] );
    }

    foreach ( nsp_get_service_page_definitions() as $svc ) {
        $existing = get_page_by_path( $svc['slug'] );
        if ( $existing ) {
            if ( 'publish' !== get_post_status( $existing->ID ) ) {
                wp_update_post( [
                    'ID'          => $existing->ID,
                    'post_status' => 'publish',
                ] );
            }
            if ( get_page_template_slug( $existing->ID ) !== $svc['template'] ) {
                update_post_meta( $existing->ID, '_wp_page_template', $svc['template'] );
            }
            continue;
        }

        $id = wp_insert_post( [
            'post_title'  => $svc['title'],
            'post_name'   => $svc['slug'],
            'post_status' => 'publish',
            'post_type'   => 'page',
        ] );

        if ( $id && ! is_wp_error( $id ) ) {
            update_post_meta( $id, '_wp_page_template', $svc['template'] );
        }
    }
}
add_action( 'after_switch_theme', 'nsp_create_service_pages' );
add_action( 'admin_init', 'nsp_create_service_pages' );

function nsp_sync_project_content_labels() {
    $sync_version = '20260616_project_names_dammam_tv_lounge_url';
    if ( get_option( 'nsp_project_content_sync_version' ) === $sync_version ) {
        return;
    }

    $project_updates = [
        'residential-deep-cleaning' => [
            'post_title'   => 'Residence Cleaning',
            'post_excerpt' => 'Complete residence cleaning for a family home in Dammam.',
            'post_content' => '<p>A comprehensive residence cleaning project covering all rooms, upholstery, and outdoor areas of a family home.</p>',
            'type'         => 'Residence Cleaning',
        ],
        'corporate-office-pest-control' => [
            'post_title'   => 'Room Cleaning',
            'post_excerpt' => 'Detailed room cleaning for a Dammam property.',
            'post_content' => '<p>Complete room cleaning service with dusting, floor care, surface sanitizing, and detailed finishing.</p>',
            'type'         => 'Room Cleaning',
        ],
        'hotel-ac-servicing-contract' => [
            'post_title'   => 'Office Cleaning',
            'post_excerpt' => 'Professional office cleaning for a Dammam business property.',
            'post_content' => '<p>Complete office cleaning service covering workstations, meeting rooms, common areas, floors, and high-touch surfaces.</p>',
            'client'       => 'Dammam Business Office',
            'type'         => 'Office Cleaning',
        ],
        'tv-lounge-room' => [
            'old_slugs'     => [ 'shopping-mall-carpet-cleaning' ],
            'post_title'   => 'TV Lounge Room',
            'post_excerpt' => 'Detailed TV lounge room cleaning for a Dammam property.',
            'post_content' => '<p>Complete TV lounge room cleaning service covering seating areas, tables, floors, entertainment units, and high-touch surfaces.</p>',
            'client'       => 'Dammam Residence',
            'type'         => 'TV Lounge Room Cleaning',
        ],
    ];

    foreach ( $project_updates as $slug => $project_update ) {
        $project = get_page_by_path( $slug, OBJECT, 'project' );
        if ( ! $project && ! empty( $project_update['old_slugs'] ) ) {
            foreach ( $project_update['old_slugs'] as $old_slug ) {
                $project = get_page_by_path( $old_slug, OBJECT, 'project' );
                if ( $project ) {
                    break;
                }
            }
        }

        if ( ! $project ) {
            continue;
        }

        wp_update_post( [
            'ID'           => $project->ID,
            'post_name'    => $slug,
            'post_title'   => $project_update['post_title'],
            'post_excerpt' => $project_update['post_excerpt'],
            'post_content' => $project_update['post_content'],
        ] );

        update_post_meta( $project->ID, '_nsp_project_location', 'Dammam, Saudi Arabia' );
        update_post_meta( $project->ID, '_nsp_project_type', $project_update['type'] );

        if ( isset( $project_update['client'] ) ) {
            update_post_meta( $project->ID, '_nsp_project_client', $project_update['client'] );
        }
    }

    $project_ids = get_posts( [
        'post_type'      => 'project',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ] );

    foreach ( $project_ids as $project_id ) {
        update_post_meta( $project_id, '_nsp_project_location', 'Dammam, Saudi Arabia' );
    }

    update_option( 'nsp_project_content_sync_version', $sync_version );
}
add_action( 'init', 'nsp_sync_project_content_labels' );
