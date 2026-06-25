<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function nsp_customizer_register( WP_Customize_Manager $wp_customize ) {

    /* ================================================================
       Panel: New Super Prime Theme Options
       ================================================================ */
    $wp_customize->add_panel( 'nsp_theme_options', [
        'title'    => esc_html__( 'New Super Prime Options', 'newsuperprime' ),
        'priority' => 130,
    ] );

    /* ================================================================
       Section: Topbar / Contact Info
       ================================================================ */
    $wp_customize->add_section( 'nsp_topbar', [
        'title' => esc_html__( 'Topbar / Contact Info', 'newsuperprime' ),
        'panel' => 'nsp_theme_options',
    ] );

    nsp_add_text_setting( $wp_customize, 'nsp_phone1',         'nsp_topbar', esc_html__( 'Phone 1',       'newsuperprime' ), '+966 593657772' );
    nsp_add_text_setting( $wp_customize, 'nsp_phone2',         'nsp_topbar', esc_html__( 'Phone 2',       'newsuperprime' ), '+966 559357772' );
    nsp_add_text_setting( $wp_customize, 'nsp_email',          'nsp_topbar', esc_html__( 'Email',         'newsuperprime' ), 'info@newsuperprime.sa' );
    nsp_add_text_setting( $wp_customize, 'nsp_address',        'nsp_topbar', esc_html__( 'Address',       'newsuperprime' ), 'Building Number 7461, Hamza Street, PO Box 4161, Aladama Dist, Dammam 32242, Kingdom Of Saudi Arabia' );
    nsp_add_text_setting( $wp_customize, 'nsp_opening_hours',  'nsp_topbar', esc_html__( 'Opening Hours', 'newsuperprime' ), '10.00pm - 08.00am, Friday Off' );

    /* ================================================================
       Section: Social Links
       ================================================================ */
    $wp_customize->add_section( 'nsp_social', [
        'title' => esc_html__( 'Social Links', 'newsuperprime' ),
        'panel' => 'nsp_theme_options',
    ] );

    nsp_add_url_setting( $wp_customize, 'nsp_social_snapchat',  'nsp_social', esc_html__( 'Snapchat URL',  'newsuperprime' ), 'https://www.snapchat.com/add/newsuperprime' );
    nsp_add_url_setting( $wp_customize, 'nsp_social_facebook',  'nsp_social', esc_html__( 'Facebook URL',  'newsuperprime' ), 'https://www.facebook.com/newsuperprime' );
    nsp_add_url_setting( $wp_customize, 'nsp_social_tiktok',    'nsp_social', esc_html__( 'TikTok URL',    'newsuperprime' ), 'https://www.tiktok.com/@new_super_prime_company' );
    nsp_add_url_setting( $wp_customize, 'nsp_social_x',         'nsp_social', esc_html__( 'X URL',         'newsuperprime' ), 'https://x.com/NewSuperPrime' );
    nsp_add_url_setting( $wp_customize, 'nsp_social_instagram', 'nsp_social', esc_html__( 'Instagram URL', 'newsuperprime' ), 'https://www.instagram.com/newsuperprimecompany?utm_source=qr&igsh=dTE4Mm56dmF3Ymhm' );

    /* ================================================================
       Section: Footer
       ================================================================ */
    $wp_customize->add_section( 'nsp_footer', [
        'title' => esc_html__( 'Footer', 'newsuperprime' ),
        'panel' => 'nsp_theme_options',
    ] );

    nsp_add_text_setting( $wp_customize, 'nsp_copyright_text', 'nsp_footer', esc_html__( 'Copyright Text', 'newsuperprime' ),
        'Copyright © 2024 New Super Prime. All rights reserved. | Crafted by <a href="https://deweboo.com/" target="_blank">De Weboo</a>' );
    nsp_add_url_setting( $wp_customize, 'nsp_footer_logo',  'nsp_footer', esc_html__( 'Footer Logo URL', 'newsuperprime' ), '' );
    nsp_add_textarea_setting( $wp_customize, 'nsp_footer_about', 'nsp_footer', esc_html__( 'Footer About Text', 'newsuperprime' ),
        'Your trusted cleaning partner in the Eastern Province since 1997. Serving Dammam, Khobar, Jubail, Qatif, Al-Ahsa and beyond.' );

    /* ================================================================
       Section: CTA / Promo
       ================================================================ */
    $wp_customize->add_section( 'nsp_cta', [
        'title' => esc_html__( 'CTA / Promo Section', 'newsuperprime' ),
        'panel' => 'nsp_theme_options',
    ] );

    nsp_add_text_setting( $wp_customize, 'nsp_cta_headline', 'nsp_cta', esc_html__( 'Promo Headline (EN)', 'newsuperprime' ),
        "Get Our Services, It's Affordable Save Time & Save Money." );
    nsp_add_text_setting( $wp_customize, 'nsp_cta_headline_ar', 'nsp_cta', esc_html__( 'Promo Headline (AR)', 'newsuperprime' ),
        'احصل على خدماتنا بأسعار معقولة. وفر وقتك وأموالك.' );
    nsp_add_url_setting( $wp_customize, 'nsp_cta_button_url', 'nsp_cta', esc_html__( 'Promo Button URL', 'newsuperprime' ), '#' );

    /* ================================================================
       Section: 404 Page
       ================================================================ */
    $wp_customize->add_section( 'nsp_404', [
        'title' => esc_html__( '404 Page', 'newsuperprime' ),
        'panel' => 'nsp_theme_options',
    ] );

    nsp_add_text_setting( $wp_customize, 'nsp_404_title',   'nsp_404', esc_html__( '404 Title',   'newsuperprime' ), 'Page Not Found' );
    nsp_add_textarea_setting( $wp_customize, 'nsp_404_message', 'nsp_404', esc_html__( '404 Message', 'newsuperprime' ),
        "The page you are looking for might have been removed, had its name changed, or is temporarily unavailable." );
    nsp_add_url_setting( $wp_customize, 'nsp_404_button_url', 'nsp_404', esc_html__( '404 Button URL', 'newsuperprime' ), '/' );
}
add_action( 'customize_register', 'nsp_customizer_register' );

/* ================================================================
   Helper: add a text setting + control
   ================================================================ */
function nsp_add_text_setting( WP_Customize_Manager $wp, string $id, string $section, string $label, string $default ) {
    $wp->add_setting( $id, [ 'default' => $default, 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
    $wp->add_control( $id, [ 'label' => $label, 'section' => $section, 'type' => 'text' ] );
}

function nsp_add_url_setting( WP_Customize_Manager $wp, string $id, string $section, string $label, string $default ) {
    $wp->add_setting( $id, [ 'default' => $default, 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ] );
    $wp->add_control( $id, [ 'label' => $label, 'section' => $section, 'type' => 'url' ] );
}

function nsp_add_textarea_setting( WP_Customize_Manager $wp, string $id, string $section, string $label, string $default ) {
    $wp->add_setting( $id, [ 'default' => $default, 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ] );
    $wp->add_control( $id, [ 'label' => $label, 'section' => $section, 'type' => 'textarea' ] );
}
