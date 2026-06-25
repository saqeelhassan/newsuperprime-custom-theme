<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function nsp_theme_setup() {
    load_theme_textdomain( 'newsuperprime', NSP_THEME_DIR . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'customize-selective-refresh-widgets' );

    add_theme_support( 'custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ] );

    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );

    add_theme_support( 'post-formats', [ 'aside', 'image', 'video', 'quote', 'link' ] );

    register_nav_menus( [
        'primary' => esc_html__( 'Primary Menu', 'newsuperprime' ),
        'footer'  => esc_html__( 'Footer Menu', 'newsuperprime' ),
    ] );

    add_image_size( 'nsp-blog-thumb',   80,   80,  true );
    add_image_size( 'nsp-blog-feed',    730,  430, true );
    add_image_size( 'nsp-project',      370,  420, true );
    add_image_size( 'nsp-team',         370,  440, true );
    add_image_size( 'nsp-service',      390,  320, true );
    add_image_size( 'nsp-banner',       1920, 520, true );

    add_editor_style( 'assets/css/style.css' );
}
add_action( 'after_setup_theme', 'nsp_theme_setup' );


/* ---------- Admin notice for Contact Form 7 ---------- */
function nsp_cf7_admin_notice() {
    if ( ! function_exists( 'wpcf7' ) ) {
        echo '<div class="notice notice-warning"><p>';
        echo esc_html__( 'New Super Prime theme: Please install and activate Contact Form 7 for booking and contact forms to work.', 'newsuperprime' );
        echo '</p></div>';
    }
}
add_action( 'admin_notices', 'nsp_cf7_admin_notice' );
