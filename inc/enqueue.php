<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_head', function () {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    echo '<link rel="dns-prefetch" href="https://maps.googleapis.com">' . "\n";
    echo '<link rel="dns-prefetch" href="https://maps.google.com">' . "\n";
}, 1 );

function nsp_enqueue_assets() {
    $v   = NSP_THEME_VERSION;
    $uri = NSP_THEME_URI;

    // ---------- Stylesheets (same order as source <head>) ----------
    wp_enqueue_style( 'nsp-bootstrap',    $uri . '/assets/css/bootstrap.min.css',  [], $v );
    wp_enqueue_style( 'nsp-fontawesome',  $uri . '/assets/css/fontawesome-all.css', [], $v );
    wp_enqueue_style( 'nsp-animate',      $uri . '/assets/css/animate.css',         [], $v );
    wp_enqueue_style( 'nsp-video',        $uri . '/assets/css/video.min.css',       [], $v );
    wp_enqueue_style( 'nsp-slick',        $uri . '/assets/css/slick.css',           [], $v );
    wp_enqueue_style( 'nsp-slick-theme',  $uri . '/assets/css/slick-theme.css',     [], $v );
    wp_enqueue_style( 'nsp-magnific',     $uri . '/assets/css/magnific-popup.css',  [], $v );
    wp_enqueue_style( 'nsp-reset',        $uri . '/assets/css/reset.css',           [], $v );
    $main_css_file = NSP_THEME_DIR . '/assets/css/style.css';
    $main_css_ver  = file_exists( $main_css_file ) ? filemtime( $main_css_file ) : $v;
    wp_enqueue_style( 'nsp-main', $uri . '/assets/css/style.css', [], $main_css_ver );

    // ---------- Arabic font + RTL stylesheet (must come after nsp-main and Bootstrap) ----------
    // Enqueueing rtl BEFORE Bootstrap caused WordPress to pull nsp-main early via the
    // dependency resolver, making bootstrap.min.css load AFTER style.css and rtl.css —
    // which let Bootstrap's LTR defaults override all RTL overrides.
    if ( nsp_is_arabic() ) {
        $rtl_css_file = NSP_THEME_DIR . '/rtl.css';
        $rtl_css_ver  = file_exists( $rtl_css_file ) ? filemtime( $rtl_css_file ) : $v;
        wp_enqueue_style( 'nsp-rtl', $uri . '/rtl.css', [ 'nsp-main' ], $rtl_css_ver );
    }


    // ---------- Scripts (footer, same order as scripts-inner-standard.php) ----------
    // Deregister WP's jQuery and use the bundled one from source
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', $uri . '/assets/js/jquery.min.js', [], $v, true );
    wp_enqueue_script( 'jquery' );

    wp_enqueue_script( 'nsp-popper',         $uri . '/assets/js/popper.min.js',                [ 'jquery' ], $v, true );
    wp_enqueue_script( 'nsp-bootstrap',      $uri . '/assets/js/bootstrap.min.js',             [ 'jquery', 'nsp-popper' ], $v, true );
    wp_enqueue_script( 'nsp-magnific',       $uri . '/assets/js/jquery.magnific-popup.min.js', [ 'jquery' ], $v, true );
    wp_enqueue_script( 'nsp-appear',         $uri . '/assets/js/appear.js',                    [ 'jquery' ], $v, true );
    wp_enqueue_script( 'nsp-slick',          $uri . '/assets/js/slick.js',                     [ 'jquery' ], $v, true );
    wp_enqueue_script( 'nsp-counterup',      $uri . '/assets/js/jquery.counterup.min.js',      [ 'jquery' ], $v, true );
    wp_enqueue_script( 'nsp-waypoints',      $uri . '/assets/js/waypoints.min.js',             [ 'jquery' ], $v, true );
    if ( is_post_type_archive( 'project' ) || is_tax( 'project_category' ) ) {
        wp_enqueue_script( 'nsp-imagesloaded', $uri . '/assets/js/imagesloaded.pkgd.min.js', [ 'jquery' ], $v, true );
        wp_enqueue_script( 'nsp-filterizr',    $uri . '/assets/js/jquery.filterizr.js',      [ 'jquery', 'nsp-imagesloaded' ], $v, true );
    }
    wp_enqueue_script( 'nsp-wow',            $uri . '/assets/js/wow.min.js',                   [ 'jquery' ], $v, true );
    wp_enqueue_script( 'nsp-inputarrow',     $uri . '/assets/js/jquery.inputarrow.js',         [ 'jquery' ], $v, true );
    // gmap3 + Google Maps API are loaded only from contact.php (pages that have #googleMaps)
    // Ripples WebGL water effect — front page hero only
    if ( is_front_page() ) {
        wp_enqueue_script( 'nsp-ripples', $uri . '/assets/js/jquery.ripples.min.js', [ 'jquery' ], $v, true );
    }

    $main_js_file = NSP_THEME_DIR . '/assets/js/script.js';
    $main_js_ver  = file_exists( $main_js_file ) ? filemtime( $main_js_file ) : $v;
    wp_enqueue_script( 'nsp-main', $uri . '/assets/js/script.js', [ 'jquery', 'nsp-slick', 'nsp-wow' ], $main_js_ver, true );
    $dropdown_js_file = NSP_THEME_DIR . '/assets/js/nsp-dropdowns.js';
    $dropdown_js_ver  = file_exists( $dropdown_js_file ) ? filemtime( $dropdown_js_file ) : $v;
    wp_enqueue_script( 'nsp-dropdowns', $uri . '/assets/js/nsp-dropdowns.js', [], $dropdown_js_ver, true );

    // Pass dynamic data for JS
    wp_localize_script( 'nsp-main', 'nspData', [
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'themeUri'  => $uri,
        'nonce'     => wp_create_nonce( 'nsp_nonce' ),
        'isRtl'     => nsp_is_arabic(),
    ] );
}
add_action( 'wp_enqueue_scripts', 'nsp_enqueue_assets' );
