<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function nsp_register_post_types() {
    // ---------- Service ----------
    register_post_type( 'service', [
        'labels' => [
            'name'          => esc_html__( 'Services',         'newsuperprime' ),
            'singular_name' => esc_html__( 'Service',          'newsuperprime' ),
            'add_new_item'  => esc_html__( 'Add New Service',  'newsuperprime' ),
            'edit_item'     => esc_html__( 'Edit Service',     'newsuperprime' ),
        ],
        'public'        => true,
        'has_archive'   => 'services',
        'rewrite'       => [ 'slug' => 'services' ],
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-admin-tools',
        'menu_position' => 5,
    ] );

    // ---------- Project ----------
    register_post_type( 'project', [
        'labels' => [
            'name'          => esc_html__( 'Projects',        'newsuperprime' ),
            'singular_name' => esc_html__( 'Project',         'newsuperprime' ),
            'add_new_item'  => esc_html__( 'Add New Project', 'newsuperprime' ),
            'edit_item'     => esc_html__( 'Edit Project',    'newsuperprime' ),
        ],
        'public'        => true,
        'has_archive'   => 'projects',
        'rewrite'       => [ 'slug' => 'projects' ],
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-portfolio',
        'menu_position' => 6,
    ] );

    // ---------- Team ----------
    register_post_type( 'team', [
        'labels' => [
            'name'          => esc_html__( 'Team',                 'newsuperprime' ),
            'singular_name' => esc_html__( 'Team Member',          'newsuperprime' ),
            'add_new_item'  => esc_html__( 'Add New Team Member',  'newsuperprime' ),
            'edit_item'     => esc_html__( 'Edit Team Member',     'newsuperprime' ),
        ],
        'public'        => true,
        'has_archive'   => 'team',
        'rewrite'       => [ 'slug' => 'team' ],
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-groups',
        'menu_position' => 7,
    ] );

    // ---------- Testimonial ----------
    register_post_type( 'testimonial', [
        'labels' => [
            'name'          => esc_html__( 'Testimonials',          'newsuperprime' ),
            'singular_name' => esc_html__( 'Testimonial',           'newsuperprime' ),
            'add_new_item'  => esc_html__( 'Add New Testimonial',   'newsuperprime' ),
            'edit_item'     => esc_html__( 'Edit Testimonial',      'newsuperprime' ),
        ],
        'public'        => false,
        'show_ui'       => true,
        'has_archive'   => false,
        'rewrite'       => false,
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-format-quote',
        'menu_position' => 8,
    ] );

    // ---------- Pricing ----------
    register_post_type( 'pricing', [
        'labels' => [
            'name'          => esc_html__( 'Pricing Plans',          'newsuperprime' ),
            'singular_name' => esc_html__( 'Pricing Plan',           'newsuperprime' ),
            'add_new_item'  => esc_html__( 'Add New Pricing Plan',   'newsuperprime' ),
            'edit_item'     => esc_html__( 'Edit Pricing Plan',      'newsuperprime' ),
        ],
        'public'        => false,
        'show_ui'       => true,
        'has_archive'   => false,
        'rewrite'       => false,
        'supports'      => [ 'title', 'editor', 'thumbnail' ],
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-tag',
        'menu_position' => 9,
    ] );

    // ---------- FAQ ----------
    register_post_type( 'faq', [
        'labels' => [
            'name'          => esc_html__( 'FAQs',         'newsuperprime' ),
            'singular_name' => esc_html__( 'FAQ',          'newsuperprime' ),
            'add_new_item'  => esc_html__( 'Add New FAQ',  'newsuperprime' ),
            'edit_item'     => esc_html__( 'Edit FAQ',     'newsuperprime' ),
        ],
        'public'        => false,
        'show_ui'       => true,
        'has_archive'   => false,
        'rewrite'       => false,
        'supports'      => [ 'title', 'editor' ],
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-editor-help',
        'menu_position' => 10,
    ] );
}
add_action( 'init', 'nsp_register_post_types' );
