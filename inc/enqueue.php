<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Keep DNS hints for the existing embedded Google map.
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array
 */
function nsp_resource_hints( array $urls, string $relation_type ): array {

	if ( 'dns-prefetch' === $relation_type ) {
		$urls[] = 'https://maps.googleapis.com';
		$urls[] = 'https://maps.google.com';
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'nsp_resource_hints', 10, 2 );

add_action( 'wp_enqueue_scripts', function () {
    if ( ! is_front_page() ) return;
    $dependencies = [ 'nsp-main', 'nsp-service-catalog' ];
    if ( nsp_is_arabic() ) $dependencies[] = 'nsp-rtl';
    wp_enqueue_style( 'nsp-home-design', NSP_THEME_URI . '/assets/css/home.css', $dependencies, filemtime( NSP_THEME_DIR . '/assets/css/home.css' ) );
}, 30 );

/** File-based versions invalidate long-lived browser caches after deployment. */
function nsp_asset_version( string $path ) {
    return is_file( NSP_THEME_DIR . $path ) ? filemtime( NSP_THEME_DIR . $path ) : NSP_THEME_VERSION;
}

function nsp_script_args() {
    global $wp_version;
    return version_compare( $wp_version, '6.3', '>=' ) ? [ 'strategy'=>'defer', 'in_footer'=>true ] : true;
}

/** Features actually rendered by the current templates, plus editor content. */
function nsp_page_asset_features(): array {
    $post = get_queried_object();
    $content = $post instanceof WP_Post ? $post->post_content : '';
    return apply_filters( 'nsp_page_asset_features', [
        'slick' => is_front_page() || is_page_template( 'page-templates/tpl-about.php' ) || false !== strpos( $content, '-slider' ),
        'counters' => is_front_page() || is_page_template( 'page-templates/tpl-about.php' ) || false !== strpos( $content, 'class="counter' ),
        'progress' => is_singular( 'team' ) || is_page_template( 'page-templates/tpl-about.php' ) || false !== strpos( $content, 'progress-bar' ),
        'gallery' => false !== strpos( $content, 'zoom-gallery' ),
        'video' => false !== strpos( $content, 'popup-video' ) || false !== strpos( $content, 'video_box' ),
        'quantity' => false !== strpos( $content, 'quantity-input-2' ),
        'filterizr' => is_post_type_archive( 'project' ) || is_tax( 'project_category' ),
        'ripples' => is_front_page(),
        'bootstrap' => is_front_page() || is_page_template( 'page-templates/tpl-faq.php' ) || false !== strpos( $content, 'data-bs-' ),
    ] );
}

function nsp_enqueue_assets() {
    $v   = NSP_THEME_VERSION;
    $uri = NSP_THEME_URI;
    $features = nsp_page_asset_features();

    wp_enqueue_style( 'nsp-fonts', $uri . '/assets/css/fonts.css', [], nsp_asset_version( '/assets/css/fonts.css' ) );

    // ---------- Stylesheets (same order as source <head>) ----------
    wp_enqueue_style( 'nsp-bootstrap',    $uri . '/assets/css/bootstrap.min.css',  [], nsp_asset_version( '/assets/css/bootstrap.min.css' ) );
    wp_enqueue_style( 'nsp-fontawesome',  $uri . '/assets/css/fontawesome-all.css', [], nsp_asset_version( '/assets/css/fontawesome-all.css' ) );
    wp_enqueue_style( 'nsp-animate',      $uri . '/assets/css/animate.css',         [], nsp_asset_version( '/assets/css/animate.css' ) );
    if ( $features['video'] ) wp_enqueue_style( 'nsp-video', $uri . '/assets/css/video.min.css', [], nsp_asset_version( '/assets/css/video.min.css' ) );
    if ( $features['slick'] ) wp_enqueue_style( 'nsp-slick', $uri . '/assets/css/slick.css', [], nsp_asset_version( '/assets/css/slick.css' ) );
    if ( $features['slick'] ) wp_enqueue_style( 'nsp-slick-theme', $uri . '/assets/css/slick-theme.css', [], nsp_asset_version( '/assets/css/slick-theme.css' ) );
    if ( $features['gallery'] || $features['video'] ) wp_enqueue_style( 'nsp-magnific', $uri . '/assets/css/magnific-popup.css', [], nsp_asset_version( '/assets/css/magnific-popup.css' ) );
    wp_enqueue_style( 'nsp-reset',        $uri . '/assets/css/reset.css',           [], nsp_asset_version( '/assets/css/reset.css' ) );
    $main_css_file = NSP_THEME_DIR . '/assets/css/style.css';
    $main_css_ver  = file_exists( $main_css_file ) ? filemtime( $main_css_file ) : $v;
    wp_enqueue_style( 'nsp-main', $uri . '/assets/css/style.css', [ 'nsp-fonts' ], $main_css_ver );

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


    // Keep the WordPress jQuery + Migrate dependency graph; never load a second copy.
    wp_enqueue_script( 'jquery' );
    foreach ( [ 'jquery', 'jquery-core', 'jquery-migrate' ] as $handle ) {
        wp_scripts()->add_data( $handle, 'group', 1 );
    }
    $main_dependencies = [ 'jquery', 'nsp-wow' ];
    $scripts = [ 'nsp-wow'=>[ 'wow.min.js', [ 'jquery' ] ] ];
    if ( $features['bootstrap'] ) {
        // The rendered Bootstrap feature is Collapse; it does not use Popper.
        $scripts['nsp-bootstrap'] = [ 'bootstrap.min.js', [ 'jquery' ] ];
    }
    if ( $features['slick'] ) $scripts['nsp-slick'] = [ 'slick.min.js', [ 'jquery' ] ];
    if ( $features['gallery'] || $features['video'] ) $scripts['nsp-magnific'] = [ 'jquery.magnific-popup.min.js', [ 'jquery' ] ];
    if ( $features['progress'] ) $scripts['nsp-appear'] = [ 'appear.js', [ 'jquery' ] ];
    if ( $features['counters'] ) {
        $scripts['nsp-waypoints'] = [ 'waypoints.min.js', [ 'jquery' ] ];
        $scripts['nsp-counterup'] = [ 'jquery.counterup.min.js', [ 'jquery', 'nsp-waypoints' ] ];
    }
    if ( $features['filterizr'] ) {
        $scripts['nsp-imagesloaded'] = [ 'imagesloaded.pkgd.min.js', [ 'jquery' ] ];
        $scripts['nsp-filterizr'] = [ 'jquery.filterizr.js', [ 'jquery', 'nsp-imagesloaded' ] ];
    }
    if ( $features['quantity'] ) $scripts['nsp-inputarrow'] = [ 'jquery.inputarrow.js', [ 'jquery' ] ];
    if ( $features['ripples'] ) $scripts['nsp-ripples'] = [ 'jquery.ripples.min.js', [ 'jquery' ] ];
    // Contact uses a lazy iframe: no gmap3 or Maps JavaScript API is required.
    foreach ( $scripts as $handle => $script ) {
        $path = '/assets/js/' . $script[0];
        wp_enqueue_script( $handle, $uri . $path, $script[1], nsp_asset_version( $path ), nsp_script_args() );
        $main_dependencies[] = $handle;
    }
    wp_enqueue_script( 'nsp-main', $uri . '/assets/js/script.js', array_unique( $main_dependencies ), nsp_asset_version( '/assets/js/script.js' ), nsp_script_args() );
    wp_enqueue_script( 'nsp-dropdowns', $uri . '/assets/js/nsp-dropdowns.js', [ 'jquery' ], nsp_asset_version( '/assets/js/nsp-dropdowns.js' ), nsp_script_args() );
    if ( is_front_page() ) {
        foreach ( [ 'nsp-about-services'=>'about-services.js', 'nsp-home-booking'=>'home-booking.js' ] as $handle=>$file ) {
            wp_enqueue_script( $handle, $uri . '/assets/js/' . $file, [ 'jquery' ], nsp_asset_version( '/assets/js/' . $file ), nsp_script_args() );
        }
    }

    // Pass dynamic data for JS
    wp_localize_script( 'nsp-main', 'nspData', [
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'themeUri'  => $uri,
        'nonce'     => wp_create_nonce( 'nsp_nonce' ),
        'isRtl'     => nsp_is_arabic(),
    ] );
}
add_action( 'wp_enqueue_scripts', 'nsp_enqueue_assets' );

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'nsp-accessibility', NSP_THEME_URI . '/assets/css/accessibility.css', [], nsp_asset_version( '/assets/css/accessibility.css' ) );
}, 99 );
