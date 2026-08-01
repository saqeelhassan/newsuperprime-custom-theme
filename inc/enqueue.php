<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add preconnect resource hints for Google Fonts and Maps for performance.
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array
 */
function nsp_resource_hints( array $urls, string $relation_type ): array {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = 'https://fonts.gstatic.com';
	}
	if ( 'dns-prefetch' === $relation_type ) {
		$urls[] = 'https://maps.googleapis.com';
		$urls[] = 'https://maps.google.com';
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'nsp_resource_hints', 10, 2 );

function nsp_enqueue_assets() {
    $v   = NSP_THEME_VERSION;
    $uri = NSP_THEME_URI;

    // Enqueue Google Fonts correctly instead of using @import or manual <link> tags.
    $font_url = 'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap';
	wp_enqueue_style( 'nsp-google-fonts', $font_url, [], null );

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
    wp_enqueue_style( 'nsp-main', $uri . '/assets/css/style.css', [ 'nsp-google-fonts' ], $main_css_ver );

    // ---------- Arabic font + RTL stylesheet (must come after nsp-main and Bootstrap) ----------
    // Enqueueing rtl BEFORE Bootstrap caused WordPress to pull nsp-main early via the
    // dependency resolver, making bootstrap.min.css load AFTER style.css and rtl.css —
    // which let Bootstrap's LTR defaults override all RTL overrides.
    if ( nsp_is_arabic() ) {
        $rtl_css_file = NSP_THEME_DIR . '/rtl.css';
        $rtl_css_ver  = file_exists( $rtl_css_file ) ? filemtime( $rtl_css_file ) : $v;
        wp_enqueue_style( 'nsp-rtl', $uri . '/rtl.css', [ 'nsp-main' ], $rtl_css_ver );

        // **RTL Animation Fix**
        // This inline style block overrides the hardcoded `translateX` in animate.css
        // for RTL layouts, ensuring animations slide in the correct direction.
        $rtl_animation_fix = "
            /* RTL Animation Overrides for animate.css */
            @keyframes slideOutLeft {
                from { transform: translateX(0); }
                to { opacity: 0; transform: translateX(2000px); }
            }
            .slideOutLeft { animation-name: slideOutLeft; }

            @keyframes bounceInLeft {
                from, 60%, 75%, 90%, to { animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000); }
                0% { opacity: 0; transform: translate3d(3000px, 0, 0) scaleX(3); }
                60% { opacity: 1; transform: translate3d(-25px, 0, 0) scaleX(1); }
                75% { transform: translate3d(10px, 0, 0) scaleX(0.98); }
                90% { transform: translate3d(-5px, 0, 0) scaleX(0.995); }
                to { transform: translate3d(0, 0, 0); }
            }
            .bounceInLeft { animation-name: bounceInLeft; }
        ";
        wp_add_inline_style( 'nsp-main', $rtl_animation_fix );
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
