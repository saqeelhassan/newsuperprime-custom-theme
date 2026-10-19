<?php
/** Client-only booking requests. Package prices come from the service CPT. */
if ( ! defined( 'ABSPATH' ) ) exit;
require_once __DIR__ . '/booking-admin.php';

/** Native package editor takes priority; existing ACF data is a fallback. */
function nsp_booking_packages( int $service_id ): array {
    if ( metadata_exists( 'post', $service_id, '_nsp_booking_packages' ) ) {
        $rows = get_post_meta( $service_id, '_nsp_booking_packages', true );
    } else {
        $rows = function_exists( 'get_field' ) ? get_field( 'service_packages', $service_id ) : [];
    }
    return is_array( $rows ) ? $rows : [];
}

function nsp_booking_service_id(): int {
    if ( is_singular( 'service' ) ) return get_queried_object_id();
    if ( ! is_page() ) return 0;
    // The existing service pages use titles matching their service CPT entries.
    $services = get_posts( [ 'post_type' => 'service', 'numberposts' => -1, 'post_status' => 'publish' ] );
    foreach ( $services as $service ) {
        if ( url_to_postid( nsp_get_service_page_url( $service->post_title ) ) === get_queried_object_id() ) {
            return (int) $service->ID;
        }
    }
    return 0;
}

/** Header calls to action open the same service preview as the homepage hero. */
function nsp_header_booking_button( string $label ): void {
    $services = nsp_catalog_services();
    if ( ! $services ) return;
    $service = $services[0];
    nsp_booking_button( $service['id'], $label, $service['image'] );
}

/** Reusable trigger: nsp_booking_button( $service_post_id ). */
function nsp_booking_button( int $service_id, string $label = 'Book Service', string $image = '', ?int $package_index = null ): void {
    $packages = [];
    $rows = nsp_booking_packages( $service_id );
    foreach ( is_array( $rows ) ? $rows : [] as $row ) {
        $price = $row['package_price'] ?? null;
        $name = sanitize_text_field( $row['package_name'] ?? '' );
        if ( '' === $name || ! is_numeric( $price ) || ! is_finite( (float) $price ) || (float) $price < 0 ) continue;
        $packages[] = [
            'package_name' => $name,
            'package_price' => round( (float) $price, 2 ),
            'package_description' => wp_strip_all_tags( $row['package_description'] ?? '' ),
            'package_perk' => wp_strip_all_tags( $row['package_perk'] ?? '' ),
        ];
    }
    $terms = get_the_terms( $service_id, 'service_category' );
    $category = ! is_wp_error( $terms ) && $terms ? $terms[0]->name : 'Cleaning services';
    ?>
    <button type="button" class="nsp-booking-trigger" data-nsp-booking
        <?php if ( null !== $package_index ) : ?>data-package-index="<?php echo (int) $package_index; ?>"<?php endif; ?>
        aria-haspopup="dialog" aria-controls="nsp-booking"
        data-service-title="<?php echo esc_attr( nsp_service_ar( get_the_title( $service_id ), 'title' ) ?: html_entity_decode( get_the_title( $service_id ), ENT_QUOTES, 'UTF-8' ) ); ?>"
        data-service-overview="<?php echo esc_attr( nsp_service_ar( get_the_title( $service_id ), 'desc' ) ?: wp_strip_all_tags( get_post_meta( $service_id, '_nsp_service_short_desc', true ) ?: get_post_field( 'post_content', $service_id ) ) ); ?>"
        data-service-image="<?php echo esc_url( $image ?: ( get_the_post_thumbnail_url( $service_id, 'nsp-service' ) ?: nsp_asset( 'assets/img/logo/logo.png' ) ) ); ?>"
        data-service-category="<?php echo esc_attr( $category ); ?>"
        data-price-label="<?php echo esc_attr( nsp_service_price_label( $service_id ) ); ?>"
        data-packages="<?php echo esc_attr( wp_json_encode( $packages, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ) ); ?>"><?php echo esc_html( $label ); ?></button>
    <?php
}

/** A display basis for services that cannot use a single package price. */
function nsp_service_price_label( int $id ): string {
    $basis = get_post_meta( $id, '_nsp_price_basis', true );
    if ( 'hourly' === $basis ) return nsp_t( '45 SAR / hour', '٤٥ ر.س / ساعة' );
    if ( 'size' === $basis ) return nsp_t( 'Price depends on size', 'السعر حسب المساحة' );
    if ( 'quote' === $basis ) return nsp_t( 'Price on request', 'السعر عند الطلب' );
    return '';
}

add_action( 'wp_enqueue_scripts', function () {
    if ( ! nsp_special_offer_items() && ! nsp_is_service_catalog() && ! is_front_page() && ! is_singular( 'service' ) && ! ( is_page() && strpos( (string) get_page_template_slug(), 'page-templates/tpl-service-' ) === 0 ) ) return;
    foreach ( [ 'css' => 'style', 'js' => 'script' ] as $extension => $type ) {
        $path = '/assets/' . $extension . '/booking.' . $extension;
        $version = filemtime( NSP_THEME_DIR . $path );
        if ( 'style' === $type ) wp_enqueue_style( 'nsp-booking', NSP_THEME_URI . $path, [ 'nsp-main' ], $version );
        else wp_enqueue_script( 'nsp-booking', NSP_THEME_URI . $path, [], $version, true );
    }
    wp_enqueue_style( 'nsp-service-preview', NSP_THEME_URI . '/assets/css/service-preview.css', [ 'nsp-booking' ], filemtime( NSP_THEME_DIR . '/assets/css/service-preview.css' ) );
    wp_enqueue_script( 'nsp-service-preview', NSP_THEME_URI . '/assets/js/service-preview.js', [ 'nsp-booking' ], filemtime( NSP_THEME_DIR . '/assets/js/service-preview.js' ), true );
} );

add_action( 'wp_footer', function () {
    if ( nsp_special_offer_items() || nsp_is_service_catalog() || is_front_page() || is_singular( 'service' ) || ( is_page() && strpos( (string) get_page_template_slug(), 'page-templates/tpl-service-' ) === 0 ) ) {
        get_template_part( 'template-parts/booking/modal' );
        get_template_part( 'template-parts/booking/preview' );
    }
} );
