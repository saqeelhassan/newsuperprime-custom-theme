<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function nsp_register_taxonomies() {
    // project_category — for portfolio filtering
    register_taxonomy( 'project_category', 'project', [
        'labels' => [
            'name'          => esc_html__( 'Project Categories', 'newsuperprime' ),
            'singular_name' => esc_html__( 'Project Category',  'newsuperprime' ),
            'all_items'     => esc_html__( 'All Categories',    'newsuperprime' ),
            'add_new_item'  => esc_html__( 'Add New Category',  'newsuperprime' ),
        ],
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'rewrite'           => [ 'slug' => 'project-category' ],
        'show_admin_column' => true,
    ] );

    // service_category — optional grouping for services
    register_taxonomy( 'service_category', 'service', [
        'labels' => [
            'name'          => esc_html__( 'Service Categories', 'newsuperprime' ),
            'singular_name' => esc_html__( 'Service Category',  'newsuperprime' ),
            'all_items'     => esc_html__( 'All Categories',    'newsuperprime' ),
            'add_new_item'  => esc_html__( 'Add New Category',  'newsuperprime' ),
        ],
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'rewrite'           => [ 'slug' => 'service-category' ],
        'show_admin_column' => true,
    ] );
}
add_action( 'init', 'nsp_register_taxonomies' );
